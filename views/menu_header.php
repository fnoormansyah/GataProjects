<?php
if (!isset($_SESSION[config::$LOGIN_USER])) {
    echo "<script>window.open('index.php','_self');</script>";
}
?>
<section class="content">   

<h2><?php echo $master_module->getDescription() ?> </h2>
<ol class="breadcrumb">
      <li><i class="fa fa-dashboard"></i> Home </li>
      <li class="active"><?php echo $master_module->getDescriptionhead() ?></li>
</ol>             
<div class="cleaner_h10"></div>
</section>
<script type="text/javascript">
   $("#content").load(<?php echo $master_module->getOnclicksubmenu() ?>);
</script>