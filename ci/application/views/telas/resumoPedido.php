<?php include 'vendor/modal/modalMiscelaneas.php'; ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h2>Resumo do Pedido</h2>



    <a href=<?= site_url("pedidos/fazerPedidosAdm?tecnico=$login") ?> class="btn btn-secondary ml-2 mb-1">Voltar</a>

</div>


<?php if ($this->session->flashdata('success')) : ?>
    <h6 class="alert alert-success"> <?= $this->session->flashdata('success'); ?></h6>
<?php elseif ($this->session->flashdata('danger')) : ?>
    <h6 class="alert alert-success"> <?= $this->session->flashdata('danger'); ?></h6>
<?php endif ?>

<div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 700px;">
    <table class="table table-striped table-bordered table-sm text-center" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="th-sm" style="width: 15%">Código
                </th>
                <th class="th-sm">Item
                </th>
                <th class="th-sm">Quantidade
                </th>
                <th colspan="2">Ações</th>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($pedido as $e) : ?>
                <tr>
                    <td id="codigoItem"><?= $e['codigoItem'] ?></td>
                    <td id="item"><?= $e['item'] ?></td>
                    <td id="quantidade"><?= $e['quantidade'] ?></td>
                    <td><a href=<?= site_url("pedidos/deletaPedidoResumo?id=$e[id]&codigo=$e[codigoItem]&login=$login") ?>><span class="fas fa-trash" style="color:red"></span></a></td>
                    
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href=<?= site_url("pedidos/finalizaPedido?tecnico=$login") ?> class="btn btn-success mt-3" style="margin-left: 85%;">Finalizar Pedido</a>
</div>