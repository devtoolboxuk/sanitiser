<?php

namespace devtoolboxuk\sanitise\Handler;

abstract class FilterAdapter implements HandlerInterface
{

    protected $globalOptions;
    protected $options = [];
    private $level;

    public function createHandler(LogModel $log)
    {
        $this->options = $log->getOptions();
        $this->level = $log->getLogLevel();
    }

    protected function setOptions($className)
    {
        $this->options = isset($this->options['Handlers'][$className]) ? $this->options['Handlers'][$className] : [];
        return;
    }


    public function getOption($name)
    {
        if (!$this->hasOption($name)) {
            return null;
        }

        return $this->options[$name];
    }

    private function hasOption($name)
    {
        return isset($this->options[$name]);
    }


    protected function getLogLevel()
    {
        return $this->level;
    }

}