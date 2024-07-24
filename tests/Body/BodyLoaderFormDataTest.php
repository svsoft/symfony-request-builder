<?php

namespace Svsoft\SymfonyRequestBuilder\Tests\Body;

use PHPUnit\Framework\TestCase;
use Svsoft\SymfonyRequestBuilder\BodySerializer\BodySerializerFormData;
use Symfony\Component\HttpClient\HttpOptions;

/**
 * @see BodySerializerFormData
 */
class BodyLoaderFormDataTest extends TestCase
{
    private const DATA = [
        'name' => 'Ivan',
        'age' => 30,
        'phones' => ['78881', '78882'],
    ];

    public function testApply(): void
    {
        $bodyLoader = new BodySerializerFormData();
        $options = new HttpOptions();
        $bodyLoader->apply($options, self::DATA);

        $header = $options->toArray()['headers'][0];

        $body = $options->toArray()['body'];

        $boundary = explode('boundary=', $header)[1];

        $parts = explode('--'.$boundary, $body);

        $expected = ["\r
Content-Type: text/plain; charset=utf-8\r
Content-Transfer-Encoding: 8bit\r
Content-Disposition: form-data; name=\"name\"\r
\r
Ivan\r
", "\r
Content-Type: text/plain; charset=utf-8\r
Content-Transfer-Encoding: 8bit\r
Content-Disposition: form-data; name=\"age\"\r
\r
30\r
", "\r
Content-Type: text/plain; charset=utf-8\r
Content-Transfer-Encoding: 8bit\r
Content-Disposition: form-data; name=\"phones[0]\"\r
\r
78881\r
", "\r
Content-Type: text/plain; charset=utf-8\r
Content-Transfer-Encoding: 8bit\r
Content-Disposition: form-data; name=\"phones[1]\"\r
\r
78882\r
"];

        array_shift($parts);
        array_pop($parts);

        $this->assertEquals($expected, $parts);

        $this->assertEquals("Content-Type: multipart/form-data; boundary=$boundary", $header);
    }
}
