<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NFC\Application;
use Google\Cloud\Logging\LoggingClient;

Application::bootstrap();

$logger = Application::getServiceManager()->get(LoggingClient::class, ['name' => 'backup-service']);
$filesBucket = Application::getServiceManager()->get('google_files_service');

while (true) {
    $files = $filesBucket->objects([
        'maxResults' => 1000,
        'fields' => 'items/name,nextPageToken'
    ]);

    foreach ($files as $file) {

    }
}

