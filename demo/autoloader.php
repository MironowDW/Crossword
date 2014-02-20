<?php

spl_autoload_register(
    function ($class)
    {
        $file = dirname(__DIR__) . '/src/' . str_replace('\\', '/', $class) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
);