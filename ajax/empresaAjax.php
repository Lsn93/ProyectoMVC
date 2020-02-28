<?php
    $peticionAjax=true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['dni-reg'])){

        require_once "../controladores/empresaControlador.php";
        $insEm = new empresaControlador();

        if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg'])){
            echo $insEm->agregar_empresa_controlador();
        }

        
    }else{
        session_start(['name'=>'SBP']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }