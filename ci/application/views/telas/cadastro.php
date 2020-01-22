<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="icon" type="imagem/png" href="../img/logo-claro-512.png" />

</head>

<body style="background-image:url(<?= base_url('img/wall10.jpg') ?>);">
    <div class="container">
        <div class="container" style="width:300px; height:610px ;margin-top:160px;background:white; border-radius:8px; box-shadow: 0px 10px 25px #000000;">
            <img class="rounded mx-auto d-block" style="width:40%;" src="<?= base_url('img/logo-claro-512.png') ?>">
            <h3 style="text-align:center;">Cadastro de Usuario</h3>
            <?php
          $ddds = array(
            'DDD12' => 'DDD12',
            'DDD13' => 'DDD13',
            'DDD14' => 'DDD14',
            'DDD15' => 'DDD15',
            'DDD16' => 'DDD16',
            'DDD17' => 'DDD17',
            'DDD18' => 'DDD18',
            'DDD19' => 'DDD19',
            
        );

            echo form_open("autenticar/cadastrar");

            echo form_label("Nome", "nome");
            echo form_input(array(
                'name' => 'nome',
                'id' => 'nome',
                'class' => 'form-control',
                'maxlength' => '255'
            ));

            echo form_label("Sobrenome", "sobrenome");
            echo form_input(array(
                'name' => 'sobrenome',
                'id' => 'sobrenome',
                'class' => 'form-control',
                'maxlength' => '255'
            ));

            echo form_label("DDD", "ddd");
            echo form_dropdown(array(
                'name' => 'ddd',
                'id' => 'ddd',
                'class' => 'form-control',
                'maxlength' => '255'
            ),$ddds);

            echo form_label("Usuario", "usuario");
            echo form_input(array(
                'name' => 'usuario',
                'id' => 'usuario',
                'class' => 'form-control',
                'maxlength' => '255'
            ));

            echo form_label("Senha", "senha");
            echo form_input(array(
                'name' => 'senha',
                'id' => 'usuario',
                'class' => 'form-control',
                'maxlength' => '255',
                'type' => 'password'
            ));

            echo form_button(array(
                'class' => 'btn btn-info btn-block mt-2 mb-2',
                'content' => 'Cadastrar',
                'type' => 'submit',
            ));

            echo form_close();

            ?>
            <p class="alert-danger" style="text-align:center;"><?= $this->session->flashdata('danger'); ?></p>
        </div>
    </div>
</body>

</html>