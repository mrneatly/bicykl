<?php

namespace Bicykl;

class Config
{
    public function __construct(
        protected array $config = [],
    )
    {
    }

    public function merge(array $config): static
    {
        $this->config = array_merge_recursive($this->config, $config);

        return $this;
    }

    public function get(string $key, $default = null): mixed
    {
        return dot($this->config)->get($key) ?? $default;
    }
}