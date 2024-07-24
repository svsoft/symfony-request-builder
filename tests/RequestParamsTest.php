<?php

declare(strict_types=1);

namespace Svsoft\SymfonyRequestBuilder\Tests;

use PHPUnit\Framework\TestCase;
use Svsoft\SymfonyRequestBuilder\RequestParams;

/**
 * @see RequestParams
 */
final class RequestParamsTest extends TestCase
{
    private const DATA = [
        'name' => 'Ivan',
        'age' => 30,
        'phones' => ['78881', '78882'],
    ];

    public function testAdd(): void
    {
        $params = new RequestParams();

        foreach (self::DATA as $name => $value) {
            $params->set($name, $value);
        }

        $this->assertEquals(self::DATA, $params->toArray());
    }

    public function testSetParamsAfterSet(): void
    {
        $params = new RequestParams();
        $params->set('test', 1);
        $params->setParams(self::DATA);
        $this->assertEquals(self::DATA, $params->toArray());
    }

    public function testSetParamsBeforeSet(): void
    {
        $params = new RequestParams();
        $params->set('test', 1);
        $params->setParams(self::DATA);
        $this->assertEquals(self::DATA, $params->toArray());
    }

    public function testAddParams2(): void
    {
        $params = new RequestParams();
        $params->setParams(self::DATA);
        $params->set('test', 1);
        $expected = self::DATA;
        $expected['test'] = 1;
        $this->assertEquals($expected, $params->toArray());
    }

    public function testIsEmpty(): void
    {
        $params = new RequestParams();
        $this->assertTrue($params->isEmpty());

        $params->set('test', 'test');
        $this->assertFalse($params->isEmpty());
    }
}
