<?php
    if($peticionAjax){
        require_once "../modelos/administradorModelo.php";
    }else{
        require_once "./modelos/administradorModelo.php";
    }

    class administradorControlador extends administradorModelo{

        //Controlador para agregar administrador
        public function agregar_administrador_controlador(){
            $dni=mainModel::limpiar_cadena($_POST['dni-reg']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
            $apellido=mainModel::limpiar_cadena($_POST['apellido-reg']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);
            $usuario=mainModel::limpiar_cadena($_POST['usuario-reg']);
            $password1=mainModel::limpiar_cadena($_POST['password1-reg']);
            $password2=mainModel::limpiar_cadena($_POST['password2-reg']);
            $email=mainModel::limpiar_cadena($_POST['email-reg']);
            $genero=mainModel::limpiar_cadena($_POST['optionsGenero']);
            $privilegio=mainModel::limpiar_cadena($_POST['optionsPrivilegio']);

            if($genero=="Masculino"){
                $foto="Male3Avatar.png";
            }else{
                $foto="Female3Avatar.png";
            }

            if($password1!=$password2){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Las contraseñas que acabas de ingresar no coinciden, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];
            }else{
                $consulta1=mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM admin WHERE AdminDNI='$dni'");
                if($consulta1->rowCount()>=1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El DNI que acaba de ingresar ya se encuentra registrado en el sistema",
                        "Tipo"=>"error"
                    ];
                }else{
                    if($email!=""){
                        $consulta2=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$email'");
                        $ec=$consulta2->rowCount();
                    }else{
                        $ec=0;
                    }

                    if($ec>=1){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema",
                            "Tipo"=>"error"
                        ];
                    }else{
                        $consulta3=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$usuario'");
                        if($consulta3->rowCount()>=1){
                            $alerta=[
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrió un error inesperado",
                                "Texto"=>"El USUARIO que acaba de ingresar ya se encuentra registrado en el sistema",
                                "Tipo"=>"error"
                            ];
                        }else{
                            $consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta");
                            
                            $numero=($consulta4->rowCount())+1;
                            
                            $codigo=mainModel::generar_codigo_aleatorio("AC",7,$numero);
                            
                            $clave=mainModel::encryption($password1);
                            
                            $dataAC=[
                                "Codigo"=>$codigo,
                                "Privilegio"=>$privilegio,
                                "Usuario"=>$usuario,
                                "Clave"=>$clave,
                                "Email"=>$email,
                                "Estado"=>"Activo",
                                "Tipo"=>"Administrador",
                                "Genero"=>$genero,
                                "Foto"=>$foto
                            ];

                            $guardarCuenta=mainModel::agregar_cuenta($dataAC);

                            if($guardarCuenta->rowCount()>=1){
                                
                                $dataAD=[
                                    "DNI"=>$dni,
                                    "Nombre"=>$nombre,
                                    "Apellido"=>$apellido,
                                    "Telefono"=>$telefono,
                                    "Direccion"=>$direccion,
                                    "Codigo"=>$codigo
                                ];

                                $guardarAdmin=administradorModelo::agregar_administrador_modelo($dataAD);

                                if($guardarAdmin->rowCount()>=1){
                                    $alerta=[
                                        "Alerta"=>"limpiar",
                                        "Titulo"=>"Administrador registrado",
                                        "Texto"=>"El administrador se registró con éxito en el sistema",
                                        "Tipo"=>"success"
                                    ];
                                }else{
                                    mainModel::eliminar_cuenta($codigo);
                                    $alerta=[
                                        "Alerta"=>"simple",
                                        "Titulo"=>"Ocurrió un error inesperado",
                                        "Texto"=>"No hemos podido registrar el administrador",
                                        "Tipo"=>"error"
                                    ];
                                }
                            }else{
                                $alerta=[
                                    "Alerta"=>"simple",
                                    "Titulo"=>"Ocurrió un error inesperado",
                                    "Texto"=>"No hemos podido registrar el administrador",
                                    "Tipo"=>"error"
                                ];
                            }
                        }
                    }
                }
            }
            return mainModel::sweet_alert($alerta);
        }


        //Controlador para paginar administradores
        public function paginador_administrador_controlador($pagina,$registros,$privilegio,$codigo){

            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $codigo=mainModel::limpiar_cadena($codigo);
            $tabla="";

            $pagina= (isset($pagina) && $pagina>0) ? (int)$pagina:1;
            $inicio= ($pagina>0) ? (($pagina*$registros-$registros)) : 0;

            $conexion = mainModel::conectar();

            $datos = $conexion->query("
                SELECT SQL_CALC_FOUND_ROWS * FROM admin WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre ASC LIMIT $inicio,$registros
            ");
            $datos= $datos->fetchAll();

            $total= $conexion->query("SELECT FOUND_ROWS()");
            $total= (int) $total->fetchColumn();

            $NPaginas= ceil($total/$registros);

            
            return $tabla;
        }

    }