<?php

namespace Skurian\Dolly;

class BladeDirective
{
    protected $cache;

    public function __construct(RussianCaching $cache)
    {
        $this->cache = $cache;
    }

    /**
     * A list of model cache keys
     *
     * @param array $keys
     */
    protected $keys = [];

    /**
     * setup the caching mechanism
     *
     * @param mixed $model
     */
    public function setUp($model)
    {
        ob_start();

        $this->keys[] = $key = $model->getCacheKey();

        return $this->cache->has($key);
    }

    /**
     * Teardown the cache setup
     */
    public function tearDown()
    {
        return $this->cache->put(
            array_pop($this->keys), ob_get_clean()
        );
    }
}
