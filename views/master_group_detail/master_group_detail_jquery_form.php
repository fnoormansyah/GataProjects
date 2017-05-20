<script language="javascript" type="text/javascript">
        jQuery(function(){
            $("#frmmaster_group_detail").submit(function(){
                var post_data = $(this).serialize();
                var form_action = $(this).attr("action");
                var form_method = $(this).attr("method");
                $.ajax({
                     type : form_method,
                     url : form_action, 
                     cache: false, 
                     data : post_data,
                     success : function(x){
                         alert(x);
                         showMenu('content', 'index.php?model=master_group_detail&action=showAllJQuery&skip=<?php echo $skip ?>&search=<?php echo $search ?>');
                     }, 
                     error : function(){
                        alert("Error");
                     }
                });
                return false;
             });
        });
</script>

<br>


<form name="frmmaster_group_detail" id="frmmaster_group_detail" method="post" action="index.php?model=master_group_detail&action=saveFormJQuery">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $master_group_detail_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Groupcode</td> 
            <td><input type="text"  name="groupcode" id="groupcode" value="<?php echo $master_group_detail_->getGroupcode();?>" size="20"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Module</td> 
            <td><input type="text"  name="module" id="module" value="<?php echo $master_group_detail_->getModule();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Read</td> 
            <td><input type="text"  name="read" id="read" value="<?php echo $master_group_detail_->getRead();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Confirm</td> 
            <td><input type="text"  name="confirm" id="confirm" value="<?php echo $master_group_detail_->getConfirm();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entry</td> 
            <td><input type="text"  name="entry" id="entry" value="<?php echo $master_group_detail_->getEntry();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Update</td> 
            <td><input type="text"  name="update" id="update" value="<?php echo $master_group_detail_->getUpdate();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Delete</td> 
            <td><input type="text"  name="delete" id="delete" value="<?php echo $master_group_detail_->getDelete();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Print</td> 
            <td><input type="text"  name="print" id="print" value="<?php echo $master_group_detail_->getPrint();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Export</td> 
            <td><input type="text"  name="export" id="export" value="<?php echo $master_group_detail_->getExport();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Import</td> 
            <td><input type="text"  name="import" id="import" value="<?php echo $master_group_detail_->getImport();?>" size="1"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entrytime </td> 
            <td><?php echo $master_group_detail_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryuser</td> 
            <td><?php echo $master_group_detail_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryip</td> 
            <td><?php echo $master_group_detail_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updatetime</td> 
            <td><?php echo $master_group_detail_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateuser</td> 
            <td><?php echo $master_group_detail_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateip</td> 
            <td><?php echo $master_group_detail_->getUpdateip();?></td>
        </tr>


        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-red btn-sm" ></td>
        </tr>
    </table>
</form>
<br>
<br>
