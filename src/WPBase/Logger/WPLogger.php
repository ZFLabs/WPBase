<?php
namespace WPBase\Logger;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class WPLogger
{
    public static function addWriter(\Exception $e)
    {
        if(!file_exists('./data/log')){
            mkdir('./data/log', 0777);
        }

        if(!file_exists('./data/log/error_exception.log')){
            $file = fopen('/data/log/error_exception.log', 'a');
            fclose($file);
        }

        $logger = new Logger;
        $writer = new Stream('./data/log/error_exception.log');
        $logger->addWriter($writer);
        $logger->info("Informational message " . date('Y-m-d H:i:s'));

        $logger->crit($e->getTraceAsString() . "\n\n");

    }
} 