<h1>master_user_detail</h1>
<br>
<a href='index.php?model=master_user_detail&action=showAll'>Back</a>

<form name="frmmaster_user_detail" id="frmmaster_user_detail" method="post" action="index.php?model=master_user_detail&action=saveForm">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $master_user_detail_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">User</td> 
            <td><input type="text"  name="user" id="user" value="<?php echo $master_user_detail_->getUser();?>" size="30"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Groupcode</td> 
            <td><input type="text"  name="groupcode" id="groupcode" value="<?php echo $master_user_detail_->getGroupcode();?>" size="20"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entrytime</td> 
            <td><?php echo $master_user_detail_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryuser</td> 
            <td><?php echo $master_user_detail_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryip</td> 
            <td><?php echo $master_user_detail_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updatetime</td> 
            <td><?php echo $master_user_detail_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateuser</td> 
            <td><?php echo $master_user_detail_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateip</td> 
            <td><?php echo $master_user_detail_->getUpdateip();?></td>
        </tr>


        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-red btn-sm" ></td>
        </tr>
    </table>
</form>
<br>
<br>
