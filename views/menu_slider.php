<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>

	<script>
            $(document).ready(function() {
                    $("#owl-demo").owlCarousel({
                            items : 4,
                            lazyLoad : true,
                            autoPlay : false,
                            navigation : true,
                            navigationText : ["", ""],
                            rewindNav : false,
                            scrollPerPage : false,
                            pagination : false,
                            paginationNumbers : false,
                    });
            });
            
        </script>
        <!-- //Owl Carousel Assets -->
        <!-----768px-menu----->
        <link type="text/css" rel="stylesheet" href="css/jquery.mmenu.all.css" />
        <script type="text/javascript" src="js/jquery.mmenu.js"></script>
                <script type="text/javascript">
                        //	The menu on the left
                        $(function() {
                                $('nav#menu-left').mmenu();
                        });
        </script>
        <!-----//768px-menu----->
</head>
<body>
<!-- start header --><!-- start header --><!---start-banner----><!---slider---->
				
        <script src="js/jquery-ui.js" type="text/javascript"></script>
        <script src="js/scripts-f0e4e0c2.js" type="text/javascript"></script>
        <script>
                  jQuery('#jquery-demo').slippry({
                  // general elements & wrapper
                  slippryWrapper: '<div class="sy-box jquery-demo" />', // wrapper to wrap everything, including pager
                  // options
                  adaptiveHeight: false, // height of the sliders adapts to current slide
                  useCSS: false, // true, false -> fallback to js if no browser support
                  autoHover: false,
                  transition: 'fade'
                });
        </script>
        <!---scrooling-script--->
                <!----//End-image-slider---->
<!-- start services -->
  <div class="menubar">          
            
            
        <div class="wrap">
                <!----start-img-cursual---->
                <div id="owl-demo" class="owl-carousel">                  

<?php
foreach ($master_module_list as $master_module){
?>
                    <div class="item">
                        <div class="cau_left">	
                            <!-- small box -->
                            <div class="small-box <?php echo $master_module->getClasscolour(); ?> " onclick="<?php echo $master_module->getOnclick(); ?>">
                               <div class="inner">
                                   <h3>
                                   <img src="<?php echo $master_module->getPicture(); ?>" onclick="<?php echo $master_module->getOnclick(); ?>"> </h3>
                                   <p>
                                     <?php echo $master_module->getDescription(); ?>  
                                   </p>
                               </div>
                             </div>
                        </div>
                    </div>
<?php
}
?>

               <script type="text/javascript" src="js/nivo-lightbox.min.js"></script>
               <script type="text/javascript">
               $(document).ready(function(){
                   $('#nivo-lightbox-demo a').nivoLightbox({ effect: 'fade' });
               });
               </script>

            </div>
        </div>
            </div>
            
</body>
</html>
