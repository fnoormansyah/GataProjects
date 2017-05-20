<h1>Master Module</h1>
<br>
<a href='index.php?model=master_module&action=showAll'>Back</a>

<form name="frmmaster_module" id="frmmaster_module" method="post" action="index.php?model=master_module&action=saveForm">
    <table >
        <tr> 
            <td class="textBold">Id</td>
            <td>:</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $master_module_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Module</td>
            <td>:</td> 
            <td><input type="text"  name="module" id="module" value="<?php echo $master_module_->getModule();?>" size="37"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Description Head</td>
            <td>:</td> 
            <td><input type="text"  name="descriptionhead" id="descriptionhead" value="<?php echo $master_module_->getDescriptionhead();?>" size="37"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Description</td>
            <td>:</td> 
            <td><input type="text"  name="description" id="description" value="<?php echo $master_module_->getDescription();?>" size="37"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Picture</td>
            <td>:</td> 
            <td><input type="text"  name="picture" id="picture" value="<?php echo $master_module_->getPicture();?>" size="37"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Class colour</td>
            <td>:</td> 
            <td><input type="text"  name="classcolour" id="classcolour" value="<?php echo $master_module_->getClasscolour();?>" size="37"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Onclick</td>
            <td>:</td> 
            <td><textarea rows="10" cols="37" name="onclick" id="onclick"><?php echo $master_module_->getOnclick();?></textarea></td>
        </tr>

        <tr> 
            <td class="textBold">Onclick Submenu</td>
            <td>:</td> 
            <td><textarea rows="10" cols="37" name="onclicksubmenu" id="onclicksubmenu"><?php echo $master_module_->getOnclicksubmenu();?></textarea></td>
        </tr>

        <tr> 
            <td class="textBold">Parent Id</td>
            <td>:</td> 
            <td><input type="text"  name="parentid" id="parentid" value="<?php echo $master_module_->getParentid();?>" size="11"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Public</td>
            <td>:</td> 
            <td><input type="text"  name="public" id="public" value="<?php echo $master_module_->getPublic();?>" size="11"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entry Time</td>
            <td>:</td> 
            <td><?php echo $master_module_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entry User</td>
            <td>:</td> 
            <td><?php echo $master_module_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entry IP</td>
            <td>:</td> 
            <td><?php echo $master_module_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Update Time</td>
            <td>:</td> 
            <td><?php echo $master_module_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Update User</td>
            <td>:</td> 
            <td><?php echo $master_module_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Update IP</td>
            <td>:</td> 
            <td><?php echo $master_module_->getUpdateip();?></td>
        </tr>


        <tr>
            <td></td>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-red btn-sm" ></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<br>
<br>
