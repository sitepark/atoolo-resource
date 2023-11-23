<?php

declare(strict_types=1);

namespace Atoolo\Resource\Test\Loader;

use Atoolo\Resource\Exception\RootMissingException;
use Atoolo\Resource\Loader\SiteKitNavigationHierarchyLoader;
use Atoolo\Resource\ResourceLoader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SiteKitNavigationHierarchyLoader::class)]
class SiteKitNavigationHierarchyLoaderTest extends TestCase
{
    public function testLoadRootResourceWithHomeFlag(): void
    {
        $treeLoader = $this->createTreeLoader(
            realpath(
                __DIR__ . '/../resources/' .
                'Loader/SiteKitNavigationHierarchyLoader/withHomeFlag'
            )
        );

        $root = $treeLoader->loadRoot('/c.php');

        $this->assertEquals(
            'a',
            $root->getId(),
            'unexpected root'
        );
    }

    public function testLoadRootResourceWithDefaultRoot(): void
    {
        $treeLoader = $this->createTreeLoader(
            realpath(
                __DIR__ . '/../resources/' .
                'Loader/SiteKitNavigationHierarchyLoader/withDefaultRoot'
            )
        );

        $root = $treeLoader->loadRoot('/dir/c.php');

        $this->assertEquals(
            'root',
            $root->getId(),
            'unexpected root'
        );
    }

    public function testLoadRootResourceWithoutRoot(): void
    {
        $treeLoader = $this->createTreeLoader(
            realpath(
                __DIR__ . '/../resources/' .
                'Loader/SiteKitNavigationHierarchyLoader/withoutRoot'
            )
        );

        $this->expectException(RootMissingException::class);
        $treeLoader->loadRoot('/a.php');
    }

    private function createTreeLoader(
        string $resourceBaseDir
    ): SiteKitNavigationHierarchyLoader {
        $resourceLoader = $this->createStub(
            ResourceLoader::class
        );
        $resourceLoader->method('load')
            ->willReturnCallback(static function ($location) use (
                $resourceBaseDir
            ) {
                return include $resourceBaseDir . $location;
            });
        $resourceLoader->method('exists')
            ->willReturnCallback(static function ($location) use (
                $resourceBaseDir
            ) {
                return file_exists($resourceBaseDir . $location);
            });
        return new SiteKitNavigationHierarchyLoader(
            $resourceLoader
        );
    }
}
