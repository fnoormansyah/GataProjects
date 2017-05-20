<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    
    require_once './models/master_user_detail.class.php';
    require_once './controllers/master_user_detail.controller.php';
    
    require_once './models/master_group.class.php';
    require_once './controllers/master_group.controller.php';
    
    
    
    require_once './models/graph_query.class.php';
    require_once './controllers/graph_query.controller.generate.php';
    require_once './models/graph_model.class.php';
    require_once './controllers/graph_model.controller.php';
    require_once './models/report_query.class.php';
    require_once './controllers/report_query.controller.php';
    require_once './database/config.php';

    if (!isset($_SESSION)) {
        session_start();
    }
 
    class graph_queryController extends graph_queryControllerGenerate
    {
        function deleteGraphUserById(){
            if (isset($_SESSION[config::$LOGIN_USER])) {
                $graph_query_id = isset($_GET['id']) ? $_GET['id'] : 0;
                $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
                $sql = "DELETE FROM dashboard_user WHERE user = '".$master_user->getID()."' and graph_query_id='".$graph_query_id."'";
                $execute = $this->dbh->query($sql);
            }
            
            $this->showGraphAll();
            
        }
        function showGraphAll(){
            
            if (isset($_SESSION[config::$LOGIN_USER])) {
                $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
            }
            $graph_query_list = $this->showDataByUser();
            $graph_query_controller = $this;
            $graph_list = $this->list_graph();
            
            
            require_once './views/graph_query/graph_query_list_graph.php';
        }
        function js(){
            echo "<script type=\"text/javascript\" src=\"./js/jquery-1.8.2.js\"></script>".PHP_EOL;
            echo "<script src=\"./jsgraph/highcharts.js\"></script>".PHP_EOL;
            echo "<script src=\"./jsgraph/modules/exporting.js\"></script>".PHP_EOL;            
        }
        function showGraphAllWithJS(){
            $this->js();
            
            if (isset($_SESSION[config::$LOGIN_USER])) {
                $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
            }
            $graph_query_list = $this->showDataByUser();
            $graph_query_controller = $this;
            $graph_list = $this->list_graph();
            require_once './views/graph_query/graph_query_list_graph.php';            
        }
        function showGraphAndTable(){
            $month = isset($_GET['month']) ? $_GET['month'] : date('m');
            $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
            $id = $_GET['id'];
                        
            $graph_query = new graph_query();            
            $graph_query = $this->showData($id);
            $graph_model = new graph_model();
            $graph_model_controller = new graph_modelController($graph_model, $this->getDbh());
            $graph_model = $graph_model_controller->showData($graph_query ->getId_graph_model());                
            if ($graph_model->getType()!="table"){
                $this->showGraphWithID($graph_query);
            }                                        
            $report_query = new report_query();
            $report_query_controller = new report_queryController($report_query, $this->dbh);
            $query = $this->processQuery($graph_query, $month, $year, $graph_model->getType(),1);
            
            echo "<center><h1>".$graph_query->getTitle()."</h1></center>";
            echo $report_query_controller->generatetableview($query,0);
            echo "<br><br><div id='graphandtable2'></table><br><br><br>";
        }
        function showGraphAndTable2(){
            $id = $_GET['id'];
            $parameter1 = isset($_REQUEST['parameter1']) ?  $_REQUEST['parameter1'] : "";
            $parameter2 = isset($_REQUEST['parameter2']) ?  $_REQUEST['parameter2'] : "";
            $parameter3 = isset($_REQUEST['parameter3']) ?  $_REQUEST['parameter3'] : "";
            $graph_query = new graph_query();            
            $graph_query = $this->showData($id);
            $querytable2 = $graph_query->getQuerytable2();            
            $querytable2 = str_replace("<<parameter1>>", $parameter1, $querytable2);
            $querytable2 = str_replace("<<parameter2>>", $parameter2, $querytable2);
            $querytable2 = str_replace("<<parameter3>>", $parameter3, $querytable2);
            
           
            $parameter = $parameter1 == "" ? "" : $parameter1 ;
            $parameter .= $parameter2 == "" ? "" : ", ".$parameter2 ;
            $parameter .= $parameter3 == "" ? "" : ", " . $parameter3 ;
                    
            $report_query = new report_query();
            $report_query_controller = new report_queryController($report_query, $this->dbh);
            //echo $querytable2;
            echo "<center>";
            echo "<h1>".$parameter."</h1>";
            echo $report_query_controller->generatetableview($querytable2,0);
            echo "</center>";
            echo "<br><br><div id='graphandtable3'></table><br><br><br>";
        }
        function showGraph(){
            $id = $_GET['id'];
            $graph_query = new graph_query();            
            $graph_query = $this->showData($id);
            $this->showGraphWithID($graph_query);
        }
        function showGraphWithJS(){
            $id = $_GET['id'];
            $this->js();
            $graph_query = new graph_query();            
            $graph_query = $this->showData($id);
            $this->showGraphWithID($graph_query);
        }
        
        function processQuery($graph_query, $month, $year, $type="table", $modelquery=0){
            $now = date("Y-m-d H:i:s");
            $hour_now = date("H:i");
            $tableTemp = $graph_query->getTabletemp();
            $lastUpdate = $graph_query->getLastupdate();
            $timing = $graph_query->getTiming();
            $ct = new CrossTab($this->dbh);
            if($modelquery==0){
                $query = $graph_query->getQuery();
            }else{
                $query = $graph_query->getQuerytable();                
            }
            
//            echo "<BR>".$query;
            $query = str_replace("<<month>>", $month, $query);
            $query = str_replace("<<year>>", $year, $query);
            $bmonthyear = $month == date('m') && $year == date('Y');
            
            if($tableTemp == ""){
//                echo "1<br>";
                $queryOri = $query;
            } else {
//                echo "2<br>";                
                if (!$bmonthyear){
//                    echo "3<br>";                
                    $queryOri = $query;                    
                }else{
//                    echo "4<br>";
                    $querychecktable = "SHOW TABLES IN temp LIKE '".$graph_query->getTabletemp().$modelquery."'";
//                    echo "<BR>".$querychecktable ;
                    $bresultchektable = $this->dbh->query($querychecktable)->rowcount();
//                    echo "<BR>".$bresultchektable  ."<BR>";
                    
//                    echo strtotime("now")  . " - " . strtotime($lastUpdate) . " >  ". $timing;
                    
                    if (strtotime("now") - strtotime($lastUpdate) > $timing or $bresultchektable ==0) {                    
            //           echo "<br>5<br>";
                        if($bresultchektable !=0) {
                            $sqldrop = "DROP TABLE IF EXISTS `temp`.`".$tableTemp.$modelquery."`";
                            try{
                                $this->dbh->exec($sqldrop);
                            }catch(PDOException $e){
                                echo "Error " . $e->getMessage();
                            }
                        }
                        //Insert into table temporary
                        $sql = "create table `temp`.`".$tableTemp.$modelquery."` ";
                        $sql .= " \n".$query."\n ";
//                      echo "<BR>".$query."---<br>";
                        try{
                            $this->dbh->exec($sql);
                        }catch(PDOException $e){
                            echo "Error " . $e->getMessage();
                        }
                        
                        $sql = "update graph_query set lastupdate =now() where id=" . $graph_query->getId();
                        
                        try{
                            $this->dbh->exec($sql);
                        }catch(PDOException $e){
                            echo "Error " . $e->getMessage();
                        }
                        
                        
                    }
                    
                    $queryOri = "SELECT * FROM `temp`.".$tableTemp.$modelquery;                    
                }
            }
            //echo $queryOri;
            if($graph_query->getCrosstab() == 1){
                $fields = $ct->getFields($queryOri);                
                if ($type == 'pie') {            
                    $query = $ct->getCrossTab($fields,$queryOri,2) ;
                }else{
                    $query = $ct->getCrossTab($fields,$queryOri,3) ;
                }
            } else {
                $query = $queryOri;
            }
            return $query;
        }
        function showGraphWithID($graph_query){                        
            $month = isset($_GET['month']) ? $_GET['month'] : date('m');
            $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

            $graph_model = new graph_model();
            $graph_model_controller = new graph_modelController($graph_model, $this->getDbh());
            $graph_model = $graph_model_controller->showData($graph_query ->getId_graph_model());
            $graph_model->setName($graph_model->getName().$graph_query->getId());                    
            $graph_model->setTitle($graph_query->getTitle());                        
            $graph_model->setSubTitle($graph_query->getSubTitle());
            $graph_model->setXaxistitle($graph_query->getXaxistitle());
            $graph_model->setYaxistitle($graph_query->getYaxistitle());
            $graph_model->setTooltips($graph_query->getTooltips());
            $query = $this->processQuery($graph_query, $month, $year, $graph_model->getType());  
            if ($graph_model->getType() != 'table') {            
                if ($graph_model->getType() != 'pie') {
                    $graph_model->setXaxiscategories($this->getHeader($query));
                    $graph_model->setSeries($this->getSeries($query));                                 
                }else{
                    $graph_model->setSeries($this->getSeriesPie($query,$graph_model->getTitle()));
                }
                $graph_model_controller->setGraph_model($graph_model);
                //echo "<br>show graph<br>";
                $graph_model_controller->showGraph();
            }else{                
                $report_query = new report_query();
                $report_query_controller = new report_queryController($report_query, $this->dbh);
                
                echo "<center><h2>".$graph_model->getTitle()."</h2></center>";
                echo $report_query_controller->generatetableview($query,1);                
            }
            
        }
        
        function getHeader($query) {
            $header = "";
            $rs = $this->getDbh()->query($query);
            for ($i = 0; $i < $rs->columnCount(); $i++) {
                $col = $rs->getColumnMeta($i);
                if ($i > 0) {
                    $header .= "'".$col['name']. "'". ($i < $rs->columnCount()-1 ? ", " : "");
                }
            }
            return $header;
        }
        
        function getSeriesPie($query, $title){
            
/* Sample
 *         [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Firefox',   45.0],
                    ['IE',        26.8],
                    ['Chrome',    12.8],
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]
                ]
            }]
*/
//            echo $query;
            $rs = $this->getDbh()->query($query);
            $colcount = $rs->columnCount(); 
            $type = "type: 'pie',".PHP_EOL;
            $name = "name: '".$title."',".PHP_EOL ;
            $series = PHP_EOL."[{".PHP_EOL;
            $data = "data : [".PHP_EOL;
            $data = $type . $name . $data;
            foreach ($rs as $row) {                
                for ($j = 0; $j < $colcount; $j++) {
                    $col = $rs->getColumnMeta($j);
                    
                    $colname = ($col['name'] == null ? "Blank": $col['name']);
                    $valrow = $row[$j] == null ? 0 :$row[$j];
                    $data .= "['".$colname ."', ". $valrow ." ]" .($j < $colcount -1 ? "," : "").PHP_EOL ;
                }
                break;
            }
            $data .= "]".PHP_EOL;
            
            $series .= $data;
            $series .= PHP_EOL."}]".PHP_EOL;
            return $series;
        }
        function getSeries($query) {
 /*
  * Sample
            [{
                name: 'Asia',
                data: [502, 635, 809, 947, 1402, 3634, 5268]
            }, {
                name: 'Africa',
                data: [106, 107, 111, 133, 221, 767, 1766]
            }]
            */
            $rs = $this->getDbh()->query($query);
            $rowcount = $rs->rowCount();
            $colcount = $rs->columnCount(); 
            $series = PHP_EOL."[".PHP_EOL;
            $i = 1;
            $seriesdetails = "";
            $name = "";
            $data = "";
            foreach ($rs as $row) {
                $seriesdetail = "{" ;
                $name = "name:";
                $data = ", data : [";
                for ($j = 0; $j < $colcount; $j++) {
                    $col = $rs->getColumnMeta($j);
                        if ($j == 0) {
                        $name .= "'".$row[$col['name']] . "'" ;
                    }else{
                        $data .= $row[$col['name']] . ($j < $colcount - 1 ? "," : "");
                    }
                }
                $data .= "]";
                $seriesdetail .= $name;
                $seriesdetail .= $data;
                $seriesdetail .= "}".($i<$rowcount ? "," : "").PHP_EOL;
            
                $seriesdetails .=  $seriesdetail;
                $i++;
            }        
            $series .= $seriesdetails;
            $series .= "]";
            
            return $series;
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

                $grap_query_control = $this;
                
                require_once './views/graph_query/graph_query_jquery_list.php';
            }else{
                echo "You cannot access this module";
            }
        }
        
        
        function getModelGraph($graph_query) {
            $graph_model = new graph_model();
            $graph_model_controller = new graph_modelController($graph_model, $this->getDbh());
            $graph_model =  $graph_model_controller->showData($graph_query->getId_graph_model());
            return $graph_model;
        }
        function showFormJQuery(){
            if ($this->ispublic || $this->isadmin || ($this->isread && $this->isupdate)){
                $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
                $skip = isset($_REQUEST["skip"]) ? $_REQUEST["skip"] : 0;
                $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
                $graph_query_ = $this->showData($id);

                $graph_model = new graph_model();
                $graph_model_controller = new graph_modelController($graph_model, $this->getDbh());
                $graph_model_list = $graph_model_controller->showDataAll();
                
                require_once './views/graph_query/graph_query_jquery_form.php';
            }else{
                echo "You cannot access this module";
            }
        }        
        function showDetailJQuery(){
            if ($this->ispublic || $this->isadmin || $this->isread ){
                $id = $_GET['id'];
                $graph_query_ = $this->showData($id);
                $graph_model = new graph_model();
                $graph_model_controller = new graph_modelController($graph_model, $this->getDbh());
                $graph_model =  $graph_model_controller->showData($graph_query_->getId_graph_model());
                require_once './views/graph_query/graph_query_jquery_detail.php';
            }else{
                echo  "You cannot access this module";
            }
        }
        

        function showDataByUser(){
            
            if (isset($_SESSION[config::$LOGIN_USER])) {
                $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
            }
            
            $sql = "SELECT b.* FROM dashboard_user a 
            INNER JOIN graph_query b ON a.graph_query_id=b.id 
            WHERE a.user='".$master_user->getId()."'";
            return $this->createList($sql);            
        }
        
        function checkDashBoard(){
            if (isset($_SESSION[config::$LOGIN_USER])) {
                $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
            }
            $sql="SELECT COUNT(*) AS jml FROM dashboard_user WHERE `user`='".$master_user->getId()."'";
            $row = $this->dbh->query($sql)->fetch();
            return $row[0];
        }
        
        function list_graph_lm(){
            if (isset($_SESSION[config::$LOGIN_USER])) {
                $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
                
            }
            /* query jika yg sudah ada tidak muncul */
            $sql="SELECT b.* FROM dashboard_user a
            RIGHT JOIN graph_query b ON a.graph_query_id=b.id AND a.user='".$master_user->getId()."'
            WHERE a.graph_query_id IS NULL;";
            
            return $this->createList($sql); 
        }
        function list_graph(){
            
            if (isset($_SESSION[config::$LOGIN_USER])) {
                $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
                $master_group=new master_group();
                $master_groupctrl=new master_groupController($master_group, $this->dbh);
                $master_group_list=$master_groupctrl->showDataAll();
                
                $groups="";
                $n=count($master_group_list);
                $i=1;
                foreach ($master_group_list as $master_group){
                    if($i!=$n){
                        $groups .="'".$master_group->getGroupcode()."',";
                    }else{
                        $groups .="'".$master_group->getGroupcode()."'";
                    }
                    $i++;
                }
                
            }
            
            /* query jika yg sudah ada tidak muncul */
            $sql="SELECT b.* FROM dashboard_user a
            RIGHT JOIN graph_query b ON a.graph_query_id=b.id AND a.user='".$master_user->getId()."' 
                
            WHERE a.graph_query_id IS NULL and (b.group_code IS NULL OR b.group_code='All' OR IF('".$this->isadmin."'='1',TRUE,b.group_code IN (".$groups."))) ;";
            
            return $this->createList($sql); 
        }
    }
?>
