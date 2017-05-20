
<table width="100%" border="1" align="center">
    <tr>
        <td >
            <image src="images/icon-close.png" onclick="showMenu('uploadphoto','blank.php')">
        </td>
    </tr>
    <tr>
        <td>
            <form id="uploadphoto" action="index.php?model=master_profil&action=fileUpload" method="post" enctype="multipart/form-data">
                Please Insert Your Photo : <input type="file" name="fileupload" id="fileupload"> <input type="submit" name="submit" value="Upload">
            </form>
        <div class="progress">
        <div class="bar"></div >
        <div class="percent">0%</div >        
        <div id="status"></div>  
        </td>
    </tr>
</table>
    <script>
        (function() {
 
            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');
 
            $('form').ajaxForm({
                beforeSend: function() {
                    status.empty();
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                success: function() {
                    var percentVal = '100%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                complete: function(xhr) {
                    status.html(xhr.responseText);
                    showMenu('avatarprofile','index.php?model=master_profil&action=showAvatar');
                    showMenu('content','index.php?model=master_profil&action=showProfileUser');
                }
            });
        })();
    </script>
