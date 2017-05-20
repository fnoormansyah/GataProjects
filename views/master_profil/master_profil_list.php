
<h1>master_profil</h1>
<div id="header_list">
</div>
<table width="95%" >
    <tr>
        <td align="left">
                    <a href="index.php?model=master_profil&action=showAll&search=<?php echo $search ?>"><img alt="Move First"  src="./img/icon/icon_move_first.gif" ></a>
                    <a href="index.php?model=master_profil&action=showAll&skip=<?php echo $previous ?>&search=<?php echo $search ?>"><img alt="Move Previous" src="./img/icon/icon_move_prev.gif" ></a>
                     Page <?php echo $pageactive ?> / <?php echo $pagecount ?> 
                    <a href="index.php?model=master_profil&action=showAll&skip=<?php echo $next ?>&search=<?php echo $search ?>"><img alt="Move Next" src="./img/icon/icon_move_next.gif" ></a>
                    <a href="index.php?model=master_profil&action=showAll&skip=<?php echo $last ?>&search=<?php echo $search ?>"><img alt="Move Last" src="./img/icon/icon_move_last.gif" ></a>
                    <a href="index.php?model=master_profil&action=export&search=<?php echo $search ?>">Export</a>
                    <a href="index.php?model=master_profil&action=printdata&search=<?php echo $search ?>" target="_"><img src="./images/icon_print.png"/></a>
        </td>
        <td align="right">
<form name="frmmaster_profil" method="post" action="?model=master_profil&action=showAll">
    <input type="text" name="search" id="search" value="<?php echo $search ?>"><input type="submit" value="find">
<?php if($isadmin || $ispublic ||$isentry){ ?>
    <a href="index.php?model=master_profil&action=showForm"> New</a><?php } ?>
</form>

        </td>
    </tr>
</table>
<table border="1"  cellpadding="2" style="border-collapse: collapse;" width="95%">
    <tr>
        <th class="textBold">id</th>
        <th class="textBold">nik</th>
        <th class="textBold">avatar</th>
        <th class="textBold">departmentid</th>
<td>&nbsp;</td>
    </tr>
    <?php
    
    $no = 1;
    
    if ($master_profil_list != "") { 
        foreach($master_profil_list as $master_profil){
            $pi = $no + 1;
            $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
    ?>
            <tr bgcolor="<?php echo $bg;?>">
              <td><a href='<?php echo "index.php?model=master_profil&action=showDetail&id=".$master_profil->getId() ?>'><?php echo $master_profil->getId();?></a></td>
            <td><?php echo $master_profil->getNik();?></td>
            <td><?php echo $master_profil->getAvatar();?></td>
            <td><?php echo $master_profil->getDepartmentid();?></td>

                <td align="center" class="combobox">
  <?php if($isadmin || $ispublic || $isupdate){ ?>
                    <a href='index.php?model=master_profil&action=showForm&id=<?php echo $master_profil->getid();?>'>[Edit]</a> | 
<?php } ?>
<?php if($isadmin || $ispublic ||$isdelete){ ?>
                    <a href='index.php?model=master_profil&action=deleteForm&id=<?php echo $master_profil->getid();?>'>[Delete]</a>
<?php } ?>

                </td>
            </tr>
    <?php
            $no++;
        }
    }
    ?>
</table>
<br>