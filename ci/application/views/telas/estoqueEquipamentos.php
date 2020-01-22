<?php include 'vendor/modal/modalEquipamentos.php' ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h2>Estoque de Equipamentos <?= $cidadeEscolhida ?></h2>
    <a href=<?= site_url("home/index") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>
</div>

<form class="form-group">
    <div class="row ml-1">
        <label for="ddd" class="label ml-1 mr-2 " style="font-size:1.5em;">Cidade: </label>
        <select class="form-control" name='selecionaCidade' style="width:25%;" id="ddd">
        <option ><?= $cidadeEscolhida?></option>
            <?php foreach ($cidades as $c) : ?>
                <option><?= $c['cidade'] ?></option>
                <?php $sp = $c['grupo']?>
            <?php endforeach ?>
        </select>
        <button type="submit" action="estoque/estoqueMiscelaneas" class="btn btn-info ml-2 mb-2 mr-3"> Selecionar</button>
</form>

<button type="button" id='btnCadastraMis' class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#cadastraItem" data-sp="<?php echo $sp;?>">Cadastrar Modelo</button>

<div class="row mt-4"></div>
<div class="col-sm-12 col-md-6"></div>
<div class="col-sm-12 col-md-6"></div>
<?php if ($this->session->flashdata('success')) : ?>
    <h6 class="alert alert-success"><?= $this->session->flashdata('success') ?></h6>
<?php elseif ($this->session->flashdata('danger')) : ?>
    <h6 class="alert alert-danger"><?= $this->session->flashdata('danger') ?></h6>
<?php endif ?>


<div class="table-wrapper-scroll-y my-custom-scrollbar" style="height: 600px; width:100%;">
    <table id="tabela" class="table table-striped table-bordered table-sm text-center" cellspacing="0" width="100%">
        <thead>
            <tr class="table-info">
                <th>Código</th>
                <th>Modelo</th>
                <th>Tecnologia</th>
                <th>Valor Un.</th>
                <th colspan="3">Ações</th>
            </tr>

            <tr>
                <th><input type="text" id='filtro' class="form-control form-control-sm" placeholder="Código"></th>
                <th><input type="text" id='filtro' class="form-control form-control-sm" placeholder="Item"></th>
                <th colspan="7" style="background-color: #B0E0E6"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estoque as $e) : ?>
                <tr>
                    <td id='codigoItem'><?= html_escape($e['codigoItem']) ?></td>
                    <?php $cidade = str_replace(" ", "+", $cidadeEscolhida) ?>
                    <td><a href=<?= site_url("estoque/seriais?codigoItem=$e[codigoItem]&cidade=$cidade") ?>> <?= html_escape($e['item']) ?></a></td>
                    <td><?= html_escape($e['tecnologia']) ?></td>
                    <td><?= html_escape(numReais($e['valor_un'])) ?></td>
                    <td><a href=<?= site_url("estoque/deletaModelo?id=$e[id]&cidade=$e[cidade]&codigo=$e[codigoItem]&item=$e[item]") ?>><span class="fas fa-trash" style="color:red"></span></a></td>


                    <td><a id='editaEquipamentoBtn' data-toggle="modal" data-target="#editaEquipamento" data-codigo="<?php echo $e['codigoItem']; ?>" data-item="<?php echo $e['item']; ?>" data-tecnologia="<?php echo $e['tecnologia']; ?>" data-valor="<?php echo $e['valor_un']; ?>" data-id="<?php echo $e['id']; ?>"><span class="fas fa-edit" style="color:blue"></a></span></td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
    <script src="<?php echo base_url() ?>vendor/scripts/filtros.js"></script>
    </body>

    </html>