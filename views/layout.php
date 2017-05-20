<?php
    
    ini_set("display_errors",1);
    ini_set("memory_limit",-1);
    date_default_timezone_set('GMT');
    include_once 'routes.php';
    
    $routes = new routes();

    $routes->call($model, $action, $dbh);
            
?>
             


