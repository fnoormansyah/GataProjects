<?php
    
require_once './models/master_module.class.php';
require_once './models/master_user.class.php';
require_once './controllers/master_module.controller.php';
require_once './database/config.php';


class layoutController {
    var $dbh;
    function __construct($dbh) {
        $this->dbh = $dbh;
        
    }

    function getHeader(){
        
        $initial_company=new initial_company();
        $initial_companyctrl=new initial_companyController($initial_company, $this->dbh);
        $initial_company=$initial_companyctrl->showData(1);
            
        require_once './views/header.php';
    }

    function getTesting(){
        echo "testing";
    }
    function getMenuSlider(){
        $initial_company=new initial_company();
        $initial_companyctrl=new initial_companyController($initial_company, $this->dbh);
        $initial_company=$initial_companyctrl->showData(1);
        if(isset($_SESSION[config::$MENUS])) {
            $master_module_list = unserialize($_SESSION[config::$MENUS]);
            require_once './views/menu_slider.php';        
        }else{
            require_once './views/welcome_header.php';                    
        }
    }
    function getMenuContent(){
        $initial_company=new initial_company();
        $initial_companyctrl=new initial_companyController($initial_company, $this->dbh);
        $initial_company=$initial_companyctrl->showData(1);
        require_once './views/welcome_content.php';                    
    }
            
    function getFooter(){
        $initial_company=new initial_company();
            $initial_companyctrl=new initial_companyController($initial_company, $this->dbh);
            $initial_company=$initial_companyctrl->showData(1);
            
        require_once './views/footer.php';
    }

 }
ob_flush();
?>
