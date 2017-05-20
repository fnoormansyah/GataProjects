<h1>graph_query</h1>
<br>
<a href='index.php?model=graph_query&action=showAll'>Back</a>

<form name="frmgraph_query" id="frmgraph_query" method="post" action="index.php?model=graph_query&action=saveForm">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $graph_query_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Id_graph_model</td> 
            <td><input type="text"  name="id_graph_model" id="id_graph_model" value="<?php echo $graph_query_->getId_graph_model();?>" size="11"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Query</td> 
            <td><textarea rows="10" cols="50" name="query" id="query"><?php echo $graph_query_->getQuery();?></textarea></td>
        </tr>

        <tr> 
            <td class="textBold">Crosstab</td> 
            <td><input type="text"  name="crosstab" id="crosstab" value="<?php echo $graph_query_->getCrosstab();?>" size="11"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Tabletemp</td> 
            <td><input type="text"  name="tabletemp" id="tabletemp" value="<?php echo $graph_query_->getTabletemp();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Lastupdate</td> 
            <td><input type="text"  name="lastupdate" id="lastupdate" value="<?php echo $graph_query_->getLastupdate();?>" size="10"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Timing</td> 
            <td><input type="text"  name="timing" id="timing" value="<?php echo $graph_query_->getTiming();?>" size="11"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Month</td> 
            <td><input type="text"  name="month" id="month" value="<?php echo $graph_query_->getMonth();?>" size="11"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Year</td> 
            <td><input type="text"  name="year" id="year" value="<?php echo $graph_query_->getYear();?>" size="11"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Title</td> 
            <td><input type="text"  name="Title" id="Title" value="<?php echo $graph_query_->getTitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">SubTitle</td> 
            <td><input type="text"  name="SubTitle" id="SubTitle" value="<?php echo $graph_query_->getSubTitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Xaxistitle</td> 
            <td><input type="text"  name="xaxistitle" id="xaxistitle" value="<?php echo $graph_query_->getXaxistitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Yaxistitle</td> 
            <td><input type="text"  name="yaxistitle" id="yaxistitle" value="<?php echo $graph_query_->getYaxistitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Tooltips</td> 
            <td><input type="text"  name="tooltips" id="tooltips" value="<?php echo $graph_query_->getTooltips();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entrytime</td> 
            <td><?php echo $graph_query_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryuser</td> 
            <td><?php echo $graph_query_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryip</td> 
            <td><?php echo $graph_query_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updatetime</td> 
            <td><?php echo $graph_query_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateuser</td> 
            <td><?php echo $graph_query_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateip</td> 
            <td><?php echo $graph_query_->getUpdateip();?></td>
        </tr>


        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-danger btn-sm" ></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<br>
<br>
