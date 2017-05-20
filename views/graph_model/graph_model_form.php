<h1>graph_model</h1>
<br>
<a href='index.php?model=graph_model&action=showAll'>Back</a>

<form name="frmgraph_model" id="frmgraph_model" method="post" action="index.php?model=graph_model&action=saveForm">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $graph_model_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Type</td> 
            <td><input type="text"  name="type" id="type" value="<?php echo $graph_model_->getType();?>" size="10"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Name</td> 
            <td><input type="text"  name="name" id="name" value="<?php echo $graph_model_->getName();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Filename</td> 
            <td><input type="text"  name="filename" id="filename" value="<?php echo $graph_model_->getFilename();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Description</td> 
            <td><input type="text"  name="description" id="description" value="<?php echo $graph_model_->getDescription();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Title</td> 
            <td><input type="text"  name="title" id="title" value="<?php echo $graph_model_->getTitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Subtitle</td> 
            <td><input type="text"  name="subtitle" id="subtitle" value="<?php echo $graph_model_->getSubtitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Xaxiscategories</td> 
            <td><textarea rows="10" cols="50" name="xaxiscategories" id="xaxiscategories"><?php echo $graph_model_->getXaxiscategories();?></textarea></td>
        </tr>

        <tr> 
            <td class="textBold">Xaxistitle</td> 
            <td><input type="text"  name="xaxistitle" id="xaxistitle" value="<?php echo $graph_model_->getXaxistitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Yaxistitle</td> 
            <td><input type="text"  name="yaxistitle" id="yaxistitle" value="<?php echo $graph_model_->getYaxistitle();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Tooltips</td> 
            <td><input type="text"  name="tooltips" id="tooltips" value="<?php echo $graph_model_->getTooltips();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Series</td> 
            <td><textarea rows="10" cols="50" name="series" id="series"><?php echo $graph_model_->getSeries();?></textarea></td>
        </tr>

        <tr> 
            <td class="textBold">Entrytime</td> 
            <td><?php echo $graph_model_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryuser</td> 
            <td><?php echo $graph_model_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryip</td> 
            <td><?php echo $graph_model_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updatetime</td> 
            <td><?php echo $graph_model_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateuser</td> 
            <td><?php echo $graph_model_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateip</td> 
            <td><?php echo $graph_model_->getUpdateip();?></td>
        </tr>


        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-red btn-sm" ></td>
        </tr>
    </table>
</form>
<br>
<br>
