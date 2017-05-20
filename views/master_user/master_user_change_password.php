<script language="javascript" type="text/javascript">
    jQuery(function(){
        $("#changepassword").submit(function(){
            var post_data = $(this).serialize();
            var form_action = $(this).attr("action");
            var form_method = $(this).attr("method");
            $.ajax({
                 type : form_method,
                 url : form_action, 
                 cache: false, 
                 data : post_data,
                 success : function(x){
                    if(x.trim() == "Data is updated") {
                        showMenu('contentmenu', 'index.php?model=master_module&action=showMenu&id=1');
                    }else{
                        alert(x);
                    }
                 }, 
                 error : function(){
                    alert("Error");
                 }
            });
            return false;
         });
    });
</script>


<form name="changepassword" id="changepassword" method="post" action="index.php?model=master_user&action=changePassword">
    Change Password
    <br>
    Please Insert Old Password
    <br>
    <input type="password" name="oldpassword" id="oldpassword" value="*****"> *
    <br>
    Please Input New Password
    <br>
    <input type="password" name="newpassword" id="newpassword"  value=""> *
    <br>
    Retype New Password
    <br>
    <input type="password" name="retypepassword" id="retypepassword" value=""> *
    <br>
    <input type="submit" name="changepass" id="changepass" value="change">
</form>
<br>
<br>



