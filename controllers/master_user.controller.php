<?php
    require_once './models/master_user.class.php';
    require_once './models/master_profil.class.php';
    require_once './models/master_user_detail.class.php';
    require_once './controllers/master_user.controller.generate.php';
    require_once './controllers/master_profil.controller.php';
    require_once './controllers/master_user_detail.controller.php';
    require_once './controllers/tools.controller.php';
    require_once './controllers/master_unit.controller.php';
    require_once './controllers/master_department.controller.php';
    require_once './controllers/master_group.controller.php';
    
    if (!isset($_SESSION)){
        session_start();
    }
 
    class master_userController extends master_userControllerGenerate
    {
        function showDetailJQuery(){
            $id = $_GET['id'];
            $master_user_ = $this->showData($id);
            
            $master_unit = new master_unit();
            $master_unit_controller= new master_unitController($master_unit, $this->dbh);
            $master_unit_list=  $master_unit_controller->showData($master_user_->getUnitid());

            $master_department = new master_department();
            $master_department_controller = new master_departmentController($master_department, $this->dbh);
            $master_department_list = $master_department_controller->showData($master_user_->getDepartmentid());
            
            $master_user_detail = new master_user_detail();
            $master_user_detail_controller = new master_user_detailController($master_user_detail, $this->dbh);
            $master_user_detail_list = $master_user_detail_controller->showPrevileges($master_user_);
            
            require_once './views/master_user/master_user_jquery_detail.php';
        }
        
        function showFormJQuery(){
            
            $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
            $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
            $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
            $master_user_ = $this->showData($id);

            $master_unit = new master_unit();
            $master_unit_controller= new master_unitController($master_unit, $this->dbh);
            $master_unit_list=  $master_unit_controller->showDataUnit();

            $master_department = new master_department();
            $master_department_controller = new master_departmentController($master_department, $this->dbh);
            $master_department_list = $master_department_controller->showDataDepartment();
            
            $master_user_detail = new master_user_detail();
            $master_user_detail_controller = new master_user_detailController($master_user_detail, $this->dbh);
            $master_user_detail_list = $master_user_detail_controller->showPrevileges($master_user_);
            
            require_once './views/master_user/master_user_jquery_form.php';
        }
        
        public function saveFormJQuery() {
            $id = isset($_POST['id'])?$_POST['id'] : "";
	    $user = isset($_POST['user'])?$_POST['user'] : "";
	    $description = isset($_POST['description'])?$_POST['description'] : "";
	    $password = isset($_POST['password'])? md5($_POST['password']) : "";
	    $username = isset($_POST['username'])?$_POST['username'] : "";
	    $avatar = isset($_POST['avatar'])?$_POST['avatar'] : "";
	    $nik = isset($_POST['nik'])?$_POST['nik'] : "";
	    $departmentid = isset($_POST['departmentid'])?$_POST['departmentid'] : "";
	    $unitid = isset($_POST['unitid'])?$_POST['unitid'] : "";
	    $this->master_user->setId($id);
	    $this->master_user->setUser($user);
	    $this->master_user->setDescription($description);
	    $this->master_user->setPassword($password);
	    $this->master_user->setUsername($username);
	    $this->master_user->setAvatar($avatar);
	    $this->master_user->setNik($nik);
	    $this->master_user->setDepartmentid($departmentid);
	    $this->master_user->setUnitid($unitid);            
            $this->saveData();
            
            $master_user_detail = new master_user_detail();
            $master_user_detail_controller = new master_user_detailController($master_user_detail, $this->dbh);
            $master_user_detail_controller->savePrivileges();
        }
        
        
        function checkAdmin($user){
            $sql = "SELECT count(*) FROM master_user_detail mud WHERE `user` = '". $user ."' AND groupcode = 'admin';";            
            $row = $this->dbh->query($sql)->fetch();
            return $row[0];
        }
        
        function changePasswordForm(){
            require_once './views/master_user/master_user_change_password.php';            
        }
        
        function changePassword(){
            
            $oldpassword = isset($_POST['oldpassword']) ? $_POST['oldpassword'] : "";
            $newpassword = isset($_POST['newpassword']) ? $_POST['newpassword'] : "";
            $retypepassword = isset($_POST['retypepassword']) ? $_POST['retypepassword'] : "";
            
            $masteruser = isset($_SESSION[config::$LOGIN_USER])? unserialize($_SESSION[config::$LOGIN_USER]) : new master_user();
            
            if (md5($oldpassword) ==  $masteruser->getPassword()) {
                if ($newpassword == $retypepassword){
                    if (trim($newpassword) != "") {
                        if(strlen(trim($newpassword)) < 8 ) {
                            $masteruser->setPassword(MD5($newpassword));                        
                            $masterusercontroller = new master_userController($masteruser, $this->dbh);
                            $masterusercontroller->saveData();
                            $_SESSION[config::$LOGIN_USER] = serialize($masteruser);                                                        
                            
                        }else{
                            echo "Password Must Be More Than 8 ";
                        }
                    }else{
                        echo "Password cannot be blank";
                    }
                }else{
                    echo "New Password is not the same with retypepassword";
                }
            }else {
                echo "Old password is Not The Same";                
            }
                        
        }
    }
?>
