<?php

namespace devtoolboxuk\sanitiser;

/**
 * @method static Firewall logger()
 */
class Sanitise
{
    protected static $factory;
    protected static $options;
    protected static $dbService;

    public static function create()
    {
        $ref = new ReflectionClass(__CLASS__);

        return $ref->newInstance(func_get_args());
    }

    public static function __callStatic($ruleName, $arguments = [])
    {
        $validator = new static();
        return $validator->__call($ruleName, $arguments);
    }

    public static function buildSanitise($ruleSpec)
    {
        try {
            return static::getFactory()->sanitise($ruleSpec, static::$options);
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }

    /**
     * @return Factory
     */
    protected static function getFactory()
    {
        if (!static::$factory instanceof Factory) {
            static::$factory = new Factory();
        }

        return static::$factory;
    }

    /**
     * @param Factory $factory
     */
    public static function setFactory($factory)
    {
        static::$factory = $factory;
    }

    public function __call($method, $arguments)
    {
        return static::buildSanitise($method);
    }

    /**
     * @param $options
     */
    public static function setOptions($options)
    {
        static::$options = $options;
    }

}
