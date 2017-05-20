
<li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-user"></i>
            <span><?php echo $master_user->getUsername();?><i class="caret"></i></span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header bg-light-blue">                
                    <div id="avatarprofile"></div>
                    <?php echo $master_user->getUsername();?>               
                    <br>
                    <?php echo $master_user->getDescription();?>
                    <br>
                    <small>Member since Nov. <?php echo $master_user->getEntrytime();?></small>
                </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
                <div class="col-xs-4 text-center">
                    <a href="#" onclick="showMenu('content', 'index.php?model=master_user&action=changePasswordForm')">Password</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">&nbsp;</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">&nbsp;</a>
                </div>
            </li>

            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">                    
                    <a href="#" onClick="showMenu('content','index.php?model=master_profil&action=showProfileUser&id=<?php echo $master_user->getUser();?>')" class="btn btn-default btn-flat">Profile</a>                                          
                </div>
                <div class="pull-right">
                    <a href="index.php?model=login&action=logOut" class="btn btn-default btn-flat">Sign out</a>
                </div>
            </li>
        </ul>
</li>
<script type="text/javascript">
   $("#avatarprofile").load('index.php?model=master_profil&action=showAvatar');      
</script>

