<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItem;

/**
 * Interface for taggable cache item implementation.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
interface TaggableCacheItemInterface extends CacheItemInterface
{
    /**
     * Set cache item tags.
     *
     * @param array $tags
     *
     * @return mixed
     */
    public function setTags(array $tags);
}
