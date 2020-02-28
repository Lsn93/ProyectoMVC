<?php
    $peticionAjax=true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['dni-reg'])){

        require_once "../controladores/clienteControlador.php";
        $InsClient= new clienteControlador();

        if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg'])){
            echo $InsClient->agregar_cliente_controlador();
        }


    }else{
        session_start(['name'=>'SBP']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }