<?php
if(file_exists('database/connection.php')){
    header("location:index.php");
}

?>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- fullCalendar -->
<link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<!-- Theme style -->
<link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />


<link href="css/tables.css" rel="stylesheet">  

<link href="./calendar/CalendarControl.css" rel="stylesheet" type="text/css">
<!--      <link href="js/main.css" rel="stylesheet" type="text/css" />
<script src="js/main.js"></script>
<script src="js/js_popup.js"></script> -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<!-- jQuery 2.0.2 -->
<script type="text/javascript" src="js/popup.js"></script>
<script src="js/202/jquery.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="js/raphael-min.js"></script>
<script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- fullCalendar -->
<script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<!-- <script src="js/AdminLTE/app.js" type="text/javascript"></script>-->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>   
<script src="js/chart.js" type="text/javascript"></script>     
<script language="javascript" type="text/javascript" src="js/jschart.js"></script>
<script type="text/javascript" src="js/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/jquery.min.slider.js"></script>
<script src="js/owl.carousel.js"></script>
<script src="./jsgraph/highcharts.js"></script>
<script src="./jsgraph/modules/exporting.js"></script>
<script src="./calendar/CalendarControl.js" language="javascript"></script>        
<script src="./nicEdit/nicEdit.js" type="text/javascript" ></script>
<script src="./js/jquery.form.js" type="text/javascript" ></script>
<script src="./js/jquery.autocomplete.js" type="text/javascript" ></script>

<!--<script type="text/javascript" src="jHtmlArea/scripts/jquery-1.3.2.js"></script>-->
<script type="text/javascript" src="jHtmlArea/scripts/jquery-ui-1.7.2.custom.min.js"></script>
<link rel="Stylesheet" type="text/css" href="jHtmlArea/style/jqueryui/ui-lightness/jquery-ui-1.7.2.custom.css" />
<script type="text/javascript" src="jHtmlArea/scripts/jHtmlArea-0.8.js"></script>
<link rel="Stylesheet" type="text/css" href="jHtmlArea/style/jHtmlArea.css" />


<script>
    function complete(){
        window.open('index.php','_self');
    }
    (function() {
        $('form').ajaxForm({
            beforeSubmit: function() {
                if($('#company_name').val()==""){
                    alert('Company is empty');return false;
                }
                if($('#username').val()==""){
                    alert('User admin is empty');return false;
                }
                if($('#password').val()==""){
                    alert('Password is empty');return false;
                }
                if($('#database_name').val()==""){
                    alert('Database name is empty');return false;
                }
                document.getElementById("btnsubmit").disabled = true;
                document.getElementById("btnsubmit").value = "Process .... ";
                
                        },
            complete: function(xhr) {  
                $('#success').html('<center><div class="app_title" style="margin-top:150px;">INSTALLATION IS COMPLETED </div><br><input type="button" value="OK" class="btn btn-primary" onclick="complete()"></center>');
                    
                
            }
        });
    })();

</script>
<div id="wrapper">
<div class="container">
<center>
<form method="post" action="create_db.php" name="formcreate" id="formcreate">
    <div id="success">
    <p><img src="images/icon-instal.png" width="64" height="64" /></p>
    <div class="app_title">REGISTRATION YOUR APPLICATION</div>
    <br>
    <br>
    
        
    <table>
        <tr>
            <td>Company Name</td>
            <td>:</td>
            <td><input type="text" name="company_name" id="company_name" size="20"></td>
            
        </tr>
        <tr>
            <td>User Admin</td>
            <td>:</td>
            <td><input type="text" name="username" id="username" size="20"></td>
            
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td><input type="password" name="password" id="password" size="20"></td>
            
        </tr>
        <tr>
            <td>Database Name</td>
            <td>:</td>
            <td><input type="text" name="database_name" id="database_name" size="20"></td>
            
        </tr>
        <tr>
            <td>User Database </td>
            <td>:</td>
            <td><input type="text" name="database_user" id="database_user" size="20" value="root"></td>
            
        </tr>
        <tr>
            <td>Password Database </td>
            <td>:</td>
            <td><input type="password" name="database_password" id="database_pasword" size="20"></td>
            
        </tr>


        <tr>
            <td>Logo</td>
            <td>:</td>
            <td><input type="file" name="logo"></td>
            
        </tr>
        <tr>
            <td>Background Front Office</td>
            <td>:</td>
            <td><input type="file" name="bgfile"></td>
            
        </tr>
        
        <tr>
            <td></td>
            <td></td>
            <td><input type="submit" value="save" class="btn btn-primary" id="btnsubmit"></td>
            
        </tr>
        
    </table>
    </div>
</form>
</center>
</div>

<div id="footer">
<div class="footer">Copyright @ 2017 Gata Framework. All rights Reserved</div>
</div></div>

