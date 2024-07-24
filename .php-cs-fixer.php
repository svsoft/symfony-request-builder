<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        '@PHP82Migration' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
        ],
    ])
    ->setFinder($finder)
    ;