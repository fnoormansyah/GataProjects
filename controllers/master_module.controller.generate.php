<?php
    require_once './models/master_module.class.php';
    require_once './models/master_module.class.php';
    require_once './controllers/master_module.controller.php';
    require_once './models/master_group_detail.class.php';
    require_once './controllers/master_group_detail.controller.php';
    require_once './models/report_query.class.php';
    require_once './controllers/report_query.controller.php';
    require_once './controllers/tools.controller.php';
    require_once './database/config.php';
    if (!isset($_SESSION)) {
        session_start();
    }
 
    class master_moduleControllerGenerate
    {
        protected $master_module;
        var $modulename = "master_module";
        var $dbh;
        var $limit = 20;
        var $user = "None";
        var $ip = "";
        var $isadmin = false;
        var $ispublic = false;
        var $isread = false;
        var $isconfirm = false;
        var $isentry = false;
        var $isupdate = false;
        var $isdelete = false;
        var $isprint = false;
        var $isexport = false;
        var $isimport = false;
        var $toolsController;
        var $lastID = "";
        function __construct($master_module, $dbh) {
            $this->modulename = strtoupper($this->modulename);
            $this->master_module = $master_module;
            $this->dbh = $dbh;            
                                     
            $user = isset($_SESSION[config::$LOGIN_USER])? unserialize($_SESSION[config::$LOGIN_USER]): new master_user() ;
            $this->user = $user->getUser();
            $this->ip =  $_SERVER['REMOTE_ADDR'];
            if ($this->modulename != "MASTER_MODULE") {
                $master_module = new master_module();
                $master_moduleController = new master_moduleController($master_module, $this->dbh);
                $master_module_list = $master_moduleController->showFindData("module", "=", $this->modulename);            
                if(count($master_module_list) == 0) {
                    $master_module_list[] = new master_module();
                }
            }else{
                $master_module_list = $this->showFindData("module", "=", $this->modulename);
            }
            foreach ($master_module_list as $master_module){
                $this->ispublic = $master_module->getPublic() > 0 ? true : false;                
            }            
            if(isset($_SESSION[config::$ISADMIN])) {
                $this->isadmin = unserialize($_SESSION[config::$ISADMIN]);
            }else{
                $this->isadmin = false;
            }

            $this->isadmin = isset($_SESSION[config::$ISADMIN]) ? unserialize($_SESSION[config::$ISADMIN]) : false;
            if(isset($_SESSION[config::$MASTER_GROUP_DETAIL_LIST]) ){
                $master_group_detail_list = unserialize($_SESSION[config::$MASTER_GROUP_DETAIL_LIST]);
            }else{
                $master_group_detail_list[] = new master_group_detail();
            }
            foreach($master_group_detail_list as $master_group_detail) {
                if($master_group_detail->getModule() == $this->modulename) {
                    $this->isread = $master_group_detail->getRead();
                    $this->isconfirm = $master_group_detail->getConfirm();
                    $this->isentry = $master_group_detail->getEntry();
                    $this->isupdate = $master_group_detail->getUpdate();
                    $this->isdelete = $master_group_detail->getDelete();
                    $this->isprint = $master_group_detail->getPrint();
                    $this->isexport = $master_group_detail->getExport();
                    $this->isimport = $master_group_detail->getImport();
                    break;
                }                
            }
            $this->toolsController = new toolsController();
        }
        
        function insertData(){
            $datetime = date("Y-m-d H:i:s");
            
            $sql = "INSERT INTO master_module ";
            $sql .= " ( ";
	    $sql .= "`id`,";
	    $sql .= "`module`,";
	    $sql .= "`descriptionhead`,";
	    $sql .= "`description`,";
	    $sql .= "`picture`,";
	    $sql .= "`classcolour`,";
	    $sql .= "`onclick`,";
	    $sql .= "`onclicksubmenu`,";
	    $sql .= "`parentid`,";
	    $sql .= "`public`,";
	    $sql .= "`entrytime`,";
	    $sql .= "`entryuser`,";
	    $sql .= "`entryip`,";
	    $sql .= "`updatetime`,";
	    $sql .= "`updateuser`,";
	    $sql .= "`updateip` ";
            $sql .= ") ";
            $sql .= " VALUES (";
	    $sql .= " null,";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getModule(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getDescriptionhead(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getDescription(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getPicture(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getClasscolour(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getOnclick(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getOnclicksubmenu(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getParentid(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_module->getPublic(), $this->dbh)."',";
	    $sql .= "'".$datetime."',";
	    $sql .= "'".$this->user."',";
	    $sql .= "'".$this->ip."',";
	    $sql .= "'".$datetime."',";
	    $sql .= "'".$this->user."',";
	    $sql .= "'".$this->ip."' ";

            $sql .= ")";
            $execute = $this->dbh->query($sql);
        }
        
        
        function updateData(){
            $datetime = date("Y-m-d H:i:s");
            $sql = "UPDATE master_module SET ";
	    $sql .= "`id` = '".$this->toolsController->replacecharSave($this->master_module->getId(),$this->dbh)."',";
	    $sql .= "`module` = '".$this->toolsController->replacecharSave($this->master_module->getModule(),$this->dbh)."',";
	    $sql .= "`descriptionhead` = '".$this->toolsController->replacecharSave($this->master_module->getDescriptionhead(),$this->dbh)."',";
	    $sql .= "`description` = '".$this->toolsController->replacecharSave($this->master_module->getDescription(),$this->dbh)."',";
	    $sql .= "`picture` = '".$this->toolsController->replacecharSave($this->master_module->getPicture(),$this->dbh)."',";
	    $sql .= "`classcolour` = '".$this->toolsController->replacecharSave($this->master_module->getClasscolour(),$this->dbh)."',";
	    $sql .= "`onclick` = '".$this->toolsController->replacecharSave($this->master_module->getOnclick(),$this->dbh)."',";
	    $sql .= "`onclicksubmenu` = '".$this->toolsController->replacecharSave($this->master_module->getOnclicksubmenu(),$this->dbh)."',";
	    $sql .= "`parentid` = '".$this->toolsController->replacecharSave($this->master_module->getParentid(),$this->dbh)."',";
	    $sql .= "`public` = '".$this->toolsController->replacecharSave($this->master_module->getPublic(),$this->dbh)."',";
	    $sql .= "`entryuser` = '".$this->toolsController->replacecharSave($this->master_module->getEntryuser(),$this->dbh)."',";
	    $sql .= "`entryip` = '".$this->toolsController->replacecharSave($this->master_module->getEntryip(),$this->dbh)."',";
	    $sql .= "`updatetime` = '".$datetime."',";
	    $sql .= "`updateuser` = '".$this->user."',";
	    $sql .= "`updateip` = '".$this->ip."' ";
            $sql .= "WHERE id = '".$this->master_module->getId()."'";  
            
            
            $execute = $this->dbh->query($sql);
        }
        
        function deleteData($id){
            $sql = "DELETE FROM master_module WHERE id = '".$id."'";
            $execute = $this->dbh->query($sql);
        }
        
        function showData($id){
            $sql = "SELECT * FROM master_module WHERE id = '".$this->toolsController->replacecharFind($id,$this->dbh)."'";

            $row = $this->dbh->query($sql)->fetch();
            $this->loadData($this->master_module, $row);
            
            return $this->master_module;
        }
        
        function checkData($id){
            $sql = "SELECT count(*) FROM master_module where id = '".$id."'";
            $row = $this->dbh->query($sql)->fetch();
            return $row[0];
        }
        
        function showDataAll(){
            $sql = $this->findDataWhere("");
            return $this->createList($sql);            
        }
        function showDataAllQuery(){
            return $this->findDataWhere($this->showDataWhereQuery());
        }
        function countDataAll(){            
            $sql = $this->findCountDataWhere($this->showDataWhereQuery());
            $row = $this->dbh->query($sql)->fetch();
            return $row[0];
        }

        function showDataWhereQuery(){
            $bsearch = isset($_REQUEST["search"]) ;
            $where = "";
            if ($bsearch) {
                $search = $_REQUEST["search"] ;
               $where .= " where id like '%".$search."%'";
               $where .= "       or  module like '%".$search."%'";
               $where .= "       or  descriptionhead like '%".$search."%'";
               $where .= "       or  description like '%".$search."%'";

            }            
            return $where;
        }        
        function showDataAllLimit(){
            $sql = $this->showDataAllLimitQuery();
            return $this->createList($sql);            
        }

        function showDataAllLimitQuery(){            
            $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
            $limit = isset($_REQUEST["limit"]) ? $_REQUEST["limit"] : 20;
            $sql = $this->showDataAllQuery();
            $sql .= " limit ". $skip . ", ". $limit;
            return $sql;
        }
        function showFindData($field, $operator ,$keyword){
            $sql = $this->findData($field, $operator ,$keyword);
            return $this->createList($sql);
        }
        
        function findData($field, $operator ,$keyword){
            $where = "WHERE (".$field." ". $operator ."  '$keyword')";
            return $this->findDataWhere($where);
        }
        function findDataWhere($where){
            $sql = "SELECT * FROM master_module  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findCountDataWhere($where){
            $sql = "SELECT count(id)  FROM master_module  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findDataSql($sql){
            return $this->createList($sql);            
        }

        function createList($sql){
            $master_module_List = array();
            foreach ($this->dbh->query($sql) as $row) {
                    $master_module_ = new master_module();
                    $this->loadData($master_module_, $row);
                    $master_module_List[] = $master_module_;
            }
            return $master_module_List;            
        }

                
        function loadData($master_module,$row){
	    $master_module->setId($row['id']);
	    $master_module->setModule($row['module']);
	    $master_module->setDescriptionhead($row['descriptionhead']);
	    $master_module->setDescription($row['description']);
	    $master_module->setPicture($row['picture']);
	    $master_module->setClasscolour($row['classcolour']);
	    $master_module->setOnclick($row['onclick']);
	    $master_module->setOnclicksubmenu($row['onclicksubmenu']);
	    $master_module->setParentid($row['parentid']);
	    $master_module->setPublic($row['public']);
	    $master_module->setEntrytime($row['entrytime']);
	    $master_module->setEntryuser($row['entryuser']);
	    $master_module->setEntryip($row['entryip']);
	    $master_module->setUpdatetime($row['updatetime']);
	    $master_module->setUpdateuser($row['updateuser']);
	    $master_module->setUpdateip($row['updateip']);

        }

        function show(){
            $this->showAll();
        }
        
        function showAll(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $last = $this->countDataAll();
                $limit = isset($_REQUEST["limit"]) ? $_REQUEST["limit"] : $this->limit;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";

                $sisa = $last % $limit;

                if ($sisa > 0) {
                    $last = $last - $sisa;
                }else if ($last - $limit < 0){
                    $last = 0;
                }else{
                    $last = $last -$limit;
                }

                $previous = $skip - $limit < 0 ? 0 : $skip - $limit ;

                if ($skip + $limit > $last) {
                    $next = $last;
                }else if($skip == 0 ) {
                    $next = $skip + $limit + 1;
                }else{
                    $next = $skip + $limit;
                }
                $first = 0;

                $pageactive = $last == 0 ? $sisa == 0 ? 0 : 1 : intval(($skip / $limit)) + 1;
                $pagecount = $last == 0 ? $sisa == 0 ? 0 : 1 : intval(($last / $limit)) + 1;

                $master_module_list = $this->showDataAllLimit();

                $isadmin = $this->isadmin;
                $ispublic = $this->ispublic;
                $isread = $this->isread;
                $isconfirm = $this->isconfirm;
                $isentry = $this->isentry;
                $isupdate = $this->isupdate;
                $isdelete = $this->isdelete;
                $isprint = $this->isprint;
                $isexport = $this->isexport ;
                $isimport = $this->isimport;

                require_once './views/master_module/master_module_list.php';
            }else{
                echo "You cannot access this module";
            }
        }
        function showAllJQuery(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $last = $this->countDataAll();
                $limit = isset($_REQUEST["limit"]) ? $_REQUEST["limit"] : $this->limit;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";

                $sisa = intval($last % $limit);

                if ($sisa > 0) {
                    $last = $last - $sisa;
                }else if ($last - $limit < 0){
                    $last = 0;
                }else{
                    $last = $last -$limit;
                }

                $previous = $skip - $limit < 0 ? 0 : $skip - $limit ;

                if ($skip + $limit > $last) {
                    $next = $last;
                }else if($skip == 0 ) {
                    $next = $skip + $limit + 1;
                }else{
                    $next = $skip + $limit;
                }
                $first = 0;

                $pageactive = $last == 0 ? $sisa == 0 ? 0 : 1 : intval(($skip / $limit)) + 1;
                $pagecount = $last == 0 ? $sisa == 0 ? 0 : 1 : intval(($last / $limit)) + 1;

                $master_module_list = $this->showDataAllLimit();
                $isadmin = $this->isadmin;
                $ispublic = $this->ispublic;
                $isread = $this->isread;
                $isconfirm = $this->isconfirm;
                $isentry = $this->isentry;
                $isupdate = $this->isupdate;
                $isdelete = $this->isdelete;
                $isprint = $this->isprint;
                $isexport = $this->isexport ;
                $isimport = $this->isimport;
                require_once './views/master_module/master_module_jquery_list.php';
            }else{
                echo "You cannot access this module";
            }
        }
        
        function showDetail(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $master_module_ = $this->showData($id);
                require_once './views/master_module/master_module_detail.php';
            }else{
                echo "You cannot access this module";
            }
        }
        function showDetailJQuery(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $master_module_ = $this->showData($id);
                require_once './views/master_module/master_module_jquery_detail.php';
            }else{
                echo  "You cannot access this module";
            }
        }
        
        function showForm(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $master_module_ = $this->showData($id);
                require_once './views/master_module/master_module_form.php';
            }else{
                echo "You cannot access this module";
            }
        }

        function showFormJQuery(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
                $master_module_ = $this->showData($id);
                require_once './views/master_module/master_module_jquery_form.php';
            }else{
                echo "You cannot access this module";
            }
        }        
        function deleteForm(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isdelete)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $this->deleteData($id);
                $this->showAll();
            }else{
                echo "You cannot access this module";
            }
        }
        function deleteFormJQuery(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isdelete)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $this->deleteData($id);
                $this->showAllJQuery();
            }else{
                echo "You cannot access this module";
            }
        }
        function saveFormJQuery(){
            $this->saveFormPost();
        }
        function saveForm(){
            $this->saveFormPost();
            $this->showAll();
        }                
        function saveFormPost(){
	    $id = isset($_POST['id'])?$_POST['id'] : "";
	    $module = isset($_POST['module'])?$_POST['module'] : "";
	    $descriptionhead = isset($_POST['descriptionhead'])?$_POST['descriptionhead'] : "";
	    $description = isset($_POST['description'])?$_POST['description'] : "";
	    $picture = isset($_POST['picture'])?$_POST['picture'] : "";
	    $classcolour = isset($_POST['classcolour'])?$_POST['classcolour'] : "";
	    $onclick = isset($_POST['onclick'])?$_POST['onclick'] : "";
	    $onclicksubmenu = isset($_POST['onclicksubmenu'])?$_POST['onclicksubmenu'] : "";
	    $parentid = isset($_POST['parentid'])?$_POST['parentid'] : "";
	    $public = isset($_POST['public'])?$_POST['public'] : "";

	    $this->master_module->setId($id);
	    $this->master_module->setModule($module);
	    $this->master_module->setDescriptionhead($descriptionhead);
	    $this->master_module->setDescription($description);
	    $this->master_module->setPicture($picture);
	    $this->master_module->setClasscolour($classcolour);
	    $this->master_module->setOnclick($onclick);
	    $this->master_module->setOnclicksubmenu($onclicksubmenu);
	    $this->master_module->setParentid($parentid);
	    $this->master_module->setPublic($public);
            
            $this->saveData();
        }
        public function saveData(){
            $check = $this->checkData($this->master_module->getId());
            if($check == 0){
                if ($this->ispublic || $this->isadmin || ($this->isread && $this->isentry)){
                    $this->insertData();
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
        public function export() {
            $sql = $this->findDataWhere($this->showDataWhereQuery());
            header("Content-Type:application/csv",false);
            header("Content-Disposition: attachment; filename=". $this->getModulename() .".csv");           
            if($this->getModulename() != "report_query"){
                $report_query = new report_query();
                $report_query_controller = new report_queryController($report_query, $this->dbh);
                echo $report_query_controller->exportcsv($sql);
            }else{
                echo $this->exportcsv($sql);                
            }
        }
        public function printdata() {
            $sql = $this->findDataWhere($this->showDataWhereQuery());
            echo "<html>";
            echo "<head>";
            echo "</head>";
            echo "<body onLoad=\"window.print();window.close()\">";
            echo "<H1>".$this->getModulename()."</H1>";
            if($this->getModulename() != "report_query"){
                $report_query = new report_query();
                $report_query_controller = new report_queryController($report_query, $this->dbh);
                echo $report_query_controller->generatetableview($sql);
            }else{
                echo $this->generatetableview($sql);                
            }
            echo "</body>";
            echo "</html>";
        }
        public function getMaster_module() {
            return $this->master_module;
        }
        public function setMaster_module($master_module) {
            $this->master_module = $master_module;
        }
        public function getDbh() {
            return $this->dbh;
        }
        public function setDbh($dbh) {
            $this->dbh = $dbh;
        }
        public function getModulename() {
            return $this->modulename;
        }

        public function setModulename($modulename) {
            $this->modulename = $modulename;
        }

        public function getLimit() {
            return $this->limit;
        }

        public function setLimit($limit) {
            $this->limit = $limit;
        }

        public function getUser() {
            return $this->user;
        }

        public function setUser($user) {
            $this->user = $user;
        }

        public function getIp() {
            return $this->ip;
        }

        public function setIp($ip) {
            $this->ip = $ip;
        }

        public function getIsadmin() {
            return $this->isadmin;
        }

        public function setIsadmin($isadmin) {
            $this->isadmin = $isadmin;
        }

        public function getIspublic() {
            return $this->ispublic;
        }

        public function setIspublic($ispublic) {
            $this->ispublic = $ispublic;
        }

        public function getIsread() {
            return $this->isread;
        }

        public function setIsread($isread) {
            $this->isread = $isread;
        }

        public function getIsconfirm() {
            return $this->isconfirm;
        }

        public function setIsconfirm($isconfirm) {
            $this->isconfirm = $isconfirm;
        }

        public function getIsentry() {
            return $this->isentry;
        }

        public function setIsentry($isentry) {
            $this->isentry = $isentry;
        }

        public function getIsupdate() {
            return $this->isupdate;
        }

        public function setIsupdate($isupdate) {
            $this->isupdate = $isupdate;
        }

        public function getIsdelete() {
            return $this->isdelete;
        }

        public function setIsdelete($isdelete) {
            $this->isdelete = $isdelete;
        }

        public function getIsprint() {
            return $this->isprint;
        }

        public function setIsprint($isprint) {
            $this->isprint = $isprint;
        }

        public function getIsexport() {
            return $this->isexport;
        }

        public function setIsexport($isexport) {
            $this->isexport = $isexport;
        }

        public function getIsimport() {
            return $this->isimport;
        }

        public function setIsimport($isimport) {
            $this->isimport = $isimport;
        }
        public function getLastID() {
            return $this->lastID;
        }

        public function setLastID($lastID) {
            $this->lastID = $lastID;
        }
    }
?>
