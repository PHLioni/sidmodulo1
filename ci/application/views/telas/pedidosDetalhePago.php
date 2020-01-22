<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Técnico: <?= $nomeTecnico ?> | Área: <?= $un ?></h1>

    <a href=<?= site_url("pedidos/pedidosPagos") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>
    <?php $nome = str_replace(' ', '+', $nomeTecnico); ?>
</div>

<table class="table table-sm table-bordered table-hover text-center ">
    <thead>
        <tr class="table-info">
            <th>Serial</th>
            <th>Código Item</th>
            <th>Item</th>
            <th>Quantidade</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dados as $p) : ?>
            <tr>
                <td id='mac'><?= $codigoItem = $p['mac'] ?></td>
                <td id='codigoItem'><?= $codigoItem = $p['codigoItem'] ?></td>
                <td><?= $p['item'] ?></td>
                <td><?= $p['quantidade'] ?></td>
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