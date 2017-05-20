<script type="text/javascript"> 
function deletedata(id, skip, search){ 
    var ask = confirm("Do you want to delete ID " + id + " ?");
    if (ask == true) {
        site = "index.php?model=master_group&action=deleteFormJQuery&skip=" + skip + "&search=" + search + "&id=" + id;
        target = "content";
        showMenu(target, site);
    }
}
function searchData() {
     var searchdata = document.getElementById("search").value;
     site =  'index.php?model=master_group&action=showAllJQuery&search='+searchdata;
     target = "content";
     showMenu(target, site);
}
</script>

<h1>Master Group</h1>
<div id="header_list">
</div>
<table width="95%" >
    <tr>
        <td align="left">
                    <img alt="Move First"  src="./img/icon/icon_move_first.gif" onclick="showMenu('content', 'index.php?model=master_group&action=showAllJQuery&search=<?php echo $search ?>');" >
                    <img alt="Move Previous" src="./img/icon/icon_move_prev.gif" onclick="showMenu('content', 'index.php?model=master_group&action=showAllJQuery&skip=<?php echo $previous ?>&search=<?php echo $search ?>');">
                     Page <?php echo $pageactive ?> / <?php echo $pagecount ?> 
                    <img alt="Move Next" src="./img/icon/icon_move_next.gif" onclick="showMenu('content', 'index.php?model=master_group&action=showAllJQuery&skip=<?php echo $next ?>&search=<?php echo $search ?>');" >
                    <img alt="Move Last" src="./img/icon/icon_move_last.gif" onclick="showMenu('content', 'index.php?model=master_group&action=showAllJQuery&skip=<?php echo $last ?>&search=<?php echo $search ?>');">
                    <a href="index.php?model=master_group&action=export&search=<?php echo $search ?>"><img src="./images/icon_export.png"/></a>&nbsp;
                    <a href="index.php?model=master_group&action=printdata&search=<?php echo $search ?>" target="_"><img src="./images/icon_print.png"/></a>
        </td>
        <td align="right">
       <input type="text" name="search" id="search" value="<?php echo $search ?>" >&nbsp;&nbsp;<input type="button" class="btn btn-info btn-sm" value="find" onclick="searchData()">
<?php if($isadmin || $ispublic || $isentry){ ?>
       <input type="button" class="btn btn-orange btn-sm" value="new" name="new" onclick="showMenu('header_list', 'index.php?model=master_group&action=showFormJQuery')"> 
<?php } ?>

        </td>
    </tr>
</table>
<table width="95%"  class="table-bordered1">
    <tr>
        <th class="textBold">Id</th>
        <th class="textBold">Group Code</th>
        <th class="textBold">Description</th>
        <th class="textBold">Entry Time</th>
 <th class="textBold"><center>Action</center></th>
    </tr>
    <?php
    
    $no = 1;
    
    if ($master_group_list != "") { 
        foreach($master_group_list as $master_group){
            $pi = $no + 1;
            $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
    ?>
            <tr bgcolor="<?php echo $bg;?>">
              <td><?php echo $master_group->getId();?></td>
              <td><a href='#' onclick="showMenu('header_list', 'index.php?model=master_group&action=showDetailJQuery&id=<?php echo $master_group->getGroupcode();?>')"><?php echo $master_group->getGroupcode();?></a> </td>
            <td><?php echo $master_group->getDescription();?></td>
            <td><?php echo $master_group->getEntrytime();?></td>

                <td align="center" class="combobox">
  <?php if($isadmin || $ispublic || $isupdate){ ?>
                    <a href='#' onclick="showMenu('header_list', 'index.php?model=master_group&action=showFormJQuery&id=<?php echo $master_group->getgroupcode();?>&skip=<?php echo $skip ?>&search=<?php echo $search ?>')">[Edit]</a> | 
<?php } ?>
<?php if($isadmin || $ispublic || $isdelete){ ?>
                    <a href='#' onclick="deletedata('<?php echo $master_group->getGroupcode()?>','<?php echo $skip ?>','<?php echo $search ?>')">[Delete]</a>
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