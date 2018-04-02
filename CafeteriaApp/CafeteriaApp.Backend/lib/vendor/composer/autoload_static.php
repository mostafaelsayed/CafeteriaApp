<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6c6dfcae0dd4dc5db30e01d01f692e3d
{
    public static $files = array (
        'e07c71f2ea2b62b033964b1e1efa7980' => __DIR__ . '/..' . '/abeautifulsite/simple-php-captcha/simple-php-captcha.php',
        'c65d09b6820da036953a371c8c73a9b1' => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook/polyfills.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'F' => 
        array (
            'Facebook\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PayPal' => 
            array (
                0 => __DIR__ . '/..' . '/paypal/rest-api-sdk-php/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6c6dfcae0dd4dc5db30e01d01f692e3d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6c6dfcae0dd4dc5db30e01d01f692e3d::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit6c6dfcae0dd4dc5db30e01d01f692e3d::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
