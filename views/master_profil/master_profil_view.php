
    <table >       
        <tr> 
            <td align="center" colspan="3">                                
                <img src='images_small/<?php echo  $master_profil->getAvatar()  ?>' onClick="openFormImage('index.php?model=master_profil&action=showImageMedium')" > 
               
                <?php 
                if($bowner) {                        
                ?>
                    <br>
                    <a href ="#" onclick="showMenu('uploadphoto','index.php?model=master_profil&action=formUpload')">change Picture</a>
                <?php
                }       
                ?> 
                <div id="uploadphoto"></div>
                
            </td> 
        </tr>

        <tr> 
            <td>             
            </td> 
            <td class="textBold">User</td> 
            <td>: <?php echo $master_user->getUser();?></td>            
        </tr>

        <tr> 
            <td class="textBold">&nbsp;</td> 
            <td class="textBold">Description</td> 
            <td>: <?php echo $master_user->getDescription();?></td>
        </tr>
        
        <tr> 
            <td class="textBold">&nbsp;</td> 
            <td class="textBold">Full Name</td> 
            <td>: <?php echo $master_user->getUsername();?></td>
        </tr>

        <tr> 
            <td class="textBold">&nbsp;</td> 
            <td class="textBold">Nik</td> 
            <td>: <?php echo $master_profil->getNik();?></td>
        </tr>

        <tr> 
            <td class="textBold">&nbsp;</td> 
            <td class="textBold">Department</td> 
            <td>
                : <?php echo "(".$master_profil->getDepartmentid() .") ".$master_department_controller->showData($master_profil->getDepartmentid())->getDescription() ?>
            </td>
            
        </tr>

        <tr> 
            <td class="textBold">&nbsp;</td> 
            <td class="textBold">Unit</td> 
            <td>
                : <?php echo "(".$master_profil->getUnitid() .") ".$master_unit_controller->showData($master_profil->getUnitid())->getUnitname() ?>
            </td>
        </tr>        
    </table>
    
<br>
<br>
