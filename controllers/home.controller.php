<?php
include './models/initial_company.class.php';
include './controllers/initial_company.controller.php';
require_once './database/config.php';


    class homeController
    {
        private $home;
        private $dbh;
        
        function __construct($home, $dbh) {
            $this->home = $home;
            $this->dbh = $dbh;
        }

        function show(){
            $dbh = $this->dbh;
            $initial_company=new initial_company();
            $initial_companyctrl=new initial_companyController($initial_company, $this->dbh);
            $initial_company=$initial_companyctrl->showData(1);
            
            require_once './views/home.php';
        }
        
    }
?>
