<?php

namespace Bicykl\Providers;

use Bicykl\Config;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ConfigServiceProvider extends AbstractServiceProvider
{
    private string $defaultConfigPath = __DIR__ . '/../../config/';

    public function __construct(
        protected string $configPath
    )
    {
    }

    public function register(): void
    {
        $this->getContainer()->add(Config::class, function () {
            return $this->loadConfigFilesIntoInstance(
                new Config($this->getDefaultConfigArray())
            );
        });
    }

    // NB: this method has to be in sync with self::register()
    public function provides(string $id): bool
    {
        return $id === Config::class;
    }

    private function loadConfigFilesIntoInstance(Config $config): Config
    {
        foreach (array_diff(scandir($this->configPath), ['.', '..']) as $file) {
            $configKey = explode('.', $file)[0];

            $config->merge([
                $configKey => require $this->configPath . '/'. $file,
            ]);
        }

        return $config;
    }

    private function getDefaultConfigArray(): array
    {
        return [
            'app' => require $this->defaultConfigPath . 'app.php'
        ];
    }
}