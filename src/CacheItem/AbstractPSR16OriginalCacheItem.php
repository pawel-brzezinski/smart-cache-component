<?php

declare(strict_types=1);

namespace PB\Component\Cache\CacheItem;

use Psr\Cache\CacheItemInterface as PsrCacheItemInterface;

/**
 * Abstract for PSR-16 original value cache item implementation.
 *
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
abstract class AbstractPSR16OriginalCacheItem implements CacheItemInterface
{
    /**
     * @var PsrCacheItemInterface
     */
    protected $originalValue;

    /**
     * AbstractPSR16OriginalCacheItem constructor.
     *
     * @param PsrCacheItemInterface $originalValue
     */
    public function __construct(PsrCacheItemInterface $originalValue)
    {
        $this->originalValue = $originalValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalValue(): PsrCacheItemInterface
    {
        return $this->originalValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->originalValue->getKey();
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->originalValue->get();
    }

    /**
     * {@inheritdoc}
     */
    public function isHit()
    {
        return $this->originalValue->isHit();
    }

    /**
     * {@inheritdoc}
     */
    public function set($value)
    {
        $this->originalValue->set($value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAt($expiration)
    {
        $this->originalValue->expiresAt($expiration);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAfter($time)
    {
        $this->originalValue->expiresAfter($time);

        return $this;
    }
}
