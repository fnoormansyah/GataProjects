<script language="javascript" type="text/javascript">
        jQuery(function(){
            $("#frmmaster_module").submit(function(){
                var post_data = $(this).serialize();
                var form_action = $(this).attr("action");
                var form_method = $(this).attr("method");
                $.ajax({
                     type : form_method,
                     url : form_action, 
                     cache: false, 
                     data : post_data,
                     success : function(x){
                         alert(x);
                         showMenu('content', 'index.php?model=master_module&action=showAllJQuery&skip=<?php echo $skip ?>&search=<?php echo $search ?>');
                     }, 
                     error : function(){
                        alert("Error");
                     }
                });
                return false;
             });
        });
        function tampilgambar(){
            var namafile=$('#picture').val();
            site =  'index.php?model=master_module&action=tampilgambaricon&namafile='+namafile;
            target = "imgicon";
            showMenu(target, site);
        }
</script>

<br>


<form name="frmmaster_module" id="frmmaster_module" method="post" action="index.php?model=master_module&action=saveFormJQuery">
    <table >
        <tr> 
            <td class="textBold">Id</td> 
            <td><input type="text"  name="id" id="id" value="<?php echo $master_module_->getId();?>" size="11" ReadOnly  ></td>
        </tr>

        <tr> 
            <td class="textBold">Module</td> 
            <td><input type="text"  name="module" id="module" value="<?php echo $master_module_->getModule();?>" size="40"   ></td>
        </tr>
        <tr> 
            <td class="textBold">Description</td> 
            <td><input type="text"  name="description" id="description" value="<?php echo $master_module_->getDescription();?>" size="40"   ></td>
        </tr>


        
        <tr> 
            <td class="textBold">Parent module</td> 
            <td>
                <select name="parentid" id="parentid">
                    <option value="0">--</option>
                <?php
                $listmod=$this->showDataAll();
                foreach ($listmod as $rw){
                    if($master_module_->getParentid()==$rw->getId()){
                        echo "<option selected value='".$rw->getId()."'>".$rw->getDescription()."</option>";
                    }else{
                        echo "<option value='".$rw->getId()."'>".$rw->getDescription()."</option>";
                    }
                    
                }
                
                ?>
                </select>
                
            </td>
        </tr>
        
        <tr> 
            <td class="textBold">Description head</td> 
            <td><input type="text"  name="descriptionhead" id="descriptionhead" value="<?php echo htmlentities($master_module_->getDescriptionhead());?>" size="80"   ></td>
        </tr>

<!--        <tr> 
            <td class="textBold">Description</td> 
            <td><input type="text"  name="description" id="description" value="<?php echo $master_module_->getDescription();?>" size="40"   ></td>
        </tr>-->

        <tr> 
            <td class="textBold">Picture</td> 
            <td>
                <table>
                    <tr>
                        <td>
                            <select name="picture" id="picture" onchange="tampilgambar();">
                                <option value="">--</option>
                    <?php
                    foreach(glob('./img/icon/*.png*') as $filename){
                        $nm=  str_replace("./", "", $filename);
                        if("./".$master_module_->getPicture()==$filename){
                            echo "<option selected value='".$nm."'>".$nm."</option>";
                        }else{
                            echo "<option value='".$nm."'>".$nm."</option>";
                        }
                        
                    }
                    
                    ?>
                </select>
                       </td>
                       <td>
                           <div id="imgicon">
                               <?php
                               if($master_module_->getId()!=""){
                                   echo "<img src='./".$master_module_->getPicture()."'>";
                               }
                               
                               ?>
                           </div>
                       </td>
                    </tr>
                    
                </table>
            </td>
        </tr>

        <tr> 
            <td class="textBold">Classcolour</td> 
            <td>
                <select name="classcolour" id="classcolour">
                <?php
                $colr['bg-red']='bg-red';
                $colr['bg-yellow']='bg-yellow';
                $colr['bg-aqua']='bg-aqua';
                $colr['bg-blue']='bg-blue';
                $colr['bg-blue1']='bg-blue1';
                $colr['bg-green']='bg-green';
                $colr['bg-navy']='bg-navy';
                $colr['bg-teal']='bg-teal';
                $colr['bg-olive']='bg-olive';
                $colr['bg-lime']='bg-lime';
                $colr['bg-orange']='bg-orange';
                $colr['bg-orange1']='bg-orange1';
                $colr['bg-orange2']='bg-orange2';
                $colr['bg-orange3']='bg-orange3';
                $colr['bg-fuchsia']='bg-fuchsia';
                $colr['bg-purple']='bg-purple';
                $colr['bg-maroon']='bg-maroon';
                $colr['bg-beige']='bg-beige';
                $colr['bg-light-brown']='bg-light-brown';
                $colr['bg-lime-green']='bg-lime-green';
                $colr['bg-lilac']='bg-lilac';
                $colr['bg-pink']='bg-pink';
                $colr['bg-magenta']='bg-magenta';
                $colr['bg-red']='bg-red';
                $colr['bg-red1']='bg-red1';
                $colr['bg-red2']='bg-red2';
                $colr['bg-red3']='bg-red3';
                $colr['bg-light-yellow']='bg-light-yellow';
                $colr['bg-dark-green']='bg-dark-green';
                $colr['bg-dark-blue']='bg-dark-blue';
                $colr['bg-dark-browo']='bg-dark-browo';
                $colr['bg-black']='bg-black';
                foreach ($colr as $x=>$y){
                    if($x==$master_module_->getClasscolour()){
                        echo "<option selected>".$y."</option>";
                    }else{
                        echo "<option>".$y."</option>";
                    }
                }
                
                ?>
                </select>
        </tr>

        <tr> 
            <td class="textBold">Onclick</td> 
            <td><textarea rows="10" cols="50" name="onclick" id="onclick"><?php echo $master_module_->getOnclick();?></textarea></td>
        </tr>

        <tr> 
            <td class="textBold">Onclicksubmenu</td> 
            <td><textarea rows="10" cols="50" name="onclicksubmenu" id="onclicksubmenu"><?php echo $master_module_->getOnclicksubmenu();?></textarea></td>
        </tr>

        
        <tr> 
            <td class="textBold">Public</td> 
            <td>
                    <select  name="public" id="public" >
                <?php
                if($master_module_->getPublic()!=""){
                    if($master_module_->getPublic()==1){
                        
                        echo "<option value='0' >No</option>";
                        echo "<option value='1' selected >Yes</option>";

                    }else{
                        
                        echo "<option value='0' selected >No</option>";
                        echo "<option value='1' >Yes</option>";

                    }    
                }else{
                        
                        echo "<option value='0' >No</option>";
                        echo "<option value='1' >Yes</option>";

                }
                
                
                ?>
                </select>
                
            
                <!--<input type="text"  name="public" id="public" value="<?php echo $master_module_->getPublic();?>" size="11"   >-->
            </td>
        </tr>

        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit" class="btn btn-danger btn-sm" ></td>
        </tr>
    </table>
</form>

<br>
<br>
