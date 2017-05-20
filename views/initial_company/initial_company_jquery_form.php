<script language="javascript" type="text/javascript">
        (function() {
            $('form').ajaxForm({
                beforeSubmit: function() {
                },
                complete: function(xhr) {
                        alert($.trim(xhr.responseText));
                        showMenu('content', 'index.php?model=initial_company&action=showAllJQuery&skip=<?php echo $skip ?>&search=<?php echo $search ?>');
                }
             });
        })();
        function validate(evt){
            var e = evt || window.event;
            var key = e.keyCode || e.which;
            if((key <48 || key >57) && !(key ==8 || key ==9 || key ==13  || key ==37  || key ==39 || key ==46)  ){
                e.returnValue = false;
                if(e.preventDefault)e.preventDefault();
            }
        }
</script>

<br>


<form name="frminitial_company" id="frminitial_company" method="post" action="index.php?model=initial_company&action=saveFormJQuery">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text" style="text-align: right;" onkeypress="validate(event);"  name="id" id="id" value="<?php echo $initial_company_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Company_name</td> 
            <td><input type="text"  name="company_name" id="company_name" value="<?php echo $initial_company_->getCompany_name();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Username</td> 
            <td><input type="text"  name="username" id="username" value="<?php echo $initial_company_->getUsername();?>" size="40"   ></td>
        </tr>

        <tr> 
            <td class="textBold">Database_name</td> 
            <td><input type="text"  name="database_name" id="database_name" value="<?php echo $initial_company_->getDatabase_name();?>" size="40"   ></td>
        </tr>


        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-danger btn-sm" ></td>
        </tr>
    </table>
</form>

<br>
<br>
