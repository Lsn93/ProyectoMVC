<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class cuentaControlador extends mainModel{

        public function datos_cuenta_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            
            return mainModel::datos_cuenta($codigo);
        }

        public function actualizar_cuenta_controlador(){
            $CuentaCodigo=mainModel::decryption($_POST['CodigoCuenta-up']);
            $CuentaTipo=mainModel::decryption($_POST['tipoCuenta-up']);

            $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='$CuentaCodigo'");
            $DatosCuenta=$query1->fetch();

            $user=mainModel::limpiar_cadena($_POST['user-log']);
            $password=mainModel::limpiar_cadena($_POST['password-log']);
            $password=mainModel::encryption($password);

            if($user!="" && $password!=""){
                if(isset($_POST['privilegio-up'])){
                    $login=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password'");
                }else{
                    $login=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password' AND CuentaCodigo='$CuentaCodigo'");
                }

                if($login->rowCount()==0){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El nombre de usuario y clave que acaba de ingresar no coinciden con los datos de su cuenta",
                        "Tipo" => "error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Para actualizar los datos de la cuenta debe de ingresar el nombre de usuario y clave, por favor ingrese los datos e intente nuevamente",
                    "Tipo" => "error"
                ];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            //VERIFICAR USUARIO
            $CuentaUsuario=mainModel::limpiar_cadena($_POST['usuario-up']);
            if($CuentaUsuario!=$DatosCuenta['CuentaUsuario']){
                $query2=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$CuentaUsuario'");
                if($query2->rowCount()>=1){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El nombre de usuario que acaba de ingresar ya se encuentra registrado en el sistema",
                        "Tipo" => "error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            //VERIFICAR EMAIL
            $CuentaEmail=mainModel::limpiar_cadena($_POST['email-up']);
            if($CuentaEmail!=$DatosCuenta['CuentaEmail']){
                $query3=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$CuentaEmail'");
                if($query3->rowCount()>=1){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El nombre de usuario que acaba de ingresar ya se encuentra registrado en el sistema",
                        "Tipo" => "error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }


            $CuentaGenero=mainModel::limpiar_cadena($_POST['optionsGenero-up']);
            if(isset($_POST['optionsEstado-up'])){
                $CuentaEstado=mainModel::limpiar_cadena($_POST['optionsEstado-up']);
            }else{
                $CuentaEstado=$DatosCuenta['CuentaEstado'];
            }

            if($CuentaTipo=="admin"){
                if(isset($_POST['optionsPrivilegio-up'])){
                    $CuentaPrivilegio=mainModel::decryption($_POST['optionsPrivilegio-up']);
                }else{
                    $CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
                }

                if($CuentaGenero=="Masculino"){
                    $CuentaFoto="Male3Avatar.png";
                }else{
                    $CuentaFoto="Female3Avatar.png";
                }
            }else{
                $CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
                if($CuentaGenero=="Masculino"){
                    $CuentaFoto="Male2Avatar.png";
                }else{
                    $CuentaFoto="Female2Avatar.png";
                }
            }




        }

    }