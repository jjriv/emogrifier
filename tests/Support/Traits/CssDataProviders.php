<?php

declare(strict_types=1);

namespace Pelago\Emogrifier\Tests\Support\Traits;

use PHPUnit\Framework\TestCase;
use TRegx\DataProvider\DataProviders;

/**
 * Adds common data providers to a test case for a `Constraint` which matches CSS.
 *
 * @mixin TestCase
 */
trait CssDataProviders
{
    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public function provideEquivalentCss(): array
    {
        return $this->provideEquivalentCompleteCss() + $this->provideEquivalentCssComponents();
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public function provideEquivalentCompleteCss(): array
    {
        $equivalentCssWithAtMediaRuleSelectorListAndPropertyDeclaration = [
            'unminified CSS with `@media` rule, selector list, and property declaration'
                => ['@media screen { html, body { color: green; } }'],
            'minified CSS with `@media` rule, selector list, and property declaration'
                => ['@media screen{html,body{color:green}}'],
            'CSS with `@media` rule, selector list, and property declaration, with extra spaces'
                => ['  @media  screen  {  html  ,  body  {  color  :  green  ;  }  }  '],
            'CSS with `@media` rule, selector list, and property declaration, with linefeeds'
                => ["\n@media\nscreen\n{\nhtml\n,\nbody\n{\ncolor\n:\ngreen\n;\n}\n}\n"],
            'CSS with `@media` rule, selector list, and property declaration, with Windows line endings'
                => ["\r\n@media\r\nscreen\r\n{\r\nhtml\r\n,\r\nbody\r\n{\r\ncolor\r\n:\r\ngreen\r\n;\r\n}\r\n}\r\n"],
        ];

        /** @var array<string, array{0: string, 1: string}> $datasetsWithAtMediaRuleSelectorListAndPropertyDeclaration */
        $datasetsWithAtMediaRuleSelectorListAndPropertyDeclaration = DataProviders::cross(
            $equivalentCssWithAtMediaRuleSelectorListAndPropertyDeclaration,
            $equivalentCssWithAtMediaRuleSelectorListAndPropertyDeclaration
        );

        $equivalentCssWithUrlPropertyValue = [
            'CSS with unquoted URL in property value' => ['body { background-image: url(images/foo.jpeg); }'],
            'CSS with quoted URL in property value' => ['body { background-image: url("images/foo.jpeg"); }'],
        ];

        /** @var array<string, array{0: string, 1: string}> $datasetsWithUrlPropertyValue */
        $datasetsWithUrlPropertyValue = DataProviders::cross(
            $equivalentCssWithUrlPropertyValue,
            $equivalentCssWithUrlPropertyValue
        );

        $equivalentCssWithAtImportRule = [
            '`@import` with unquoted string' => ['@import foo/bar.css;'],
            '`@import` with single-quoted string' => ['@import \'foo/bar.css\';'],
            '`@import` with double-quoted string' => ['@import "foo/bar.css";'],
            '`@import` with unquoted URL' => ['@import url(foo/bar.css);'],
            '`@import` with single-quoted URL' => ['@import url(\'foo/bar.css\');'],
            '`@import` with double-quoted URL' => ['@import url("foo/bar.css");'],
            '`@import` with spaces around unquoted URL' => ['@import url( foo/bar.css );'],
            '`@import` with spaces around quoted URL' => ['@import url( "foo/bar.css" );'],
            '`@import` with space after unquoted string' => ['@import foo/bar.css ;'],
            '`@import` with space after quoted string' => ['@import "foo/bar.css" ;'],
            '`@import` with space after URL' => ['@import url(foo/bar.css) ;'],
        ];

        /** @var array<string, array{0: string, 1: string}> $datasetsWithAtImportRule */
        $datasetsWithAtImportRule = DataProviders::cross(
            $equivalentCssWithAtImportRule,
            $equivalentCssWithAtImportRule
        );

        return \array_merge(
            $datasetsWithAtMediaRuleSelectorListAndPropertyDeclaration,
            $datasetsWithUrlPropertyValue,
            $datasetsWithAtImportRule
        );
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public function provideEquivalentCssComponents(): array
    {
        $equivalentCssPropertyDeclarations = [
            'property declaration' => ['color: green;'],
            'property declaration without trailing semicolon' => ['color: green'],
            'property declaration without trailing semicolon but space after' => ['color: green '],
            'property declaration with space before trailing semicolon' => ['color: green ;'],
            'property declaration with line feed before trailing semicolon' => ["color: green\n;"],
            'property declaration with Windows line ending before trailing semicolon' => ["color: green\r\n;"],
            'property declaration with TAB before trailing semicolon' => ["color: green\t;"],
            'property declaration with space after trailing semicolon' => ['color: green; '],
        ];

        /** @var array<string, array{0: string, 1: string}> $datasetsWithPropertyDelcaration */
        $datasetsWithPropertyDelcaration = DataProviders::cross(
            $equivalentCssPropertyDeclarations,
            $equivalentCssPropertyDeclarations
        );

        $equivalentPropertyDeclarationsWithRgbValue = [
            'property declaration with lowercase RGB value' => ['color: #0f0;'],
            'property declaration with uppercase RGB value' => ['color: #0F0;'],
        ];

        /** @var array<string, array{0: string, 1: string}> $datasetsWithPropertyDelcarationWithRgbValue */
        $datasetsWithPropertyDelcarationWithRgbValue = DataProviders::cross(
            $equivalentPropertyDeclarationsWithRgbValue,
            $equivalentPropertyDeclarationsWithRgbValue
        );

        $equivalentPropertyDeclarationsWithSixDigitRgbValue = [
            'property declaration with lowercase 6-digit RGB value' => ['color: #abcdef;'],
            'property declaration with uppercase 6-digit RGB value' => ['color: #ABCDEF;'],
        ];

        /** @var array<string, array{0: string, 1: string}> $datasetsWithPropertyDelcarationWithSixDigitRgbValue */
        $datasetsWithPropertyDelcarationWithSixDigitRgbValue = DataProviders::cross(
            $equivalentPropertyDeclarationsWithSixDigitRgbValue,
            $equivalentPropertyDeclarationsWithSixDigitRgbValue
        );

        $equivalentPropertyDeclarationsWithUrlValue = [
            'property declaration with unquoted URL' => ['background-image: url(images/foo.jpeg);'],
            'property declaration with single-quoted URL' => ['background-image: url(\'images/foo.jpeg\');'],
            'property declaration with double-quoted URL' => ['background-image: url("images/foo.jpeg");'],
            'property declaration with spaces around unquoted URL' => ['background-image: url( images/foo.jpeg );'],
            'property declaration with spaces around quoted URL' => ['background-image: url( "images/foo.jpeg" );'],
            'property declaration with space after URL' => ['background-image: url(images/foo.jpeg) ;'],
        ];

        /** @var array<string, array{0: string, 1: string}> $datasetsWithPropertyDelcarationWithUrlValue */
        $datasetsWithPropertyDelcarationWithUrlValue = DataProviders::cross(
            $equivalentPropertyDeclarationsWithUrlValue,
            $equivalentPropertyDeclarationsWithUrlValue
        );

        return \array_merge(
            $datasetsWithPropertyDelcaration,
            $datasetsWithPropertyDelcarationWithRgbValue,
            $datasetsWithPropertyDelcarationWithSixDigitRgbValue,
            $datasetsWithPropertyDelcarationWithUrlValue
        );
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public function provideEquivalentCssInStyleTags(): array
    {
        $datasetsWithoutStyleTags = $this->provideEquivalentCompleteCss();

        $datasetsWithRenamedKeys = static::arrayMapKeys(
            static function (string $description): string {
                return $description . ' in <style> tag';
            },
            $datasetsWithoutStyleTags
        );

        $datasets = \array_map(
            /**
             * @param array{0: string, 1: string} $dataset
             *
             * @return array{0: string, 1: string}
             */
            static function (array $dataset): array {
                return \array_map(
                    static function (string $css): string {
                        return '<style>' . $css . '</style>';
                    },
                    $dataset
                );
            },
            $datasetsWithRenamedKeys
        );

        return $datasets;
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public function provideCssNeedleFoundInLargerHaystack()
    {
        return [
            'needle at start of haystack' => ['p { color: green; }', 'p { color: green; } a { color: blue; }'],
            'needle at end of haystack' => ['p { color: green; }', 'body { font-size: 16px; } p { color: green; }'],
            'needle in middle of haystack' => [
                'p { color: green; }',
                'body { font-size: 16px; } p { color: green; } a { color: blue; }',
            ],
        ];
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public function provideCssNeedleNotFoundInHaystack(): array
    {
        return [
            'CSS part with "{" not in CSS' => ['p {', 'body { color: green; }'],
            'CSS part with "}" not in CSS' => ['color: red; }', 'body { color: green; }'],
            'CSS part with "," not in CSS' => ['html, body', 'body { color: green; }'],
            'missing `;` after declaration where not optional' => [
                'body { color: green; font-size: 15px; }',
                "body { color: green\nfont-size: 15px; }",
            ],
            'extra `;` after declaration' => ['body { color: green; }', 'body { color: green;; }'],
            'spurious `;` in empty rule' => ['body { }', 'body { ; }'],
            'spurious `;` after rule in at-rule' => [
                '@media print { body { color: green; } }',
                '@media print { body { color: green; }; }',
            ],
            'spurious `;` after rule in needle' => ['body { color: green; };', 'body { color: green; }'],
            'spurious `;` after rule in needle with space between' => [
                'body { color: green; } ;',
                'body { color: green; }',
            ],
            'spurious `;` after declaration in needle' => ['color: green;;', 'color: green;'],
            'spurious `;` after declaration in needle with spaces around' => ['color: green ; ;', 'color: green;'],
            'invalid space after `:` for pseudo-class' => [
                'p:first-child { color: green; }',
                'p: first-child { color: green; }',
            ],
            'pseudo-class without descendant combinator does not match with' => [
                'p:first-child { color: green; }',
                'p :first-child { color: green; }',
            ],
            'pseudo-class with descendant combinator does not match without' => [
                'p :first-child { color: green; }',
                'p:first-child { color: green; }',
            ],
            'class does not match if uppercase' => ['.a { color: red; }', '.A { color: red; }'],
            'ID does not match if uppercase' => ['#a { color: red; }', '#A { color: red; }'],
            '`font-family` does not match if uppercase' => ['font-family: a;', 'font-family: A;'],
            'missing required whitespace after at-rule identifier' => ['@media screen', '@mediascreen'],
            'missing required whitespace in calc before addition operator' => [
                'width: calc(1px + 50%);',
                'width: calc(1px+ 50%);',
            ],
            'missing required whitespace in calc before subtraction operator' => [
                'width: calc(50% - 1px);',
                'width: calc(50%- 1px);',
            ],
            'missing required whitespace in calc after addition operator' => [
                'width: calc(1px + 50%);',
                'width: calc(1px +50%);',
            ],
            '`attr` does not match quoted attribute name' => ['content: attr(title);', 'content: attr("title");'],
            '`url` does not match without explicit `url`' => ['background: url(foo.jpeg);', 'background: foo.jpeg;'],
            '`url` does not match different URL' => ['background: url(foo.jpeg);', 'background: url(foo.png);'],
            '`url` with space in URL does not match unquoted' => [
                'background: url("f o.jpeg");',
                'background: url(f o.jpeg);',
            ],
            '`url` with `(` in URL does not match unquoted' => [
                'background: url("f(o.jpeg");',
                'background: url(f(o.jpeg);',
            ],
            '`url` with `)` in URL does not match unquoted' => [
                'background: url("f)o.jpeg");',
                'background: url(f)o.jpeg);',
            ],
            '`url` with single quote in URL does not match unquoted' => [
                'background: url("f\'o.jpeg");',
                'background: url(f\'o.jpeg);',
            ],
            '`url` with double quote in URL does not match unquoted' => [
                'background: url(\'f"o.jpeg\');',
                'background: url(f"o.jpeg);',
            ],
            '`@import` rule does not match with leading space inside quotes' => [
                '@import foo.css;',
                '@import " foo.css";',
            ],
            '`@import` rule does not match with leading line feed inside quotes' => [
                '@import foo.css;',
                "@import '\nfoo.css';",
            ],
            '`@import` rule does not match with leading Windows line ending inside quotes' => [
                '@import foo.css;',
                "@import '\r\nfoo.css';",
            ],
            '`@import` rule does not match with leading TAB inside quotes' => [
                '@import foo.css;',
                "@import '\tfoo.css';",
            ],
            '`@import` rule does not match with trailing space inside quotes' => [
                '@import foo.css;',
                '@import "foo.css ";',
            ],
            '`@import` rule does not match with leading space inside quotes with `url` function' => [
                '@import foo.css;',
                '@import url(" foo.css");',
            ],
            '`@import` rule does not match with trailing space inside quotes with `url` function' => [
                '@import foo.css;',
                '@import url("foo.css ");',
            ],
            '`@import` rule does not match with parameter in backticks' => ['@import foo.css;', '@import `foo.css`;'],
            '`@import` rule does not match with parameter in brackets' => ['@import foo.css;', '@import (foo.css);'],
            '`@import` rule does not match with misspelt `url` function' => [
                '@import foo.css;',
                '@import uri(foo.css);',
            ],
            '`@import` rule with media query does not match if media query is part of URL in quotes' => [
                '@import foo.css screen;',
                '@import "foo.css screen";',
            ],
            '`@import` rule does not match with missing semicolon' => ['@import foo.css;', '@import foo.css'],
            'more CSS than haystack' => ['p { color: green; } h1 { color: red; }', 'p { color: green; }'],
        ];
    }

    /**
     * @template T
     *
     * @param callable(string):string $callback
     * @param array<string, T> $array
     *
     * @return array<string, T>
     *
     * @throws \RuntimeException
     */
    private static function arrayMapKeys(callable $callback, array $array): array
    {
        $result = \array_combine(\array_map($callback, \array_keys($array)), \array_values($array));

        if ($result === false) {
            throw new \RuntimeException('`array_keys` and `array_values` did not give equal-length arrays', 1619201107);
        }

        return $result;
    }
}
