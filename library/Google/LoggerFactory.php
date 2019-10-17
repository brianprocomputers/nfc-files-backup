<?php

namespace NFC\Google;

use Exception;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Google\Cloud\Logging\LoggingClient;

final class LoggerFactory implements
    FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (! isset($options['name'])) {
            throw new Exception('Name is a required option to build a logger.');
        }

        $config = $container->get('config');

        $loggingClient = new LoggingClient([
            'keyFilePath' => $config['google']['keyFilePath'],
        ]);

        $logger = $loggingClient->logger($config['google']['logging']['prefix'] . $options['name']);

        return $logger;
    }
}
