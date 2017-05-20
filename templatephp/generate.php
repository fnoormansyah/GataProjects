<?php
    include '../database/connection.php';
    if(isset($_REQUEST['tabel'])){
        $table = $_REQUEST['tabel'];
        $generate = new generate($dbh);

        echo "<plaintext>";
        //$sql = "show tables";
        //foreach ($generate->dbh->query($sql) as $row){
            //$table = $row[0];
            
            foreach ($_REQUEST['pil'] as $idx=>$val){
                if($val==1){
                    $generate->generateClass($table);
                }
                if($val==2){
                    $generate->generateControllerGenerate($table);
                }
                if($val==3){
                    $bool=false;
                    $rep=  isset($_REQUEST['rep'.$val])?$_REQUEST['rep'.$val]:"";
                    if($rep==1){
                        $bool=true;
                    }
                    $generate->generateController($table , $bool); // false -- jika sudah ada di skip
                }
                if($val==4){
                    $generate->createDirView("../views/".$table);
                }
        //        //$generate->generateViewList($table, false, false ); 
                if($val==5){
                    $bool=false;
                    $rep=  isset($_REQUEST['rep'.$val])?$_REQUEST['rep'.$val]:"";
                    if($rep==1){
                        $bool=true;
                    }
                    $generate->generateViewList($table, $bool, true ); //table , created, jquery
                }
        //        //$generate->generateViewDetail($table, false, false);
                if($val==6){
                    $bool=false;
                    $rep=  isset($_REQUEST['rep'.$val])?$_REQUEST['rep'.$val]:"";
                    if($rep==1){
                        $bool=true;
                    }
                    $generate->generateViewDetail($table, $bool, true);
                }
        //        //$generate->generateViewForm($table, false, false);
                if($val==7){
                    $bool=false;
                    $rep=  isset($_REQUEST['rep'.$val])?$_REQUEST['rep'.$val]:"";
                    if($rep==1){
                        $bool=true;
                    }
                    $generate->generateViewForm($table, $bool, true);
                }
            }
    //    //}
             echo "</plaintext>";
             echo "<script>alert('Generate is success');window.open('index.php','_self');</script>";
    }
   
    class generate{
        var $dbh;
        function __construct($dbh) {
            $this->dbh = $dbh;
        }

        function generateClass($table){
            $primarykey = $this->getPrimaryKey($table);
            $variables = $this->generateVariableClass($table);
            $setget = $this->generateSetterGetterClass($table);
            
            $myfilename = "master_template.txt";
            $readFile = $this->readFileTemplate($myfilename);
            $readFile = str_replace("<<table>>", $table, $readFile);
            $readFile = str_replace("<<Variables>>", $variables, $readFile);
            $readFile = str_replace("<<primarykey>>", $primarykey, $readFile);
            $readFile = str_replace("<<SetGet>>", $setget, $readFile);

            $myfilename = "../models/".$table.".class.php";
            $this->writeFileTemplate($myfilename, $readFile);

        }
        
        function getPrimaryKey($table) {
            echo "Check Primary Key in Table : ".$table.PHP_EOL;
            
            $primarykey = "";            
            $q = 'DESCRIBE '.$table ;
            foreach ($this->dbh->query($q) as $row) {
                if ($row['Key'] == 'PRI') {
                    $primarykey = $row['Field'];
                    break;
                }
            }
            
            echo "Primary Key : " .$primarykey.PHP_EOL;
            return $primarykey;
        }
        function getAutoIncrement($table) {
            $autoincrement = "";
            $q = 'DESCRIBE '.$table;
            foreach ($this->dbh->query($q) as $row) {
                if ($row['Extra'] == 'auto_increment') {
                    $autoincrement = $row['Field'];
                    break;
                }         
            }
            return $autoincrement;
        }
        
        function generateVariableClass($table) {
            echo "Generate Variable : ".PHP_EOL;
            $variable = "var $";
            $variables = "";
            $q = 'DESCRIBE '.$table;
            foreach ($this->dbh->query($q) as $row) {
                $variables .= "\t".$variable . $row['Field'].';'.PHP_EOL;
            }
            echo $variables.PHP_EOL;
            return $variables;            
        }
        
        function generateSetterGetterClass($table) {
            echo "Generate Setter Getter  : ".PHP_EOL;
            $setVariable =  "\tpublic function set<<Field>>($<<field>>) {".PHP_EOL;
            $setVariable .= "\t   \$this-><<field>> = $<<field>>;".PHP_EOL;   
            $setVariable .= "\t}".PHP_EOL;

            $getVariable = "\tpublic function get<<Field>>() {".PHP_EOL;
            $getVariable .= "\t   return \$this-><<field>>;".PHP_EOL;
            $getVariable .= "\t}".PHP_EOL;
            $setVariables = "";
            $getVariables = "";
            $setGet = "";
            $q = 'DESCRIBE '.$table;
            foreach ($this->dbh->query($q) as $row) {
                $field = $row['Field'];
                $Field = ucfirst($row['Field']);                        

                $getVariables = str_replace("<<Field>>",$Field,$getVariable);
                $getVariables = str_replace("<<field>>",$field,$getVariables);
                $setVariables = str_replace("<<Field>>",$Field,$setVariable);
                $setVariables = str_replace("<<field>>",$field,$setVariables);

                $setGet .= $getVariables.PHP_EOL.$setVariables;
            }
            echo $setGet.PHP_EOL; 
            return $setGet;
        }
                
        function generateControllerGenerate($table) {
            echo "Generate Controller Generate : ".PHP_EOL;
            $saveNewNameField = "\t    \$sql .= \"`<<field>>`"; 
            $saveNewNameFields = ""; 
            $saveNewField = "\t    \$sql .= \"'\".\$this->toolsController->replacecharSave(\$this-><<table>>->get<<Field>>(), \$this->dbh).\"'";
            $saveNewFieldTime = "\t    \$sql .= \"'\".\$datetime.\"'";
            $saveNewFieldUser = "\t    \$sql .= \"'\".\$this->user.\"'";
            $saveNewFieldIP = "\t    \$sql .= \"'\".\$this->ip.\"'";
            $saveNewFields = "";

            $saveNewData = "";
            $SaveField = "\t    \$sql .= \"`<<field>>` = '\".\$this->toolsController->replacecharSave(\$this-><<table>>->get<<Field>>(),\$this->dbh).\"'";
            $SaveFieldTime = "\t    \$sql .= \"`<<field>>` = '\".\$datetime.\"'";
            $SaveFieldUser = "\t    \$sql .= \"`<<field>>` = '\".\$this->user.\"'";
            $SaveFieldIP = "\t    \$sql .= \"`<<field>>` = '\".\$this->ip.\"'";
            $SaveFields = "";

            $updateData = "";

            $LoadRecord = "\t    $<<table>>->set<<Field>>(\$row['<<field>>']);".PHP_EOL;
            $LoadRecords = "";
            $loadData = "";
            
            $GetDataPost = "\t    \$<<field>> = isset(\$_POST['<<field>>'])?\$_POST['<<field>>'] : \"\";";
            $GetDataPosts = "";
            
            $SetData = "\t    \$this-><<table>>->set<<Field>>(\$<<field>>);";
            $SetDatas = "";
            
            $searchdata = "";
            $i = 1;
            $q = 'DESCRIBE '.$table;
            $jml = $this->dbh->query($q)->rowCount();
            foreach ($this->dbh->query($q) as $row) {
                $field = $row['Field'];
                $Field = ucfirst($row['Field']);                        

                $saveNewNameField_ = str_replace("<<field>>", $field, $saveNewNameField);
                $saveNewNameFields .= $saveNewNameField_.($i < $jml ? ",\";".PHP_EOL: " \";");

                if ($field == "entrytime" || $field == "updatetime"){
                    $saveNewFields = $saveNewFieldTime;
                }else if ($field == "entryuser" || $field == "updateuser"){
                    $saveNewFields = $saveNewFieldUser;
                }else if ($field == "entryip" || $field == "updateip"){
                    $saveNewFields = $saveNewFieldIP;
                }else{
                    $saveNewFields = str_replace("<<table>>", $table, $saveNewField);
                    $saveNewFields = str_replace("<<Field>>", $Field, $saveNewFields);
                }
                $saveNewData .= $saveNewFields.($i < $jml ? ",\";": " \";").PHP_EOL;
                
                $autonumber = $this->getAutoIncrement($table);
                
                if ($autonumber == $field) {
                    $saveNewData =  "\t    \$sql .= \" null".($i < $jml ? ",\";".PHP_EOL : " \";");                    
                }
                if ($field != "entrytime" && $field != "entryuser" && $field != "entryip" ){
                    if($field == "updatetime") {
                        $SaveFields = str_replace("<<field>>",$field, $SaveFieldTime);
                    }else if($field == "updateuser") {
                        $SaveFields = str_replace("<<field>>",$field, $SaveFieldUser);
                    }else if($field == "updateip") {
                        $SaveFields = str_replace("<<field>>",$field,$SaveFieldIP);
                    }  else {
                        $SaveFields = str_replace("<<field>>", $field, $SaveField);
                    }
                    $SaveFields = str_replace("<<table>>", $table, $SaveFields);
                    $SaveFields = str_replace("<<Field>>", $Field, $SaveFields);                    
                    $updateData .= $SaveFields.($i < $jml ? ",\";".PHP_EOL : " \";");
                }
                    
                $LoadRecords = str_replace("<<table>>", $table, $LoadRecord);
                $LoadRecords = str_replace("<<Field>>", $Field, $LoadRecords);
                $LoadRecords = str_replace("<<field>>", $field, $LoadRecords);
                //$LoadRecords .= $i < $jml ? PHP_EOL : "";
                $loadData .= $LoadRecords;

                if ($field != 'entryuser' 
                        && $field != 'entrytime' 
                        && $field != 'entryip'
                        && $field != 'updateuser'
                        && $field != 'updatetime'
                        && $field != 'updateip'
                        ){
                    $GetDataPosts .= str_replace("<<field>>", $field, $GetDataPost) . ($i < $jml ? PHP_EOL : "");                
                    $SetData_ = str_replace("<<table>>", $table, $SetData); 
                    $SetData_ = str_replace("<<Field>>", $Field, $SetData_); 
                    $SetData_ = str_replace("<<field>>", $field, $SetData_); 
                    $SetDatas .= $SetData_ . ($i < $jml ? PHP_EOL : "");
                }
                if($i <= 4){
                    if($i == 1) {
                        $searchdata = "               \$where .= \" where ".$field. " like '%\".\$search.\"%'\";".PHP_EOL;
                    }else {
                        $searchdata .= "               \$where .= \"       or  ".$field. " like '%\".\$search.\"%'\";".PHP_EOL;                    
                    }                
                }
                $i++;
            }            
            $myfilename = "master_controller_generate.txt";
            $readFile = $this->readFileTemplate($myfilename);
            
            $primarykey = $this->getPrimaryKey($table);
            $Primarykey = ucfirst($this->getPrimaryKey($table));

            $readFile = str_replace("<<Table>>", ucfirst($table), $readFile);
            $readFile = str_replace("<<table>>", $table, $readFile);
            $readFile = str_replace("<<primarykey>>", $primarykey, $readFile);
            $readFile = str_replace("<<Primarykey>>", $Primarykey, $readFile);
            $readFile = str_replace("<<SaveNewFields>>", $saveNewData, $readFile);
            $readFile = str_replace("<<SaveNewNameFields>>", $saveNewNameFields, $readFile);
            $readFile = str_replace("<<SaveFields>>", $updateData, $readFile);
            $readFile = str_replace("<<LoadRecord>>", $loadData, $readFile);
            $readFile = str_replace("<<GetDataPost>>", $GetDataPosts, $readFile);
            $readFile = str_replace("<<SetData>>", $SetDatas, $readFile);
            $readFile = str_replace("<<SearchData>>", $searchdata, $readFile);

            $myfilename = "../controllers/".$table.".controller.generate.php";
            $this->writeFileTemplate($myfilename, $readFile);
            
            echo $readFile.PHP_EOL;
        }
        function generateController($table, $created) {
            if (!file_exists("../controllers/".$table.".controller.php" )|| $created) {
                echo "Generate Controller : ".PHP_EOL;
                $myfilename = "master_controller.txt";
                $readFile = $this->readFileTemplate($myfilename);

                $readFile = str_replace("<<table>>", $table, $readFile);

                $myfilename = "../controllers/".$table.".controller.php";
                $this->writeFileTemplate($myfilename, $readFile);
            }else{
                echo "../controllers/".$table.".controller.php is existing ".PHP_EOL;
            }
        }
        function generateViewList($table, $created, $jquery) {
            $javascriptheader = "<script type=\"text/javascript\"> ".PHP_EOL;
            $javascriptheader .= "function deletedata(id, skip, search){ ".PHP_EOL;
            $javascriptheader .= "    var ask = confirm(\"Do you want to delete ID \" + id + \" ?\");".PHP_EOL;
            $javascriptheader .= "    if (ask == true) {".PHP_EOL;
            $javascriptheader .= "        site = \"index.php?model=<<table>>&action=deleteFormJQuery&skip=\" + skip + \"&search=\" + search + \"&id=\" + id;".PHP_EOL;
            $javascriptheader .= "        target = \"content\";".PHP_EOL;
            $javascriptheader .= "        showMenu(target, site);".PHP_EOL;        
            $javascriptheader .= "    }".PHP_EOL;
            $javascriptheader .= "}".PHP_EOL;
            $javascriptheader .= "function searchData() {".PHP_EOL;
            $javascriptheader .= "     var searchdata = document.getElementById(\"search\").value;".PHP_EOL;
            $javascriptheader .= "     site =  'index.php?model=<<table>>&action=showAllJQuery&search='+searchdata;".PHP_EOL;
            $javascriptheader .= "     target = \"content\";".PHP_EOL;
            $javascriptheader .= "     showMenu(target, site);".PHP_EOL;
            $javascriptheader .= "}".PHP_EOL;
            $javascriptheader .= "$(document).ready(function(){".PHP_EOL;
            $javascriptheader .= "    $('#search').keypress(function(e) {".PHP_EOL;
            $javascriptheader .= "            if(e.which == 13) {".PHP_EOL;
            $javascriptheader .= "                searchData();".PHP_EOL;
            $javascriptheader .= "            }".PHP_EOL;
            $javascriptheader .= "    });".PHP_EOL;
            $javascriptheader .= "});".PHP_EOL;
            $javascriptheader .= "</script>".PHP_EOL; 

            $headertable = "        <th class=\"textBold\"><<field>></th>";
            $headertables = "";
            $primarykey = $this->getPrimaryKey($table);
            $Primarykey = ucfirst($this->getPrimaryKey($table));
            $detailtable = "            <td><?php echo $<<table>>->get<<Field>>();?></td>";
            $detailtablepk = "            <td><a href='<?php echo \"index.php?model=<<table>>&action=showDetail&id=\".$<<table>>->get<<Field>>() ?>'><?php echo $<<table>>->get<<Field>>();?></a></td>";
            $detailtablepkjquery ="              <td><a href='#' onclick=\"showMenu('header_list', 'index.php?model=<<table>>&action=showDetailJQuery&id=<?php echo $<<table>>->get<<Field>>();?>')\"><?php echo $<<table>>->get<<Field>>();?></a> </td>";
            $detailtables = "";
            $first = "<a href=\"index.php?model=<<table>>&action=showAll&search=<?php echo \$search ?>\"><img alt=\"Move First\"  src=\"./img/icon/icon_move_first.gif\" ></a>";
            $firstjquery = "<img alt=\"Move First\"  src=\"./img/icon/icon_move_first.gif\" onclick=\"showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery&search=<?php echo \$search ?>');\" >";
            $previous = "<a href=\"index.php?model=<<table>>&action=showAll&skip=<?php echo \$previous ?>&search=<?php echo \$search ?>\"><img alt=\"Move Previous\" src=\"./img/icon/icon_move_prev.gif\" ></a>";
            $previousjquery = "<img alt=\"Move Previous\" src=\"./img/icon/icon_move_prev.gif\" onclick=\"showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery&skip=<?php echo \$previous ?>&search=<?php echo \$search ?>');\">";
            $next = "<a href=\"index.php?model=<<table>>&action=showAll&skip=<?php echo \$next ?>&search=<?php echo \$search ?>\"><img alt=\"Move Next\" src=\"./img/icon/icon_move_next.gif\" ></a>";
            $nextjquery = "<img alt=\"Move Next\" src=\"./img/icon/icon_move_next.gif\" onclick=\"showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery&skip=<?php echo \$next ?>&search=<?php echo \$search ?>');\" >";
            $last = "<a href=\"index.php?model=<<table>>&action=showAll&skip=<?php echo \$last ?>&search=<?php echo \$search ?>\"><img alt=\"Move Last\" src=\"./img/icon/icon_move_last.gif\" ></a>";
            $lastjquery = "<img alt=\"Move Last\" src=\"./img/icon/icon_move_last.gif\" onclick=\"showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery&skip=<?php echo \$last ?>&search=<?php echo \$search ?>');\">";
            
            if($jquery ) {
                $ahref = "<?php if(\$isadmin || \$ispublic || \$isupdate){ ?>".PHP_EOL;
                $ahref .="                    <a href='#' onclick=\"showMenu('header_list', 'index.php?model=<<table>>&action=showFormJQuery&id=<?php echo $<<table>>->get<<primarykey>>();?>&skip=<?php echo \$skip ?>&search=<?php echo \$search ?>')\">[Edit]</a> | ".PHP_EOL;
                $ahref .= "<?php } ?>".PHP_EOL;
                $ahref .= "<?php if(\$isadmin || \$ispublic || \$isdelete){ ?>".PHP_EOL;
                $ahref .="                    <a href='#' onclick=\"deletedata('<?php echo \$<<table>>->get<<Primarykey>>()?>','<?php echo \$skip ?>','<?php echo \$search ?>')\">[Delete]</a>".PHP_EOL;
                $ahref .= "<?php } ?>".PHP_EOL;
                
                $formsearch .= "       <input type=\"text\" name=\"search\" id=\"search\" value=\"<?php echo \$search ?>\" >&nbsp;&nbsp;<input type=\"button\" class=\"btn btn-info btn-sm\" value=\"find\" onclick=\"searchData()\">".PHP_EOL;
                $formsearch .= "<?php if(\$isadmin || \$ispublic || \$isentry){ ?>".PHP_EOL;
                $formsearch .= "       <input type=\"button\" class=\"btn btn-warning btn-sm\" value=\"new\" name=\"new\" onclick=\"showMenu('header_list', 'index.php?model=<<table>>&action=showFormJQuery')\"> ".PHP_EOL;
                $formsearch .= "<?php } ?>".PHP_EOL;
            }else{
                $ahref = "<?php if(\$isadmin || \$ispublic || \$isupdate){ ?>".PHP_EOL;
                $ahref .="                    <a href='index.php?model=<<table>>&action=showForm&id=<?php echo $<<table>>->get<<primarykey>>();?>'>[Edit]</a> | ".PHP_EOL;
                $ahref .= "<?php } ?>".PHP_EOL;
                $ahref .= "<?php if(\$isadmin || \$ispublic ||\$isdelete){ ?>".PHP_EOL;
                $ahref .="                    <a href='index.php?model=<<table>>&action=deleteForm&id=<?php echo $<<table>>->get<<primarykey>>();?>'>[Delete]</a>".PHP_EOL;
                $ahref .= "<?php } ?>".PHP_EOL;
                
                $formsearch = "<form name=\"frm<<table>>\" method=\"post\" action=\"?model=<<table>>&action=showAll\">".PHP_EOL;
                $formsearch .= "    <input type=\"text\" name=\"search\" id=\"search\" value=\"<?php echo \$search ?>\"><input type=\"submit\" value=\"find\">".PHP_EOL;
                $formsearch .= "<?php if(\$isadmin || \$ispublic ||\$isentry){ ?>".PHP_EOL;
                $formsearch .= "    <a href=\"index.php?model=<<table>>&action=showForm\"> New</a>";
                $formsearch .= "<?php } ?>".PHP_EOL;
                $formsearch .= "</form>".PHP_EOL;
            }
            $q = 'DESCRIBE '.$table;
            $col = 1;
            foreach ($this->dbh->query($q) as $row) {
                $field = $row['Field'];
                $Field = ucfirst($row['Field']);         

                $headertable_ = str_replace("<<field>>", $field, $headertable).PHP_EOL; 
                $headertables .= $headertable_;
                if($field==$primarykey && $jquery) {                  
                     $detailtable_ = $detailtablepkjquery;                    
                }else if($field==$primarykey && !$jquery) {
                     $detailtable_ = $detailtablepk;
                }else{
                    $detailtable_ = $detailtable;                        
                }

                $detailtable_ = str_replace("<<Field>>", $Field, $detailtable_); 
                $detailtable_ = str_replace("<<field>>", $field, $detailtable_); 
                $detailtable_ = str_replace("<<table>>", $table, $detailtable_); 
                $detailtables .= $detailtable_.PHP_EOL;
                if ($col == 4) {
                    break;
                }
                $col++;
            }            

            $headertables .= "<td>&nbsp;</td>";
            $myfilename = "master_list.txt";
            $readFile = $this->readFileTemplate($myfilename);

            if($jquery) {
                $myfilename = "../views/".$table. "/".$table."_jquery_list.php";                    
                $readFile = str_replace("<<javascriptheader>>", $javascriptheader, $readFile );
                $readFile = str_replace("<<JQuery>>", "JQuery", $readFile );
                $readFile = str_replace("<<First>>", $firstjquery, $readFile );
                $readFile = str_replace("<<Previous>>", $previousjquery, $readFile );
                $readFile = str_replace("<<Next>>", $nextjquery, $readFile );
                $readFile = str_replace("<<Last>>", $lastjquery, $readFile );                
            }else{
                $myfilename = "../views/".$table. "/".$table."_list.php";
                $readFile = str_replace("<<javascriptheader>>", "", $readFile );
                $readFile = str_replace("<<JQuery>>", "", $readFile );
                $readFile = str_replace("<<First>>", $first, $readFile );
                $readFile = str_replace("<<Previous>>", $previous, $readFile );
                $readFile = str_replace("<<Next>>", $next, $readFile );
                $readFile = str_replace("<<Last>>", $last, $readFile );                
            }
            $readFile = str_replace("<<FormSearch>>", $formsearch, $readFile );
            $readFile = str_replace("<<ahref>>", $ahref, $readFile );
            $readFile = str_replace("<<table>>", $table, $readFile);
            $readFile = str_replace("<<primarykey>>", $primarykey, $readFile);
            $readFile = str_replace("<<Primarykey>>", $Primarykey, $readFile);
            $readFile = str_replace("<<HeaderTable>>", $headertables, $readFile) ;
            $readFile = str_replace("<<DetailTable>>", $detailtables, $readFile );
            if (!file_exists($myfilename)|| $created) {
                $this->writeFileTemplate($myfilename, $readFile);
            } else {
                echo "file ".$table."_list.php  is existing ".PHP_EOL ;
            }
        }
        
        function generateViewDetail($table, $created, $jquery) {
            echo "Generate View Detail : " .PHP_EOL;
            $backjquery = "<a href='#' onclick=\"showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery');\">Back</a>";
            $back = "<a href='index.php?model=<<table>>&action=showAll'>Back</a>";
            $content = "    <tr> ".PHP_EOL;
            $content .= "        <td> ".PHP_EOL;
            $content .= "            <<Field>> ".PHP_EOL;
            $content .= "        </td> ".PHP_EOL;
            $content .= "        <td> ".PHP_EOL;
            $content .= "            : ".PHP_EOL;
            $content .= "        </td> ".PHP_EOL;
            $content .= "        <td> ".PHP_EOL;
            $content .= "            <?php echo $<<table>>_->get<<Field>>() ?>".PHP_EOL;
            $content .= "        </td> ".PHP_EOL;   
            $content .= "    </tr>".PHP_EOL;

            $contents = "";

            $q = 'DESCRIBE '.$table;            
            foreach ($this->dbh->query($q) as $row) {
                $field = $row['Field'];
                $Field = ucfirst($row['Field']);                        

                $content_ = str_replace("<<table>>", $table, $content); 
                $content_ = str_replace("<<field>>", $field, $content_); 
                $content_ = str_replace("<<Field>>", $Field, $content_);                 

                $contents .= $content_ . PHP_EOL;                
            }

            $myfilename = "master_detail.txt";
            $readFile = $this->readFileTemplate($myfilename);
            if($jquery) {
                $readFile = str_replace("<<header>>", "", $readFile);
                $readFile = str_replace("<<back>>", "" , $readFile);
            }else{
                $readFile = str_replace("<<header>>", "<h1>".$table."</h1>" , $readFile);
                $readFile = str_replace("<<back>>", $back , $readFile);                
            }
            $readFile = str_replace("<<table>>", $table, $readFile);
            $readFile = str_replace("<<Content>>", $contents, $readFile);

            if($jquery) {
                $myfilename = "../views/".$table. "/".$table."_jquery_detail.php";
            }else{
                $myfilename = "../views/".$table. "/".$table."_detail.php";
            }
            if (!file_exists($filename) || $created) {
                $this->writeFileTemplate($myfilename, $readFile);
                echo $readFile.PHP_EOL;
            }else{
                echo "../views/".$table. "/".$table."_detail.php  is existing ".PHP_EOL;
            }
        }
        
        function getFormJQuerylama() {
            $jquery ="<script language=\"javascript\" type=\"text/javascript\">".PHP_EOL;
            $jquery .="        jQuery(function(){".PHP_EOL;
            $jquery .="            $(\"#frm<<table>>\").submit(function(){".PHP_EOL;
            $jquery .="                var post_data = $(this).serialize();".PHP_EOL;
            $jquery .="                var form_action = $(this).attr(\"action\");".PHP_EOL;
            $jquery .="                var form_method = $(this).attr(\"method\");".PHP_EOL;
            $jquery .="                $.ajax({".PHP_EOL;
            $jquery .="                     type : form_method,".PHP_EOL;
            $jquery .="                     url : form_action, ".PHP_EOL;
            $jquery .="                     cache: false, ".PHP_EOL;
            $jquery .="                     data : post_data,".PHP_EOL;
            $jquery .="                     success : function(x){".PHP_EOL;
            $jquery .="                         alert(x);".PHP_EOL;
            $jquery .="                         showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery&skip=<?php echo \$skip ?>&search=<?php echo \$search ?>');".PHP_EOL;
            $jquery .="                     }, ".PHP_EOL;
            $jquery .="                     error : function(){".PHP_EOL;
            $jquery .="                        alert(\"Error\");".PHP_EOL;
            $jquery .="                     }".PHP_EOL;
            $jquery .="                });".PHP_EOL;
            $jquery .="                return false;".PHP_EOL;
            $jquery .="             });".PHP_EOL;
            $jquery .="        });".PHP_EOL;
            $jquery .="</script>".PHP_EOL;
            return $jquery;
        }
        function getFormJQuery() {
            $jquery ="<script language=\"javascript\" type=\"text/javascript\">".PHP_EOL;
            $jquery .="        (function() {".PHP_EOL;
            $jquery .="            $('form').ajaxForm({".PHP_EOL;
            $jquery .="                beforeSubmit: function() {".PHP_EOL;
            $jquery .="                },".PHP_EOL;
            $jquery .="                complete: function(xhr) {".PHP_EOL;
            $jquery .="                        alert($.trim(xhr.responseText));".PHP_EOL;
            $jquery .="                        showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery&skip=<?php echo \$skip ?>&search=<?php echo \$search ?>');".PHP_EOL;
            $jquery .="                }".PHP_EOL;
            $jquery .="             });".PHP_EOL;
            $jquery .="        })();".PHP_EOL;
            $jquery .="        function validate(evt){".PHP_EOL;
            $jquery .="            var e = evt || window.event;".PHP_EOL;
            $jquery .="            var key = e.keyCode || e.which;".PHP_EOL;
            $jquery .="            if((key <48 || key >57) && !(key ==8 || key ==9 || key ==13  || key ==37  || key ==39 || key ==46)  ){".PHP_EOL;
            $jquery .="                e.returnValue = false;".PHP_EOL;
            $jquery .="                if(e.preventDefault)e.preventDefault();".PHP_EOL;
            $jquery .="            }".PHP_EOL;
            $jquery .="        }".PHP_EOL;            
            $jquery .="</script>".PHP_EOL;
            return $jquery;
        }
        function generateViewForm($table, $created, $jquery) {
            echo "Generate View Form ".PHP_EOL;
            $backjquery = "<a href='#' onclick=\"showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery');\">Back</a>";
            $back = "<a href='index.php?model=<<table>>&action=showAll'>Back</a>";
            $content = "        <tr> ".PHP_EOL;
            $content .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $content .="            <td><input type=\"text\"  name=\"<<field>>\" id=\"<<field>>\" value=\"<?php echo $<<table>>_->get<<Field>>();?>\" size=\"<<Size>>\" <<ReadOnly>>  ></td>".PHP_EOL;
            $content .="        </tr>".PHP_EOL;
            
            $contentint = "        <tr> ".PHP_EOL;
            $contentint .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $contentint .="            <td><input type=\"text\" style=\"text-align: right;\" onkeypress=\"validate(event);\"  name=\"<<field>>\" id=\"<<field>>\" value=\"<?php echo $<<table>>_->get<<Field>>();?>\" size=\"<<Size>>\" <<ReadOnly>>  ></td>".PHP_EOL;
            $contentint .="        </tr>".PHP_EOL;
            
            $contentdouble = "        <tr> ".PHP_EOL;
            $contentdouble .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            
            $contentdouble .="            <td><input type=\"text\" style=\"text-align: right;\" onkeypress=\"validate(event);\"  name=\"curr<<field>>\" id=\"curr<<field>>\" value=\"<?php echo $<<table>>_->get<<Field>>();?>\" size=\"<<Size>>\" <<ReadOnly>>  ></td>".PHP_EOL;
            $contentdouble .="                <script>".PHP_EOL;
            $contentdouble .="                       $(document).ready(function(){".PHP_EOL;
            $contentdouble .="                             $('#curr<<field>>').formatCurrency({ symbol:'',roundToDecimalPlace: 0, });".PHP_EOL;
            $contentdouble .="                             $('#curr<<field>>').blur(function(){".PHP_EOL;
            $contentdouble .="                                  $('#curr<<field>>').formatCurrency({ symbol:'',roundToDecimalPlace: 0, });".PHP_EOL;
            $contentdouble .="                                  $('#<<field>>').val($('#curr<<field>>').val().replace(/,/g,''));".PHP_EOL;
            $contentdouble .="                              });".PHP_EOL;
            $contentdouble .="                       });".PHP_EOL;
            $contentdouble .="                 </script>".PHP_EOL; 
            $contentdouble .="            <input type=\"hidden\"  name=\"<<field>>\" id=\"<<field>>\" value=\"<?php echo $<<table>>_->get<<Field>>();?>\" size=\"<<Size>>\" <<ReadOnly>>  ></td>".PHP_EOL;
            
            $contentdouble .="        </tr>".PHP_EOL;
            
            
            
            
            $contenttextarea = "        <tr> ".PHP_EOL;
            $contenttextarea .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $contenttextarea .="            <td><textarea rows=\"10\" cols=\"50\" name=\"<<field>>\" id=\"<<field>>\"><?php echo $<<table>>_->get<<Field>>();?></textarea>".PHP_EOL;
            $contenttextarea .="        <script>$(function(){ ".PHP_EOL;
            $contenttextarea .="                   $('#<<field>>').htmlarea({css: 'jHtmlArea/style/jHtmlArea.Editor.css'});".PHP_EOL;
            $contenttextarea .="                });".PHP_EOL;
            $contenttextarea .="        </script></td>".PHP_EOL;
            
            $contenttextarea .="        </tr>".PHP_EOL;
            

            $contenttextonly = "        <tr> ".PHP_EOL;
            $contenttextonly .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $contenttextonly .="            <td><?php echo $<<table>>_->get<<Field>>();?></td>".PHP_EOL;
            $contenttextonly .="        </tr>".PHP_EOL;

            $contentdate = "        <tr> ".PHP_EOL;
            $contentdate .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $contentdate .="            <td><input type=\"text\" name=\"<<field>>\" id=\"<<field>>\" value=\"<?php echo $<<table>>_->get<<Field>>();?>\" size=\"<<Size>>\" readonly >".PHP_EOL;
            //$contentdate .="                <div id=\"<<field>>_cal\" ></div>".PHP_EOL;
            $contentdate .="            <script>".PHP_EOL;
            $contentdate .="                $(function() {".PHP_EOL;
            $contentdate .="                    $('#<<field>>').datepicker({".PHP_EOL;
            $contentdate .="                        dateFormat: 'yy-mm-dd',".PHP_EOL;
            $contentdate .="                        yearRange: '-100:+20',".PHP_EOL;
            $contentdate .="                        changeYear: true,".PHP_EOL;
            $contentdate .="                        changeMonth: true".PHP_EOL;
            $contentdate .="                    });".PHP_EOL;
            $contentdate .="                });".PHP_EOL;
            
            $contentdate .="            </script>".PHP_EOL;
            
            $contentdate .="            </td> ".PHP_EOL;
            $contentdate .="        </tr>".PHP_EOL;

            $contents = "";

            $q = 'DESCRIBE '.$table;
            foreach ($this->dbh->query($q) as $row) {
                $field = $row['Field'];
                $Field = ucfirst($row['Field']);                        
                $type = $row['Type'];
                $variable = $type;
                $size = "10";
                $maxsize = "40";

                $openposition = strpos($type, "(");

                if ($openposition != false) {
                    $closeposition = strpos($type, ")");
                    $variable = substr($type, 0, $openposition);
                    $size = substr($type, $openposition + 1, $closeposition - $openposition - 1);
                    if ($size > $maxsize) {
                        $size = $maxsize;
                    }
                }

                if ($field=="entrytime" 
                        || $field == "entryuser" 
                        || $field == "entryip" 
                        || $field=="updatetime" 
                        || $field == "updateuser" 
                        || $field == "updateip"
                        ){
                    $content_ = str_replace("<<table>>", $table, $contenttextonly);                         
                }else if ($variable == "text") {
                    $content_ = str_replace("<<table>>", $table, $contenttextarea);                         
                }else if ($variable == "date") {
                    $content_ = str_replace("<<table>>", $table, $contentdate);                         
                }else if ($variable == "int" || $variable == "float") {
                    $content_ = str_replace("<<table>>", $table, $contentint);                         
                }else if ($variable == "double" || $variable == "decimal") {
                    $content_ = str_replace("<<table>>", $table, $contentdouble);                         
                }else{
                    $content_ = str_replace("<<table>>", $table, $content); 
                }

                $content_ = str_replace("<<field>>", $field, $content_); 
                $content_ = str_replace("<<Field>>", $Field, $content_);                 
                $content_ = str_replace("<<Size>>", $size, $content_);                 

                $autonumber = $this->getAutoIncrement($table);

                if ($autonumber == $field ) {
                    $content_ = str_replace("<<ReadOnly>>", "ReadOnly", $content_);                     
                }else{
                    $content_ = str_replace("<<ReadOnly>>", "", $content_);                                         
                }

                $contents .= $content_ . PHP_EOL;
            }

            $myfilename = "master_form.txt";
            $readFile = $this->readFileTemplate($myfilename);
            if($jquery) {
                $readFile = str_replace("<<header>>", "" , $readFile);
                $readFile = str_replace("<<back>>", "" , $readFile);
                $readFile = $this->getFormJQuery() . $readFile;
                $readFile = str_replace("<<JQuery>>", "JQuery", $readFile );                
            }else{
                $readFile = str_replace("<<header>>", "<h1>".$table."</h1>" , $readFile);
                $readFile = str_replace("<<back>>", $back , $readFile);                
                $readFile = str_replace("<<JQuery>>", "", $readFile );                                
            }
            $readFile = str_replace("<<table>>", $table, $readFile);
            $readFile = str_replace("<<DetailForm>>", $contents, $readFile);

            if($jquery){
                $myfilename = "../views/".$table. "/".$table."_jquery_form.php";
                $readFile = str_replace("<<JQuery>>", "JQuery", $readFile);                
            }else{
                $myfilename = "../views/".$table. "/".$table."_form.php";
            }
            if (!file_exists($myfilename) || $created) {
                $this->writeFileTemplate($myfilename, $readFile);
                echo $readFile.PHP_EOL;
            }else{
                echo "../views/".$table. "/".$table."_form.php  is existing ".PHP_EOL;
            }
        }
        function generateViewFormlama($table, $created, $jquery) {
            echo "Generate View Form ".PHP_EOL;
            $backjquery = "<a href='#' onclick=\"showMenu('content', 'index.php?model=<<table>>&action=showAllJQuery');\">Back</a>";
            $back = "<a href='index.php?model=<<table>>&action=showAll'>Back</a>";
            $content = "        <tr> ".PHP_EOL;
            $content .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $content .="            <td><input type=\"text\"  name=\"<<field>>\" id=\"<<field>>\" value=\"<?php echo $<<table>>_->get<<Field>>();?>\" size=\"<<Size>>\" <<ReadOnly>>  ></td>".PHP_EOL;
            $content .="        </tr>".PHP_EOL;

            $contenttextarea = "        <tr> ".PHP_EOL;
            $contenttextarea .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $contenttextarea .="            <td><textarea rows=\"10\" cols=\"50\" name=\"<<field>>\" id=\"<<field>>\"><?php echo $<<table>>_->get<<Field>>();?></textarea>".PHP_EOL;
            $contenttextarea .="        <script>$(function(){ ".PHP_EOL;
            $contenttextarea .="                   $('#<<field>>').htmlarea({css: 'jHtmlArea/style/jHtmlArea.Editor.css'});".PHP_EOL;
            $contenttextarea .="                });".PHP_EOL;
            $contenttextarea .="        </script></td>".PHP_EOL;
            
            $contenttextarea .="        </tr>".PHP_EOL;
            

            $contenttextonly = "        <tr> ".PHP_EOL;
            $contenttextonly .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $contenttextonly .="            <td><?php echo $<<table>>_->get<<Field>>();?></td>".PHP_EOL;
            $contenttextonly .="        </tr>".PHP_EOL;

            $contentdate = "        <tr> ".PHP_EOL;
            $contentdate .="            <td class=\"textBold\"><<Field>></td> ".PHP_EOL;
            $contentdate .="            <td><input type=\"text\" name=\"<<field>>\" id=\"<<field>>\" value=\"<?php echo $<<table>>_->get<<Field>>();?>\" size=\"<<Size>>\" <<ReadOnly>> onfocus=\"showCalendarControl(this, '<<field>>_cal');\">".PHP_EOL;
            //$contentdate .="                <div id=\"<<field>>_cal\" ></div>".PHP_EOL;
            $contentdate .="            <script>".PHP_EOL;
            $contentdate .="                $(function() {".PHP_EOL;
            $contentdate .="                    $('#<<field>>').datepicker({".PHP_EOL;
            $contentdate .="                        dateFormat: 'yy-mm-dd',".PHP_EOL;
            $contentdate .="                        yearRange: '-100:+20',".PHP_EOL;
            $contentdate .="                        changeYear: true,".PHP_EOL;
            $contentdate .="                        changeMonth: true".PHP_EOL;
            $contentdate .="                    });".PHP_EOL;
            $contentdate .="                });".PHP_EOL;
            
            $contentdate .="            </script>".PHP_EOL;
            
            $contentdate .="            </td> ".PHP_EOL;
            $contentdate .="        </tr>".PHP_EOL;

            $contents = "";

            $q = 'DESCRIBE '.$table;
            foreach ($this->dbh->query($q) as $row) {
                $field = $row['Field'];
                $Field = ucfirst($row['Field']);                        
                $type = $row['Type'];
                $variable = $type;
                $size = "10";
                $maxsize = "40";

                $openposition = strpos($type, "(");

                if ($openposition != false) {
                    $closeposition = strpos($type, ")");
                    $variable = substr($type, 0, $openposition);
                    $size = substr($type, $openposition + 1, $closeposition - $openposition - 1);
                    if ($size > $maxsize) {
                        $size = $maxsize;
                    }
                }

                if ($field=="entrytime" 
                        || $field == "entryuser" 
                        || $field == "entryip" 
                        || $field=="updatetime" 
                        || $field == "updateuser" 
                        || $field == "updateip"
                        ){
                    $content_ = str_replace("<<table>>", $table, $contenttextonly);                         
                }else if ($variable == "text") {
                    $content_ = str_replace("<<table>>", $table, $contenttextarea);                         
                }else if ($variable == "date") {
                    $content_ = str_replace("<<table>>", $table, $contentdate);                         
                }else{
                    $content_ = str_replace("<<table>>", $table, $content); 
                }

                $content_ = str_replace("<<field>>", $field, $content_); 
                $content_ = str_replace("<<Field>>", $Field, $content_);                 
                $content_ = str_replace("<<Size>>", $size, $content_);                 

                $autonumber = $this->getAutoIncrement($table);

                if ($autonumber == $field ) {
                    $content_ = str_replace("<<ReadOnly>>", "ReadOnly", $content_);                     
                }else{
                    $content_ = str_replace("<<ReadOnly>>", "", $content_);                                         
                }

                $contents .= $content_ . PHP_EOL;
            }

            $myfilename = "master_form.txt";
            $readFile = $this->readFileTemplate($myfilename);
            if($jquery) {
                $readFile = str_replace("<<header>>", "" , $readFile);
                $readFile = str_replace("<<back>>", "" , $readFile);
                $readFile = $this->getFormJQuery() . $readFile;
                $readFile = str_replace("<<JQuery>>", "JQuery", $readFile );                
            }else{
                $readFile = str_replace("<<header>>", "<h1>".$table."</h1>" , $readFile);
                $readFile = str_replace("<<back>>", $back , $readFile);                
                $readFile = str_replace("<<JQuery>>", "", $readFile );                                
            }
            $readFile = str_replace("<<table>>", $table, $readFile);
            $readFile = str_replace("<<DetailForm>>", $contents, $readFile);

            if($jquery){
                $myfilename = "../views/".$table. "/".$table."_jquery_form.php";
                $readFile = str_replace("<<JQuery>>", "JQuery", $readFile);                
            }else{
                $myfilename = "../views/".$table. "/".$table."_form.php";
            }
            if (!file_exists($myfilename) || $created) {
                $this->writeFileTemplate($myfilename, $readFile);
                echo $readFile.PHP_EOL;
            }else{
                echo "../views/".$table. "/".$table."_form.php  is existing ".PHP_EOL;
            }
        }
            
        function createDirView($directory) {
            echo "Trying create ".  $directory .PHP_EOL;
            try{
                mkdir($directory);
            }  catch (Exception $message ) {
                //echo $message;
            }            
            echo "Done ".PHP_EOL;
        }

        function readFileTemplate($fileName) {
            echo "Read Template file : ".$fileName .PHP_EOL;
            $file = fopen($fileName, "r") or die("Unable to open file!");
            $readFile = fread($file,filesize($fileName));
            fclose($file);

            return $readFile;
        }
        
        function writeFileTemplate($filename, $readFile) {
            echo "Write Template file : ".$filename.PHP_EOL;
            $fileWrite = fopen($filename,"w");
            fwrite($fileWrite,$readFile);
            fclose($fileWrite);            
        }
    }
    
?>
