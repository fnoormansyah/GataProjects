<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/graph_model.class.php';
    require_once './controllers/graph_model.controller.generate.php';
    if (!isset($_SESSION)) {
        session_start();
    }

    class graph_modelController extends graph_modelControllerGenerate
    {
        function js(){
            echo "<script type=\"text/javascript\" src=\"./js/jquery-1.8.2.js\"></script>".PHP_EOL;
            echo "<script src=\"./jsgraph/highcharts.js\"></script>".PHP_EOL;
            echo "<script src=\"./jsgraph/modules/exporting.js\"></script>".PHP_EOL;            
        }
        function showGraphWithJs(){
            $this->js();
            $this->showGraphFromModel();
        }
        function showGraphFromModel(){
            $id = $_GET['id'];
            $graph_model = $this->showData($id);
            require_once './views/graph/'.$graph_model->getFilename().'.php';
        }
        function showGraph(){
            
            $graph_model = $this->getGraph_model();
            require './views/graph/'.$graph_model->getFilename().'.php';            
        }

    }
?>
