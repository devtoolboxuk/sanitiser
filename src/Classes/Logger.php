<?php

namespace devtoolboxuk\sanitise\Classes;

use devtoolboxuk\sanitise\Handler\LogModel;

class Logger extends AbstractLog
{

    private $handlers;

    function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    public function log()
    {
        $model = new LogModel($this->logLevel, $this->channelName, $this->options);

        $this->getHandlers();

        foreach ($this->getPrefixes() as $prefix) {
            foreach ($this->rules as $handler) {
                $className = str_replace($prefix, '', get_class($handler));
                $model->addHandler($className, $handler, $model);
            }
        }

        return $model;

    }

    private function getHandlers()
    {
        $this->addRule('Null');
        $this->handlers = $this->getOption('Handlers');
        foreach ($this->handlers as $name=>$handler) {

            if ($this->handlerActive($handler)) {
                $this->addRule($name);
            }
        }
    }

}