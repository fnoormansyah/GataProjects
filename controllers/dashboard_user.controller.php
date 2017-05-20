<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/dashboard_user.class.php';
    require_once './controllers/dashboard_user.controller.generate.php';
    if (!isset($_SESSION)){
        session_start();
    }

    class dashboard_userController extends dashboard_userControllerGenerate
    {
        function saveGraphUserById(){
            if (isset($_POST['graph_query_id'])){
                $id = isset($_POST['id'])?$_POST['id'] : "0";
                $graph_query_id = isset($_POST['graph_query_id'])?$_POST['graph_query_id'] : "";
                $user = isset($_POST['user'])?$_POST['user'] : "";
                $this->dashboard_user->setGraph_query_id($graph_query_id);
                $this->dashboard_user->setUser($user);            
                $this->insertData();
            }
        }
        
    }
?>
