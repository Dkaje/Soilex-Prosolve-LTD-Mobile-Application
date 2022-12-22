<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd9d701081109d5f648b4ff031d6387b5
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd9d701081109d5f648b4ff031d6387b5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd9d701081109d5f648b4ff031d6387b5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd9d701081109d5f648b4ff031d6387b5::$classMap;

        }, null, ClassLoader::class);
    }
}
