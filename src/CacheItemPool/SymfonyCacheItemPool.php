<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItemPool;

use PB\Component\Cache\CacheItem\SymfonyCacheItem;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

/**
 * Symfony cache component item pool.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
final class SymfonyCacheItemPool extends AbstractPSR16OriginalCacheItemPool implements TaggableCacheItemPoolInterface
{
    /**
     * {@inheritdoc}
     */
    public function getItem($key): SymfonyCacheItem
    {
        $cacheItem = $this->originalPool->getItem($key);

        return new SymfonyCacheItem($cacheItem);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = [])
    {
        $items = $this->originalPool->getItems($keys);

        foreach ($items as $key => $item) {
            yield $key => new SymfonyCacheItem($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function invalidateTags(array $tags): bool
    {
        if ($this->originalPool instanceof TagAwareAdapterInterface) {
            return $this->originalPool->invalidateTags($tags);
        }

        return false;
    }
}
