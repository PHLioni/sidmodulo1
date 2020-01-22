<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Controle extends CI_Controller
{

    public function pedidosDetalhe()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {

            $nomeTecnico = $this->input->get('tecnico');
            $cidade = $this->input->get('cidade');
            $un = $this->input->get('un');
            $num_pedido = $this->input->get('num_pedido');

            $this->load->model('pedidos_model');
            $pedidoTecnico = $this->pedidos_model->buscaPedido($nomeTecnico, $cidade, $un);


            $dado = array(
                'nomeTecnico' => $nomeTecnico, 'un' => $un, 'cidade' => $cidade,
                'dados' => $pedidoTecnico, 'num_pedido' => $num_pedido
            );


            $this->load->helper('formataData');
            $this->load->helper('formataTextos');
            $this->load->template('telas/pedidosDetalhe', $dado);
        }
    }
    public function pagaPedido()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {

            $num_pedido = $this->input->get('num_pedido');
            $nomeTecnico = $this->input->get('tecnico');

            $nome = str_replace('+', ' ', $nomeTecnico);

            $this->load->model('pedidos_model');
            $this->pedidos_model->pagaPedido($num_pedido);

            $dados = array();
            $this->session->set_flashdata('success', 'O pedido do Técnico ' . $nome . ' foi pago!');

            redirect('home/index', $dados);
        }
    }

    public function deletaPedido()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {

            $num_pedido = $this->input->get('num_pedido');
            $nomeTecnico = $this->input->get('tecnico');

            $nome = str_replace('+', ' ', $nomeTecnico);

            $this->load->model('pedidos_model');
            $this->pedidos_model->deletaPedido($num_pedido);


            $dados = array();
            $this->session->set_flashdata('danger', 'O pedido do Técnico ' . $nome . ' foi deletado!');

            redirect('home/index', $dados);
        }
    }

    
    public function pedidosDetalhePago()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {

            $nomeTecnico = $this->input->get('tecnico');
            $cidade = $this->input->get('cidade');
            $un = $this->input->get('un');
            $num_pedido = $this->input->get('num_pedido');

            $this->load->model('pedidos_model');
            $pedidoTecnico = $this->pedidos_model->buscaPedido($nomeTecnico, $cidade, $un);


            $dado = array(
                'nomeTecnico' => $nomeTecnico, 'un' => $un, 'cidade' => $cidade,
                'dados' => $pedidoTecnico, 'num_pedido' => $num_pedido
            );


            $this->load->helper('formataData');
            $this->load->helper('formataTextos');
            $this->load->template('telas/pedidosDetalhePago', $dado);
        }
    }


    
}
