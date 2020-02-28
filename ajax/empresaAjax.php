<?php
    $peticionAjax=true;
    require_once "../core/configGeneral.php";
    if(){

        
    }else{
        session_start(['name'=>'SBP']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }