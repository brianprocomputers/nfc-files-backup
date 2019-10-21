<?php

namespace NFC;

use Google\Cloud\Logging\Logger;

return [
    'service_manager' => [
        'factories' => [
            'config' => Application\ConfigProviderFactory::class,
            'google_files_bucket' => Google\FilesBucketFactory::class,
            Logger::class => Google\LoggerFactory::class,
        ],
    ],
];
