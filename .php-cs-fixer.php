<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('public')
    ->exclude('resources')
    ->exclude('storage')
    ->exclude('bootstrap')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;