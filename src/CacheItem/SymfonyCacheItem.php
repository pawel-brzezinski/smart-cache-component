<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItem;

use Symfony\Contracts\Cache\ItemInterface;

/**
 * Symfony cache component item.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
final class SymfonyCacheItem extends AbstractPSR16OriginalCacheItem implements TaggableCacheItemInterface
{
    /**
     * {@inheritdoc}
     */
    public function setTags(array $tags): self
    {
        if ($this->originalValue instanceof ItemInterface) {
            $this->originalValue->tag($tags);
        }

        return $this;
    }
}
