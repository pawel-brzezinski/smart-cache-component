<?php

declare(strict_types=1);

namespace PB\Component\Cache\Tests\CacheItemPool;

use PB\Component\Cache\CacheItem\CacheItemInterface;
use PB\Component\Cache\Tests\Fake\CacheItemPool\FakePSR16OriginalCacheItemPool;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Cache\{CacheItemInterface as PsrCacheItemInterface, CacheItemPoolInterface as PsrCacheItemPoolInterface};

/**
 * @author Paweł Brzeziński <pawel.brzezinski@smartint.pl>
 */
class AbstractPSR16OriginalCacheItemPoolTest extends TestCase
{
    /** @var ObjectProphecy|PsrCacheItemPoolInterface */
    private $ocipMock;

    protected function setUp()
    {
        $this->ocipMock = $this->prophesize(PsrCacheItemPoolInterface::class);
    }

    protected function tearDown()
    {
        $this->ocipMock = null;
    }

    public function testGetOriginal()
    {
        // When
        $actual = $this->buildCacheItemPool()->getOriginal();

        // Then
        $this->assertSame($this->ocipMock->reveal(), $actual);
    }

    public function testHasItem()
    {
        // Given
        $key = 'foo';
        $expected = true;

        // Mock PsrCacheItemPoolInterface::hasItem()
        $this->ocipMock->hasItem($key)->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->hasItem($key);

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testClear()
    {
        // Given
        $expected = true;

        // Mock PsrCacheItemPoolInterface::clear()
        $this->ocipMock->clear()->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->clear();

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testDeleteItem()
    {
        // Given
        $key = 'foo';
        $expected = true;

        // Mock PsrCacheItemPoolInterface::deleteItem()
        $this->ocipMock->deleteItem($key)->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->deleteItem($key);

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testDeleteItems()
    {
        // Given
        $keys = ['foo', 'bar'];
        $expected = true;

        // Mock PsrCacheItemPoolInterface::deleteItems()
        $this->ocipMock->deleteItems($keys)->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->deleteItems($keys);

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testSaveWhenCacheItemIsInstanceOfPBCacheItemInterface()
    {
        // Given
        /** @var ObjectProphecy|CacheItemInterface $pciMock */
        $pciMock = $this->prophesize(CacheItemInterface::class);
        $ciMock = $this->prophesize(PsrCacheItemInterface::class);
        $expected = true;

        // Mock CacheItemInterface::getOriginalValue()
        $pciMock->getOriginalValue()->shouldBeCalledTimes(1)->willReturn($ciMock->reveal());
        // End

        // Mock PsrCacheItemPoolInterface::save()
        $this->ocipMock->save($ciMock->reveal())->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->save($pciMock->reveal());

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testSaveWhenCacheItemIsNotInstanceOfPBCacheItemInterface()
    {
        // Given
        $ciMock = $this->prophesize(PsrCacheItemInterface::class);
        $expected = true;

        // Mock PsrCacheItemPoolInterface::save()
        $this->ocipMock->save($ciMock->reveal())->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->save($ciMock->reveal());

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testSaveDeferredWhenCacheItemIsInstanceOfPBCacheItemInterface()
    {
        // Given
        /** @var ObjectProphecy|CacheItemInterface $pciMock */
        $pciMock = $this->prophesize(CacheItemInterface::class);
        $ciMock = $this->prophesize(PsrCacheItemInterface::class);
        $expected = true;

        // Mock CacheItemInterface::getOriginalValue()
        $pciMock->getOriginalValue()->shouldBeCalledTimes(1)->willReturn($ciMock->reveal());
        // End

        // Mock PsrCacheItemPoolInterface::save()
        $this->ocipMock->saveDeferred($ciMock->reveal())->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->saveDeferred($pciMock->reveal());

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testSaveDeferredWhenCacheItemIsNotInstanceOfPBCacheItemInterface()
    {
        // Given
        $ciMock = $this->prophesize(PsrCacheItemInterface::class);
        $expected = true;

        // Mock PsrCacheItemPoolInterface::save()
        $this->ocipMock->saveDeferred($ciMock->reveal())->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->saveDeferred($ciMock->reveal());

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testCommit()
    {
        // Given
        $expected = true;

        // Mock PsrCacheItemPoolInterface::deleteItem()
        $this->ocipMock->commit()->shouldBeCalledTimes(1)->willReturn($expected);
        // End

        // When
        $actual = $this->buildCacheItemPool()->commit();

        // Then
        $this->assertSame($expected, $actual);
    }

    private function buildCacheItemPool(): FakePSR16OriginalCacheItemPool
    {
        return new FakePSR16OriginalCacheItemPool($this->ocipMock->reveal());
    }
}
