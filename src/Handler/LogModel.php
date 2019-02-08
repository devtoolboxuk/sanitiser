<?php

namespace devtoolboxuk\sanitise\Handler;

use Monolog\Logger;

class LogModel
{

    private $message;
    private $logLevel;
    private $channelName;
    private $options;
    private $handlers;
    private $logger;

    function __construct($logLevel, $channelName, $options)
    {
        $this->logLevel = $logLevel;
        $this->channelName = $channelName;
        $this->options = $options;
        $this->logger = new Logger($this->channelName);

    }

    public function toArray()
    {
        return [
            'ChannelName' => $this->getChannelName(),
            'Message' => $this->getMessage(),
            'LogLevel' => $this->getLogLevel(),
            'Options' => $this->getOptions(),
            'Handlers' => $this->getHandlers()
        ];
    }

    public function getChannelName()
    {
        return $this->channelName;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getLogLevel()
    {
        return $this->logLevel;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getHandlers()
    {
        return $this->handlers;
    }

    public function info($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->info($string, $context);
    }

    public function notice($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->notice($string, $context);
    }

    public function warn($string, array $context = [])
    {
        return $this->warning($string, $context);
    }

    public function warning($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->warning($string, $context);
    }

    public function emerg($string, array $context = [])
    {
        return $this->emergency($string, $context);
    }

    public function emergency($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->emergency($string, $context);
    }

    public function err($string, array $context = [])
    {
        return $this->error($string, $context);
    }

    public function error($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->error($string, $context);
    }

    public function crit($string, array $context = [])
    {
        return $this->critical($string, $context);
    }

    public function critical($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->critical($string, $context);
    }

    public function alert($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->alert($string, $context);
    }

    public function debug($string, array $context = [])
    {
        $this->message = $string;
        $this->logger->debug($string, $context);
    }

    public function addHandler($name, $handler, $log)
    {
        $this->handlers[$name] = $handler;
        $this->logger->pushHandler($handler->createHandler($log));
    }

    public function addHandlers(array $options)
    {
        $this->handlers = $options;
        return $this;
    }

    public function getHandler($name)
    {
        if (!$this->hasHandler($name)) {
            return null;
        }

        return $this->handlers[$name];
    }

    public function hasHandler($name)
    {
        return isset($this->handlers[$name]);
    }
}