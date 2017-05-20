<script language="javascript" type="text/javascript">
        jQuery(function(){
            $("#frmgraph_query").submit(function(){
                var post_data = $(this).serialize();
                var form_action = $(this).attr("action");
                var form_method = $(this).attr("method");
                $.ajax({
                     type : form_method,
                     url : form_action, 
                     cache: false, 
                     data : post_data,
                     success : function(x){
                         showMenu('content', 'index.php?model=graph_query&action=showGraphAll');
                     }, 
                     error : function(){
                        alert("Error");
                     }
                });
                return false;
             });
        });
</script>
<form name="frmgraph_query" id="frmgraph_query" method="post" action="index.php?model=dashboard_user&action=saveGraphUserById">
    <table width="100%" border="0" align="right" style="border-collapse: collapse">
        <tr>
            <td align="right">Personalize Dashboard : 
                <select name='graph_query_id' id='graph_query_id'>
                <?php
                foreach ($graph_list as $graph_list){
                    $selected =$graph_list->getId();
                    ?>
                    <option value="<?php echo $graph_list-> getId()?>" <?php echo $selected; ?>>
                        <?php  echo $graph_list-> getTitle() ?>
                    </option>
                    <?php
                }
                ?>
                </select>
                <input type="hidden"  name="user" id="user" value="<?php echo $master_user->getId();?>" size="2"   >                
                <input type="submit" name="submit" value="add" class="btn btn-facebook btn-sm" >
            </td>
            
        </tr>
    </table>
</form>