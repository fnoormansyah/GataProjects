<?php
    require_once './models/master_group_detail.class.php';
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
 
    class master_group_detailControllerGenerate
    {
        protected $master_group_detail;
        var $modulename = "master_group_detail";
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
        function __construct($master_group_detail, $dbh) {
            $this->modulename = strtoupper($this->modulename);
            $this->master_group_detail = $master_group_detail;
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
            
            $sql = "INSERT INTO master_group_detail ";
            $sql .= " ( ";
	    $sql .= "`id`,";
	    $sql .= "`groupcode`,";
	    $sql .= "`module`,";
	    $sql .= "`read`,";
	    $sql .= "`confirm`,";
	    $sql .= "`entry`,";
	    $sql .= "`update`,";
	    $sql .= "`delete`,";
	    $sql .= "`print`,";
	    $sql .= "`export`,";
	    $sql .= "`import`,";
	    $sql .= "`entrytime`,";
	    $sql .= "`entryuser`,";
	    $sql .= "`entryip`,";
	    $sql .= "`updatetime`,";
	    $sql .= "`updateuser`,";
	    $sql .= "`updateip` ";
            $sql .= ") ";
            $sql .= " VALUES (";
	    $sql .= " null,";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getGroupcode(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getModule(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getRead(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getConfirm(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getEntry(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getUpdate(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getDelete(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getPrint(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getExport(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->master_group_detail->getImport(), $this->dbh)."',";
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
            $sql = "UPDATE master_group_detail SET ";
	    $sql .= "`id` = '".$this->toolsController->replacecharSave($this->master_group_detail->getId(),$this->dbh)."',";
	    $sql .= "`groupcode` = '".$this->toolsController->replacecharSave($this->master_group_detail->getGroupcode(),$this->dbh)."',";
	    $sql .= "`module` = '".$this->toolsController->replacecharSave($this->master_group_detail->getModule(),$this->dbh)."',";
	    $sql .= "`read` = '".$this->toolsController->replacecharSave($this->master_group_detail->getRead(),$this->dbh)."',";
	    $sql .= "`confirm` = '".$this->toolsController->replacecharSave($this->master_group_detail->getConfirm(),$this->dbh)."',";
	    $sql .= "`entry` = '".$this->toolsController->replacecharSave($this->master_group_detail->getEntry(),$this->dbh)."',";
	    $sql .= "`update` = '".$this->toolsController->replacecharSave($this->master_group_detail->getUpdate(),$this->dbh)."',";
	    $sql .= "`delete` = '".$this->toolsController->replacecharSave($this->master_group_detail->getDelete(),$this->dbh)."',";
	    $sql .= "`print` = '".$this->toolsController->replacecharSave($this->master_group_detail->getPrint(),$this->dbh)."',";
	    $sql .= "`export` = '".$this->toolsController->replacecharSave($this->master_group_detail->getExport(),$this->dbh)."',";
	    $sql .= "`import` = '".$this->toolsController->replacecharSave($this->master_group_detail->getImport(),$this->dbh)."',";
	    $sql .= "`entryuser` = '".$this->toolsController->replacecharSave($this->master_group_detail->getEntryuser(),$this->dbh)."',";
	    $sql .= "`entryip` = '".$this->toolsController->replacecharSave($this->master_group_detail->getEntryip(),$this->dbh)."',";
	    $sql .= "`updatetime` = '".$datetime."',";
	    $sql .= "`updateuser` = '".$this->user."',";
	    $sql .= "`updateip` = '".$this->ip."' ";
            $sql .= "WHERE id = '".$this->master_group_detail->getId()."'";                
            $execute = $this->dbh->query($sql);
        }
        
        function deleteData($id){
            $sql = "DELETE FROM master_group_detail WHERE id = '".$id."'";
            $execute = $this->dbh->query($sql);
        }
        
        function showData($id){
            $sql = "SELECT * FROM master_group_detail WHERE id = '".$this->toolsController->replacecharFind($id,$this->dbh)."'";

            $row = $this->dbh->query($sql)->fetch();
            $this->loadData($this->master_group_detail, $row);
            
            return $this->master_group_detail;
        }
        
        function checkData($id){
            $sql = "SELECT count(*) FROM master_group_detail where id = '".$id."'";
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
               $where .= "       or  groupcode like '%".$search."%'";
               $where .= "       or  module like '%".$search."%'";
               $where .= "       or  read like '%".$search."%'";

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
            $sql = "SELECT * FROM master_group_detail  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findCountDataWhere($where){
            $sql = "SELECT count(id)  FROM master_group_detail  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findDataSql($sql){
            return $this->createList($sql);            
        }

        function createList($sql){
            $master_group_detail_List = array();
            foreach ($this->dbh->query($sql) as $row) {
                    $master_group_detail_ = new master_group_detail();
                    $this->loadData($master_group_detail_, $row);
                    $master_group_detail_List[] = $master_group_detail_;
            }
            return $master_group_detail_List;            
        }

                
        function loadData($master_group_detail,$row){
	    $master_group_detail->setId($row['id']);
	    $master_group_detail->setGroupcode($row['groupcode']);
	    $master_group_detail->setModule($row['module']);
	    $master_group_detail->setRead($row['read']);
	    $master_group_detail->setConfirm($row['confirm']);
	    $master_group_detail->setEntry($row['entry']);
	    $master_group_detail->setUpdate($row['update']);
	    $master_group_detail->setDelete($row['delete']);
	    $master_group_detail->setPrint($row['print']);
	    $master_group_detail->setExport($row['export']);
	    $master_group_detail->setImport($row['import']);
	    $master_group_detail->setEntrytime($row['entrytime']);
	    $master_group_detail->setEntryuser($row['entryuser']);
	    $master_group_detail->setEntryip($row['entryip']);
	    $master_group_detail->setUpdatetime($row['updatetime']);
	    $master_group_detail->setUpdateuser($row['updateuser']);
	    $master_group_detail->setUpdateip($row['updateip']);

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

                $master_group_detail_list = $this->showDataAllLimit();

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

                require_once './views/master_group_detail/master_group_detail_list.php';
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

                $master_group_detail_list = $this->showDataAllLimit();
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
                require_once './views/master_group_detail/master_group_detail_jquery_list.php';
            }else{
                echo "You cannot access this module";
            }
        }
        
        function showDetail(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $master_group_detail_ = $this->showData($id);
                require_once './views/master_group_detail/master_group_detail_detail.php';
            }else{
                echo "You cannot access this module";
            }
        }
        function showDetailJQuery(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $master_group_detail_ = $this->showData($id);
                require_once './views/master_group_detail/master_group_detail_jquery_detail.php';
            }else{
                echo  "You cannot access this module";
            }
        }
        
        function showForm(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $master_group_detail_ = $this->showData($id);
                require_once './views/master_group_detail/master_group_detail_form.php';
            }else{
                echo "You cannot access this module";
            }
        }

        function showFormJQuery(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
                $master_group_detail_ = $this->showData($id);
                require_once './views/master_group_detail/master_group_detail_jquery_form.php';
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
	    $groupcode = isset($_POST['groupcode'])?$_POST['groupcode'] : "";
	    $module = isset($_POST['module'])?$_POST['module'] : "";
	    $read = isset($_POST['read'])?$_POST['read'] : "";
	    $confirm = isset($_POST['confirm'])?$_POST['confirm'] : "";
	    $entry = isset($_POST['entry'])?$_POST['entry'] : "";
	    $update = isset($_POST['update'])?$_POST['update'] : "";
	    $delete = isset($_POST['delete'])?$_POST['delete'] : "";
	    $print = isset($_POST['print'])?$_POST['print'] : "";
	    $export = isset($_POST['export'])?$_POST['export'] : "";
	    $import = isset($_POST['import'])?$_POST['import'] : "";

	    $this->master_group_detail->setId($id);
	    $this->master_group_detail->setGroupcode($groupcode);
	    $this->master_group_detail->setModule($module);
	    $this->master_group_detail->setRead($read);
	    $this->master_group_detail->setConfirm($confirm);
	    $this->master_group_detail->setEntry($entry);
	    $this->master_group_detail->setUpdate($update);
	    $this->master_group_detail->setDelete($delete);
	    $this->master_group_detail->setPrint($print);
	    $this->master_group_detail->setExport($export);
	    $this->master_group_detail->setImport($import);
            
            $this->saveData();
        }
        public function saveData(){
            $check = $this->checkData($this->master_group_detail->getId());
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
        public function getMaster_group_detail() {
            return $this->master_group_detail;
        }
        public function setMaster_group_detail($master_group_detail) {
            $this->master_group_detail = $master_group_detail;
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
    }
?>
