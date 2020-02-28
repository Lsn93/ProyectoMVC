<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class bitacoraModelo extends mainModel{

        public function listado_bitacora_controlador($registros){
            $registros=mainModel::limpiar_cadena($registros);

            $datos=mainModel::ejecutar_consulta_simple("SELECT * FROM bitacora ORDER BY id DESC LIMIT $registros");
            
            $conteo=1;

            while($rows=$datos->fetch()){

                $datosC=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='".$rows['CuentaCodigo']."'");
                $datosC=$datosC->fetch();

                if($rows['BitacoraTipo']=="Administrador"){
                    $datosU=mainModel::ejecutar_consulta_simple("SELECT AdminNombre,AdminApellido FROM admin WHERE CuentaCodigo='".$rows['CuentaCodigo']."'");
                    $datosU=$datosU->fetch();
                    $NombreCompleto=$datosU['AdminNombre']." ".$datosU['AdminApellido'];
                }else{
                    $datosU=mainModel::ejecutar_consulta_simple("SELECT ClienteNombre,ClienteApellido FROM cliente WHERE CuentaCodigo='".$rows['CuentaCodigo']."'");
                    $datosU=$datosU->fetch();
                    $NombreCompleto=$datosU['ClienteNombre']." ".$datosU['ClienteApellido'];
                }

                echo '
                
                
                ';
            }
        }
    }