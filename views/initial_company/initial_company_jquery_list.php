<script type="text/javascript"> 
function deletedata(id, skip, search){ 
    var ask = confirm("Do you want to delete ID " + id + " ?");
    if (ask == true) {
        site = "index.php?model=initial_company&action=deleteFormJQuery&skip=" + skip + "&search=" + search + "&id=" + id;
        target = "content";
        showMenu(target, site);
    }
}
function searchData() {
     var searchdata = document.getElementById("search").value;
     site =  'index.php?model=initial_company&action=showAllJQuery&search='+searchdata;
     target = "content";
     showMenu(target, site);
}
$(document).ready(function(){
    $('#search').keypress(function(e) {
            if(e.which == 13) {
                searchData();
            }
    });
});
</script>

<h1>initial_company</h1>
<div id="header_list">
</div>
<table width="95%" >
    <tr>
        <td align="left">
                    <img alt="Move First"  src="./img/icon/icon_move_first.gif" onclick="showMenu('content', 'index.php?model=initial_company&action=showAllJQuery&search=<?php echo $search ?>');" >
                    <img alt="Move Previous" src="./img/icon/icon_move_prev.gif" onclick="showMenu('content', 'index.php?model=initial_company&action=showAllJQuery&skip=<?php echo $previous ?>&search=<?php echo $search ?>');">
                     Page <?php echo $pageactive ?> / <?php echo $pagecount ?> 
                    <img alt="Move Next" src="./img/icon/icon_move_next.gif" onclick="showMenu('content', 'index.php?model=initial_company&action=showAllJQuery&skip=<?php echo $next ?>&search=<?php echo $search ?>');" >
                    <img alt="Move Last" src="./img/icon/icon_move_last.gif" onclick="showMenu('content', 'index.php?model=initial_company&action=showAllJQuery&skip=<?php echo $last ?>&search=<?php echo $search ?>');">
                    <a href="index.php?model=initial_company&action=export&search=<?php echo $search ?>">Export</a>
                    <a href="index.php?model=initial_company&action=printdata&search=<?php echo $search ?>" target="_"><img src="./images/icon_print.png"/></a>
        </td>
        <td align="right">
       <input type="text" name="search" id="search" value="<?php echo $search ?>" >&nbsp;&nbsp;<input type="button" class="btn btn-info btn-sm" value="find" onclick="searchData()">
<?php if($isadmin || $ispublic || $isentry){ ?>
       <input type="button" class="btn btn-warning btn-sm" value="new" name="new" onclick="showMenu('header_list', 'index.php?model=initial_company&action=showFormJQuery')"> 
<?php } ?>

        </td>
    </tr>
</table>
<table border="1"  cellpadding="2" style="border-collapse: collapse;" width="95%">
    <tr>
        <th class="textBold">id</th>
        <th class="textBold">company_name</th>
        <th class="textBold">username</th>
        <th class="textBold">database_name</th>
<td>&nbsp;</td>
    </tr>
    <?php
    
    $no = 1;
    
    if ($initial_company_list != "") { 
        foreach($initial_company_list as $initial_company){
            $pi = $no + 1;
            $bg = ($pi%2 != 0) ? "#E1EDF4" : "#F0F0F0";
    ?>
            <tr bgcolor="<?php echo $bg;?>">
                <td><a href='#' onclick="showMenu('header_list', 'index.php?model=initial_company&action=showDetailJQuery&id=<?php echo $initial_company->getId();?>')"><?php echo $initial_company->getId();?></a> </td>
            <td><?php echo $initial_company->getCompany_name();?></td>
            <td><?php echo $initial_company->getUsername();?></td>
            <td><?php echo $initial_company->getDatabase_name();?></td>

                <td align="center" class="combobox">
  <?php if($isadmin || $ispublic || $isupdate){ ?>
                    <a href='#' onclick="showMenu('header_list', 'index.php?model=initial_company&action=showFormJQuery&id=<?php echo $initial_company->getid();?>&skip=<?php echo $skip ?>&search=<?php echo $search ?>')">[Edit]</a> | 
<?php } ?>
<?php if($isadmin || $ispublic || $isdelete){ ?>
                    <a href='#' onclick="deletedata('<?php echo $initial_company->getId()?>','<?php echo $skip ?>','<?php echo $search ?>')">[Delete]</a>
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