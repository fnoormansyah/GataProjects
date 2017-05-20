<br>
<table >
    <tr> 
        <td> 
            Id 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getId() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            User Fullname 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getUsername() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            User Description 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getDescription() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            Username
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getUser() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            Password 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getPassword() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            NIK 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getNik() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            Department 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getDepartmentid()." - ".$master_department_list->getDescription() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            Unit 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getUnitid()." - ".$master_unit_list->getUnitname() ?>
        </td> 
    </tr>
    <tr>
        <td valign="top">Group User</td>
        <td valign="top">:</td>
        <td valign="top">
            <table>
                <?php
                    $no = 1;
                    if ($master_user_detail_list != "") { 
                        foreach($master_user_detail_list as $master_user_detail){
                            $pi = $no + 1;
                            $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
                            if($master_user_detail->getId() > 0){
                ?>
                <tr><td>&raquo <?php echo $master_user_detail->getGroupcode();?></td></tr>
                <?php
                            }
                            $no++;
                        }
                    }
                ?>
            </table>
        </td>
    </tr>
    <tr> 
        <td> 
            Entrytime 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getEntrytime() ?>
        </td> 
    </tr>
    <tr> 
        <td> 
            Updatetime 
        </td> 
        <td> 
            : 
        </td> 
        <td> 
            <?php echo $master_user_->getUpdatetime() ?>
        </td> 
    </tr>
</table>
<br>
<br>



