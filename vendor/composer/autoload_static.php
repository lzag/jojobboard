<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf45c1d14e3f837c4560b60f490acf84a
{
    public static $prefixLengthsPsr4 = array (
        'P' =>
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' =>
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf45c1d14e3f837c4560b60f490acf84a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf45c1d14e3f837c4560b60f490acf84a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
