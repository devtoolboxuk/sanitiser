<?php

namespace devtoolboxuk\sanitise\Handler;

use Monolog\Handler\nullHandler;

class Null extends FilterAdapter
{

    public function createHandler(LogModel $log)
    {
        parent::createHandler($log);
        parent::setOptions($this->getClassName());
        $handler = new nullHandler();
        return $handler;
    }

    private function getClassName()
    {
        return str_replace(__NAMESPACE__.'\\','',__CLASS__);
    }
}