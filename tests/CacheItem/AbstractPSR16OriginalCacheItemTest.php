<?php

declare(strict_types=1);

namespace PB\Component\Cache\Tests\CacheItem;

use PB\Component\Cache\Tests\Fake\CacheItem\FakePSR16OriginalCacheItem;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Cache\CacheItemInterface as PsrCacheItemInterface;

/**
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
class AbstractPSR16OriginalCacheItemTest extends TestCase
{
    /** @var ObjectProphecy|PsrCacheItemInterface */
    private $ocvMock;

    protected function setUp()
    {
        $this->ocvMock = $this->prophesize(PsrCacheItemInterface::class);
    }

    protected function tearDown()
    {
        $this->ocvMock;
    }

    public function testGetOriginalValue()
    {
        // When
        $actual = $this->buildCacheItem()->getOriginalValue();

        // Then
        $this->assertSame($this->ocvMock->reveal(), $actual);
    }

    public function testGetKey()
    {
        // Given
        $expected = 'org-cache-item-key';

        // Mock PsrCacheItemInterface::getKey()
        $this->ocvMock->getKey()->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItem()->getKey();

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testGet()
    {
        // Given
        $expected = 'org-cache-item-value';

        // Mock PsrCacheItemInterface::getKey()
        $this->ocvMock->get()->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItem()->get();

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testIsHit()
    {
        // Given
        $expected = true;

        // Mock PsrCacheItemInterface::getKey()
        $this->ocvMock->isHit()->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItem()->isHit();

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testSet()
    {
        // Given
        $value = 'some-cache-value';

        $ciUnderTest = $this->buildCacheItem();

        // Mock PsrCacheItemInterface::getKey()
        $this->ocvMock->set($value)->shouldBeCalledTimes(1);
        // End

        // When
        $actual = $ciUnderTest->set($value);

        // Then
        $this->assertSame($ciUnderTest, $actual);
    }

    public function testExpiresAt()
    {
        // Given
        $date = new \DateTime();

        $ciUnderTest = $this->buildCacheItem();

        // Mock PsrCacheItemInterface::getKey()
        $this->ocvMock->expiresAt($date)->shouldBeCalledTimes(1);
        // End

        // When
        $actual = $ciUnderTest->expiresAt($date);

        // Then
        $this->assertSame($ciUnderTest, $actual);
    }

    public function testExpiresAfter()
    {
        // Given
        $time = 123;

        $ciUnderTest = $this->buildCacheItem();

        // Mock PsrCacheItemInterface::getKey()
        $this->ocvMock->expiresAfter($time)->shouldBeCalledTimes(1);
        // End

        // When
        $actual = $ciUnderTest->expiresAfter($time);

        // Then
        $this->assertSame($ciUnderTest, $actual);
    }

    private function buildCacheItem(): FakePSR16OriginalCacheItem
    {
        return new FakePSR16OriginalCacheItem($this->ocvMock->reveal());
    }
}
