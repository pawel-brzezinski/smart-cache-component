<?php

declare(strict_types=1);

namespace PB\Component\Cache\Tests\CacheItemPool;

use PB\Component\Cache\CacheItem\SymfonyCacheItem;
use PB\Component\Cache\CacheItemPool\SymfonyCacheItemPool;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Cache\{CacheItemInterface as PsrCacheItemInterface, CacheItemPoolInterface as PsrCacheItemPoolInterface};
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

/**
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
class SymfonyCacheItemPoolTest extends TestCase
{
    /** @var ObjectProphecy|PsrCacheItemPoolInterface */
    private $ocipMock;

    protected function setUp()
    {
        $this->ocipMock = $this->prophesize(PsrCacheItemPoolInterface::class);
    }

    protected function tearDown()
    {
        $this->ocipMock = null;
    }

    public function testGetItem()
    {
        // Given
        $key = 'foo';
        $ociMock = $this->prophesize(PsrCacheItemInterface::class);

        // Mock PsrCacheItemPoolInterface::getItem()
        $this->ocipMock->getItem($key)->shouldBeCalledTimes(1)->willReturn($ociMock->reveal());
        // End


        // When
        $actual = $this->buildCacheItemPool()->getItem($key);

        // Then
        $this->assertInstanceOf(SymfonyCacheItem::class, $actual);
    }

    public function testGetItems()
    {
        // Given
        $keys = ['foo', 'bar'];
        $ociMock1 = $this->prophesize(PsrCacheItemInterface::class);
        $ociMock2 = $this->prophesize(PsrCacheItemInterface::class);

        // Mock PsrCacheItemPoolInterface::getItems()
        $this->ocipMock->getItems($keys)->shouldBeCalledTimes(1)->willReturn([
            'foo' => $ociMock1->reveal(),
            'bar' => $ociMock2->reveal(),
        ]);
        // End

        // When
        $actual = $this->buildCacheItemPool()->getItems($keys);

        // Then
        $this->assertInstanceOf(\Traversable::class, $actual);

        $i = 0;

        foreach ($actual as $key => $item) {
            $this->assertTrue(in_array($key, $keys));
            $this->assertInstanceOf(SymfonyCacheItem::class, $item);

            if ('foo' === $key) {
                $this->assertSame($ociMock1->reveal(), $item->getOriginalValue());
            } elseif ('bar' === $key) {
                $this->assertSame($ociMock2->reveal(), $item->getOriginalValue());
            }

            $i++;
        }

        $this->assertSame(2, $i);
    }

    public function testInvalidateTagsWhereOriginalPoolIsNotTagAwareAdapterInterfaceImplementation()
    {
        // Given
        $tags = ['tag1', 'tag2'];
        $orgPoolMock = $this->prophesize(PsrCacheItemPoolInterface::class);

        $cacheItemPoolUnderTest = new SymfonyCacheItemPool($orgPoolMock->reveal());

        // When
        $actual = $cacheItemPoolUnderTest->invalidateTags($tags);

        // Then
        $this->assertFalse($actual);
    }

    public function testInvalidateTagsWhereOriginalPoolIsTagAwareAdapterInterfaceImplementation()
    {
        // Given
        $expected = true;
        $tags = ['tag1', 'tag2'];

        /** @var ObjectProphecy|TagAwareAdapterInterface $orgPoolMock */
        $orgPoolMock = $this->prophesize(TagAwareAdapterInterface::class);

        // Mock TagAwareAdapterInterface::invalidateTags()
        $orgPoolMock->invalidateTags($tags)->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        $cacheItemPoolUnderTest = new SymfonyCacheItemPool($orgPoolMock->reveal());

        // When
        $actual = $cacheItemPoolUnderTest->invalidateTags($tags);

        // Then
        $this->assertSame($expected, $actual);
    }

    private function buildCacheItemPool(): SymfonyCacheItemPool
    {
        return new SymfonyCacheItemPool($this->ocipMock->reveal());
    }
}
