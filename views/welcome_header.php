<div class="col-xs-12">
    <?php
    if($initial_company->getBgfile()!=""){
        ?>
        <img class="img-responsive" src="./images_medium/<?php echo $initial_company->getBgfile();?>" />
        <?php
    }else{
        ?>
        <img class="img-responsive" src="./images/noimage.png" />
        <?php
    }
    
    ?>
    
</div>
<div class="cleaner"></div> 


     