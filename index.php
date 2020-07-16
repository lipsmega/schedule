<?php

spl_autoload_register( function($class) {
    if (file_exists($class . '.php')) {
        require_once $class . '.php';
    }
});

$class = isset($_REQUEST['class']) ? $_REQUEST['class'] : 'UserList';
$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;

if (class_exists($class))
{
    $page = new $class( $_REQUEST );
    
    if (!empty($method) AND method_exists($class, $method))
    {
        $page->$method( $_REQUEST );
    }
    $page->show();
}
