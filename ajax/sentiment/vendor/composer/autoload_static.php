<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6e42d5837016be71fa761a385fce0925
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sentiment\\Tests\\' => 16,
            'Sentiment\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sentiment\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Sentiment\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
            1 => __DIR__ . '/..' . '/davmixcool/php-sentiment-analyzer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6e42d5837016be71fa761a385fce0925::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6e42d5837016be71fa761a385fce0925::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6e42d5837016be71fa761a385fce0925::$classMap;

        }, null, ClassLoader::class);
    }
}
