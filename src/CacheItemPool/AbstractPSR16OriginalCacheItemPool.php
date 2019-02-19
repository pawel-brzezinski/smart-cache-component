<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItemPool;

use PB\Component\Cache\CacheItem\CacheItemInterface;
use Psr\Cache\{CacheItemInterface as PsrCacheItemInterface, CacheItemPoolInterface as PsrCacheItemPoolInterface};

/**
 * Abstract for PSR-16 original cache item pool implementation.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
abstract class AbstractPSR16OriginalCacheItemPool implements CacheItemPoolInterface
{
    /**
     * @var PsrCacheItemPoolInterface
     */
    protected $originalPool;

    /**
     * AbstractPSR16OriginalCacheItemPool constructor.
     *
     * @param PsrCacheItemPoolInterface $originalPool
     */
    public function __construct(PsrCacheItemPoolInterface $originalPool)
    {
        $this->originalPool = $originalPool;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginal(): PsrCacheItemPoolInterface
    {
        return $this->originalPool;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($key): bool
    {
        return $this->originalPool->hasItem($key);
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): bool
    {
        return $this->originalPool->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItem($key): bool
    {
        return $this->originalPool->deleteItem($key);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItems(array $keys): bool
    {
        return $this->originalPool->deleteItems($keys);
    }

    /**
     * {@inheritdoc}
     */
    public function save(PsrCacheItemInterface $item): bool
    {
        if ($item instanceof CacheItemInterface) {
            $item = $item->getOriginalValue();
        }

        return $this->originalPool->save($item);
    }

    /**
     * {@inheritdoc}
     */
    public function saveDeferred(PsrCacheItemInterface $item): bool
    {
        if ($item instanceof CacheItemInterface) {
            $item = $item->getOriginalValue();
        }

        return $this->originalPool->saveDeferred($item);
    }

    /**
     * {@inheritdoc}
     */
    public function commit(): bool
    {
        return $this->originalPool->commit();
    }
}
