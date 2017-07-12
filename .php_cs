<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_opening_tag' => false,
        'class_definition' => ['singleLine' => false],
        'concat_space' => ['spacing' => 'one'],
        'mb_str_functions' => true,
        'no_unused_imports' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'phpdoc_no_empty_return' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
