<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItem;

use Psr\Cache\CacheItemInterface as BaseCacheItemInterface;

/**
 * Interface for cache item implementation.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
interface CacheItemInterface extends BaseCacheItemInterface
{
    /**
     * Get original value of cache provider.
     *
     * @return mixed
     */
    public function getOriginalValue();
}
