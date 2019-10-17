<?php

namespace NFC\Google;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Google\Cloud\Storage\StorageClient;

final class FilesBucketFactory implements
    FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        $storage = new StorageClient([
            'keyFilePath' => $config['google']['keyFilePath'],
        ]);

        $bucket = $storage->bucket($config['google']['storage']['filesBucket']);

        return $bucket;
    }
}
