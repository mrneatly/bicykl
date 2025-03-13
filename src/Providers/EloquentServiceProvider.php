<?php

namespace Bicykl\Providers;

use Bicykl\Config;
use Illuminate\Database\DatabaseManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected Capsule $capsule;

    public function boot(): void
    {
        /** @var Config $config */
        $config = $this->getContainer()->get(Config::class);

        $capsule    = new Capsule();
        $connection = $config->get('database.connection');

        $capsule->addConnection(
            $config->get("database.$connection"),
            $connection
        );

        $capsule->bootEloquent();
        $capsule->getDatabaseManager()->setDefaultConnection($connection);

        $this->capsule = $capsule;
    }

    public function register(): void
    {
        $this->getContainer()->add(DatabaseManager::class, function () {
            return $this->capsule->getDatabaseManager();
        })
            ->setShared();
    }

    public function provides(string $id): bool
    {
        return $id === DatabaseManager::class;
    }
}