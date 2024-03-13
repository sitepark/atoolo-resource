<?php

declare(strict_types=1);

namespace Atoolo\Resource\Loader;

use Atoolo\Resource\Exception\InvalidResourceException;
use Atoolo\Resource\Exception\ResourceNotFoundException;
use Atoolo\Resource\Resource;
use Atoolo\Resource\ResourceLoader;

/**
 * The CachedResourceLoader class is used to load resources
 * from a given location and cache them for future use.
 */
class CachedResourceLoader implements ResourceLoader
{
    /**
     * @var array<string, Resource>
     */
    private array $cache = [];
    public function __construct(
        private readonly ResourceLoader $resourceLoader,
    ) {
    }

    /**
     * @throws InvalidResourceException
     * @throws ResourceNotFoundException
     */
    public function load(string $location): Resource
    {
        if (isset($this->cache[$location])) {
            return $this->cache[$location];
        }

        $resource = $this->resourceLoader->load($location);
        $this->cache[$location] = $resource;
        return $resource;
    }

    public function exists(string $location): bool
    {
        if (isset($this->cache[$location])) {
            return true;
        }
        return $this->resourceLoader->exists($location);
    }
}