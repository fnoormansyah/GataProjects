<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sample POP UP Window</title>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/popup.js"></script>
<style type="text/css">
    #popup {
        visibility : visible;
        border : solid 1px red;        
        position : fixed;
        background : #CCC;
        z-index: 999;
    }
</style>

<script language="javascript">
    function closeDetail(id) {
        document.getElementById(id).innerHTML = "";
    }

    function openPopup(iddiv) {
        document.getElementById(iddiv).style.visibility = "visible";
    }

    function closePopup(iddiv) {
        document.getElementById(iddiv).style.visibility = "hidden";
        document.getElementById(iddivi).innerHTML = "";
    }

    function openForm(url){
        openPopup('popup');
        ajax_loadContent('popup',url);
        Popup.showModal('popup',null,null,{'screenColor':'#000000','screenOpacity':.6});
        return false;
    }
    
    function showCommand(command) {
        target = 'bodyContent';
        site =  'app?cmd=' + command;
        ajax_loadContent(target,site);
    }
</script>
</head>

<body>
    <div id="popup" style="width: 900px; height:auto; overflow: auto; padding-bottom:10px; margin-top:-230px;"></div>
    <a href="#" onclick="openForm('content_popup.php')">Sample Popup Window</a>
</body>
</html>