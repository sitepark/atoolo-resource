<?php

declare(strict_types=1);

namespace Atoolo\Resource\Loader;

use Atoolo\Resource\Exception\InvalidResourceException;
use Atoolo\Resource\Exception\ResourceNotFoundException;
use Atoolo\Resource\Exception\RootMissingException;
use Atoolo\Resource\Resource;
use Atoolo\Resource\ResourceLoader;
use Atoolo\Resource\ResourceLocation;

class SiteKitNavigationHierarchyLoader extends SiteKitResourceHierarchyLoader
{
    public function __construct(ResourceLoader $resourceLoader)
    {
        parent::__construct($resourceLoader, 'navigation');
    }

    public function isRoot(Resource $resource): bool
    {
        return $resource->data->getBool('init.home');
    }

    /**
     * @throws InvalidResourceException
     * @throws ResourceNotFoundException
     */
    protected function loadPrimaryParentResource(Resource $resource): Resource
    {
        $parentLocation = $this->getPrimaryParentLocation($resource);
        if ($parentLocation === null) {
            return $this->loadDefaultRootResource($resource);
        }
        return $this->load($parentLocation);
    }

    /**
     * @throws InvalidResourceException
     * @throws ResourceNotFoundException
     * @throws RootMissingException
     */
    private function loadDefaultRootResource(Resource $resource): Resource
    {
        $path = $resource->location;
        do {
            $dir = dirname($path);
            if (str_ends_with($path, '/index.php')) {
                $dir = dirname($dir);
            }
            if ($dir === '/' || $dir === '\\') {
                $path = '/index.php';
            } else {
                $path = $dir . '/index.php';
            }

            $location = ResourceLocation::of($path, $resource->lang);
            if ($this->exists($location)) {
                $root = $this->load($location);
                if ($this->isRoot($root)) {
                    return $root;
                }
            }
        } while ($dir !== '/' && $dir !== '\\' && $dir !== '');

        throw new RootMissingException(
            $resource->location,
            'No default root could be determined for the resource'
        );
    }
}
