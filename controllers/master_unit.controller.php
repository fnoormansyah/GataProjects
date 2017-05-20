<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/master_unit.class.php';
    require_once './controllers/master_unit.controller.generate.php';
    if (!isset($_SESSION)){
        session_start();
    }

    class master_unitController extends master_unitControllerGenerate
    {
        function showDataUnit(){
            $sql = "select * from master_unit ";
            return $this->createList($sql);            
        }
    }
?>
