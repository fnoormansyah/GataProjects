<?php
    require_once('../../database/connection.php');
    ob_start();


    if (!isset($_SESSION)) {
        session_start();
    }

?>

<?php
    $bulan = isset($_REQUEST['bulan']) ? $_REQUEST['bulan'] : date("m");
    $tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date("Y");
    $valHET = 0;
    $valTarget = "";
    $nilai = 0;
    $nilaiMember = "" ;
    $storeName = "";
    $data = "";
    $day = date("t");
    $start_date = $tahun . "-" . ($bulan) . "-01 00:00:01";
    $end_date = $tahun . "-" . ($bulan) . "-" . $day . " 23:59:59";
    
    $bload = true;
    
    $outlet = "";
    $valueMember = "";
    $value = "";
    $Target = "";
    if ($bulan == date("m") && $tahun == date("Y") && isset($_SESSION['graph_targettransaksimember_outlet'])){
        $outlet = unserialize($_SESSION['graph_targettransaksimember_outlet']);
        $valueMember = unserialize($_SESSION['graph_targettransaksimember_valueMember']);
        $value = unserialize($_SESSION['graph_targettransaksimember_value']);
        $Target = unserialize($_SESSION['graph_targettransaksimember_Target']);
        $bload = false;
    }
    
    if($bload){
        $sql = "select * from master_store where active=1 ";
        foreach ($dbh->query($sql) as $row) {
            $outletName = str_replace("MTS OUTLET ", "", $row['storealias']);
            $get_id = $row['storeidalias'];

            $total_het=0;
            $total_het_member = 0;


            $querygethet = "SELECT 
                                    SUM(product_transaction.prod_quantity*product_transaction.prod_unit_price) AS price_het, 
                                    SUM(product_transaction.prod_quantity*product_info.prod_base_price) AS price_hjp 
                            FROM 
                            ((transaction_log 
                            INNER JOIN product_transaction ON transaction_log.trans_number=product_transaction.trans_number) 
                            INNER JOIN product_info ON product_transaction.prod_number = product_info.prod_number) 
                            INNER JOIN master_store ON transaction_log.`store_id` = master_store.storeidalias
                            WHERE (transaction_log.trans_date BETWEEN '$start_date' AND '$end_date') 
                            AND (transaction_log.trans_type_id=1 OR transaction_log.trans_type_id=6)
                            and  transaction_log.`store_id` = '$get_id'
                            ";

            $get_het = $dbh->query($querygethet)->fetch();

            //echo "HET GET ".$querygethet . "<br>";
            $querytransnumber = "SELECT SUM(product_transaction.prod_quantity*product_transaction.prod_unit_price) AS price_het_member, 
            SUM(product_transaction.prod_quantity*product_info.prod_base_price) AS price_hjp_member
            FROM ((transaction_log INNER JOIN product_transaction ON transaction_log.trans_number=product_transaction.trans_number) 
            INNER JOIN product_info ON product_transaction.prod_number = product_info.prod_number) 
            WHERE (transaction_log.trans_date BETWEEN '$start_date' and '$end_date')  
            AND transaction_log.cust_number<>'0000000000' AND (transaction_log.trans_type_id=1 OR transaction_log.trans_type_id=6)
            AND transaction_log.`store_id` = '$get_id'";

            //echo "<br>Transaksi "  . $querytransnumber;
            $getTransMember = $dbh->query($querytransnumber)->fetch();

            $queryachieve = "SELECT SUM(price_het) het, SUM(target) target 
            FROM
            (
            SELECT SUM(product_transaction.prod_quantity*product_transaction.prod_unit_price) AS price_het, 0 target
            FROM transaction_log 
                INNER JOIN product_transaction ON transaction_log.trans_number=product_transaction.trans_number
                AND (transaction_log.trans_date BETWEEN '$start_date' and '$end_date')  
                AND (transaction_log.trans_type_id=1 OR transaction_log.trans_type_id=6)
                AND transaction_log.store_id='$get_id'
            UNION ALL
            SELECT 0 price_het,SUM(a.target) target
            FROM daily_target a
            WHERE a.target_date BETWEEN '$start_date' and '$end_date'
            AND a.store_id='$get_id'
            ) AS a";

            //echo "ACHIEVE " . $queryachieve ;

            $getAchieve = $dbh->query($queryachieve)->fetch();

            $nilHET = $getAchieve['het']/1000000;
            $nilTarget = $getAchieve['target']/1000000;

            $nilHET = $nilHET.",";
            $valHET = $valHET.$nilHET;
            $nilTarget = $nilTarget.",";
            $valTarget = $valTarget.$nilTarget;

            $total_het = $total_het + $get_het['price_het'];   
            $total_het_member = $total_het_member + $getTransMember['price_het_member'];

            $nilaiSales = number_format($total_het/1000000,3);
            $nilaiSalesMember = number_format($total_het_member/1000000,3);
            $total_het = $nilaiSales.",";
            $total_het_member = $nilaiSalesMember.",";
            $nilai = $nilai.$total_het;
            $nilaiMember = $nilaiMember.$total_het_member;

            $outletName = "'".$outletName."',";
            $storeName = $storeName.$outletName;

        }
        $outlet = substr($storeName, 0, strlen($storeName)-1);
        $value = substr($nilai, 0,  strlen($nilai)-1);   
        $valueMember = substr($nilaiMember, 0,  strlen($nilaiMember)-1); 

        $HET = substr($valHET, 0, strlen($valHET)-1);
        $Target = substr($valTarget, 0, strlen($valTarget)-1);
        
        if ($bulan == date("m") && $tahun == date("Y")) {
            $_SESSION['graph_targettransaksimember_outlet'] = serialize($outlet);
            $_SESSION['graph_targettransaksimember_valueMember'] =  serialize($valueMember);
            $_SESSION['graph_targettransaksimember_value'] = serialize($value);
            $_SESSION['graph_targettransaksimember_Target'] = serialize($Target);        
        }
    }
    //$dataValue = substr($data,0,strlen($data)-1);    
