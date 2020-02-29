<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>EMPRESA</small></h1>
    </div>
    <p class="lead">Lista de todas las empresas registradas en el sistema:</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>company/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVA EMPRESA
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>companylist/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE EMPRESAS
            </a>
        </li>
    </ul>
</div>
<?php
    require_once "./controladores/empresaControlador.php";
    $insEmpresa = new empresaControlador();
?>
<!-- panel lista de empresas -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE EMPRESAS</h3>
        </div>
        <div class="panel-body">
            <?php
                $pagina = explode("/", $_GET['views']);
                echo $insEmpresa->paginador_empresa_controlador($pagina[1],10,$_SESSION['privilegio_sbp']);
            ?>
        </div>
    </div>
</div>