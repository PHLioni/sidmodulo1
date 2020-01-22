<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h2>Histórico de Transferências</h2>
    <a href=<?= site_url("home/index") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>

</div>
<form class="form-group">
    <div class="row ml-1">
        <label for="ddd" class="label ml-1 mr-2 " style="font-size:1.5em;">Segmento: </label>
        <select class="form-control" name='segmento' style="width:25%;" id="ddd">
            <option>Miscelaneas</option>
            <option>Equipamentos</option>
            <option>Rede</option>
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
            <th>Código</th>
            <th>Item</th>
            <th>Quantidade</th>
            <th>Grupo</th>
            <th>Cidade Origem</th>
            <th>Cidade Destino</th>
            <th>Data Transferência</th>
            <th>Usuário</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transferencias as $e) : ?>    
            <tr>
               <td><?= $e['codigoItem']?></td>
               <td><?= $e['item']?></td>
               <td><?= $e['quantidade']?></td>
               <td><?= $e['grupo']?></td>
               <td><?= $e['cidadeOrigem']?></td>
               <td><?= $e['cidadeDestino']?></td>
               <td><?= dataBR($e['data_transferencia'])?></td>
               <td><?= $e['quem']?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>