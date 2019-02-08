<?php

namespace devtoolboxuk\sanitise\Classes;

use devtoolboxuk\sanitise\Handler\LogModel;

use ReflectionClass;

use Monolog\Logger;

abstract class AbstractLog
{

    public $rules = [];
    protected $prefixes = ['devtoolboxuk\\logging\\Handler\\'];

    protected $channelName = 'log';
    protected $logLevel = Logger::DEBUG;

    protected $options = [];
    protected $model;

    public function __construct($options = [])
    {
        $localOptions = new LogOptions();
        $this->options = $this->array_merge_recursive_distinct($localOptions->getOptions(), $options);
        $this->setChannelName($this->getOption('ChannelName'));
        $this->setLogLevel($this->getOption('Level'));

    }


    function handlerActive($handler)
    {
        if (isset($handler['active'])) {
            if ($handler['active'] || $handler['active'] == 1) {
                return true;
            }
        }
        return false;
    }


    public function getOption($name)
    {
        if (!$this->hasOption($name)) {
            return null;
        }

        return $this->options[$name];
    }

    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    public function setChannelName($channelName)
    {
        $this->channelName = $channelName;
    }

    public function setLogLevel($logLevel)
    {
        $this->logLevel = $logLevel;
    }

    private function array_merge_recursive_distinct(array $array1, array $array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }



    public function addRule($method, $arguments = [])
    {
        $this->rules[] = $this->build($method, $arguments);
        return $this;
    }

    protected function build($method, $arguments = [])
    {


        foreach ($this->getPrefixes() as $prefix) {

            $className = $prefix . ucfirst($method);

            if (!class_exists($className)) {
                continue;
            }

            $reflection = new ReflectionClass($className);

            if (!$reflection->isInstantiable()) {
                throw new InvalidClassException(sprintf('"%s" must be instantiable', $className));
            }

            return $reflection->newInstanceArgs($arguments);
        }
        throw new \Exception(sprintf('"%s" is not a valid logg xx name', $method));

    }

    protected function getPrefixes()
    {
        return $this->prefixes;
    }

    protected function getOptions()
    {
        return $this->options;
    }


}