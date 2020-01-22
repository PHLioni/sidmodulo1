<?php include 'vendor/modal/modalAddPedido.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h2>Realizar Pedido</h2>
    <a href=<?= site_url("home/index") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>
</div>

<form class="form-group">
    <div class="row ml-1">
        <label for="ddd" class="label ml-1 mr-2 " style="font-size:1.5em;">Técnico: </label>
        <input type="text" name="tecnico" style="width:15%;" class="form-control" placeholder="Login">
        <button type="submit" action="pedidos/fazerPedidosAdm" class="btn btn-info ml-2 mb-2 mr-3"> Buscar</button>
    </div>
</form>

<div class="mt-4">
    <?php if ($tecnico) :  ?>
        <p>Nome: <?= $tecnico['nome'] ?> </p>
        <p>Área: <?= $tecnico['un'] ?> </p>
        <p>Cidade: <?= $tecnico['cidade'] ?> </p>
        <p>Responsável: <?= $tecnico['responsavel'] ?> </p>
    <?php else : ?>
        <p class="alert alert-danger" style="width: 25%;">Técnico não encontrado!</p>
    <?php endif ?>
</div>

<div class="row mt-4"></div>
<div class="col-sm-12 col-md-6"></div>
<div class="col-sm-12 col-md-6"></div>
<?php if ($this->session->flashdata('add')) : ?>
    <h6 class="alert alert-success"><?= $this->session->flashdata('add') ?></h6>
<?php elseif ($this->session->flashdata('success')) : ?>
    <h6 class="alert alert-success"><?= $this->session->flashdata('success') ?></h6>
<?php elseif ($this->session->flashdata('danger')) : ?>
    <h6 class="alert alert-danger"><?= $this->session->flashdata('danger') ?></h6>
<?php else : ?>
<?php endif ?>

<div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 400px;">
    <table id="tabela" class="table table-striped table-bordered table-sm text-center" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="th-sm" style="width: 15%">Código</th>
                <th class="th-sm">Item</th>
                <th class="th-sm">Estoque</th>
                <th class="th-sm">Grupo</th>
                <th class="th-sm">Adicionar</th>

            </tr>

            <tr>
                <th><input type="text" id='filtro' class="form-control form-control-sm" placeholder="Código"></th>
                <th><input type="text" id='filtro2' class="form-control form-control-sm" disabled></th>
                <th colspan="7" style="background-color: #B0E0E6"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estoque as $e) : ?>
                <tr>
                    <td id="codigoItem"><?= $e['codigoItem'] ?></td>
                    <td id="item"><?= $e['item'] ?></td>
                    <td id="quantidade"><?= $e['qtd'] ?></td>
                    <td id="grupo"><?= $e['grupo'] ?></td>

                    <td style="width: 15%;"><a id='adicionaBtn' data-toggle="modal" data-target="#adicionaPedido" data-codigo="<?php echo $e['codigoItem']; ?>" data-grupo="<?php echo $e['grupo']; ?>" data-item="<?php echo $e['item']; ?>" data-max="<?php echo $e['pedidoMax']; ?>" data-tecnico="<?php echo  $tecnico['login']; ?>"><span class="fas fa-plus" style="color:green"></a></span></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<a href=<?= site_url("pedidos/resumoPedido?tecnico=$tecnico[login]&cidade=$tecnico[cidade]") ?> class="btn btn-info mt-3" style="margin-left: 85%;">Verificar Pedido</a>



<script src="<?php echo base_url() ?>vendor/scripts/filtroPedido.js"></script>