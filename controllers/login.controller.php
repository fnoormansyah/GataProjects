<?php
    ob_start();
    require_once './models/login.class.php';
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/master_module.class.php';
    require_once './controllers/master_module.controller.php';
    require_once './models/master_group_detail.class.php';
    require_once './controllers/master_group_detail.controller.php';
    include_once './controllers/master_profil.controller.generate.php';
    include_once './controllers/master_profil.controller.php';
    require_once './database/config.php';

    if (!isset($_SESSION)) {
        session_start();
    }

    class loginController {
        private $login;
        var $dbh;
        var $toolsController;
        function __construct($login, $dbh) {
            $this->login = $login;
            $this->dbh = $dbh;
            $this->toolsController = new toolsController();
        }

        function checkLogin() {
            $this->login->setUser($this->toolsController->replacechar(isset($_POST['user'])?$_POST['user']:"",$this->dbh));
            $this->login->setPassword($this->toolsController->replacechar(isset($_POST['password'])?$_POST['password']:"",$this->dbh));
            
            $sql = "SELECT * FROM master_user where user = '".$this->login->getUser()."'";
            $row = $this->dbh->query($sql)->fetch();
            if($row['password'] == $this->login->getEncrypt()){
                $master_user = new master_user();
                $master_userController = new master_userController($master_user, $this->dbh);
                $master_user = $master_userController->showData($this->login->getUser());

                $master_user_detail=new master_user_detail();
                $master_user_detailctrl=new master_user_detailController($master_user_detail, $this->dbh);
                $master_user_detail_list=$this->showDataUserDetail($this->login->getUser());
                
                
                $isadmin = $master_userController->checkAdmin($master_user->getUser());
                        
                $master_module = new master_module();
                $master_moduleController = new master_moduleController($master_module, $this->dbh);
                if ($isadmin){
                    $master_module_list = $master_moduleController->showFindData("parentid", "=", 0);
                }else{
                    $master_module_list = $master_moduleController->showMenuBoxHeader($master_user->getUser());
                }
                
                $master_group_detail = new master_group_detail();
                $master_group_detail_controller = new master_group_detailController($master_group_detail, $this->dbh);
                $master_group_detail_list = $master_group_detail_controller->getPrevileges($master_user->getUser());               
                
                $_SESSION[config::$LOGIN_USER] = serialize($master_user);
                $_SESSION[config::$LOGIN_DETAIL] = serialize($master_user_detail_list);
                $_SESSION[config::$MENUS] = serialize($master_module_list);
                $_SESSION[config::$ISADMIN] = serialize($isadmin > 0);
                $_SESSION[config::$MASTER_GROUP_DETAIL_LIST] = serialize($master_group_detail_list );
                
            }else{
                unset($_SESSION[config::$LOGIN_USER]);
                unset($_SESSION[config::$LOGIN_DETAIL]);                
                unset($_SESSION[config::$MENUS]);
                unset($_SESSION[config::$ISADMIN]);
                unset($_SESSION[config::$MASTER_GROUP_DETAIL_LIST]);
            }
            
            header("location: index.php");

        }
        
        function logOut() {
            unset($_SESSION[config::$LOGIN_USER]);
            unset($_SESSION[config::$MENUS]);
            unset($_SESSION[config::$ISADMIN]);
            unset($_SESSION[config::$MASTER_GROUP_DETAIL_LIST]);
            echo '<script>window.location="index.php";</script>';
        }
        
        function showDataUserDetail($user){
            $sql = "SELECT * FROM master_user_detail WHERE user = '".$user."'";
            $master_user_detail=new master_user_detail();
            $master_user_detailctrl=new master_user_detailController($master_user_detail, $this->dbh);
            return $master_user_detailctrl->createList($sql);
        }
    }
	ob_flush();
?>
