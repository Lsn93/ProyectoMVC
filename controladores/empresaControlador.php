<?php
    if($peticionAjax){
        require_once "../modelos/empresaModelo.php";
    }else{
        require_once "./modelos/empresaModelo.php";
    }

    class empresaControlador extends empresaModelo{
        
        public function agregar_empresa_controlador(){
            $codigo=mainModel::limpiar_cadena($_POST['dni-reg']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
            $email=mainModel::limpiar_cadena($_POST['email-reg']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);
            $director=mainModel::limpiar_cadena($_POST['director-reg']);
            $moneda=mainModel::limpiar_cadena($_POST['moneda-reg']);
            $year=mainModel::limpiar_cadena($_POST['year-reg']);

            $consulta1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM empresa WHERE EmpresaCodigo='$codigo'");

            if($consulta1->rowCount()<=0){

                $consulta2=mainModel::ejecutar_consulta_simple("SELECT EmpresaNombre FROM empresa WHERE EmpresaNombre='$nombre'");

                if($consulta2->rowCount()<=0){

                    $datosEmpresa=[
                        "Codigo"=>$codigo,
                        "Nombre"=>$nombre,
                        "Telefono"=>$telefono,
                        "Email"=>$email,
                        "Direccion"=>$direccion,
                        "Director"=>$director,
                        "Moneda"=>$moneda,
                        "Year"=>$year
                    ];

                    $guardarEmpresa=empresaModelo::agregar_empresa_modelo($datosEmpresa);

                    if($guardarEmpresa->rowCount()>=1){
                        $alerta = [
                            "Alerta" => "recargar",
                            "Titulo" => "Empresa registrada",
                            "Texto" => "Los datos de la empresa se registraron con éxito",
                            "Tipo" => "success"
                        ];
                    }else{
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrió un error inesperado",
                            "Texto" => "No hemos podido guardar los datos de la empresa, por favor intente nuevamente",
                            "Tipo" => "error"
                        ];
                    }
                }else{
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El nombre de la empresa que acaba de ingresar ya se encuentra en el sistema",
                        "Tipo" => "error"
                    ];
                }
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El código de registro que acaba de ingresar ya se encuentra en el sistema",
                    "Tipo" => "error"
                ];
            }
            return mainModel::sweet_alert($alerta);
        }
    }