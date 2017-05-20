<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/initial_company.class.php';
    require_once './controllers/initial_company.controller.generate.php';
    if (!isset($_SESSION)){
        session_start();
    }

    class initial_companyController extends initial_companyControllerGenerate
    {

    }
?>
