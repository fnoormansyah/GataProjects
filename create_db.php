<?php
$host="localhost";
$user=$_REQUEST["database_user"];
$pass=$_REQUEST["database_password"];
$db_=$_REQUEST["database_name"];
$formatnow = date('YmdHis');
$conn=new PDO("mysql:host=$host", $user, $pass);
$create_db=new create_db();
$create_db->create_file_koneksi($host,$user,$pass,$db_);
$create_db->create_database($db_,$conn,$formatnow);
$create_db->create_file_config($db_);


include './controllers/tools.controller.php';
$toolsctrl=new toolsController();

if(isset($_FILES['logo']['tmp_name'])){
    
    $typeid="logo";                                  
    $target_dir = "uploads/";
    $filesource = basename($_FILES[$typeid]["name"]);
    $target_file = $target_dir . $filesource;
    $uploadOk = 1;

    $check = getimagesize($_FILES[$typeid]["tmp_name"]);
    if($check != false) {
        $uploadok = move_uploaded_file($_FILES[$typeid]["tmp_name"], $target_file);
        if ($uploadok) {
            $toolsctrl->uploadImage($filesource, $formatnow);
        }
    }
}
if(isset($_FILES['bgfile']['tmp_name'])){
    
    $typeid="bgfile";                                  
    $target_dir = "uploads/";
    $filesource = basename($_FILES[$typeid]["name"]);
    $target_file = $target_dir . $filesource;
    $uploadOk = 1;

    $check = getimagesize($_FILES[$typeid]["tmp_name"]);
    if($check != false) {
        $uploadok = move_uploaded_file($_FILES[$typeid]["tmp_name"], $target_file);
        if ($uploadok) {
            $toolsctrl->uploadImage($filesource, $formatnow);
        }
    }
}
if(file_exists("database/connection.php")){
    unlink("create_db.php");
}

