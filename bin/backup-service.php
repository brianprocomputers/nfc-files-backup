<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NFC\Application;
use Google\Cloud\Logging\Logger;

Application::bootstrap();

$logger = Application::getServiceManager()->build(Logger::class, ['name' => 'backup-service']);
$filesBucket = Application::getServiceManager()->get('google_files_bucket');

// Allow this script to run on the cli only
if (php_sapi_name() !== 'cli') {
    header("Status: 403 Forbidden");
    die();
}

$entry = $logger->entry("Backup Service start");
$logger->write($entry);

while (true) {
    $files = $filesBucket->objects([
        'maxResults' => 1000,
        'fields' => 'items/name,nextPageToken'
    ]);

    foreach ($files as $object) {
        $fileName = Application::getConfig()['downloadDirectory'] . $object->name();

        if (file_exists($fileName)) {
            continue;
        } else {
            $entry = $logger->entry("Downloading: " . $object->name());
            $logger->write($entry);

            if (! file_exists(dirname($fileName))) {
                mkdir(dirname($fileName), 0777, true);
            }

            $fileContent = $object->downloadAsStream()->getContents();
            file_put_contents($fileName, $fileContent);
        }
    }

    $entry = $logger->entry("Backup Service run complete.  Sleeping for 1 hour.");
    $logger->write($entry);

    sleep(3600);
}

$entry = $logger->entry("Backup Service end");
$logger->write($entry);
