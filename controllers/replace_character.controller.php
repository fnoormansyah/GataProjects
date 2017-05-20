<?php
    require_once './models/master_user.class.php';
    require_once './controllers/master_user.controller.php';
    require_once './models/replace_character.class.php';
    require_once './controllers/replace_character.controller.generate.php';
    if (!isset($_SESSION)) {
        session_start();
    }

    class replace_characterController extends replace_characterControllerGenerate
    {
        function replacechar($var){
            foreach ($this->showDataAll() as $replace_character){
                $var = str_replace($replace_character->getSourceText(), $replace_character->getReplaceText(), $var);
            }            
            return $var;
        }
        function replacecharFind($var){
            $sql = "select * from replace_character where `find`=1 ";                                  

            foreach ($this->createList($sql) as $replace_character){
                $var = str_replace($replace_character->getSourceText(), $replace_character->getReplaceText(), $var);
            }            
            return $var;
        }
        function replacecharSave($var){
            $sql = "select * from replace_character where `save`=1 ";                                  

            foreach ($this->createList($sql) as $replace_character){
                $var = str_replace($replace_character->getSourceText(), $replace_character->getReplaceText(), $var);
            }            
            return $var;
        }
    }
?>
