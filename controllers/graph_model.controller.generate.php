<?php
    require_once './models/graph_model.class.php';
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
 
    class graph_modelControllerGenerate
    {
        protected $graph_model;
        var $modulename = "graph_model";
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
        function __construct($graph_model, $dbh) {
            $this->modulename = strtoupper($this->modulename);
            $this->graph_model = $graph_model;
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
            
            $sql = "INSERT INTO graph_model ";
            $sql .= " ( ";
	    $sql .= "`id`,";
	    $sql .= "`type`,";
	    $sql .= "`name`,";
	    $sql .= "`filename`,";
	    $sql .= "`description`,";
	    $sql .= "`title`,";
	    $sql .= "`subtitle`,";
	    $sql .= "`xaxiscategories`,";
	    $sql .= "`xaxistitle`,";
	    $sql .= "`yaxistitle`,";
	    $sql .= "`tooltips`,";
	    $sql .= "`series`,";
	    $sql .= "`entrytime`,";
	    $sql .= "`entryuser`,";
	    $sql .= "`entryip`,";
	    $sql .= "`updatetime`,";
	    $sql .= "`updateuser`,";
	    $sql .= "`updateip` ";
            $sql .= ") ";
            $sql .= " VALUES (";
	    $sql .= " null,";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getType(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getName(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getFilename(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getDescription(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getTitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getSubtitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getXaxiscategories(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getXaxistitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getYaxistitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getTooltips(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_model->getSeries(), $this->dbh)."',";
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
            $sql = "UPDATE graph_model SET ";
	    $sql .= "`id` = '".$this->toolsController->replacecharSave($this->graph_model->getId(),$this->dbh)."',";
	    $sql .= "`type` = '".$this->toolsController->replacecharSave($this->graph_model->getType(),$this->dbh)."',";
	    $sql .= "`name` = '".$this->toolsController->replacecharSave($this->graph_model->getName(),$this->dbh)."',";
	    $sql .= "`filename` = '".$this->toolsController->replacecharSave($this->graph_model->getFilename(),$this->dbh)."',";
	    $sql .= "`description` = '".$this->toolsController->replacecharSave($this->graph_model->getDescription(),$this->dbh)."',";
	    $sql .= "`title` = '".$this->toolsController->replacecharSave($this->graph_model->getTitle(),$this->dbh)."',";
	    $sql .= "`subtitle` = '".$this->toolsController->replacecharSave($this->graph_model->getSubtitle(),$this->dbh)."',";
	    $sql .= "`xaxiscategories` = '".$this->toolsController->replacecharSave($this->graph_model->getXaxiscategories(),$this->dbh)."',";
	    $sql .= "`xaxistitle` = '".$this->toolsController->replacecharSave($this->graph_model->getXaxistitle(),$this->dbh)."',";
	    $sql .= "`yaxistitle` = '".$this->toolsController->replacecharSave($this->graph_model->getYaxistitle(),$this->dbh)."',";
	    $sql .= "`tooltips` = '".$this->toolsController->replacecharSave($this->graph_model->getTooltips(),$this->dbh)."',";
	    $sql .= "`series` = '".$this->toolsController->replacecharSave($this->graph_model->getSeries(),$this->dbh)."',";
	    $sql .= "`entryuser` = '".$this->toolsController->replacecharSave($this->graph_model->getEntryuser(),$this->dbh)."',";
	    $sql .= "`entryip` = '".$this->toolsController->replacecharSave($this->graph_model->getEntryip(),$this->dbh)."',";
	    $sql .= "`updatetime` = '".$datetime."',";
	    $sql .= "`updateuser` = '".$this->user."',";
	    $sql .= "`updateip` = '".$this->ip."' ";
            $sql .= "WHERE id = '".$this->graph_model->getId()."'";                
            $execute = $this->dbh->query($sql);
        }
        
        function deleteData($id){
            $sql = "DELETE FROM graph_model WHERE id = '".$id."'";
            $execute = $this->dbh->query($sql);
        }
        
        function showData($id){
            $sql = "SELECT * FROM graph_model WHERE id = '".$this->toolsController->replacecharFind($id,$this->dbh)."'";

            $row = $this->dbh->query($sql)->fetch();
            $this->loadData($this->graph_model, $row);
            
            return $this->graph_model;
        }
        
        function checkData($id){
            $sql = "SELECT count(*) FROM graph_model where id = '".$id."'";
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
               $where .= "       or  type like '%".$search."%'";
               $where .= "       or  name like '%".$search."%'";
               $where .= "       or  filename like '%".$search."%'";

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
            $sql = "SELECT * FROM graph_model  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findCountDataWhere($where){
            $sql = "SELECT count(id)  FROM graph_model  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findDataSql($sql){
            return $this->createList($sql);            
        }

        function createList($sql){
            $graph_model_List = array();
            foreach ($this->dbh->query($sql) as $row) {
                    $graph_model_ = new graph_model();
                    $this->loadData($graph_model_, $row);
                    $graph_model_List[] = $graph_model_;
            }
            return $graph_model_List;            
        }

                
        function loadData($graph_model,$row){
	    $graph_model->setId($row['id']);
	    $graph_model->setType($row['type']);
	    $graph_model->setName($row['name']);
	    $graph_model->setFilename($row['filename']);
	    $graph_model->setDescription($row['description']);
	    $graph_model->setTitle($row['title']);
	    $graph_model->setSubtitle($row['subtitle']);
	    $graph_model->setXaxiscategories($row['xaxiscategories']);
	    $graph_model->setXaxistitle($row['xaxistitle']);
	    $graph_model->setYaxistitle($row['yaxistitle']);
	    $graph_model->setTooltips($row['tooltips']);
	    $graph_model->setSeries($row['series']);
	    $graph_model->setEntrytime($row['entrytime']);
	    $graph_model->setEntryuser($row['entryuser']);
	    $graph_model->setEntryip($row['entryip']);
	    $graph_model->setUpdatetime($row['updatetime']);
	    $graph_model->setUpdateuser($row['updateuser']);
	    $graph_model->setUpdateip($row['updateip']);

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

                $graph_model_list = $this->showDataAllLimit();

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

                require_once './views/graph_model/graph_model_list.php';
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

                $graph_model_list = $this->showDataAllLimit();
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
                require_once './views/graph_model/graph_model_jquery_list.php';
            }else{
                echo "You cannot access this module";
            }
        }
        
        function showDetail(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $graph_model_ = $this->showData($id);
                require_once './views/graph_model/graph_model_detail.php';
            }else{
                echo "You cannot access this module";
            }
        }
        function showDetailJQuery(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $graph_model_ = $this->showData($id);
                require_once './views/graph_model/graph_model_jquery_detail.php';
            }else{
                echo  "You cannot access this module";
            }
        }
        
        function showForm(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $graph_model_ = $this->showData($id);
                require_once './views/graph_model/graph_model_form.php';
            }else{
                echo "You cannot access this module";
            }
        }

        function showFormJQuery(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
                $graph_model_ = $this->showData($id);
                require_once './views/graph_model/graph_model_jquery_form.php';
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
	    $type = isset($_POST['type'])?$_POST['type'] : "";
	    $name = isset($_POST['name'])?$_POST['name'] : "";
	    $filename = isset($_POST['filename'])?$_POST['filename'] : "";
	    $description = isset($_POST['description'])?$_POST['description'] : "";
	    $title = isset($_POST['title'])?$_POST['title'] : "";
	    $subtitle = isset($_POST['subtitle'])?$_POST['subtitle'] : "";
	    $xaxiscategories = isset($_POST['xaxiscategories'])?$_POST['xaxiscategories'] : "";
	    $xaxistitle = isset($_POST['xaxistitle'])?$_POST['xaxistitle'] : "";
	    $yaxistitle = isset($_POST['yaxistitle'])?$_POST['yaxistitle'] : "";
	    $tooltips = isset($_POST['tooltips'])?$_POST['tooltips'] : "";
	    $series = isset($_POST['series'])?$_POST['series'] : "";

	    $this->graph_model->setId($id);
	    $this->graph_model->setType($type);
	    $this->graph_model->setName($name);
	    $this->graph_model->setFilename($filename);
	    $this->graph_model->setDescription($description);
	    $this->graph_model->setTitle($title);
	    $this->graph_model->setSubtitle($subtitle);
	    $this->graph_model->setXaxiscategories($xaxiscategories);
	    $this->graph_model->setXaxistitle($xaxistitle);
	    $this->graph_model->setYaxistitle($yaxistitle);
	    $this->graph_model->setTooltips($tooltips);
	    $this->graph_model->setSeries($series);
            
            $this->saveData();
        }
        public function saveData(){
            $check = $this->checkData($this->graph_model->getId());
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
        public function getGraph_model() {
            return $this->graph_model;
        }
        public function setGraph_model($graph_model) {
            $this->graph_model = $graph_model;
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
