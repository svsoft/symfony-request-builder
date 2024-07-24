# SymfonyRequsetBuilder 

Simple builder for the sending request based on the component symfony/http-client

## Usage

```php
<?php

    use Svsoft\SymfonyRequestBuilder\RequestBuilder;
     
    $client = new \Symfony\Component\HttpClient\CurlHttpClient();
        
    // send query string with timeout
    $response = RequestBuilder::create($clinet)
        ->get('/api/product/search')
        ->setQueryParam('query', 'Some phone')
        ->setTimeout(5)
        ->request();
               
    // send body as json
    $response = RequestBuilder::create($clinet)
        ->post('/api/product')
        ->setBodyParam('name', 'Some phone')
        ->setBodyParam('price', '10000')
        ->request();        
        
    // send body as form
    $response = RequestBuilder::create($clinet)
        ->post('/api/product')
        ->setBodySerializer(new \Svsoft\SymfonyRequestBuilder\BodySerializer\BodySerializerFormData())
        ->setBodyParam('name', 'Some phone')
        ->setBodyParam('price', '10000')
        ->request();        

    // send body as json with any options like in HttpClientInterface::request
    $options = [
        'query' => [
            'version' => 12345
        ]
    ];
    $response = RequestBuilder::create($clinet)
        ->patch('/api/product')
        ->setBodyParam('name', 'Some super phone')
        ->setOptions($options)
        ->request();

```

## License

MIT


