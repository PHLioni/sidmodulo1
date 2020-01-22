<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cadastro extends CI_Controller
{

    public function criaCadastro()
    {
        $this->load->view('telas/cadastro');
    }
}
