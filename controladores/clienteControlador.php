<?php
    if($peticionAjax){
        require_once "../modelos/clienteModelo.php";
    }else{
        require_once "./modelos/clienteModelo.php";
    }

    class clienteControlador extends clienteModelo{
        public function agregar_cliente_controlador(){
            $dni=mainModel::limpiar_cadena($_POST['dni-reg']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
            $apellido=mainModel::limpiar_cadena($_POST['apellido-reg']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
            $ocupacion=mainModel::limpiar_cadena($_POST['ocupacion-reg']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);

            $usuario=mainModel::limpiar_cadena($_POST['usuario-reg']);
            $password1=mainModel::limpiar_cadena($_POST['password1']);
            $password2=mainModel::limpiar_cadena($_POST['password2']);
            $email=mainModel::limpiar_cadena($_POST['email-reg']);
            $genero=mainModel::limpiar_cadena($_POST['optionsGenero']);
            $privilegio=4;

            if($genero=="Masculino"){
                $foto="Male2Avatar.png";
            }else{
                $foto="Female2Avatar.png";
            }

            if($password1!=$password2){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Las claves que acaba de ingresar no coinciden",
                    "Tipo" => "error"
                ];
            }else{
                $consulta1=mainModel::ejecutar_consulta_simple("SELECT ClienteDNI FROM cliente WHERE ClienteDNI='$dni'");
                if($consulta1->rowCount()>=1){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El DNI que acaba de ingresar ya se encuentra registrado en el sistema",
                        "Tipo" => "error"
                    ];
                }else{
                    if($email!=""){
                        $consulta2=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$email'");
                        $ec=$consulta2->rowCount();
                    }else{
                        $ec=0;
                    }

                    if($ec>=1){
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrió un error inesperado",
                            "Texto" => "El Email que acaba de ingresar ya se encuentra registrado en el sistema",
                            "Tipo" => "error"
                        ];
                    }else{
                        $consulta3=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$usuario'");

                        if($consulta3->rowCount()>=1){
                            $alerta = [
                                "Alerta" => "simple",
                                "Titulo" => "Ocurrió un error inesperado",
                                "Texto" => "El Usuario que acaba de ingresar ya se encuentra registrado en el sistema",
                                "Tipo" => "error"
                            ];
                        }else{
                            
                        }
                    }
                }
            }
            return mainModel::sweet_alert($alerta);
        }
    }