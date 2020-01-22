<?php include 'vendor/modal/modalCadastraMac.php' ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h2>Estoque de Equipamentos <?= $cidadeEscolhida ?></h2>
    <?php $cidade = str_replace(" ", "+", $cidadeEscolhida) ?>
    <a href=<?= site_url("estoque/estoqueEquipamentos?selecionaCidade=$cidade") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>
</div>
<h6>Quantidade de Equipamentos: <?= $quantidade['qtd'] ?></h6>
<h6>Valor Total: <?= numReais($quantidade['qtd'] * $quantidade['valor_un']) ?></h6>


<button <?php foreach ($modelos as $e) : ?> <?= $codigoItem = $e['codigoItem'] ?> <?= $item = $e['item'] ?> <?= $tecnologia = $e['tecnologia'] ?> <?= $cidade = $e['cidade'] ?> <?= $sp= $e['sp'] ?> <?php endforeach ?> type="button" id="macBtn" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#cadastraMac" data-codigo="<?php echo $codigoItem; ?>" data-item="<?php echo $item; ?>" data-tecnologia="<?php echo $tecnologia; ?>" data-cidade="<?php echo $cidade; ?>" data-sp="<?php echo $sp; ?>">Cadastrar Equipamento</button>


<?php if ($this->session->flashdata('success')) : ?>
    <h6 class="alert alert-success"><?= $this->session->flashdata('success') ?></h6>
<?php elseif ($this->session->flashdata('danger')) : ?>
    <h6 class="alert alert-danger"><?= $this->session->flashdata('danger') ?></h6>
<?php endif ?>

<div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 600px;">
    <table id="tabela" class="table table-striped table-bordered table-sm text-center" cellspacing="0" width="100%">
        <thead>
            <tr class="table-info">
                <th>Serial</th>
                <th>Código</th>
                <th>Modelo</th>
                <th>Tecnologia</th>
                <th colspan="3">Ações</th>
            </tr>

            <tr>
                <th><input type="text" id='filtro' class="form-control form-control-sm" placeholder="Serial"></th>

                <th colspan="6" style="background-color: #B0E0E6"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estoque as $e) : ?>

                <tr>
                    <td id='codigoItem'><?= html_escape($e['mac']) ?></td>
                    <td id='codigoItem'><?= html_escape($e['codigoItem']) ?></td>
                    <td><?= html_escape($e['item']) ?></td>
                    <td><?= html_escape($e['tecnologia']) ?></td>
                    <td><a href=<?= site_url("estoque/deletaMac?id=$e[id]&cidade=$e[cidade]&codigo=$e[codigoItem]") ?>><span class="fas fa-trash" style="color:red"></span></a></td>

                </tr>
            <?php endforeach ?>
        </tbody>

    </table>

    </body>

    </html>