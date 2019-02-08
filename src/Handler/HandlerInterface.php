<?php

namespace devtoolboxuk\sanitise\Handler;

interface HandlerInterface
{
    public function createHandler(LogModel $log);
}