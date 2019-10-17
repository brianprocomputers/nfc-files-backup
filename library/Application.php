<?php

/**
 * Because the app did not have any bootstrap or service manager at the time
 * I worked on it I create this and consolidated the configuration for the
 * application here
 */

namespace NFC;

use Zend\Stdlib\ArrayUtils;
use Zend\ServiceManager\ServiceManager;

class Application
{
    private static $config = [];
    private static $serviceManager;
    private static $sessionHandler;

    public static function bootstrap()
    {
        self::$config = self::mergeConfig();
        self::initServiceManager();
    }

    public static function getConfig()
    {
        return self::$config;
    }

    public static function getServiceManager()
    {
        return self::$serviceManager;
    }

    private static function mergeConfig()
    {
        $mergedConfig = [];
        $configFiles = scandir(__DIR__ . '/../config');

        foreach ($configFiles as $filename) {
            if (fnmatch('*.global.php', $filename)) {
                $config = require_once __DIR__ . '/../config/' . $filename;
                $mergedConfig = ArrayUtils::merge($mergedConfig, $config);
            }
        }

        foreach ($configFiles as $filename) {
            if (fnmatch('*.local.php', $filename)) {
                $config = require_once __DIR__ . '/../config/' . $filename;
                $mergedConfig = ArrayUtils::merge($mergedConfig, $config);
            }
        }

        foreach ($configFiles as $filename) {
            if (fnmatch('local.php', $filename)) {
                $config = require_once __DIR__ . '/../config/' . $filename;
                $mergedConfig = ArrayUtils::merge($mergedConfig, $config);
            }
        }

        return $mergedConfig;
    }

    private static function initServiceManager()
    {
        self::$serviceManager = new ServiceManager(self::$config['service_manager']);
    }
}
