<?php
        if(!file_exists('database/connection.php')){
            header("location:welcome.php");
        }else{
            require_once('./database/connection.php');
            require_once('./database/config.php');
            
        }
        if (isset($_GET['model'])) {
            $model = $_GET['model'];
        } else {
            $model = 'home';
        }

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'show';        
        }

        require_once('views/layout.php');
    
?>