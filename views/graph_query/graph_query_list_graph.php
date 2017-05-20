<script type="text/javascript" >
    function deleteGraph(id){
        showMenu('content', 'index.php?model=graph_query&action=deleteGraphUserById&id='+id);
    }
    
    function showGraph(pos, month, year){
        var month = document.getElementById(month).value;
        var year = document.getElementById(year).value;

        graphpos = "graph"+pos;
        url = "index.php?model=graph_query&action=showGraph&id="+pos+"&month="+month+"&year="+year;
                
        showMenu(graphpos, url);
    }
    function showGraphDetail(id, month, year){
        var month = document.getElementById(month).value;
        var year = document.getElementById(year).value;

        graphpos = "content";
        url = "index.php?model=graph_query&action=showGraphAndTable&id="+id+"&month="+month+"&year="+year;
                
        showMenu(graphpos, url);
    }
    
</script>


<div style="margin: auto;border-collapse: collapse">
    <table border="0" width="95%" align="center" style="border-collapse: collapse">
        <tr>
            <td><?php include_once 'dashboard_user.php';?></td>
        </tr>
    </table>
</div>    

<br>
<div class="row">
    
<table width="95%" border="0">
<tr>
<td>

    
<?php
    $countrow = count($graph_query_list) ; 
    $colrow = ceil($countrow / 2);
    
    $i = 1;
    foreach($graph_query_list as $graph_query){
        if($i == 1) {
?>
        <section class="col-lg-6 connectedSortable">  
           
<?php
        }elseif($i == $colrow+1){
		
?>

        </section>
        <section class="col-lg-6 connectedSortable">    
         
<?php                
        }
?>
        </div>
        
        
        <div class="box box-primary">
            <!-- Tabs within a box -->
            
            <ul class="nav nav-tabs pull-left">
                <li class="pull-left header"><class="fa"> <a href='#' onclick="deleteGraph('<?php echo $graph_query->getId();?>');" title="Tutup"> <img src="img/icon-delete.gif"></a>&nbsp; &nbsp;<img src="img/icon/icon-chart.png"></i>&nbsp;
                    <strong>
                    <?php
                        if($graph_query->getMonth() == 1 || $graph_query->getYear() == 1){                            
                            $link = "<a href=\"#\" onclick=\"showGraphDetail('".$graph_query->getId()."','month".$graph_query->getId()."', 'year".$graph_query->getId()."')\">".$graph_query->getTitle()."</a>";                    
                        }else{
                            $url = "index.php?model=graph_query&action=showGraphAndTable&id=".$graph_query->getId();
                            $link = "<a href=\"#\" onclick=\"showMenu('content','".$url."')\">".$graph_query->getTitle()."</a>";                    
                        }
                        echo $link;
                    ?>
                    </strong>
                </li> &nbsp;              
            </ul>
            <?php
            if($graph_query->getMonth() == 1 || $graph_query->getYear() == 1){                            
            ?>            
            <ul class="nav nav-tabs pull-right">
                <li class="pull-right header">
            <?php
                if($graph_query->getMonth() == 1){                
            ?>
                    <select name="month<?php echo $graph_query->getId();?>" id="month<?php echo $graph_query->getId();?>">
                        <option value="01" <?php echo date('m') == "01" ? "selected" : ""?>>January</option>
                        <option value="02" <?php echo date('m') == "02" ? "selected" : ""?>>February</option>
                        <option value="03" <?php echo date('m') == "03" ? "selected" : ""?>>March</option>
                        <option value="04" <?php echo date('m') == "04" ? "selected" : ""?>>May</option>
                        <option value="05" <?php echo date('m') == "05" ? "selected" : ""?>>April</option>
                        <option value="06" <?php echo date('m') == "06" ? "selected" : ""?>>June</option>
                        <option value="07" <?php echo date('m') == "07" ? "selected" : ""?>>July</option>
                        <option value="08" <?php echo date('m') == "08" ? "selected" : ""?>>Augusts</option>
                        <option value="09" <?php echo date('m') == "09" ? "selected" : ""?>>September</option>
                        <option value="10" <?php echo date('m') == "10" ? "selected" : ""?>>October</option>
                        <option value="11" <?php echo date('m') == "11" ? "selected" : ""?>>November</option>
                        <option value="12" <?php echo date('m') == "12" ? "selected" : ""?>>December</option>
                    </select>
                <?php
                }else{
                ?>
                    <input type='hidden' name="month<?php echo $graph_query->getId();?>" id="month<?php echo $graph_query->getId();?>" value='<?php echo date('m') ?>'>                
                <?php
                }
                if($graph_query->getYear() == 1){                
                ?>
                    <input type="text" name="year<?php echo $graph_query->getId();?>" id="year<?php echo $graph_query->getId();?>" value="<?php echo date('Y')?>" size="5">
                <?php
                }
                ?>
                <input type="button" value=" Show " onclick="showGraph('<?php echo $graph_query->getId();?>','month<?php echo $graph_query->getId();?>', 'year<?php echo $graph_query->getId();?>')" >&nbsp;
                </li>
            </ul>
            <?php
            }
            ?>
            <div class="cleaner"></div>
            <div class="box-body box-danger" >
                <div id="graph<?php echo $graph_query->getId();?>" >
                </div>                
            </div>
        </div>
<div class="cleaner_h10"></div>

<?php            
        if($i == $countrow){
?>
        </section>            
<?php       
        }

    $i++;
    }
?>

</div>
</td>
</tr>
</table>                                                   
<div class="cleaner_h10"></div>


<script type="text/javascript">
$(document).ready(function(){
    <?php
    foreach($graph_query_list as $graph_query){
?>
        $("#graph<?php echo $graph_query->getId();?>").load('index.php?model=graph_query&action=showGraph&id=<?php echo $graph_query->getId();?>');          
<?php
    }
?>
});

</script>
