
<header class="header">
    <a href="index.php" class="logo">
    <!-- Add the class icon to your logo image or logo icon to add the margining -->
    <?php
    if($initial_company->getBgfile()!=""){
        ?>
        <img src="./images_small/<?php echo $initial_company->getLogo();?>" style="width:40px;height:40px;">
        <?php
    }else{
        ?>
        <img src="./images/nologo.png" style="width:40px;height:40px;"/>
        <?php
    }
    
    ?>
    
 <?php echo $initial_company->getCompany_name();?>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <div class="navbar-right">
    <ul class="nav navbar-nav">
    <!-- Messages: style can be found in dropdown.less-->
    <li class="dropdown messages-menu">
    <li class="date">   
    <script type='text/javascript'>
    <!--
    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth();
    var thisDay = date.getDay(),
        thisDay = myDays[thisDay];
    var yy = date.getYear();
    var year = (yy < 1000) ? yy + 1900 : yy;
    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
    //-->
    </script>
    </li>
    <!-- Notifications: style can be found in dropdown.less -->                        
    <!-- Tasks: style can be found in dropdown.less -->                       
    <!-- User Account: style can be found in dropdown.less -->
    
    <?php
        if (isset($_SESSION[config::$LOGIN_USER])) {
            $master_user = unserialize($_SESSION[config::$LOGIN_USER]);
            
            require_once 'profile.php';
        }else{
            require_once 'login.php';
        }
    ?>
                    </ul>
                </div>
            </nav>
</header>          


