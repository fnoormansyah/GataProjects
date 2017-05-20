<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/master_department.class.php';
    require_once './controllers/master_department.controller.generate.php';
    if (!isset($_SESSION)){
        session_start();
    }

    class master_departmentController extends master_departmentControllerGenerate
    {
        function showDataDepartment(){
            $sql = "select * from master_department ";
            return $this->createList($sql);            
        }
    }
?>
