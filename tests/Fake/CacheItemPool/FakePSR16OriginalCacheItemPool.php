<?php

declare(strict_types=1);

namespace PB\Component\Cache\Tests\Fake\CacheItemPool;

use PB\Component\Cache\CacheItemPool\AbstractPSR16OriginalCacheItemPool;

/**
 * Fake cache item pool for testing AbstractPSR16OriginalCacheItemPool.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
class FakePSR16OriginalCacheItemPool extends AbstractPSR16OriginalCacheItemPool
{
    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        // TODO: Implement getItem() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = array())
    {
        // TODO: Implement getItems() method.
    }
}

