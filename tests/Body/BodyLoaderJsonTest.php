<?php

namespace Svsoft\SymfonyRequestBuilder\Tests\Body;

use PHPUnit\Framework\TestCase;
use Svsoft\SymfonyRequestBuilder\BodySerializer\BodySerializerJson;
use Symfony\Component\HttpClient\HttpOptions;

/**
 * @see BodySerializerJson
 */
class BodyLoaderJsonTest extends TestCase
{
    private const DATA = [
        'name' => 'Ivan',
        'age' => 30,
        'phones' => ['78881', '78882'],
    ];

    public function testApply(): void
    {
        $bodyLoader = new BodySerializerJson();
        $options = new HttpOptions();
        $bodyLoader->apply($options, self::DATA);

        $data = $options->toArray();

        $this->assertArrayHasKey('json', $data);
        $this->assertEquals(self::DATA, $data['json']);
    }
}
