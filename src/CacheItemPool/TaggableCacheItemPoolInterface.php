<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItemPool;

/**
 * Interface for taggable cache item pool implementation.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
interface TaggableCacheItemPoolInterface extends CacheItemPoolInterface
{
    /**
     * Invalidate cache items by tags.
     *
     * @param array $tags
     *
     * @return mixed
     */
    public function invalidateTags(array $tags);
}
