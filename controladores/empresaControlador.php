<?php
    if($peticionAjax){
        require_once "../modelos/empresaModelo.php";
    }else{
        require_once "./modelos/empresaModelo.php";
    }

    class empresaControlador extends empresaModelo{
        
        public function agregar_empresa_controlador(){

        }
    }