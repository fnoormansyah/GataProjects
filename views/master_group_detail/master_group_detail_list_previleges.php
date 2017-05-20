<script language="javascript" type="text/javascript">
        jQuery(function(){
            $("#saveprevileges").submit(function(){
                var post_data = $(this).serialize();
                var form_action = $(this).attr("action");
                var form_method = $(this).attr("method");
                $.ajax({
                     type : form_method,
                     url : form_action, 
                     cache: false, 
                     data : post_data,
                     success : function(){
                         alert("Data is Already Saved");
                     }
                     , 
                     error : function(error){
                        alert("Error"+error.value);
                     }
                });
                return false;
             });
        });
</script>


<form name="saveprevileges" id="saveprevileges" method="post" action="index.php?model=master_group_detail&action=savePrivileges" >
    <input type="hidden" name="groupcode" id="groupcode" value="<?php echo $master_group->getGroupcode() ?>">
    <table border="1"  cellpadding="2" style="border-collapse: collapse;" width="95%">
        <tr>
            <th class="textBold">module</th>
            <th class="textBold">read</th>
            <th class="textBold">confirm</th>
            <th class="textBold">entry</th>
            <th class="textBold">update</th>
            <th class="textBold">delete</th>
            <th class="textBold">print</th>
            <th class="textBold">export</th>
            <th class="textBold">import</th>
        </tr>
        <?php

        $no = 1;

        if ($master_group_detail_list != "") { 
            foreach($master_group_detail_list as $master_group_detail){
                $pi = $no + 1;
                $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
                $master_module = $master_group_detail_controller->getModuleNameByDetail($master_group_detail);
        ?>
                <tr bgcolor="<?php echo $bg;?>">
                <td><?php echo $master_module->getDescription();?> </td>
                <td><input type="checkbox" name="read[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getRead()? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="confirm[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getConfirm()? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="entry[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getEntry()? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="update[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getUpdate()? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="delete[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getDelete()? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="print[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getPrint()? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="export[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getExport()? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="import[]" value="<?php echo $master_module->getModule(); ?>" <?php echo $master_group_detail->getImport()? 'checked' : '' ?>></td>

                </tr>
        <?php
                $no++;
            }
        }
        ?>
    </table>
    <input type="submit">
</form>
<br>