?>

<script type="text/javascript">
    $(function () {
        var dt = new Date();
        var month = <?php echo $bulan;?>//document.getElementById('bulan').value;
        var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'][month-1];
        //var tahun = dt.getFullYear();
        var tahun = <?php echo $tahun;?>//document.getElementById('tahun').value;

        $('#container').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 75, 150, 80],
                options3d: {
                    enabled: true,
                    alpha: 0,
                    beta: 0,
                    depth: 70
                }
            },
            title: {
                text: 'Grafik Pendapatan Penjualan Martha Tilaar Shop'
            },
            subtitle: {
                text: 'Periode '+bulan+' '+tahun+' (Dalam Juta Rupiah)'
            },
            plotOptions: {
                column: {
                    depth: 25,
                    grouping: false,
                    shadow: false,
                    borderWidth: 0
                }
            },
            xAxis: {
                categories: [<?php echo $outlet;?>],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },                    
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value} ',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Nilai Transaksi',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }],
            tooltip: {
                shared: true
            },
            legend: {        
                align: 'left',
                verticalAlign: 'top',
                y: 20,
                x: 820,
                floating: true,
                borderWidth: 0
            }, 
            series: [{
                name: ' Transaksi Member',
                type: 'column',                
                color: 'rgba(215, 40, 40, 0.9)',
                data: [<?php echo $valueMember;?>],
                pointPadding: 0.2,
                pointPlacement: 0, 
                dataLabels: {
                    enabled: true,
                    rotation: -45,
                    color: '#FF0000',
                    align: 'center',
                    x: 5,
                    y: -15,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px white'
                    }
                }
            }, {
                name: ' Semua Transaksi',
                type: 'column',
                color: 'rgba(165,170,217,1)',
                data: [<?php echo $value;?>],
                pointPadding: 0.1,
                pointPlacement: 0,
                dataLabels: {
                    enabled: true,
                    rotation: -45,
                    color: '#0f0',
                    align: 'center',
                    x: 5,
                    y: -20,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }

            }, {
                name: 'Target Sales',
                type: 'column',
                color: 'rgba(126,86,134,.9)',
                data: [<?php echo $Target;?>],
                pointPadding: 0,
                pointPlacement: 0,
                dataLabels: {
                    enabled: true,
                    rotation: -45,
                    color: '#000000',
                    align: 'center',
                    x: 5,
                    y: -20,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px grey'
                    }
                }
            }]
        });
    });
</script>
<div id="container" style="height: 500px;"></div>