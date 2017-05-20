<?php
    require_once './models/graph_query.class.php';
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
 
    class graph_queryControllerGenerate
    {
        protected $graph_query;
        var $modulename = "graph_query";
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
        var $lastID = "";
        var $toolsController;
        function __construct($graph_query, $dbh) {
            $this->modulename = strtoupper($this->modulename);
            $this->graph_query = $graph_query;
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
            
            $sql = "INSERT INTO graph_query ";
            $sql .= " ( ";
	    $sql .= "`id`,";
	    $sql .= "`id_graph_model`,";
	    $sql .= "`group_code`,";
	    $sql .= "`query`,";
	    $sql .= "`crosstab`,";
	    $sql .= "`tabletemp`,";
	    $sql .= "`lastupdate`,";
	    $sql .= "`timing`,";
	    $sql .= "`month`,";
	    $sql .= "`year`,";
	    $sql .= "`Title`,";
	    $sql .= "`SubTitle`,";
	    $sql .= "`xaxistitle`,";
	    $sql .= "`yaxistitle`,";
	    $sql .= "`tooltips`,";
	    $sql .= "`querytable`,";
	    $sql .= "`querytable2`,";
	    $sql .= "`entrytime`,";
	    $sql .= "`entryuser`,";
	    $sql .= "`entryip`,";
	    $sql .= "`updatetime`,";
	    $sql .= "`updateuser`,";
	    $sql .= "`updateip` ";
            $sql .= ") ";
            $sql .= " VALUES (";
	    $sql .= " null,";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getId_graph_model(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getGroup_code(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getQuery(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getCrosstab(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getTabletemp(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getLastupdate(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getTiming(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getMonth(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getYear(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getTitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getSubTitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getXaxistitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getYaxistitle(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getTooltips(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getQuerytable(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->graph_query->getQuerytable2(), $this->dbh)."',";
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
            $sql = "UPDATE graph_query SET ";
	    $sql .= "`id` = '".$this->toolsController->replacecharSave($this->graph_query->getId(),$this->dbh)."',";
	    $sql .= "`id_graph_model` = '".$this->toolsController->replacecharSave($this->graph_query->getId_graph_model(),$this->dbh)."',";
	    $sql .= "`group_code` = '".$this->toolsController->replacecharSave($this->graph_query->getGroup_code(),$this->dbh)."',";
	    $sql .= "`query` = '".$this->toolsController->replacecharSave($this->graph_query->getQuery(),$this->dbh)."',";
	    $sql .= "`crosstab` = '".$this->toolsController->replacecharSave($this->graph_query->getCrosstab(),$this->dbh)."',";
	    $sql .= "`tabletemp` = '".$this->toolsController->replacecharSave($this->graph_query->getTabletemp(),$this->dbh)."',";
	    $sql .= "`lastupdate` = '".$this->toolsController->replacecharSave($this->graph_query->getLastupdate(),$this->dbh)."',";
	    $sql .= "`timing` = '".$this->toolsController->replacecharSave($this->graph_query->getTiming(),$this->dbh)."',";
	    $sql .= "`month` = '".$this->toolsController->replacecharSave($this->graph_query->getMonth(),$this->dbh)."',";
	    $sql .= "`year` = '".$this->toolsController->replacecharSave($this->graph_query->getYear(),$this->dbh)."',";
	    $sql .= "`Title` = '".$this->toolsController->replacecharSave($this->graph_query->getTitle(),$this->dbh)."',";
	    $sql .= "`SubTitle` = '".$this->toolsController->replacecharSave($this->graph_query->getSubTitle(),$this->dbh)."',";
	    $sql .= "`xaxistitle` = '".$this->toolsController->replacecharSave($this->graph_query->getXaxistitle(),$this->dbh)."',";
	    $sql .= "`yaxistitle` = '".$this->toolsController->replacecharSave($this->graph_query->getYaxistitle(),$this->dbh)."',";
	    $sql .= "`tooltips` = '".$this->toolsController->replacecharSave($this->graph_query->getTooltips(),$this->dbh)."',";
	    $sql .= "`querytable` = '".$this->toolsController->replacecharSave($this->graph_query->getQuerytable(),$this->dbh)."',";
	    $sql .= "`querytable2` = '".$this->toolsController->replacecharSave($this->graph_query->getQuerytable2(),$this->dbh)."',";
	    $sql .= "`updatetime` = '".$datetime."',";
	    $sql .= "`updateuser` = '".$this->user."',";
	    $sql .= "`updateip` = '".$this->ip."' ";
            $sql .= "WHERE id = '".$this->graph_query->getId()."'";                
            $execute = $this->dbh->query($sql);
        }
        
        function deleteData($id){
            $sql = "DELETE FROM graph_query WHERE id = '".$id."'";
            $execute = $this->dbh->query($sql);
        }
        
        function showData($id){
            $sql = "SELECT * FROM graph_query WHERE id = '".$this->toolsController->replacecharFind($id,$this->dbh)."'";

            $row = $this->dbh->query($sql)->fetch();
            $this->loadData($this->graph_query, $row);
            
            return $this->graph_query;
        }
        
        function checkData($id){
            $sql = "SELECT count(*) FROM graph_query where id = '".$id."'";
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
               $where .= "       or  id_graph_model like '%".$search."%'";
               $where .= "       or  group_code like '%".$search."%'";
               $where .= "       or  query like '%".$search."%'";

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
            $sql = "SELECT * FROM graph_query  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findCountDataWhere($where){
            $sql = "SELECT count(id)  FROM graph_query  ".$where;
            $sql .= " ORDER BY id";
            return $sql;
        }
        function findDataSql($sql){
            return $this->createList($sql);            
        }

        function createList($sql){
            $graph_query_List = array();
            foreach ($this->dbh->query($sql) as $row) {
                    $graph_query_ = new graph_query();
                    $this->loadData($graph_query_, $row);
                    $graph_query_List[] = $graph_query_;
            }
            return $graph_query_List;            
        }

                
        function loadData($graph_query,$row){
	    $graph_query->setId($row['id']);
	    $graph_query->setId_graph_model($row['id_graph_model']);
	    $graph_query->setGroup_code($row['group_code']);
	    $graph_query->setQuery($row['query']);
	    $graph_query->setCrosstab($row['crosstab']);
	    $graph_query->setTabletemp($row['tabletemp']);
	    $graph_query->setLastupdate($row['lastupdate']);
	    $graph_query->setTiming($row['timing']);
	    $graph_query->setMonth($row['month']);
	    $graph_query->setYear($row['year']);
	    $graph_query->setTitle($row['Title']);
	    $graph_query->setSubTitle($row['SubTitle']);
	    $graph_query->setXaxistitle($row['xaxistitle']);
	    $graph_query->setYaxistitle($row['yaxistitle']);
	    $graph_query->setTooltips($row['tooltips']);
	    $graph_query->setQuerytable($row['querytable']);
	    $graph_query->setQuerytable2($row['querytable2']);
	    $graph_query->setEntrytime($row['entrytime']);
	    $graph_query->setEntryuser($row['entryuser']);
	    $graph_query->setEntryip($row['entryip']);
	    $graph_query->setUpdatetime($row['updatetime']);
	    $graph_query->setUpdateuser($row['updateuser']);
	    $graph_query->setUpdateip($row['updateip']);

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

                $graph_query_list = $this->showDataAllLimit();

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

                require_once './views/graph_query/graph_query_list.php';
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

                $graph_query_list = $this->showDataAllLimit();
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
                require_once './views/graph_query/graph_query_jquery_list.php';
            }else{
                echo "You cannot access this module";
            }
        }
        
        function showDetail(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $graph_query_ = $this->showData($id);
                require_once './views/graph_query/graph_query_detail.php';
            }else{
                echo "You cannot access this module";
            }
        }
        function showDetailJQuery(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $graph_query_ = $this->showData($id);
                require_once './views/graph_query/graph_query_jquery_detail.php';
            }else{
                echo  "You cannot access this module";
            }
        }
        
        function showForm(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $graph_query_ = $this->showData($id);
                require_once './views/graph_query/graph_query_form.php';
            }else{
                echo "You cannot access this module";
            }
        }

        function showFormJQuery(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
                $graph_query_ = $this->showData($id);
                require_once './views/graph_query/graph_query_jquery_form.php';
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
	    $id_graph_model = isset($_POST['id_graph_model'])?$_POST['id_graph_model'] : "";
	    $group_code = isset($_POST['group_code'])?$_POST['group_code'] : "";
	    $query = isset($_POST['query'])?$_POST['query'] : "";
	    $crosstab = isset($_POST['crosstab'])?$_POST['crosstab'] : "";
	    $tabletemp = isset($_POST['tabletemp'])?$_POST['tabletemp'] : "";
	    $lastupdate = isset($_POST['lastupdate'])?$_POST['lastupdate'] : "";
	    $timing = isset($_POST['timing'])?$_POST['timing'] : "";
	    $month = isset($_POST['month'])?$_POST['month'] : "";
	    $year = isset($_POST['year'])?$_POST['year'] : "";
	    $Title = isset($_POST['Title'])?$_POST['Title'] : "";
	    $SubTitle = isset($_POST['SubTitle'])?$_POST['SubTitle'] : "";
	    $xaxistitle = isset($_POST['xaxistitle'])?$_POST['xaxistitle'] : "";
	    $yaxistitle = isset($_POST['yaxistitle'])?$_POST['yaxistitle'] : "";
	    $tooltips = isset($_POST['tooltips'])?$_POST['tooltips'] : "";
	    $querytable = isset($_POST['querytable'])?$_POST['querytable'] : "";
	    $querytable2 = isset($_POST['querytable2'])?$_POST['querytable2'] : "";

	    $this->graph_query->setId($id);
	    $this->graph_query->setId_graph_model($id_graph_model);
	    $this->graph_query->setGroup_code($group_code);
	    $this->graph_query->setQuery($query);
	    $this->graph_query->setCrosstab($crosstab);
	    $this->graph_query->setTabletemp($tabletemp);
	    $this->graph_query->setLastupdate($lastupdate);
	    $this->graph_query->setTiming($timing);
	    $this->graph_query->setMonth($month);
	    $this->graph_query->setYear($year);
	    $this->graph_query->setTitle($Title);
	    $this->graph_query->setSubTitle($SubTitle);
	    $this->graph_query->setXaxistitle($xaxistitle);
	    $this->graph_query->setYaxistitle($yaxistitle);
	    $this->graph_query->setTooltips($tooltips);
	    $this->graph_query->setQuerytable($querytable);
	    $this->graph_query->setQuerytable2($querytable2);
            
            $this->saveData();
        }
        public function saveData(){
            $check = $this->checkData($this->graph_query->getId());
            if($check == 0){
                if ($this->ispublic || $this->isadmin || ($this->isread && $this->isentry)){
                    $this->insertData();
                    $last_id = $this->dbh->lastInsertId();
                    $this->setLastId($last_id);
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
        public function getGraph_query() {
            return $this->graph_query;
        }
        public function setGraph_query($graph_query) {
            $this->graph_query = $graph_query;
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

        public function setLastId($id){
            $this->lastID = $id;
        }
        
        public function getLastId(){
            return $this->lastID;
        }
    }
?>
