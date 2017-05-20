<h1>replace_character</h1>
<br>
<a href='index.php?model=replace_character&action=showAll'>Back</a>

<form name="frmreplace_character" id="frmreplace_character" method="post" action="index.php?model=replace_character&action=saveForm">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $replace_character_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Sourcetext</td> 
            <td><input type="text"  name="sourcetext" id="sourcetext" value="<?php echo $replace_character_->getSourcetext();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Replacetext</td> 
            <td><input type="text"  name="replacetext" id="replacetext" value="<?php echo $replace_character_->getReplacetext();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entrytime</td> 
            <td><?php echo $replace_character_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryuser</td> 
            <td><?php echo $replace_character_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryip</td> 
            <td><?php echo $replace_character_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updatetime</td> 
            <td><?php echo $replace_character_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateuser</td> 
            <td><?php echo $replace_character_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateip</td> 
            <td><?php echo $replace_character_->getUpdateip();?></td>
        </tr>


        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-red btn-sm" ></td>
        </tr>
    </table>
</form>
<br>
<br>
