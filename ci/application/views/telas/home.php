<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pedidos</h1> <?php if ($this->session->flashdata('danger')) : ?>
        <h5 class="alert alert-danger"><?= $this->session->flashdata('danger'); ?></h5>
    <?php elseif ($this->session->flashdata('success')) : ?>
        <h5 class="alert alert-success"><?= $this->session->flashdata('success'); ?></h5>
    <?php endif ?>
    <p style="font-size: .7em;">Desenvolvido por Pedro Lioni - N5948063</p>

</div>

<div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 700px;">
    <table class="table table-sm table-bordered table-striped text-center">
        <thead>
            <tr class="table-info">
                <th>Nome</th>
                <th>Itens</th>
                <th>Quantidade</th>
                <th>Data do Pedido</th>

                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidosHome as $p) : ?>
                <tr>
                    <td><?php $textoUrl = textoUrl($p['nome']);
                        $cidade = textoUrl($p['cidade']);
                        $un = textoUrl($p['un']);
                        $num_pedido = textoUrl($p['num_pedido']);
                        $login = textoUrl($p['login']);
                        $grupo = textoUrl($p['grupo']); ?>
                        <a href=<?= site_url("pedidos/pedidosDetalhe?login=$login&tecnico=$textoUrl&cidade=$cidade&un=$un&num_pedido=$num_pedido&grupo=$grupo") ?>>
                            <?= html_escape($p['nome']) ?></a></td>
                    <td><?= html_escape($p['quantidade']) ?></td>
                    <td><?= html_escape($p['itens']) ?></td>
                    <td><?= html_escape(dataBR($p['data_pedido'])) ?></td>
                    <td class="bg-warning"><?= $p['status'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>


</div>

