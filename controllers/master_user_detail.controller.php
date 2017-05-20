<?php
    require_once './models/master_user.class.php';
    require_once './models/master_user_detail.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './controllers/master_user_detail.controller.generate.php';
	if(!isset($_SESSION)){
    	session_start();
	}

    class master_user_detailController extends master_user_detailControllerGenerate
    {
        function showTestPrevileges(){
            $master_user = new master_user();
            $master_user_controller = new master_userController($master_user, $this->dbh);
            $master_user = $master_user_controller->showData("windu");
            $this->showPrevileges($master_user);
        }

        function showPrevileges($master_user) {           
            $sql = "SELECT IFNULL(a.id,0) id, '". $master_user->getUser() ."' `user`, b.groupcode, a.entrytime, a.entryuser, a.entryip, a.updatetime, a.updateuser, a.updateip
                FROM master_user_detail a
                        RIGHT JOIN master_group b
                                ON a.groupcode = b.groupcode		
                                  AND a.user = '". $master_user->getUser() ."';";
            /*$master_user_detail_list = $this->createList($sql);
            $master_user_detail_controller = $this;*/
            
            return $this->createList($sql);
            //require_once './views/master_user_detail/master_user_detail_list_previleges.php';               
        }
        function savePrivileges(){
            $user = isset($_POST['user']) ? $_POST['user'] : "";                        
            $grouparray = isset($_POST['group']) ? $_POST['group'] : "";
            
            $this->deleteData($user);            
            foreach ($grouparray  as $group) {
                $master_user_detail = new master_user_detail();
                $master_user_detail->setGroupcode($group);
                $master_user_detail->setUser($user);
                
                $this->setMaster_user_detail($master_user_detail);
                $this->saveData();                
            }
            echo "save";
        }
        function deleteData($user){
            $sql = "DELETE FROM master_user_detail WHERE user = '".$user."'";
            $execute = $this->dbh->query($sql);
        }

    }
?>
