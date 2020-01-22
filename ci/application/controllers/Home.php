<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function index()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        }
        $usuario = $this->session->userdata('usuario_logado');
        $this->load->model('Pedidos_model');
        $pedidosHome = $this->Pedidos_model->pedidosHome($usuario['ddd']);
        $dados = array('pedidosHome' => $pedidosHome);
        $this->load->helper('formataTextos');
        $this->load->helper('formataData');

        $this->load->template('telas/home', $dados);
    }
}
