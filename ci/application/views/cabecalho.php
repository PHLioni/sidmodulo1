<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Estoque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>vendor/css/scroll.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <!--<meta http-equiv="refresh" content="30">-->
    <link rel="icon" type="imagem/png" href="../../img/logo-claro-512.png" />
</head>

<body>
    <?php $nome = $this->session->userdata('usuario_logado', "nome"); ?>
    <?php $ddd = $this->session->userdata('usuario_logado', "ddd"); ?>
    <nav class="navbar navbar-dark bg-info flex-md-nowrap p-0 shadow">
        <a href="#" class="navbar-brand col-sm-3 col-md-2 mr-0">Controle de Estoque - <?= $ddd['ddd'] ?></a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <?= anchor('autenticar/logout', 'Sair', array('class' => 'nav-link')) ?>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar" style="min-height:840px;">
                <div class="sidebar-sticky">

                    <div class="row">
                        <div class="sidebar text-center border-bottom border-secondary">
                            <img class="img-circle" src="../../img/avatar.jpg" style="width: 40%; margin-top:10%;">
                            <h3 style="color:white;"><?= $nome['nome'] ?></h3>
                        </div>
                        <ul class="nav flex-column">

                            <li class="nav-item border-bottom border-primary">
                                <a href=<?= site_url("home/index") ?> class="nav-link active text-info">
                                    <span class="fa fa-list"></span>
                                    Pedidos
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>

                            <li class="active">

                                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="nav-link active text-info"><span class="fa fa-boxes mr-1"> </span>Estoque</a>
                            <li class="nav-item border-bottom border-primary">
                                <ul class="collapse list-unstyled ml-4" id="homeSubmenu">

                                    <li>
                                        <a href=<?= site_url("estoque/estoqueEquipamentos") ?> class="nav-link active text-info"> <span class="fa fa-angle-double-right mr-1"></span>Equipamentos</a>
                                    </li>
                                    <li>
                                        <a href=<?= site_url("estoque/estoqueMiscelaneas") ?> class="nav-link active text-info"> <span class="fa fa-angle-double-right mr-1"></span>Miscelâneas</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link active text-info"> <span class="fa fa-angle-double-right mr-1"></span>Rede</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item border-bottom border-primary">
                                <a href=<?= site_url("pedidos/fazerPedidosAdm") ?> class="nav-link active text-info">
                                    <span class="fas fa-cart-plus"></span>
                                    Fazer Pedido
                                </a>
                            </li>
                            <li class="nav-item border-bottom border-primary">
                                <a href=<?= site_url("tecnicos/dadosTecnico") ?> class="nav-link active text-info">
                                    <span class="fas fa-user"></span>
                                    Adicionar Tecnico
                                </a>
                            </li>


                            <li class="active">

                                <a href="#historico" data-toggle="collapse" aria-expanded="false" class="nav-link active text-info"><span class="fa fa-history mr-1"></span>Histórico</a>
                            <li class="nav-item border-bottom border-primary">
                                <ul class="collapse list-unstyled ml-4" id="historico">

                                    <li>
                                        <a href=<?= site_url("pedidos/pedidosPagos") ?> class="nav-link active text-info"> <span class="fa fa-angle-double-right mr-1"></span>Pedidos Pagos</a>
                                    </li>
                                    <li>
                                        <a href=<?= site_url("tecnicos/tecnicosCadastrados") ?> class="nav-link active text-info"> <span class="fa fa-angle-double-right mr-1"></span>Técnicos</a>
                                    </li>
                                    <!--
                                    <li>
                                        <a href=<?= site_url("transferencias/historicoTransferencias") ?> class="nav-link active text-info"> <span class="fa fa-angle-double-right mr-1"></span>Transferências</a>
                                    </li>
                                    -->
                                </ul>
                            </li>

                        </ul>

                    </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">