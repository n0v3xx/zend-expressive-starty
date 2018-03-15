<?php

namespace App\Logger;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zend\Stratigility\Middleware\ErrorHandler;

class LoggingErrorListenerDelegatorFactory
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @return ErrorHandler
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback)
    {
        $listener = new LoggingErrorListener($container->get('Application\Error'));
//        $listener = new LoggingErrorListener($container->get(LoggerInterface::class));
        /* @var $errorHandler ErrorHandler */
        $errorHandler = $callback();
        $errorHandler->attachListener($listener);
        return $errorHandler;
    }
}