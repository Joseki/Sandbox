<?php

namespace MyApplication\LeanMapper;

class FileLogger
{

    public function register(\DibiConnection $connection, $path)
    {
        $connection->onEvent[] = array(
            new \DibiFileLogger($path, \DibiEvent::QUERY),
            'logEvent'
        );
    }
}
