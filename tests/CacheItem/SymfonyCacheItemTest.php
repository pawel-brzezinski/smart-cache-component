<?php

declare(strict_types=1);

namespace PB\Component\Cache\Tests\CacheItem;

use PB\Component\Cache\CacheItem\SymfonyCacheItem;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Cache\CacheItemInterface as PsrCacheItemInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
class SymfonyCacheItemTest extends TestCase
{
    public function testSetTagsWhereOriginalCacheValueIsNotSymfonyItemImplementation()
    {
        // Given
        $orgCacheItem = $this->prophesize(PsrCacheItemInterface::class);

        $cacheItemUnderTest = new SymfonyCacheItem($orgCacheItem->reveal());

        // When
        $actual = $cacheItemUnderTest->setTags(['tag']);

        // Then
        $this->assertSame($cacheItemUnderTest, $actual);
    }

    public function testSetTagsWhereOriginalCacheValueIsSymfonyItemImplementation()
    {
        // Given
        $tags = ['tag1', 'tag2'];

        /** @var ObjectProphecy|ItemInterface $orgCacheItem */
        $orgCacheItem = $this->prophesize(ItemInterface::class);

        // Mock ItemInterface::tag()
        $orgCacheItem->tag($tags)->shouldBeCalledTimes(1);
        // End

        $cacheItemUnderTest = new SymfonyCacheItem($orgCacheItem->reveal());

        // When
        $actual = $cacheItemUnderTest->setTags($tags);

        // Then
        $this->assertSame($cacheItemUnderTest, $actual);
    }
}
