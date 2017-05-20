<?php
    class CrossTab {
        var $dbh;
        function __construct($dbh) {
            $this->dbh = $dbh;
        }
        function getFields($sql) {        
            $fields = array();
            $result = $this->dbh->query($sql);
            $fields_cnt = $result->columnCount();
            for ($i = 0; $i < $fields_cnt; $i++){
                $col = $result->getColumnMeta($i);
                $fields[] = $col['name'];  
            }        
            return $fields;            
        }

        function getCrossTab($fields,$sql,$style) {        
            $FROM = "FROM";
            $GROUP = "GROUP";

            $SQLUP = strtoupper($sql);

            $pos = strpos($SQLUP, "FROM");
            $posgroup = strripos($SQLUP, "GROUP");

            if ($posgroup == 0) {
                $startfrom = substr($sql, $pos );
            }else{
                $startfrom = substr($sql, $pos, $posgroup - $pos );            
            }                
            $sqlconcat = "SELECT GROUP_CONCAT(DISTINCT `".$fields[0] ."`  ORDER BY `".$fields[0]."` ASC) ".$startfrom;        
            
            $jmlKolom = count($fields);
            $columns =  array();
            foreach ($this->dbh->query($sqlconcat) as $row) {
                    $columns = explode(",", $row[0]);
            }        
            $newsql = ($style == 4) ? "\nSELECT @ROW:=@ROW+1 `No`," : "\nSELECT ";
            if($jmlKolom == 3){
                $newsql .= ($style==3 || $style==4) ? "\n". $fields[1] : "";    
            } elseif($jmlKolom == 5){
                $newsql .= ($style==3 || $style==4) ? "\n". $fields[1].",".$fields[2].",".$fields[3] : "";    
            }
            
            $no = 0;
            foreach ($columns as $column){ 
                $jmlRow = count($columns);
                if($style==3 || $style==4){
                    if($jmlKolom == 3){
                        $newsql .= ",\n SUM(CASE WHEN `$fields[0]` = '$column' THEN $fields[2] ELSE 0 END) `$column` ";
                    } elseif($jmlKolom == 5){
                        $newsql .= ",\n SUM(CASE WHEN `$fields[0]` = '$column' THEN $fields[4] ELSE 0 END) `$column` ";
                    }
                } else {
                    $newsql .= "\n SUM(CASE WHEN `$fields[0]` = '$column' THEN $fields[1] ELSE 0 END) `$column` ";
                    if($no < $jmlRow-1){
                        $newsql .= ",";
                    }                    
                } 
                $no++;
            }
            if($jmlKolom == 3){
                $newsql .= ($style==4) ? ",SUM($fields[2]) `Sub Total` " : "";
            } elseif($jmlKolom == 5){
                $newsql .= ($style==4) ? ",SUM($fields[4]) `Sub Total` " : "";
            }
            $newsql .= "\n FROM (";
            $newsql .= "\n". $sql;
            $newsql .= "\n) crosstab,(SELECT @ROW:=0) r ";
            $newsql .= ($style==3 || $style==4) ?  "\n GROUP BY ".$fields[1]." ORDER BY @ROW:=@ROW+1" : ""; 

            return $newsql ;
        }
    }
?>
