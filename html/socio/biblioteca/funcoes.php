<?php
    if (!function_exists('msg')) {
        function msg($tipo, $mensagem){
            switch($tipo){
                case "aviso": 
                    $_msg = "<div class='alert alert-warning' role='alert'>$mensagem</div>"; break;
                case "erro":
                    $_msg = "<div class='alert alert-danger' role='alert'>$mensagem</div>"; break;
                case "sucesso":
                    $_msg = "<div class='alert alert-success' role='alert'>$mensagem</div>"; break;
                default: $_msg = "<div class='alert alert-primary' role='alert'>$mensagem</div>"; break;
            }
            echo($_msg);
        }
    }
    if(!function_exists('redir')){
        function redir($local, $tempo){
            if(empty($tempo)) $tempo = 0;
            echo("<META HTTP-EQUIV='Refresh' CONTENT='$tempo;URL=$local'>");
        }
    }
?>