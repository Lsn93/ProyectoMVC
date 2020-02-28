<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class empresaModelo extends mainModel{

        protected function agregar_empresa_modelo($datos){

        }
    }