<script language="javascript" type="text/javascript">
        jQuery(function(){
            $("#frmmaster_group").submit(function(){
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
                         showMenu('content', 'index.php?model=master_group&action=showAllJQuery&skip=<?php echo $skip ?>&search=<?php echo $search ?>');
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


<form name="frmmaster_group" id="frmmaster_group" method="post" action="index.php?model=master_group&action=saveFormJQuery">
    <table >
        <tr> 
            <td class="textBold">Id</td>
            <td>:</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $master_group_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Group Code</td>
            <td>:</td> 
            <td><input type="text"  name="groupcode" id="groupcode" value="<?php echo $master_group_->getGroupcode();?>" size="20"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Description</td>
            <td>:</td> 
            <td><input type="text"  name="description" id="description" value="<?php echo $master_group_->getDescription();?>" size="20"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entry Time 1</td>
            <td>:</td> 
            <td><?php echo $master_group_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entry User</td>
            <td>:</td> 
            <td><?php echo $master_group_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entry IP</td>
            <td>:</td> 
            <td><?php echo $master_group_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Update Time</td>
            <td>:</td> 
            <td><?php echo $master_group_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Update User</td>
            <td>:</td> 
            <td><?php echo $master_group_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Update IP</td>
            <td>:</td> 
            <td><?php echo $master_group_->getUpdateip();?></td>
        </tr>


        <tr>
            <td></td>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-red btn-sm" ></td>
        </tr>
    </table>
</form>
<br>
<br>
