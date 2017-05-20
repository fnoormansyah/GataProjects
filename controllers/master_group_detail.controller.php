<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/master_group.class.php';
    require_once './models/master_group_detail.class.php';
    require_once './models/master_module.class.php';
    require_once './controllers/master_group.controller.php';
    require_once './controllers/master_group_detail.controller.generate.php';
    require_once './controllers/master_module.controller.php';
 
    class master_group_detailController extends master_group_detailControllerGenerate
    {
        function deleteData($groupcode){
            $sql = "DELETE FROM master_group_detail WHERE groupcode = '".$groupcode."'";
            $execute = $this->dbh->query($sql);
        }
        
        function savePrivileges(){
            $groupcode = isset($_POST['groupcode']) ? $_POST['groupcode'] : "";                        
            
            $readarray = isset($_POST['read']) ? $_POST['read'] : "";
            $confirmarray = isset($_POST['confirm']) ? $_POST['confirm'] : "";
            $entryarray = isset($_POST['entry']) ? $_POST['entry'] : "";
            $updatearray = isset($_POST['update']) ? $_POST['update'] : "";
            $deletearray = isset($_POST['delete']) ? $_POST['delete'] : "";
            $printarray = isset($_POST['print']) ? $_POST['print'] : "";
            $exportarray = isset($_POST['export']) ? $_POST['export'] : "";
            $importarray = isset($_POST['import']) ? $_POST['import'] : "";
                        
            $this->deleteData($groupcode);
            
            $master_module = new master_module();
            $master_moduleController = new master_moduleController($master_module, $this->dbh);
            $master_module_list = $master_moduleController->showDataAll();
            foreach($master_module_list as $master_module){
                $master_group_detail = new master_group_detail();
                $master_group_detail->setGroupcode($groupcode);
                $master_group_detail->setModule($master_module->getModule());
                $cekok = false;
                $master_group_detail->setRead(0);
                foreach ($readarray as $read) {
                    if ($read == $master_module->getModule()) {
                       $master_group_detail->setRead(1);
                       $cekok = true;
                       break;
                    }
                }
                $master_group_detail->setConfirm(0);
                $master_group_detail->setEntry(0);
                $master_group_detail->setUpdate(0);
                $master_group_detail->setDelete(0);
                $master_group_detail->setPrint(0);
                $master_group_detail->setExport(0);
                $master_group_detail->setImport(0);
                
                if($cekok) {
                    foreach ($confirmarray as $confirm) {
                        if ($confirm == $master_module->getModule()) {
                           $master_group_detail->setConfirm(1);
                           break;
                        }
                    }
                    foreach ($entryarray as $entry) {
                        if ($entry == $master_module->getModule()) {
                           $master_group_detail->setEntry(1);
                           break;
                        }
                    }
                    foreach ($updatearray as $update) {
                        if ($update == $master_module->getModule()) {
                           $master_group_detail->setUpdate(1);
                           break;
                        }
                    }
                    foreach ($deletearray as $delete) {
                        if ($delete == $master_module->getModule()) {
                           $master_group_detail->setDelete(1);
                           break;
                        }
                    }
                    foreach ($printarray as $print) {
                        if ($print == $master_module->getModule()) {
                           $master_group_detail->setPrint(1);
                           break;
                        }
                    }
                    foreach ($exportarray as $export) {
                        if ($export == $master_module->getModule()) {
                           $master_group_detail->setExport(1);
                           break;
                        }
                    }
                    foreach ($importarray as $import) {
                        if ($import == $master_module->getModule()) {
                           $master_group_detail->setImport(1);
                           break;
                        }
                    }
                }
                $this->setMaster_group_detail($master_group_detail);
                $this->saveData();                 
            }             
        }
        function showTestPrevileges(){
            $master_group = new master_group();
            $master_group_controller = new master_groupController($master_group, $this->dbh);
            $master_group = $master_group_controller->showData("Sales");
            $this->showPrevileges($master_group);
        }
        function showPrevileges($master_group) {           
            $sql = "SELECT IFNULL(b.id,0) id, 
                            '".$master_group->getGroupcode()."' groupcode, 
                            b.module module, 
                            IFNULL(a.read, 0) `read`, 
                            IFNULL(a.confirm,0) `confirm`, 
                            IFNULL(a.entry,0) `entry`, 
                            IFNULL(a.update,0) `update`, 
                            IFNULL(a.delete,0) `delete`, 
                            IFNULL(a.print,0) `print`, 
                            IFNULL(a.export,0) `export`, 
                            IFNULL(a.import,0) `import`, 
                            a.entrytime, a.entryuser, a.entryip,
                            a.updatetime, a.updateuser, a.updateip
                    FROM master_group_detail a
                            RIGHT JOIN master_module b
                                    ON a.module = b.module	
                                      AND a.groupcode = '".$master_group->getGroupcode()."';";
            
            $master_group_detail_list = $this->createList($sql);
            $master_group_detail_controller = $this;
            require_once './views/master_group_detail/master_group_detail_list_previleges.php';               
        }
        function getModuleNameByDetail($master_group_detail) {
            $master_module = new master_module();
            $master_moduleController = new master_moduleController($master_module, $this->dbh);
            $master_module = $master_moduleController->showData($master_group_detail->getId());
            return $master_module;
        }
        
        function getPrevileges($user){
            $sql = " SELECT mgd.id, mgd.groupcode, mgd.module,
                            SUM(mgd.`read`) `read`,
                            SUM(mgd.confirm) `confirm`,
                            SUM(mgd.entry) `entry`,
                            SUM(mgd.`update`) `update`,
                            SUM(mgd.`delete`) `delete`,
                            SUM(mgd.`export`) `export`,
                            SUM(mgd.`Print`) `Print`,
                            SUM(mgd.`import`) `import`,
                            mgd.entrytime, mgd.entryuser, mgd. entryip, mgd.updatetime, mgd.updateuser, mgd.updateip
                          FROM master_user_detail mud
                                INNER JOIN master_group_detail mgd
                                    ON mud.groupcode = mgd.groupcode
                                       and mud.User = '".$user."'
                                       and mgd.read = 1
                          GROUP BY mgd.Module
                          ORDER BY mgd.module";
            $master_group_detail_list = $this->createList($sql);
            return $master_group_detail_list;
        }
    }
?>
