<script language="javascript" type="text/javascript">
        jQuery(function(){
            $("#frmmaster_user").submit(function(){
                var post_data = $(this).serialize();
                var form_action = $(this).attr("action");
                var form_method = $(this).attr("method");
                $.ajax({
                     type : form_method,
                     url : form_action, 
                     cache: false, 
                     data : post_data,
                     success : function(x){
                         alert("Data User Sudah Tersimpan");
                         showMenu('content', 'index.php?model=master_user&action=showAllJQuery&skip=<?php echo $skip ?>&search=<?php echo $search ?>');
                     }, 
                     error : function(){
                        alert("Error");
                     }
                });
                return false;
             });
        });
</script>

<form name="frmmaster_user" id="frmmaster_user" method="post" action="index.php?model=master_user&action=saveFormJQuery" >

    <table >        
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $master_user_->getId();?>" size="10" placeholder="Auto Generate" ReadOnly  ></td>
        </tr>
        <tr> 
            <td class="textBold">User Fullname</td> 
            <td><input type="text"  name="username" id="username" value="<?php echo $master_user_->getUsername();?>" size="40"   ></td>
        </tr>
        <tr> 
            <td class="textBold">User Description</td> 
            <td><input type="text"  name="description" id="description" value="<?php echo $master_user_->getDescription();?>" size="40"   ></td>
        </tr>
        <tr> 
            <td class="textBold">Username</td> 
            <td><input type="text"  name="user" id="user" value="<?php echo $master_user_->getUser();?>" size="30"   ></td>
        </tr>
        <tr> 
            <td class="textBold">Password</td> 
            <td><input type="text"  name="password" id="password" value="<?php echo $master_user_->getPassword();?>" size="40"   ></td>
        </tr>
        <tr> 
            <td class="textBold">Avatar</td> 
            <td>
                <input id="avatar" type="file" name="avatar" value="Upload Image"> 
            </td>
        </tr>
        <tr> 
            <td class="textBold">Nik</td> 
            <td>
                <input type="text"  name="nik" id="nik" value="<?php echo $master_user_->getNik();?>" size="30"   >                             
            </td>
        </tr>
        <tr> 
            <td class="textBold">Department</td> 
            <td>
                <select name='departmentid' id='departmentid'>
                    <option value="0">
                        All Department
                    </option>
                <?php
                    foreach ($master_department_list as $master_department){
                        $selected =($master_user_->getDepartmentid()==$master_department->getDepartmentid())? "selected":"";
                ?>
                    <option value="<?php echo $master_department-> getDepartmentid()?>" <?php echo $selected; ?>>
                        <?php echo $master_department-> getDescription() ?>
                    </option>
                <?php
                    }
                ?>
                </select>
                    
            </td>
        </tr>
        <tr> 
            <td class="textBold">Unit</td> 
            <td>
                <select name="unitid" id="unitid">
                <option value="0">All Unit</option>
                <?php 
                    foreach ($master_unit_list as $master_unit) {
                        $selected =($master_user_->getUnitid()==$master_unit ->getUnitid()) ? "selected" : "";
                        ?>
                    <option value="<?php echo $master_unit ->getUnitid() ?>" <?php echo $selected; ?>>
                      <?php  echo $master_unit ->getUnitname() ?>
                    </option>
                    <?php
                      }
                ?>
              </select>
            </td>
        </tr>        
        <tr>
            <td valign="top">Group User</td>
            <td>
                <table border="1" cellpadding="2" style="border-collapse: collapse;" width="50%">
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
            </td>
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
