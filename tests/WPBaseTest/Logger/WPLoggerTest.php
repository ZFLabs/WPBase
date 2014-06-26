<?php

namespace WPBaseTest\Logger;

use WPBaseTest\Framework\TestCase;
use WPBase\Logger\WPLogger;



class WPLoggerTest extends TestCase
{
    public function testClassExist()
    {
        $this->assertTrue(class_exists('\\WPBase\\Logger\\WPLogger'));
    }

    public function testVerificaSeExisteMetodoEsperado()
    {
        $this->assertTrue(method_exists('\\WPBase\\Logger\\WPLogger', 'addWriter'));
    }

    public function testVerificaSeCriaArquivoDeLog()
    {
        //Remove diretório se existir
        if(file_exists('data/log/error_exception.log')){
            self::delTree('data/log');
        }

        WPLogger::addWriter($this->getException());

        $this->assertTrue(file_exists('data/log/error_exception.log'));
    }

    private function getException()
    {
        return new \Exception('Teste');
    }

    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }


}
