<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItemPool;

use Psr\Cache\CacheItemPoolInterface as BaseCacheItemPoolInterface;

/**
 * Interface for cache item pool implementation.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
interface CacheItemPoolInterface extends BaseCacheItemPoolInterface
{
    /**
     * Get original cache provider.
     *
     * @return mixed
     */
    public function getOriginal();
}
