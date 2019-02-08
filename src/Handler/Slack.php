<?php

namespace devtoolboxuk\sanitise\Handler;

use Monolog\Handler\SlackHandler;

class Slack extends LogAdapter
{

    public function createHandler(LogModel $log)
    {
        parent::createHandler($log);
        parent::setOptions($this->getClassName());

        $handler = new SlackHandler(
            $this->options['token'],
            $this->options['channel'],
            $this->options['user'],
            $this->options['attachment'],
            $this->options['icon']
        );

        $handler->setLevel($log->getLogLevel());
        return $handler;
    }

    private function getClassName()
    {
        return str_replace(__NAMESPACE__.'\\','',__CLASS__);
    }
}