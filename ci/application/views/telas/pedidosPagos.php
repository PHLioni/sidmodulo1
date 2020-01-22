<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Pedidos Pagos este Mês <span class="badge badge-success"><?= $pedidosMes ?></span></h1>

    <a href=<?= site_url("home/index") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>

</div>

<form class="form-group">
    <div class="row ml-1">
        <label for="ddd" class="label ml-1 mr-2 " style="font-size:1.5em;">Cidade: </label>
        <select class="form-control" name='cidadeEscolhida' style="width:25%;" id="ddd">
        <option ><?= $cidade ?></option>
            <?php foreach ($cidades as $c) : ?>
                <option><?= $c['cidade'] ?></option>
            <?php endforeach ?>
        </select>
        <label for="ddd" class="label ml-1 mr-2 ml-3" style="font-size:1.5em;">Data: </label>
        <select class="form-control" name='dataEscolhida' style="width:25%;" id="ddd">

            <?php foreach ($data_pagamento as $d) : ?>               
                <?php if ($d['data_pagamento'] != '0000-00-00') : ?>
                    <option><?= date("d/m/Y", strtotime($d['data_pagamento'])) ?></option>
                <?php else : ?>
                    <option>-</option>
                <?php endif ?>
            <?php endforeach ?>
        </select>
        <button type="submit" action="pedidos/buscaPedidosFiltro" class="btn btn-info ml-2 mb-2 mr-3"> Selecionar</button>

</form>

<table class="table table-sm table-bordered table-striped text-center">
    <thead>
        <tr class="table-info">
            <th>Nome</th>
            <th>Itens</th>
            <th>Quantidade</th>
            <th>Data do Pedido</th>
            <th>Status</th>
            <th>Usuário</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pedidosPagos as $p) : ?>
            <tr>
                <td><?php $textoUrl = textoUrl($p['nome']);
                    $cidade = textoUrl($p['cidade']);
                    $un = textoUrl($p['un']);
                    $num_pedido = textoUrl($p['num_pedido']); ?>
                    <a href=<?= site_url("pedidos/pedidosDetalhePago?tecnico=$textoUrl&cidade=$cidade&un=$un&num_pedido=$num_pedido") ?>>
                        <?= $p['nome'] ?></a></td>
                <td><?= $p['quantidade'] ?></td>
                <td><?= $p['itens'] ?></td>
                <td><?= dataBR($p['data_pedido']) ?></td>
                <td class="bg-success" style="color: white;"><?= $p['status'] ?></td>
                <td><?= $p['quem'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>

</table>