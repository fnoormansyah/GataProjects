<?php
    ini_set("memory_limit",-1);
    class routes
    {
        function call($model, $action, $dbh) {
            require_once('models/' . $model . '.class.php');
            require_once('controllers/' . $model . '.controller.php');

            $controllerName = $model."Controller";
            $model = new $model();
            $controller = new $controllerName($model,$dbh);   
            $controller->{ $action }();
        }
    }
?>