<?php

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}

$header = [
    <<<'EOF'
        This file is part of the gigachat-symfony-ai-platform-bridge package.
        
        For the full copyright and license information, please view the LICENSE
        file that was distributed with this source code.
        EOF,
];

return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'protected_to_private' => false,
        'declare_strict_types' => false,
        'header_comment' => [
            'header' => $header,
        ],
        'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public',
                'method_protected',
                'method_private',
            ],
        ],
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->in(__DIR__.'/{.phpstan,demo,examples,fixtures,src}')
            ->append([__FILE__])
            ->exclude('var')
    )
    ;