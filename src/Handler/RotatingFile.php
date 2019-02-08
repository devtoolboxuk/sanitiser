<?php

namespace devtoolboxuk\sanitise\Handler;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LogstashFormatter;

class RotatingFile extends LogAdapter
{

    public function createHandler(LogModel $log)
    {
        parent::createHandler($log);
        parent::setOptions($this->getClassName());

        $handler = new RotatingFileHandler($this->getLogFilename(), $this->getOption('fileNumber'));
        $handler->setFormatter(new LogstashFormatter($this->options['application']));

        $handler->setLevel($this->getLogLevel());

        return $handler;
    }

    private function getLogFileName()
    {
        return sprintf('%s%s.log', $this->options['log_path'], $this->options['fileName']);
    }

    private function getClassName()
    {
        return str_replace(__NAMESPACE__.'\\','',__CLASS__);
    }
}