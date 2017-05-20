<script type="text/javascript" src="../../jsgraph/jquery-1.8.min.js"></script>
<script src="../../jsgraph/highcharts.js"></script>
<script src="../../jsgraph/highcharts-3d.js"></script>
<script src="../../jsgraph/modules/exporting.js"></script>
<script type="text/javascript" src="../../jsgraph/js.js"></script>

<script type="text/javascript" >
    function showMenu(position, page) {
        ajax_loadContent(position,page);
    }
    function resultGraphReport(){
        var bulan = document.getElementById('bulan').value;
        var tahun = document.getElementById('tahun').value;

        var page = "./views/graph_query/chart_target_member_sales.php?bulan=" + bulan + "&tahun=" +tahun;
        showMenu("chart_target_member_sales_header", page);
        
    }
</script>

<table align="right" >
    <tr>
        <td>Bulan</td>
        <td>:</td>
        <td>            
            <select name="bulan" id="bulan">
                <option value="01" <?php echo date("m")=="01" ? "Selected" : ""  ?>>Januari</option>
                <option value="02" <?php echo date("m")=="02" ? "Selected" : ""  ?>>Februari</option>
                <option value="03" <?php echo date("m")=="03" ? "Selected" : ""  ?>>Maret</option>
                <option value="04" <?php echo date("m")=="04" ? "Selected" : ""  ?>>April</option>
                <option value="05" <?php echo date("m")=="05" ? "Selected" : ""  ?>>Mei</option>
                <option value="06" <?php echo date("m")=="06" ? "Selected" : ""  ?>>Juni</option>
                <option value="07" <?php echo date("m")=="07" ? "Selected" : ""  ?>>Juli</option>
                <option value="08" <?php echo date("m")=="08" ? "Selected" : ""  ?>>Agustus</option>
                <option value="09" <?php echo date("m")=="09" ? "Selected" : ""  ?>>September</option>
                <option value="10" <?php echo date("m")=="10" ? "Selected" : ""  ?>>Oktober</option>
                <option value="11" <?php echo date("m")=="11" ? "Selected" : ""  ?>>November</option>
                <option value="12" <?php echo date("m")=="12" ? "Selected" : ""  ?>>Desember</option>
            </select>&nbsp;
            <input type="text" name="tahun" id="tahun" value="<?php echo date("Y");?>" size="4">
            <input type="button" name="creategraph" id="creategraph" value="submit" onclick="resultGraphReport()">
        </td>
    </tr>
</table>
 <section class="col-lg-12 connectedSortable">
            <div id="chart_target_member_sales_header"></div>            
 </section>
<script type="text/javascript">
   $("#chart_target_member_sales_header").load('./views/graph_query/chart_target_member_sales.php');      
</script>
