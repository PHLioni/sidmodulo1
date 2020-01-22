<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">

    <h2>Cadastrar Técnicos</h2>
    <a href=<?= site_url("home/index") ?> class="btn btn-secondary ml-2 mb-1"> Voltar</a>
</div>

<?php
$ddds = array(
    'ddd12' => 'ddd12',
    'ddd13' => 'ddd13',
    'ddd14' => 'ddd14',
    'ddd15' => 'ddd15',
    'ddd16' => 'ddd16',
    'ddd17' => 'ddd17',
    'ddd18' => 'ddd18',
    'ddd19' => 'ddd19',
    
);

$ddd = $this->session->userdata("usuario_logado", "ddd");


echo form_open("tecnicos/cadastraTecnico");

echo form_label('Login', 'login');
echo form_input(array(
    'name' => 'login',
    'id' => 'login',
    'class' => 'form-control',
    'maxlength' => '255',
    'style' => 'width:15%',
    'required' => 'true',
));

echo form_label('Nome', 'nome');
echo form_input(array(
    'name' => 'nome',
    'id' => 'nome',
    'class' => 'form-control',
    'maxlength' => '255',
    'style' => 'width:50%',
    'required' => 'true'
));

echo form_label('UN', 'un');
echo form_input(array(
    'name' => 'un',
    'id' => 'un',
    'class' => 'form-control',
    'maxlength' => '255',
    'style' => 'width:15%',
    'required' => 'true'
));

echo form_label('Cidade', 'cidade');
echo form_input(array(
    'name' => 'cidade',
    'id' => 'cidade',
    'class' => 'form-control',
    'maxlength' => '255',
    'style' => 'width:30%',
    'required' => 'true', 
));

echo form_label('DDD', 'ddd');
echo form_input(array(
    'name' => 'ddd',
    'id' => 'ddd',
    'class' => 'form-control',
    'maxlength' => '255',
    'style' => 'width:30%',
    'required' => 'true',
    'value' => $ddd["ddd"],
    'required' => 'true',
    'readonly' => 'true'
));

echo form_label('Responsável', 'responsavel');
echo form_input(array(
    'name' => 'responsavel',
    'id' => 'responsavel',
    'class' => 'form-control',
    'maxlength' => '255',
    'style' => 'width:30%;',
    'required' => 'true'
));

echo form_button(array(
    'class' => 'btn btn-info btn-block mt-2 mb-2',
    'content' => 'Cadastrar',
    'type' => 'submit',
    'style' => 'width:30%;',
    'required' => 'true'

));

echo form_close();



?>
<?php if ($this->session->flashdata('success')) : ?>
    <h5 class="alert alert-success"><?= $this->session->flashdata('success'); ?></h5>
<?php elseif($this->session->flashdata('dan')) : ?>
    <h5 class="alert alert-danger"><?= $this->session->flashdata('dan'); ?></h5>
<?php endif ?>