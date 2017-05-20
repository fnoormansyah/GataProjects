
<h1>master_user_detail</h1>
<div id="header_list">
</div>
<table width="95%" >
    <tr>
        <td align="left">
                    <a href="index.php?model=master_user_detail&action=showAll&search=<?php echo $search ?>"><img alt="Move First"  src="./img/icon/icon_move_first.gif" ></a>
                    <a href="index.php?model=master_user_detail&action=showAll&skip=<?php echo $previous ?>&search=<?php echo $search ?>"><img alt="Move Previous" src="./img/icon/icon_move_prev.gif" ></a>
                     Page <?php echo $pageactive ?> / <?php echo $pagecount ?> 
                    <a href="index.php?model=master_user_detail&action=showAll&skip=<?php echo $next ?>&search=<?php echo $search ?>"><img alt="Move Next" src="./img/icon/icon_move_next.gif" ></a>
                    <a href="index.php?model=master_user_detail&action=showAll&skip=<?php echo $last ?>&search=<?php echo $search ?>"><img alt="Move Last" src="./img/icon/icon_move_last.gif" ></a>
                    <a href="index.php?model=master_user_detail&action=export&search=<?php echo $search ?>"><img src="./images/icon_export.png"/></a>&nbsp;
                    <a href="index.php?model=master_user_detail&action=printdata&search=<?php echo $search ?>" target="_"><img src="./images/icon_print.png"/></a>
        </td>
        <td align="right">
<form name="frmmaster_user_detail" method="post" action="?model=master_user_detail&action=showAll">
    <input type="text" name="search" id="search" value="<?php echo $search ?>"><input type="submit" value="find">
<?php if($isadmin || $ispublic ||$isentry){ ?>
    <a href="index.php?model=master_user_detail&action=showForm"> New</a><?php } ?>
</form>

        </td>
    </tr>
</table>
<table border="1"  cellpadding="2" style="border-collapse: collapse;" width="95%">
    <tr>
        <th class="textBold">id</th>
        <th class="textBold">user</th>
        <th class="textBold">groupcode</th>
        <th class="textBold">entrytime</th>
<td>&nbsp;</td>
    </tr>
    <?php
    
    $no = 1;
    
    if ($master_user_detail_list != "") { 
        foreach($master_user_detail_list as $master_user_detail){
            $pi = $no + 1;
            $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
    ?>
            <tr bgcolor="<?php echo $bg;?>">
              <td><a href='<?php echo "index.php?model=master_user_detail&action=showDetail&id=".$master_user_detail->getId() ?>'><?php echo $master_user_detail->getId();?></a></td>
            <td><?php echo $master_user_detail->getUser();?></td>
            <td><?php echo $master_user_detail->getGroupcode();?></td>
            <td><?php echo $master_user_detail->getEntrytime();?></td>

                <td align="center" class="combobox">
  <?php if($isadmin || $ispublic || $isupdate){ ?>
                    <a href='index.php?model=master_user_detail&action=showForm&id=<?php echo $master_user_detail->getid();?>'>[Edit]</a> | 
<?php } ?>
<?php if($isadmin || $ispublic ||$isdelete){ ?>
                    <a href='index.php?model=master_user_detail&action=deleteForm&id=<?php echo $master_user_detail->getid();?>'>[Delete]</a>
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