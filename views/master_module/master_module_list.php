
<h1>master_module</h1>
<div id="header_list">
</div>
<table width="95%" >
    <tr>
        <td align="left">
                    <a href="index.php?model=master_module&action=showAll&search=<?php echo $search ?>"><img alt="Move First"  src="./img/icon/icon_move_first.gif" ></a>
                    <a href="index.php?model=master_module&action=showAll&skip=<?php echo $previous ?>&search=<?php echo $search ?>"><img alt="Move Previous" src="./img/icon/icon_move_prev.gif" ></a>
                     Page <?php echo $pageactive ?> / <?php echo $pagecount ?> 
                    <a href="index.php?model=master_module&action=showAll&skip=<?php echo $next ?>&search=<?php echo $search ?>"><img alt="Move Next" src="./img/icon/icon_move_next.gif" ></a>
                    <a href="index.php?model=master_module&action=showAll&skip=<?php echo $last ?>&search=<?php echo $search ?>"><img alt="Move Last" src="./img/icon/icon_move_last.gif" ></a>
                    <a href="index.php?model=master_module&action=export&search=<?php echo $search ?>"><img src="./images/icon_export.png"/></a>&nbsp;
                    <a href="index.php?model=master_module&action=printdata&search=<?php echo $search ?>" target="_"><img src="./images/icon_print.png"/></a>
        </td>
        <td align="right">
<form name="frmmaster_module" method="post" action="?model=master_module&action=showAll">
    <input type="text" name="search" id="search" value="<?php echo $search ?>"><input type="submit" value="find">
<?php if($isadmin || $ispublic ||$isentry){ ?>
    <a href="index.php?model=master_module&action=showForm"> New</a><?php } ?>
</form>

        </td>
    </tr>
</table>
<table width="95%"  class="table-bordered1">
    <tr>
        <th class="textBold">Id</th>
        <th class="textBold">Module</th>
        <th class="textBold">Description Head</th>
        <th class="textBold">Description</th>
<th class="textBold"><center>Action</center></th>
    </tr>
    <?php
    
    $no = 1;
    
    if ($master_module_list != "") { 
        foreach($master_module_list as $master_module){
            $pi = $no + 1;
            $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
    ?>
            <tr bgcolor="<?php echo $bg;?>">
              <td><a href='<?php echo "index.php?model=master_module&action=showDetail&id=".$master_module->getId() ?>'><?php echo $master_module->getId();?></a></td>
            <td><?php echo $master_module->getModule();?></td>
            <td><?php echo $master_module->getDescriptionhead();?></td>
            <td><?php echo $master_module->getDescription();?></td>

                <td align="center" class="combobox">
  <?php if($isadmin || $ispublic || $isupdate){ ?>
                    <a href='index.php?model=master_module&action=showForm&id=<?php echo $master_module->getid();?>'>[Edit]</a> | 
<?php } ?>
<?php if($isadmin || $ispublic ||$isdelete){ ?>
                    <a href='index.php?model=master_module&action=deleteForm&id=<?php echo $master_module->getid();?>'>[Delete]</a>
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