class create_db{
    function create_file_koneksi($host,$user,$pass,$db_){
        $myfile = fopen("database/connection.php", "w") or die("Unable to open file!");
        $isifile="";
        $isifile .="<?php\n";
        $isifile .="\$host='".$host."';\n";
        $isifile .="\$user='".$user."';\n";
        $isifile .="\$pass='".$pass."';\n";
        $isifile .="\$db='".$db_."';\n";               
        $isifile .="try {\n";
        $isifile .="\$dbh = new PDO(\"mysql:host=\$host;dbname=\$db\", \$user, \$pass);\n";        
        $isifile .="\$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n";        
        $isifile .="}catch(PDOException \$e){\n";
        $isifile .="echo \"Connection failed: \" . \$e->getMessage();\n";
        $isifile .="}\n";
        $isifile .="?>\n";
        fwrite($myfile, $isifile);
        fclose($myfile);
    }
    function create_file_config($db){
        $myfile = fopen("database/config.php", "w") or die("Unable to open file!");
        $isifile="";
        $isifile .="<?php\n";
        $isifile .="class config{\n";
        $isifile .="public static  \$LOGIN_USER='".$db."_login_user';\n";
        $isifile .="public static \$LOGIN_DETAIL='".$db."_login_detail';\n";
        $isifile .="public static \$MENUS='".$db."_menus';\n";
        $isifile .="public static \$ISADMIN='".$db."_isadmin';\n";
        $isifile .="public static \$MASTER_GROUP_DETAIL_LIST='".$db."_master_group_detail_list';\n";
        $isifile .="}\n";
        $isifile .="?>\n";
        fwrite($myfile, $isifile);
        fclose($myfile);
    }
    function create_database($db_,$conn,$formatnow){
        $bgfile=$_FILES['bgfile']['name']!=""?$formatnow.$_FILES['bgfile']['name']:"";
        $logo=$_FILES['logo']['name']!=""?$formatnow.$_FILES['logo']['name']:"";     
        
        $sql="

            CREATE DATABASE ".$db_.";

            USE ".$db_.";

            /*Table structure for table `dashboard_user` */

            DROP TABLE IF EXISTS `dashboard_user`;

            CREATE TABLE `dashboard_user` (
              `id` int(20) NOT NULL AUTO_INCREMENT,
              `graph_query_id` varchar(5) DEFAULT NULL,
              `user` varchar(30) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

            /*Data for the table `dashboard_user` */

            /*Table structure for table `graph_model` */

            DROP TABLE IF EXISTS `graph_model`;

            CREATE TABLE `graph_model` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `type` varchar(10) DEFAULT NULL,
              `name` varchar(255) DEFAULT NULL,
              `filename` varchar(255) DEFAULT NULL,
              `description` varchar(255) DEFAULT NULL,
              `title` varchar(255) DEFAULT NULL,
              `subtitle` varchar(255) DEFAULT NULL,
              `xaxiscategories` text,
              `xaxistitle` varchar(255) DEFAULT NULL,
              `yaxistitle` varchar(255) DEFAULT NULL,
              `tooltips` varchar(255) DEFAULT NULL,
              `series` text,
              `entrytime` timestamp NULL DEFAULT NULL,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NULL DEFAULT NULL,
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

            /*Data for the table `graph_model` */

            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (1,'area','areabasic','areabasic','Area','Historic and Estimated Worldwide Population Growth by Region','Source: Wikipedia.org','\'1750\', \'1800\', \'1850\', \'1900\', \'1950\', \'1999\', \'2050\'','Test','Billions',' millions','\r\n[{\r\n                name: \'Asia\',\r\n                data: [502, 635, 809, 947, 1402, 3634, 5268]\r\n            }, {\r\n                name: \'Africa\',\r\n                data: [106, 107, 111, 133, 221, 767, 1766]\r\n            }, {\r\n                name: \'Europe\',\r\n                data: [163, 203, 276, 408, 547, 729, 628]\r\n            }, {\r\n                name: \'America\',\r\n                data: [18, 31, 54, 156, 339, 818, 1201]\r\n            }, {\r\n                name: \'Oceania\',\r\n                data: [2, 2, 2, 6, 13, 30, 46]\r\n            }]\r\n            ',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (2,'area','areastacked','areastacked','Stacked Area','Historic and Estimated Worldwide Population Growth by Region','Source: Wikipedia.org','\'1750\', \'1800\', \'1850\', \'1900\', \'1950\', \'1999\', \'2050\'','Test','Billions',' millions','\r\n[{\r\n                name: \'Asia\',\r\n                data: [502, 635, 809, 947, 1402, 3634, 5268]\r\n            }, {\r\n                name: \'Africa\',\r\n                data: [106, 107, 111, 133, 221, 767, 1766]\r\n            }, {\r\n                name: \'Europe\',\r\n                data: [163, 203, 276, 408, 547, 729, 628]\r\n            }, {\r\n                name: \'America\',\r\n                data: [18, 31, 54, 156, 339, 818, 1201]\r\n            }, {\r\n                name: \'Oceania\',\r\n                data: [2, 2, 2, 6, 13, 30, 46]\r\n            }]\r\n            ',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (3,'bar','barbasic','barbasic','Bar','Historic and Estimated Worldwide Population Growth by Region','Source: Wikipedia.org','\'1750\', \'1800\', \'1850\', \'1900\', \'1950\', \'1999\', \'2050\'','Test','Billions',' millions','\r\n[{\r\n                name: \'Asia\',\r\n                data: [502, 635, 809, 947, 1402, 3634, 5268]\r\n            }, {\r\n                name: \'Africa\',\r\n                data: [106, 107, 111, 133, 221, 767, 1766]\r\n            }, {\r\n                name: \'Europe\',\r\n                data: [163, 203, 276, 408, 547, 729, 628]\r\n            }, {\r\n                name: \'America\',\r\n                data: [18, 31, 54, 156, 339, 818, 1201]\r\n            }, {\r\n                name: \'Oceania\',\r\n                data: [2, 2, 2, 6, 13, 30, 46]\r\n            }]\r\n            ',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (4,'bar','barstacked','barstacked','Bar Stacked','Historic and Estimated Worldwide Population Growth by Region','Source: Wikipedia.org','\'1750\', \'1800\', \'1850\', \'1900\', \'1950\', \'1999\', \'2050\'','Test','Billions',' millions','\r\n[{\r\n                name: \'Asia\',\r\n                data: [502, 635, 809, 947, 1402, 3634, 5268]\r\n            }, {\r\n                name: \'Africa\',\r\n                data: [106, 107, 111, 133, 221, 767, 1766]\r\n            }, {\r\n                name: \'Europe\',\r\n                data: [163, 203, 276, 408, 547, 729, 628]\r\n            }, {\r\n                name: \'America\',\r\n                data: [18, 31, 54, 156, 339, 818, 1201]\r\n            }, {\r\n                name: \'Oceania\',\r\n                data: [2, 2, 2, 6, 13, 30, 46]\r\n            }]\r\n            ',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (5,'column','columnbasic','columnbasic','Bar Column','Historic and Estimated Worldwide Population Growth by Region','Source: Wikipedia.org','\'1750\', \'1800\', \'1850\', \'1900\', \'1950\', \'1999\', \'2050\'','Test','Billions',' millions','\r\n[{\r\n                name: \'Asia\',\r\n                data: [502, 635, 809, 947, 1402, 3634, 5268]\r\n            }, {\r\n                name: \'Africa\',\r\n                data: [106, 107, 111, 133, 221, 767, 1766]\r\n            }, {\r\n                name: \'Europe\',\r\n                data: [163, 203, 276, 408, 547, 729, 628]\r\n            }, {\r\n                name: \'America\',\r\n                data: [18, 31, 54, 156, 339, 818, 1201]\r\n            }, {\r\n                name: \'Oceania\',\r\n                data: [2, 2, 2, 6, 13, 30, 46]\r\n            }]\r\n            ',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (6,'column','columnstacked','columnstacked','Column Staced','Historic and Estimated Worldwide Population Growth by Region','Source: Wikipedia.org','\'1750\', \'1800\', \'1850\', \'1900\', \'1950\', \'1999\', \'2050\'','Test','Billions',' millions','\r\n[{\r\n                name: \'Asia\',\r\n                data: [502, 635, 809, 947, 1402, 3634, 5268]\r\n            }, {\r\n                name: \'Africa\',\r\n                data: [106, 107, 111, 133, 221, 767, 1766]\r\n            }, {\r\n                name: \'Europe\',\r\n                data: [163, 203, 276, 408, 547, 729, 628]\r\n            }, {\r\n                name: \'America\',\r\n                data: [18, 31, 54, 156, 339, 818, 1201]\r\n            }, {\r\n                name: \'Oceania\',\r\n                data: [2, 2, 2, 6, 13, 30, 46]\r\n            }]\r\n            ',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (7,'line','linebasic','linebasic','Line','Browser market shares at a specific website, 2010','Source: Wikipedia.org','\'1750\', \'1800\', \'1850\', \'1900\', \'1950\', \'1999\', \'2050\'','Test','Percentage',' millions','\r\n[{\r\n                name: \'Asia\',\r\n                data: [502, 635, 809, 947, 1402, 3634, 5268]\r\n            }, {\r\n                name: \'Africa\',\r\n                data: [106, 107, 111, 133, 221, 767, 1766]\r\n            }, {\r\n                name: \'Europe\',\r\n                data: [163, 203, 276, 408, 547, 729, 628]\r\n            }, {\r\n                name: \'America\',\r\n                data: [18, 31, 54, 156, 339, 818, 1201]\r\n            }, {\r\n                name: \'Oceania\',\r\n                data: [2, 2, 2, 6, 13, 30, 46]\r\n            }]\r\n            ',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (8,'pie','piebasic','piebasic','Pie','Browser market shares at a specific website, 2010','Source: Wikipedia.org',NULL,'Test','Percentage','{series.name}: <b>{point.percentage}%</b>','[{\r\ntype: \'pie\',\r\nname: \'Delapan\',\r\ndata : [\r\n[\'area\', 33 ],\r\n[\'bar\', 52 ],\r\n[\'column\', 63 ],\r\n[\'line\', 55 ],\r\n[\'pie\', 88 ]\r\n]\r\n\r\n}]\r\n',NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `graph_model`(`id`,`type`,`name`,`filename`,`description`,`title`,`subtitle`,`xaxiscategories`,`xaxistitle`,`yaxistitle`,`tooltips`,`series`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (9,'table','table','table','Table Model','Browser market shares at a specific website, 2010','Source: Wikipedia.org','SELECT c.prod_name,(SUM(a.prod_quantity)) AS quantity\r\nFROM product_transaction a\r\nINNER JOIN transaction_log b ON a.trans_number = b.trans_number \r\nINNER JOIN master_product c ON a.prod_number = c.prod_number\r\nWHERE b.trans_type_id IN (1,6) \r\nAND (YEAR(b.trans_date) =  \'2015\') \r\nGROUP BY a.prod_number\r\nORDER BY SUM(a.prod_quantity) DESC\r\nLIMIT 10','Test','Percentage',' millions',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

            /*Table structure for table `graph_query` */

            DROP TABLE IF EXISTS `graph_query`;

            CREATE TABLE `graph_query` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `id_graph_model` int(11) DEFAULT NULL,
              `group_code` varchar(200) DEFAULT NULL,
              `query` text,
              `crosstab` int(11) DEFAULT '0',
              `tabletemp` varchar(200) DEFAULT NULL,
              `lastupdate` datetime DEFAULT NULL,
              `timing` int(11) DEFAULT '0',
              `month` int(11) DEFAULT '0',
              `year` int(11) DEFAULT '0',
              `Title` varchar(255) DEFAULT NULL,
              `SubTitle` varchar(255) DEFAULT NULL,
              `xaxistitle` varchar(255) DEFAULT NULL,
              `yaxistitle` varchar(255) DEFAULT NULL,
              `tooltips` varchar(255) DEFAULT NULL,
              `querytable` text,
              `querytable2` text,
              `entrytime` timestamp NULL DEFAULT NULL,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NULL DEFAULT NULL,
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

            /*Data for the table `graph_query` */

            insert  into `graph_query`(`id_graph_model`,`group_code`,`query`,`crosstab`,`tabletemp`,`lastupdate`,`timing`,`month`,`year`,`Title`,`SubTitle`,`xaxistitle`,`yaxistitle`,`tooltips`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) 
            values (7,NULL,'SELECT \'customer\', 10 a,20 b',0,'temp_customer_growth','2016-03-07 08:00:04',43200,0,0,'Customer Growth','Per Year','posisi','Jumlah Dalam Ribuan','',NULL,'','','2015-10-20 07:59:13','windu','::1');

            /*Table structure for table `initial_company` */

            DROP TABLE IF EXISTS `initial_company`;

            CREATE TABLE `initial_company` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `company_name` varchar(200) DEFAULT NULL,
              `username` varchar(200) DEFAULT NULL,
              `database_name` varchar(200) DEFAULT NULL,
              `logo` varchar(200) DEFAULT NULL,
              `bgfile` varchar(200) DEFAULT NULL,
              
              
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

            /*Data for the table `initial_company` */
            insert into `initial_company`(`company_name`,`username`,`database_name`,`logo`,`bgfile`)values('".$_REQUEST['company_name']."','".$_REQUEST['username']."','".$_REQUEST['database_name']."','".$logo."','".$bgfile."');
            /*Table structure for table `master_department` */

            DROP TABLE IF EXISTS `master_department`;

            CREATE TABLE `master_department` (
              `departmentid` varchar(2) NOT NULL,
              `description` varchar(30) DEFAULT NULL,
              PRIMARY KEY (`departmentid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            /*Data for the table `master_department` */

            /*Table structure for table `master_group` */

            DROP TABLE IF EXISTS `master_group`;

            CREATE TABLE `master_group` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `groupcode` varchar(20) NOT NULL DEFAULT '',
              `description` varchar(20) DEFAULT NULL,
              `entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`groupcode`),
              UNIQUE KEY `idxMasterGroup` (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

            /*Data for the table `master_group` */

            insert  into `master_group`(`id`,`groupcode`,`description`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (1,'Admin','Ini Admin','2015-06-20 01:10:06','','','2015-06-20 00:10:30','windu','::1');

            /*Table structure for table `master_group_detail` */

            DROP TABLE IF EXISTS `master_group_detail`;

            CREATE TABLE `master_group_detail` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `groupcode` varchar(20) DEFAULT NULL,
              `module` varchar(50) DEFAULT NULL,
              `read` int(1) DEFAULT '0',
              `confirm` int(1) DEFAULT '0',
              `entry` int(1) DEFAULT '0',
              `update` int(1) DEFAULT '0',
              `delete` int(1) DEFAULT '0',
              `print` int(1) DEFAULT '0',
              `export` int(1) DEFAULT '0',
              `import` int(1) DEFAULT '0',
              `entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `id` (`id`),
              UNIQUE KEY `idxGroupModule` (`groupcode`,`module`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

            /*Data for the table `master_group_detail` */

            /*Table structure for table `master_module` */

            DROP TABLE IF EXISTS `master_module`;

            CREATE TABLE `master_module` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `module` varchar(255) NOT NULL,
              `descriptionhead` varchar(800) DEFAULT NULL,
              `description` varchar(225) DEFAULT NULL,
              `picture` varchar(255) DEFAULT NULL,
              `classcolour` varchar(255) DEFAULT NULL,
              `onclick` text,
              `onclicksubmenu` text,
              `parentid` int(11) DEFAULT NULL,
              `public` int(11) DEFAULT '0',
              `entrytime` timestamp NULL DEFAULT NULL,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NULL DEFAULT NULL,
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

            /*Data for the table `master_module` */

            insert  into `master_module`(`id`,`module`,`descriptionhead`,`description`,`picture`,`classcolour`,`onclick`,`onclicksubmenu`,`parentid`,`public`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (1,'DASHBOARD','<a href=\"#\" onclick=\"showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=1\')\">DASHBOARD </a> ','DASHBOARD','img/icon/icon-home.png','bg-aqua','showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=1\')','showMenu(\'content\', \'index.php?model=graph_query&action=showGraphAll\')',0,1,'2015-05-19 15:19:47','','','2015-06-17 20:00:22','windu','::1');
            insert  into `master_module`(`id`,`module`,`descriptionhead`,`description`,`picture`,`classcolour`,`onclick`,`onclicksubmenu`,`parentid`,`public`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (2,'ADMIN','<a href=\"#\" onclick=\"showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=3\')\">ADMIN </a> ','ADMIN','img/icon/icon-admin.png','bg-yellow','showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=2\')','showMenu(\'content\', \'index.php?model=master_module&action=showMenUBox&id=2\')',0,0,NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `master_module`(`id`,`module`,`descriptionhead`,`description`,`picture`,`classcolour`,`onclick`,`onclicksubmenu`,`parentid`,`public`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (3,'REPORT','<a href=\"#\" onclick=\"showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=4\')\">REPORT</a> ','REPORT','img/icon/icon-report.png','bg-green','showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=3\')','showMenu(\'content\', \'index.php?model=master_module&action=showMenuBox&id=3\')',0,0,NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `master_module`(`id`,`module`,`descriptionhead`,`description`,`picture`,`classcolour`,`onclick`,`onclicksubmenu`,`parentid`,`public`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (4,'MASTER_USER','<a href=\"#\" onclick=\"showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=3\')\">ADMIN </a> / USER ','USER','img/icon/icon-create-user.png','bg-orange','showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=4\')','showMenu(\'content\', \'index.php?model=master_user&action=showAllJQuery\')',2,0,NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `master_module`(`id`,`module`,`descriptionhead`,`description`,`picture`,`classcolour`,`onclick`,`onclicksubmenu`,`parentid`,`public`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (5,'MASTER_GROUP','<a href=\"#\" onclick=\"showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=3\')\">ADMIN </a> / GROUP','GROUP','img/icon/icon-group.png','bg-red','showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=5\')','showMenu(\'content\', \'index.php?model=master_group&action=showAllJQuery\')',2,0,NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `master_module`(`id`,`module`,`descriptionhead`,`description`,`picture`,`classcolour`,`onclick`,`onclicksubmenu`,`parentid`,`public`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (6,'MASTER_MODULE','<a href=\"#\" onclick=\"showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=3\')\">ADMIN </a> / MODULE','MODULE','img/icon/icon-module.png','bg-blue1','showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=6\')','showMenu(\'content\', \'index.php?model=master_module&action=showAllJQuery\')',2,0,NULL,NULL,NULL,NULL,NULL,NULL);
            insert  into `master_module`(`id`,`module`,`descriptionhead`,`description`,`picture`,`classcolour`,`onclick`,`onclicksubmenu`,`parentid`,`public`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (7,'GRAPH_QUERY','<a href=\"#\" onclick=\"showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=3\')\">ADMIN </a> / GRAPH QUERY','GRAPH QUERY','img/icon/icon-graph-query.png','bg-orange2','showMenu(\'contentmenu\', \'index.php?model=master_module&action=showMenu&id=7\')','showMenu(\'content\', \'index.php?model=graph_query&action=showAllJQuery\')',2,0,NULL,NULL,NULL,NULL,NULL,NULL);

            /*Table structure for table `master_profil` */

            DROP TABLE IF EXISTS `master_profil`;

            CREATE TABLE `master_profil` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `nik` varchar(30) DEFAULT NULL,
              `user` varchar(30) DEFAULT NULL,
              `avatar` mediumblob,
              `departmentid` varchar(2) DEFAULT NULL,
              `unitid` varchar(2) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            /*Data for the table `master_profil` */

            /*Table structure for table `master_unit` */

            DROP TABLE IF EXISTS `master_unit`;

            CREATE TABLE `master_unit` (
              `unitid` varchar(2) NOT NULL,
              `unitname` varchar(50) DEFAULT NULL,
              `description` varchar(200) DEFAULT NULL,
              PRIMARY KEY (`unitid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            /*Data for the table `master_unit` */

            /*Table structure for table `master_user` */

            DROP TABLE IF EXISTS `master_user`;

            CREATE TABLE `master_user` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user` varchar(30) NOT NULL DEFAULT '',
              `description` varchar(255) DEFAULT NULL,
              `password` varchar(255) DEFAULT NULL,
              `username` varchar(50) DEFAULT NULL,
              `nik` varchar(50) DEFAULT NULL,
              `departmentid` int(11) DEFAULT NULL,
              `unitid` int(11) DEFAULT NULL,              
              `entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              `avatar` text,
              PRIMARY KEY (`user`),
              UNIQUE KEY `iduser` (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

            /*Data for the table `master_user` */
            insert  into `master_user`(`id`,`user`,`description`,`password`,`username`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`,`avatar`) values (1,'".$_REQUEST["username"]."','Administrator','".md5($_REQUEST["password"])."','".$_REQUEST["username"]."',now(),'','',now(),'system','','templatemo-topbar-bg.png');
            

            /*Table structure for table `master_user_detail` */

            DROP TABLE IF EXISTS `master_user_detail`;

            CREATE TABLE `master_user_detail` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user` varchar(30) DEFAULT NULL,
              `groupcode` varchar(20) DEFAULT NULL,
              `entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `usergroup` (`user`,`groupcode`)
            ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

            /*Data for the table `master_user_detail` */

            insert  into `master_user_detail`(`id`,`user`,`groupcode`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (1,'".$_REQUEST["username"]."','Admin',now(),'','',now(),'','');

            /*Table structure for table `replace_character` */

            DROP TABLE IF EXISTS `replace_character`;

            CREATE TABLE `replace_character` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `sourcetext` varchar(255) DEFAULT NULL,
              `replacetext` varchar(255) DEFAULT NULL,
              `find` int(1) DEFAULT '1',
              `save` int(1) DEFAULT '1',
              `entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

            /*Data for the table `replace_character` */

            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (1,'\'','\\\\\'',1,1,'2015-06-17 16:20:52',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (2,'javascript','',1,1,'2015-06-17 16:21:05',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (3,'script','',1,1,'2015-06-17 16:21:12',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (4,'union',' ',1,0,'2015-10-20 18:58:03',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (5,' or ',' ',1,0,'2015-10-20 18:58:06',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (6,'--',' ',1,1,'2015-09-28 10:35:11',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (7,'JAVASCRIPT',' ',1,1,'2015-09-28 10:46:19',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (8,'SCRIPT',' ',1,1,'2015-09-28 10:46:21',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (9,'UNION',' ',1,0,'2015-10-20 18:58:13',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (10,' OR ',' ',1,0,'2015-10-20 18:58:16',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (11,'Javascript',' ',1,1,'2015-09-28 10:46:23',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (12,'Script',' ',1,1,'2015-09-28 10:46:24',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (13,'Union',' ',1,0,'2015-10-20 18:58:20',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);
            insert  into `replace_character`(`id`,`sourcetext`,`replacetext`,`find`,`save`,`entrytime`,`entryuser`,`entryip`,`updatetime`,`updateuser`,`updateip`) values (14,' Or ',' ',1,0,'2015-10-20 18:58:22',NULL,NULL,'0000-00-00 00:00:00',NULL,NULL);

            /*Table structure for table `report_query` */

            DROP TABLE IF EXISTS `report_query`;

            CREATE TABLE `report_query` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `reportname` varchar(255) DEFAULT NULL,
              `header` varchar(255) DEFAULT NULL,
              `query` mediumtext,
              `crosstab` int(11) DEFAULT '0',
              `total` int(11) DEFAULT '0',
              `subtotal` int(11) DEFAULT '0',
              `entrytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              `entryuser` varchar(255) DEFAULT NULL,
              `entryip` varchar(255) DEFAULT NULL,
              `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updateuser` varchar(255) DEFAULT NULL,
              `updateip` varchar(255) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    
        ";
        $conn->query($sql);
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
