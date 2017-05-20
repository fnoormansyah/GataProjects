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
                     }, 
                     error : function(){
                        alert("Error");
                     }
                });
                return false;
             });
        });
</script>

<form name="saveprevileges" id="saveprevileges" method="post" action="index.php?model=master_user_detail&action=savePrivileges" >
    <input type="hidden" name="user" id="user" value="<?php echo $master_user->getUser() ?>">
    <table border="1"  cellpadding="2" style="border-collapse: collapse;" width="30%">
        <tr>
            <th class="textBold">groupcode</th>
        </tr>
        <?php

        $no = 1;

        if ($master_user_detail_list != "") { 
            foreach($master_user_detail_list as $master_user_detail){
                $pi = $no + 1;
                $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
        ?>
                <tr bgcolor="<?php echo $bg;?>">
                <td><input type="checkbox" name="group[]" value="<?php echo $master_user_detail->getGroupcode();?>"  <?php echo $master_user_detail->getId() > 0 ? "checked" : "" ;?> >
                <?php echo $master_user_detail->getGroupcode();?></td>
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