<?php include 'vendor/modal/modalAddMac.php'; ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Técnico: <?= $nomeTecnico ?> | Área: <?= $un ?></h1>

    <a href=<?= site_url("home/index") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>
    <?php $nome = str_replace(' ', '+', $nomeTecnico); ?>
</div>
<a href=<?= site_url("pedidos/pagaPedido?num_pedido=$num_pedido&tecnico=$nome&login=$login") ?> class="btn btn-primary mb-1" style="color:white;">Pagar Pedido</a>
<a href=<?= site_url("pedidos/deletaPedido?num_pedido=$num_pedido&tecnico=$nome") ?> class="btn btn-danger mb-1" style="color:white;">Deletar</a>
<h6 class="text text-danger"><?= $this->session->flashdata('danger') ?></h6>
<h6 class="text text-success"><?= $this->session->flashdata('success') ?></h6>
<table class="table table-sm table-bordered table-hover text-center ">
    <thead>
        <tr class="table-info">
            <th>Código Item</th>
            <th>Item</th>
            <th>Quantidade</th>
            <th>Serial</th>
            <th>Inserir Serial</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dados as $p) : ?>
            <tr>
                <td id='codigoItem'><?= $codigoItem = $p['codigoItem'] ?></td>
                <td><?= $p['item'] ?></td>
                <td><?= $p['quantidade'] ?></td>
                <td><?= $p['mac'] ?></td>
                <?php if ($p['grupo'] == 'EQUIPAMENTOS') : ?>
                    <td style="width: 15%;"><a id='adicionaMacBtn' data-toggle="modal" data-target="#adicionaMac" data-codigo="<?php echo $p['codigoItem']; ?>" data-numpedido="<?php echo $num_pedido; ?>" data-tecnico="<?php echo $nome; ?>" data-cidade="<?php echo $cidade; ?>" data-un="<?php echo $un; ?>" data-login="<?php echo $login; ?>" data-item="<?php echo $p['item']; ?>" data-id="<?php echo $p['id']; ?>"><span class="fas fa-plus" style="color:green"></a></span></td>
                <?php else : ?>
                    <td></td>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
    </tbody>

</table>

<!--
<script>
    function modaAddProduto() {
        $('#modalAddProdutos').modal('show');
        var codigoItem2 = $('tr').children('codigoItem');
        console.log(codigoItem2);
        $('#nome').val(codigoItem2);
    }

    function modalDelete($id) {
        $('#modalDelete').modal('show');
        var id = $id;
        $('#Yes').ajaxForm({
            success: function(data) {
                //alert("hello");
                window.location.href = '<?= base_url("/index.php/Obras/Obras/removeProdutosObras/") ?>' + id;
            }
        });
    }
</script>
-->