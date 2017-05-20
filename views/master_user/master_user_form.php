<h1>master_user</h1>
<br>
<a href='index.php?model=master_user&action=showAll'>Back</a>

<form name="frmmaster_user" id="frmmaster_user" method="post" action="index.php?model=master_user&action=saveForm">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $master_user_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">User</td> 
            <td><input type="text"  name="user" id="user" value="<?php echo $master_user_->getUser();?>" size="30"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Description</td> 
            <td><input type="text"  name="description" id="description" value="<?php echo $master_user_->getDescription();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Password</td> 
            <td><input type="text"  name="password" id="password" value="<?php echo $master_user_->getPassword();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Username</td> 
            <td><input type="text"  name="username" id="username" value="<?php echo $master_user_->getUsername();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Entrytime</td> 
            <td><?php echo $master_user_->getEntrytime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryuser</td> 
            <td><?php echo $master_user_->getEntryuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Entryip</td> 
            <td><?php echo $master_user_->getEntryip();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updatetime</td> 
            <td><?php echo $master_user_->getUpdatetime();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateuser</td> 
            <td><?php echo $master_user_->getUpdateuser();?></td>
        </tr>

        <tr> 
            <td class="textBold">Updateip</td> 
            <td><?php echo $master_user_->getUpdateip();?></td>
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
<br>
