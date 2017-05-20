<?php
    ob_start();
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/master_module.class.php';
    require_once './models/master_group_detail.class.php';
    require_once './controllers/master_module.controller.generate.php';
    require_once './controllers/master_group_detail.controller.php';
    if (! isset($_SESSION)){
		session_start();
	}
    class master_moduleController extends master_moduleControllerGenerate
    {
        function showMenu(){                        
            $id = isset($_REQUEST['id'])?$_REQUEST['id'] : "";    
            
//            echo $id;
            
            $master_module = $this->showData($id);            
            require_once './views/menu_header.php';
        }
        function showMenuBox(){            
            $id = isset($_REQUEST['id'])?$_REQUEST['id'] : "";
            
            
            
            $master_module = new master_module();
            $master_moduleController = new master_moduleController($master_module, $this->dbh);
            $master_module_list_ = $master_moduleController->showFindData("parentid", "=", $id);
            
            
            
            $isadmin = unserialize($_SESSION[config::$ISADMIN]); 
            if($isadmin) {
                $master_module_list = $master_module_list_;
            }else{
                $master_group_detail_list_ = unserialize($_SESSION[config::$MASTER_GROUP_DETAIL_LIST]);
                foreach($master_module_list_ as $master_module){                    
                    foreach($master_group_detail_list_ as $master_group_detail_) {
                        if ($master_module->getModule() == $master_group_detail_->getModule()){
                            $master_module_list[] = $master_module;
                        }
                    }
                }
            }
            require_once './views/menu_box.php';
        }
        function showMenuBoxHeader($user){
            $sql = "SELECT b.* 
                    FROM master_group_detail a
                           INNER JOIN master_module b
                                   ON a.module = b.module
                                           AND b.parentid = 0
                                           AND  (a.read = 1 OR b.public = 1)
                           INNER JOIN `master_user_detail` c
                                   ON a.groupcode = c.groupcode
                                      AND c.user = '".$user."'
                   GROUP BY b.module ";
            
            echo $sql;
            
            $master_module_list = $this->createList($sql);
            return $master_module_list;
        }
        
        public function saveData(){
            $check = $this->checkData($this->master_module->getId());
            if($check == 0){
                if ($this->ispublic || $this->isadmin || ($this->isread && $this->isentry)){
                    $this->insertData();
                    $last_id = $this->dbh->lastInsertId();
                    $this->setLastId($last_id);
                    $master_module=new master_module();
                    $master_modulectrl=new master_moduleController($master_module, $this->dbh);
                    $master_module=$master_modulectrl->showData($this->getLastID());
                    $master_module->setOnclick("showMenu('contentmenu', 'index.php?model=master_module&action=showMenu&id=".$this->getLastID()."')");
                    $master_module->setOnclicksubmenu("showMenu('content', 'index.php?model=".strtolower($master_module->getModule())."&action=showAllJQuery')");
                    $master_module->setDescriptionhead($this->cariBreadcumb($this->getLastID()));
                    $master_modulectrl->setMaster_module($master_module);
                    $master_modulectrl->setIsadmin(true);
                    $master_modulectrl->updateData();
                    
                    echo "Data is Inserted";
                }else{
                    echo "You cannot insert data this module";
                }
            } else {
                if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                    $this->updateData();
                    echo "Data is updated";
                }else{
                    echo "You cannot update this module";
                }
            }
            
            
        }
        function tampilgambaricon(){
            $file=$_REQUEST['namafile'];
            echo "<img src='./".$file."'>";
        }
        function getbreadcumb(){
            $id=$_REQUEST['id'];
            $this->cariBreadcumb($id);
            //print_r($cetak);
        }
        
        function cariBreadcumb($id,$i=1,$cetak=null){ 
            
            $sql="select parentid,description from master_module where id=".$id;
            $hsl=$this->dbh->query($sql)->fetch();
            $cetak[$i]="<a href=\"#\" onclick=\"showMenu('contentmenu', 'index.php?model=master_module&action=showMenu&id=".$id."')\">".$hsl[1]."</a> ";
            if($hsl[0]!=0){ 
                
                return $this->cariBreadcumb($hsl[0],$i=$i+1,$cetak);
            }else{
                $data="";
                $n=count($cetak);
                $x=1;
                for($a=$n;$a>=1;$a--){
                    if($x!=$n){
                        $data.= $cetak[$a]." / ";
                    }else{
                        $data.= $cetak[$a];
                    }
                    
                    $x++;
                }
                
                return $data;
            }
            
        }
    }
?>
