<section class="content">
<div class="cleaner_h10"></div>


<div class="row">
    
<?php


if (count($master_module_list) > 0) {
    foreach ($master_module_list as $master_module){
    ?>

        <div class="col-lg-2 col-xs-6">
           <!-- small box -->
           <!--<div class="item">-->
           <div>
          <p>
           <div class="small-box <?php echo $master_module->getClasscolour(); ?>" onclick="<?php echo $master_module->getOnclick(); ?>">
            <div class="inner">
                <h3><img src="<?php echo $master_module->getPicture(); ?>" onclick="<?php echo $master_module->getOnclick(); ?>"></h3>
                 
                     <?php echo $master_module->getDescription(); ?>  
                </p>
            </div>
           </div>
       </div>  </div>   
<?php
    }
}
?>
</div>
</section>
<div class="clearfix"></div>

