<?php include 'vendor/modal/modalAtualizaTecnico.php' ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h2>Técnicos Cadastrados - <?= $cidadeEscolhida ?></h2>
    <a href=<?= site_url("home/index") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>

</div>

<form class="form-group">
    <div class="row ml-1">
        <label for="ddd" class="label ml-1 mr-2 " style="font-size:1.5em;">Cidade: </label>
        <select class="form-control" name='selecionaCidade' style="width:25%;" id="ddd">
            <?php foreach ($cidades as $c) : ?>
                <option><?= $c['cidade'] ?></option>
            <?php endforeach ?>
        </select>
        <button type="submit" action="tecnicos/tecnicosCadastrados" class="btn btn-info ml-2 mb-2 mr-3"> Selecionar</button>
        <?php if ($this->session->flashdata('success')) : ?>
            <h6 style="color: green"><?= $this->session->flashdata('success'); ?></h6>
        <?php elseif ($this->session->flashdata('danger')) : ?>
            <h6 style="color:red"><?= $this->session->flashdata('danger'); ?></h6>
        <?php endif ?>
</form>

<table class="table table-sm table-bordered table-striped mt-1 text-center">
    <thead>
        <tr class="table-info">
            <th>Login</th>
            <th>Nome</th>
            <th>UN</th>
            <th>Cidade</th>
            <th>Responsável</th>
            <th colspan="2">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tecnicos as $e) : ?>
            <tr>
                <td id='login'><?= $e['login'] ?></td>
                <td><?= $e['nome'] ?></td>
                <td><?= $e['un'] ?></td>
                <td><?= $e['cidade'] ?></td>
                <td><?= $e['responsavel'] ?></td>
                <td><a href=<?= site_url("tecnicos/deletaTecnico?id=$e[id]&cidade=$e[cidade]&login=$e[login]") ?>><span class="fas fa-trash" style="color:red"></span></a></td>
                <td><a id="editaTecnicoBtn" style="color:green" role="button" data-toggle="modal" data-target="#editaTecnico" data-login="<?php echo $e['login']; ?>" data-nome="<?php echo $e['nome']; ?>" data-ddd="<?php echo $e['ddd']; ?>"  data-un="<?php echo $e['un']; ?>" data-cidade="<?php echo $e['cidade']; ?>" data-responsavel="<?php echo $e['responsavel']; ?>">
                        <span class=" fas fa-edit" style="color:green"></a></span></td>
                        
            </tr>
        <?php endforeach ?>
    </tbody>

</table>


<script src="<?php echo base_url() ?>vendor/scripts/atualizaTecnico.js"></script>