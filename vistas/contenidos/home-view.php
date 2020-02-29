<?php
    if($_SESSION['tipo_sbp']!="Administrador"){
        echo $lc->forzar_cierre_sesion_controlador();
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles">Sistema <small>Ventanas</small></h1>
    </div>
</div>
<div class="full-box text-center" style="padding: 30px 10px;">
    <?php
        require "./controladores/administradorControlador.php";
        $IAdmin= new administradorControlador();
        $CAdmin= $IAdmin->datos_administrador_controlador("Conteo",0);
    ?>
    <article class="full-box tile">
        <div class="full-box tile-title text-center text-titles text-uppercase">
            Administradores
        </div>
        <div class="full-box tile-icon text-center">
            <i class="zmdi zmdi-account"></i>
        </div>
        <div class="full-box tile-number text-titles">
            <p class="full-box"><?php echo $CAdmin->rowCount(); ?></p>
            <small>Registrados</small>
        </div>
    </article>

    <?php
        require "./controladores/clienteControlador.php";
        $ICliente= new clienteControlador();
        $CClientes= $ICliente->datos_cliente_controlador("Conteo",0);
    ?>
    <article class="full-box tile">
        <div class="full-box tile-title text-center text-titles text-uppercase">
            Clientes
        </div>
        <div class="full-box tile-icon text-center">
            <i class="zmdi zmdi-male-alt"></i>
        </div>
        <div class="full-box tile-number text-titles">
            <p class="full-box"><?php echo $CClientes->rowCount(); ?></p>
            <small>Registrados</small>
        </div>
    </article>

    <article class="full-box tile">
        <div class="full-box tile-title text-center text-titles text-uppercase">
            Estudiantes
        </div>
        <div class="full-box tile-icon text-center">
            <i class="zmdi zmdi-face"></i>
        </div>
        <div class="full-box tile-number text-titles">
            <p class="full-box">70</p>
            <small>Registrados</small>
        </div>
    </article>
</div>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles">Sistema <small>Bitácora</small></h1>
    </div>
    <section id="cd-timeline" class="cd-container">
        <?php
            require "./controladores/bitacoraControlador.php";
            $IBitacora= new bitacoraControlador();

            echo $IBitacora->listado_bitacora_controlador(10);
        ?>
    </section>
</div>