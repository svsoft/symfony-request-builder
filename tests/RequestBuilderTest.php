<?php

declare(strict_types=1);

namespace Svsoft\SymfonyRequestBuilder\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Svsoft\SymfonyRequestBuilder\BodySerializer\BodySerializerFormData;
use Svsoft\SymfonyRequestBuilder\RequestBuilder;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @see RequestBuilder
 */
final class RequestBuilderTest extends TestCase
{
    private MockObject $clinet;
    private MockObject $response;

    public function setUp(): void
    {
        $this->clinet = $this->createMock(HttpClientInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);

        $this->clinet->method('request')
            ->willReturn($this->response);
    }

    private const DATA = [
        'name' => 'Ivan',
        'age' => 30,
        0 => 'Moscow',
        'phones' => ['78881', '78882'],
    ];

    /**
     * @see RequestBuilder::get()
     */
    public function testGet(): void
    {
        $this->clinet->method('request')
            ->with('GET', '/start', []);

        $this->createRequestBuilder()
            ->get('/start')
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::post()
     */
    public function testPost(): void
    {
        $this->clinet->method('request')
            ->with('POST', '/start', []);

        $this->createRequestBuilder()
            ->post('/start')
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::delete()
     */
    public function testDelete(): void
    {
        $this->clinet->method('request')
            ->with('DELETE', '/start', []);

        $this->createRequestBuilder()
            ->delete('/start')
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::patch()
     */
    public function testPatch(): void
    {
        $this->clinet->method('request')
            ->with('PATCH', '/start', []);

        $this->createRequestBuilder()
            ->patch('/start')
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::put()
     */
    public function testPut(): void
    {
        $this->clinet->method('request')
            ->with('PUT', '/start', []);

        $this->createRequestBuilder()
            ->put('/start')
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setBodyParam()
     */
    public function testSetBodyParam(): void
    {
        $this->clinet->method('request')
            ->with('GET', '/start', ['json' => ['name' => 'Alex', 'age' => 30]]);

        $this->createRequestBuilder()
            ->get('/start')
            ->setBodyParam('name', 'Alex')
            ->setBodyParam('age', 25)
            ->setBodyParam('age', 30)
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setBodyParams()
     */
    public function testSetBodyParams(): void
    {
        $this->clinet->method('request')
            ->with('GET', '/start', ['json' => ['name' => 'Alex', 'age' => 30]]);

        $this->createRequestBuilder()
            ->get('/start')
            ->setBodyParams(['name' => 'Alex', 'age' => 30])
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setQueryParam()
     */
    public function testSetQueryParam(): void
    {
        $expectedOptions = [
            'query' => [
                'name' => 'Alex',
                'age' => 30,
                'list' => ['a', 'b'],
            ],
        ];

        $this->clinet->method('request')
            ->with('GET', '/start', $expectedOptions);

        $this->createRequestBuilder()
            ->get('/start')
            ->setQueryParam('name', 'Alex')
            ->setQueryParam('age', 30)
            ->setQueryParam('list', ['a', 'b'])
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setQueryParams()
     */
    public function testSetQueryParams(): void
    {
        $expectedOptions = [
            'query' => [
                'name' => 'Alex',
                'age' => 30,
                'list' => ['a', 'b'],
            ],
        ];

        $this->clinet->method('request')
            ->with('GET', '/start');

        $this->createRequestBuilder()
            ->get('/start')
            ->setQueryParams($expectedOptions)
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setHeader()
     */
    public function testSetHeader(): void
    {
        $expectedOptions = [
            'headers' => [
                'Some-Header' => 'Secret',
                'Some-Other-Header' => 'Other',
            ],
        ];

        $this->clinet->method('request')
            ->with('GET', '/start', $expectedOptions);

        $this->createRequestBuilder()
            ->get('/start')
            ->setHeader('Some-Header', 'Secret')
            ->setHeader('Some-Other-Header', 'Other')
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setOptions()
     */
    public function testSetOptions(): void
    {
        $expectedOptions = [
            'json' => [
                'age' => 30,
            ],
            'query' => [
                'surname' => 'Ivanov',
            ],
            'headers' => [
                'Some-Header' => 'Some secret',
            ],
        ];

        $this->clinet->method('request')
            ->with('GET', '/start', $expectedOptions);

        $options = [
            'json' => [
                'name' => 'Alex',
                'age' => 25,
            ],
            'query' => [
                'surname' => 'Petrov',
                'color' => 'red',
            ],
            'headers' => [
                'Some-Header' => 'Secret',
                'Some-Other-Header' => 'Other',
            ],
        ];

        $this->createRequestBuilder()
            ->get('/start')
            ->setOptions($options)
            ->setQueryParam('surname', 'Ivanov')
            ->setBodyParam('age', 30)
            ->setHeader('Some-Header', 'Some secret')
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setTimeout()
     */
    public function testSetTimeout(): void
    {
        $expectedOptions = [
            'timeout' => 0.5,
        ];

        $this->clinet->method('request')
            ->with('GET', '/start', $expectedOptions);

        $this->createRequestBuilder()
            ->get('/start')
            ->setTimeout(0.5)
            ->request();

        $this->expectNotToPerformAssertions();
    }

    /**
     * @see RequestBuilder::setBodySerializer()
     */
    public function testSetBodySerializer(): void
    {
        $this->clinet->method('request')
            ->with('POST', '/start', $this->arrayHasKey('body'));

        $this->createRequestBuilder()
            ->post('/start')
            ->setBodySerializer(new BodySerializerFormData())
            ->setBodyParams(['name' => 'Alex', 'age' => 30])
            ->request();

        $this->expectNotToPerformAssertions();
    }

    private function createRequestBuilder(): RequestBuilder
    {
        return new RequestBuilder($this->clinet);
    }
}
