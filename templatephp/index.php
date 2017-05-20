<?php
include '../database/connection.php';

?>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="../css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="../css/chart.css" rel="stylesheet" type="text/css" />
        <link href="../css/chart2.css" rel="stylesheet" type="text/css" />
        <link href="../css/style_slider.css" rel="stylesheet" type="text/css" media="all" />
        <link href="../css/owl.carousel.css" rel="stylesheet">
        <link href="../css/tables.css" rel="stylesheet">  
        <link href="../css/form_style.css" rel="stylesheet" type="text/css" />
         <link href="../css/css_popup.css" rel="stylesheet" type="text/css" />
        <link href="./calendar/CalendarControl.css" rel="stylesheet" type="text/css">
        <!--      <link href="../js/main.css" rel="stylesheet" type="text/css" />
        <script src="../js/main.js"></script>
        <script src="../js/js_popup.js"></script> -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
 <!-- jQuery 2.0.2 -->
        <script type="text/javascript" src="../js/popup.js"></script>
        <script src="../js/202/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="../js/raphael-min.js"></script>
        <script src="../js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="../js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="../js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="../js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
       <!-- <script src="../js/AdminLTE/app.js" type="text/javascript"></script>-->
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../js/AdminLTE/dashboard.js" type="text/javascript"></script>   
        <script src="../js/chart.js" type="text/javascript"></script>     
        <script language="javascript" type="text/javascript" src="../js/jschart.js"></script>
        <script type="text/javascript" src="../js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="../js/js.js"></script>
        <script type="text/javascript" src="../js/jquery.min.slider.js"></script>
        <script src="../js/owl.carousel.js"></script>
        <script src="../jsgraph/highcharts.js"></script>
        <script src="../jsgraph/modules/exporting.js"></script>
        <script src="./calendar/CalendarControl.js" language="javascript"></script>        
        <script src="./nicEdit/nicEdit.js" type="text/javascript" ></script>
        <script src="../js/jquery.form.js" type="text/javascript" ></script>
        <script src="../js/jquery.autocomplete.js" type="text/javascript" ></script>
        
        <!--<script type="text/javascript" src="jHtmlArea/scripts/jquery-1.3.2.js"></script>-->
        <script type="text/javascript" src="jHtmlArea/scripts/jquery-ui-1.7.2.custom.min.js"></script>
        <link rel="Stylesheet" type="text/css" href="jHtmlArea/style/jqueryui/ui-lightness/jquery-ui-1.7.2.custom.css" />
        <script type="text/javascript" src="jHtmlArea/scripts/jHtmlArea-0.8.js"></script>
        <link rel="Stylesheet" type="text/css" href="jHtmlArea/style/jHtmlArea.css" />
        
<script language="javascript" type="text/javascript">
        (function() {
            $('form').ajaxForm({
                beforeSubmit: function() {
                    document.getElementById("btnsubmit").disabled = true;                
                    document.getElementById("btnsubmit").value = "Process .... "; 
                
                
                },
                complete: function(xhr) {
                        document.getElementById("btnsubmit").disabled = false;                
                        document.getElementById("btnsubmit").value = "Generate"; 
                        $('#msgsukses').val($.trim(xhr.responseText));

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
<form method="post" action="generate.php">
<table width="50%">
    <tr>
        <td colspan="3"><h3>GENERATE MODEL VIEW CONTROLLER</h3></td>
        
    </tr>
    <tr>
        <td style="vertical-align: top;">Nama Database</td>
        <td>:</td>
        <td><?php echo $db;?></td>
        
    </tr>
    <tr>
        <td style="vertical-align: top;">Nama Tabel</td>
        <td>:</td>
        <td>
            <select name="tabel">
        <?php 
            $sql="show tables";
            $hsl=$dbh->query($sql);
            foreach ($hsl as $row){
                echo "<option>".$row['Tables_in_'.$db]."</option>";
            }
        ?>  
            </select>    
        </td>
        
    </tr>
    <tr>
        <td style="vertical-align: top;">Pilihan</td>
        <td>:</td>
        <td>
            <input type="checkbox" checked value="1" name="pil[]" id="pil1"> Model <br>
            <input type="checkbox" checked value="2" name="pil[]" id="pil2"> Controller Generate  <br>
            <input type="checkbox" checked value="3" name="pil[]" id="pil3"> Controller  <input type="checkbox"  value="1" name="rep3" id="rep3"> Replace File<br>
            <input type="checkbox" checked value="4" name="pil[]" id="pil4"> Dir. Views <br>
            <input type="checkbox" checked value="5" name="pil[]" id="pil5"> View List <input type="checkbox"  value="1" name="rep5" id="rep5"> Replace File<br>
            <input type="checkbox" checked value="6" name="pil[]" id="pil6"> View Detail <input type="checkbox"  value="1" name="rep6" id="rep6"> Replace File<br>
            <input type="checkbox" checked value="7" name="pil[]" id="pil7"> View Form <input type="checkbox"  value="1" name="rep7" id="rep7"> Replace File<br>
            
        
        </td>
        
        
    </tr>
    <tr>
        <td colspan="3"><input class="btn btn-info btn-sm" type="submit" id="btnsubmit" value="Generate"></td>
        
    </tr>
    <tr>
        
        <td colspan="10" style="vertical-align: top;"> 
            <b>Message :</b><br>
            <textarea  id="msgsukses" cols="100" rows="20" readonly></textarea>
        </td>
        
    </tr>
</table>
</form>