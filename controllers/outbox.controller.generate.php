<?php
    require_once './models/outbox.class.php';
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
 
    class outboxControllerGenerate
    {
        protected $outbox;
        var $modulename = "outbox";
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
        function __construct($outbox, $dbh) {
            $this->modulename = strtoupper($this->modulename);
            $this->outbox = $outbox;
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
            
            $sql = "INSERT INTO outbox ";
            $sql .= " ( ";
	    $sql .= "`UpdatedInDB`,";
	    $sql .= "`InsertIntoDB`,";
	    $sql .= "`SendingDateTime`,";
	    $sql .= "`Text`,";
	    $sql .= "`DestinationNumber`,";
	    $sql .= "`Coding`,";
	    $sql .= "`UDH`,";
	    $sql .= "`Class`,";
	    $sql .= "`TextDecoded`,";
	    $sql .= "`ID`,";
	    $sql .= "`MultiPart`,";
	    $sql .= "`RelativeValidity`,";
	    $sql .= "`SenderID`,";
	    $sql .= "`SendingTimeOut`,";
	    $sql .= "`DeliveryReport` ";
            $sql .= ") ";
            $sql .= " VALUES (";
	    $sql .= " null,";
	    $sql .= "'".$this->toolsController->replacecharSave($this->outbox->getMultiPart(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->outbox->getRelativeValidity(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->outbox->getSenderID(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->outbox->getSendingTimeOut(), $this->dbh)."',";
	    $sql .= "'".$this->toolsController->replacecharSave($this->outbox->getDeliveryReport(), $this->dbh)."' ";

            $sql .= ")";
            $execute = $this->dbh->query($sql);
        }
        
        
        function updateData(){
            $datetime = date("Y-m-d H:i:s");
            $sql = "UPDATE outbox SET ";
	    $sql .= "`UpdatedInDB` = '".$this->toolsController->replacecharSave($this->outbox->getUpdatedInDB(),$this->dbh)."',";
	    $sql .= "`InsertIntoDB` = '".$this->toolsController->replacecharSave($this->outbox->getInsertIntoDB(),$this->dbh)."',";
	    $sql .= "`SendingDateTime` = '".$this->toolsController->replacecharSave($this->outbox->getSendingDateTime(),$this->dbh)."',";
	    $sql .= "`Text` = '".$this->toolsController->replacecharSave($this->outbox->getText(),$this->dbh)."',";
	    $sql .= "`DestinationNumber` = '".$this->toolsController->replacecharSave($this->outbox->getDestinationNumber(),$this->dbh)."',";
	    $sql .= "`Coding` = '".$this->toolsController->replacecharSave($this->outbox->getCoding(),$this->dbh)."',";
	    $sql .= "`UDH` = '".$this->toolsController->replacecharSave($this->outbox->getUDH(),$this->dbh)."',";
	    $sql .= "`Class` = '".$this->toolsController->replacecharSave($this->outbox->getClass(),$this->dbh)."',";
	    $sql .= "`TextDecoded` = '".$this->toolsController->replacecharSave($this->outbox->getTextDecoded(),$this->dbh)."',";
	    $sql .= "`ID` = '".$this->toolsController->replacecharSave($this->outbox->getID(),$this->dbh)."',";
	    $sql .= "`MultiPart` = '".$this->toolsController->replacecharSave($this->outbox->getMultiPart(),$this->dbh)."',";
	    $sql .= "`RelativeValidity` = '".$this->toolsController->replacecharSave($this->outbox->getRelativeValidity(),$this->dbh)."',";
	    $sql .= "`SenderID` = '".$this->toolsController->replacecharSave($this->outbox->getSenderID(),$this->dbh)."',";
	    $sql .= "`SendingTimeOut` = '".$this->toolsController->replacecharSave($this->outbox->getSendingTimeOut(),$this->dbh)."',";
	    $sql .= "`DeliveryReport` = '".$this->toolsController->replacecharSave($this->outbox->getDeliveryReport(),$this->dbh)."' ";
            $sql .= "WHERE ID = '".$this->outbox->getID()."'";                
            $execute = $this->dbh->query($sql);
        }
        
        function deleteData($id){
            $sql = "DELETE FROM outbox WHERE ID = '".$id."'";
            $execute = $this->dbh->query($sql);
        }
        
        function showData($id){
            $sql = "SELECT * FROM outbox WHERE ID = '".$this->toolsController->replacecharFind($id,$this->dbh)."'";

            $row = $this->dbh->query($sql)->fetch();
            $this->loadData($this->outbox, $row);
            
            return $this->outbox;
        }
        
        function checkData($id){
            $sql = "SELECT count(*) FROM outbox where ID = '".$id."'";
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
               $where .= " where UpdatedInDB like '%".$search."%'";
               $where .= "       or  InsertIntoDB like '%".$search."%'";
               $where .= "       or  SendingDateTime like '%".$search."%'";
               $where .= "       or  Text like '%".$search."%'";

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
            $sql = "SELECT * FROM outbox  ".$where;
            $sql .= " ORDER BY ID";
            return $sql;
        }
        function findCountDataWhere($where){
            $sql = "SELECT count(ID)  FROM outbox  ".$where;
            $sql .= " ORDER BY ID";
            return $sql;
        }
        function findDataSql($sql){
            return $this->createList($sql);            
        }

        function createList($sql){
            $outbox_List = array();
            foreach ($this->dbh->query($sql) as $row) {
                    $outbox_ = new outbox();
                    $this->loadData($outbox_, $row);
                    $outbox_List[] = $outbox_;
            }
            return $outbox_List;            
        }

                
        function loadData($outbox,$row){
	    $outbox->setUpdatedInDB($row['UpdatedInDB']);
	    $outbox->setInsertIntoDB($row['InsertIntoDB']);
	    $outbox->setSendingDateTime($row['SendingDateTime']);
	    $outbox->setText($row['Text']);
	    $outbox->setDestinationNumber($row['DestinationNumber']);
	    $outbox->setCoding($row['Coding']);
	    $outbox->setUDH($row['UDH']);
	    $outbox->setClass($row['Class']);
	    $outbox->setTextDecoded($row['TextDecoded']);
	    $outbox->setID($row['ID']);
	    $outbox->setMultiPart($row['MultiPart']);
	    $outbox->setRelativeValidity($row['RelativeValidity']);
	    $outbox->setSenderID($row['SenderID']);
	    $outbox->setSendingTimeOut($row['SendingTimeOut']);
	    $outbox->setDeliveryReport($row['DeliveryReport']);

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

                $outbox_list = $this->showDataAllLimit();

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

                require_once './views/outbox/outbox_list.php';
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

                $outbox_list = $this->showDataAllLimit();
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
                require_once './views/outbox/outbox_jquery_list.php';
            }else{
                echo "You cannot access this module";
            }
        }
        
        function showDetail(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $outbox_ = $this->showData($id);
                require_once './views/outbox/outbox_detail.php';
            }else{
                echo "You cannot access this module";
            }
        }
        function showDetailJQuery(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $outbox_ = $this->showData($id);
                require_once './views/outbox/outbox_jquery_detail.php';
            }else{
                echo  "You cannot access this module";
            }
        }
        
        function showForm(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $outbox_ = $this->showData($id);
                require_once './views/outbox/outbox_form.php';
            }else{
                echo "You cannot access this module";
            }
        }

        function showFormJQuery(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
                $outbox_ = $this->showData($id);
                require_once './views/outbox/outbox_jquery_form.php';
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
	    $UpdatedInDB = isset($_POST['UpdatedInDB'])?$_POST['UpdatedInDB'] : "";
	    $InsertIntoDB = isset($_POST['InsertIntoDB'])?$_POST['InsertIntoDB'] : "";
	    $SendingDateTime = isset($_POST['SendingDateTime'])?$_POST['SendingDateTime'] : "";
	    $Text = isset($_POST['Text'])?$_POST['Text'] : "";
	    $DestinationNumber = isset($_POST['DestinationNumber'])?$_POST['DestinationNumber'] : "";
	    $Coding = isset($_POST['Coding'])?$_POST['Coding'] : "";
	    $UDH = isset($_POST['UDH'])?$_POST['UDH'] : "";
	    $Class = isset($_POST['Class'])?$_POST['Class'] : "";
	    $TextDecoded = isset($_POST['TextDecoded'])?$_POST['TextDecoded'] : "";
	    $ID = isset($_POST['ID'])?$_POST['ID'] : "";
	    $MultiPart = isset($_POST['MultiPart'])?$_POST['MultiPart'] : "";
	    $RelativeValidity = isset($_POST['RelativeValidity'])?$_POST['RelativeValidity'] : "";
	    $SenderID = isset($_POST['SenderID'])?$_POST['SenderID'] : "";
	    $SendingTimeOut = isset($_POST['SendingTimeOut'])?$_POST['SendingTimeOut'] : "";
	    $DeliveryReport = isset($_POST['DeliveryReport'])?$_POST['DeliveryReport'] : "";
	    $this->outbox->setUpdatedInDB($UpdatedInDB);
	    $this->outbox->setInsertIntoDB($InsertIntoDB);
	    $this->outbox->setSendingDateTime($SendingDateTime);
	    $this->outbox->setText($Text);
	    $this->outbox->setDestinationNumber($DestinationNumber);
	    $this->outbox->setCoding($Coding);
	    $this->outbox->setUDH($UDH);
	    $this->outbox->setClass($Class);
	    $this->outbox->setTextDecoded($TextDecoded);
	    $this->outbox->setID($ID);
	    $this->outbox->setMultiPart($MultiPart);
	    $this->outbox->setRelativeValidity($RelativeValidity);
	    $this->outbox->setSenderID($SenderID);
	    $this->outbox->setSendingTimeOut($SendingTimeOut);
	    $this->outbox->setDeliveryReport($DeliveryReport);            
            $this->saveData();
        }
        public function saveData(){
            $check = $this->checkData($this->outbox->getID());
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
        public function getOutbox() {
            return $this->outbox;
        }
        public function setOutbox($outbox) {
            $this->outbox = $outbox;
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
