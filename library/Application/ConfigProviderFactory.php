<?php

namespace NFC\Application;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use NFC\Bootstrap;
use NFC\Application as NfcApplication;

final class ConfigProviderFactory implements
    FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return NfcApplication::getConfig();
    }
}
