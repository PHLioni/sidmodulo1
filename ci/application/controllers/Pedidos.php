<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Pedidos extends CI_Controller
{

    public function fazerPedidosAdm()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $login = $this->input->get('tecnico');
            $user = $this->session->userdata('usuario_logado');
            $ddd = $user['ddd'];

            $this->load->model('tecnicos_model');
            $tecnico = $this->tecnicos_model->buscaT($login, $ddd);

            $t = $tecnico['cidade'];

            $this->load->model('estoque_model');
            $estoque = $this->estoque_model->buscaMiscelaneasPedido($t);

            $dados = array('tecnico' => $tecnico, 'estoque' => $estoque);

            $this->load->template('telas/fazerPedidosAdm', $dados);
        }
    }


    public function pedidosPagos()
    {

        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {

            $usuario = $this->session->userdata('usuario_logado');
            $this->load->model('estoque_model');
            $cidades = $this->estoque_model->cidadesEstoque($usuario['ddd']);

            $cidade = $this->input->get('cidadeEscolhida');
            $dataE = $this->input->get('dataEscolhida');
            $dataTratada = str_replace('/', '-', $dataE);
            $data = date("Y/m/d", strtotime($dataTratada));

            $this->load->model('Pedidos_model');
            $pedidosPagos = $this->Pedidos_model->pedidosPagos($usuario['ddd'], $cidade, $data);


            $data_pagamento = $this->Pedidos_model->buscaData();

            $mes = date('m');

            $ddd = $this->session->userdata('usuario_logado', 'ddd');

            $totalMes = $this->Pedidos_model->calculaMes($mes, $ddd['ddd']);



            $dados = array(
                'pedidosPagos' => $pedidosPagos, 'cidades' => $cidades, 'cidade' => $cidade, 'data_pagamento' => $data_pagamento,
                'pedidosMes' => count($totalMes)
            );
            $this->load->helper('formataTextos');
            $this->load->helper('formataData');
            $this->load->template('telas/pedidosPagos', $dados);
        }
    }

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
            $login = $this->input->get('login');

            $this->load->model('pedidos_model');
            $pedidoTecnico = $this->pedidos_model->buscaPedido($nomeTecnico, $cidade, $un, $num_pedido);


            $dado = array(
                'nomeTecnico' => $nomeTecnico, 'un' => $un, 'cidade' => $cidade,
                'dados' => $pedidoTecnico, 'num_pedido' => $num_pedido, 'login' => $login
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
            $login = $this->input->get('login');    


            $nome = str_replace('+', ' ', $nomeTecnico);

            $this->load->model('pedidos_model');
            $this->pedidos_model->pagaPedido($num_pedido, $usuarioLogado['nome'], $login);

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
            $pedidoTecnico = $this->pedidos_model->buscaPedido($nomeTecnico, $cidade, $un, $num_pedido);


            $dado = array(
                'nomeTecnico' => $nomeTecnico, 'un' => $un, 'cidade' => $cidade,
                'dados' => $pedidoTecnico, 'num_pedido' => $num_pedido
            );

            $this->load->helper('formataData');
            $this->load->helper('formataTextos');
            $this->load->template('telas/pedidosDetalhePago', $dado);
        }
    }

    public function adicionaPedido()
    {

        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $tecnico = $this->input->post('tecnico');
            $item = $this->input->post('item');
            $codigoItem = $this->input->post('codigo');
            $quantidade = $this->input->post('quantidade');
            $grupo = $this->input->post('grupo');
            $pedidoMax = $this->input->post('max');


            $user = $this->session->userdata('usuario_logado');
            $ddd = $user['ddd'];

            $this->load->model('tecnicos_model');
            $buscaTecnico = $this->tecnicos_model->buscaT($tecnico, $ddd);

            $this->load->model('consumo_model');
            $consumo = $this->consumo_model->buscaConsumo($tecnico, $item);

            $this->load->model('pedidos_model');
            $pedidoTec = $this->pedidos_model->buscaQuantidade($tecnico, $item);

            $nome = $buscaTecnico['nome'];
            $un = $buscaTecnico['un'];
            $reponsavel = $buscaTecnico['responsavel'];
            $cidade = $buscaTecnico['cidade'];
            $ddd = $buscaTecnico['ddd'];
            $data_pedido = date('Y-m-d');
            $num_pedido = mt_srand();

            $this->load->model('pedidos_model');
            $pedido = $this->pedidos_model->criaResumo(
                $tecnico,
                $nome,
                $codigoItem,
                $item,
                $quantidade,
                $data_pedido,
                $reponsavel,
                $un,
                $cidade,
                $ddd,
                $grupo,
                $pedidoMax,
                $num_pedido,

            );

            if ($pedido == 'insuficiente') {
                $this->session->set_flashdata('danger',  $item . ' com saldo inferior ao solicitado!');
            } elseif ($pedido == 'equipamentos') {
                $this->session->set_flashdata('danger', 'Para equipamentos insira apenas 1 unidade!');
            } elseif ($pedido == 'maximo') {
                $this->session->set_flashdata('danger', 'Quantidade máxima: ' . $pedidoMax);
            } elseif ($pedido == 'pedidoMaximo') {
                $novoMaximo = 0;
                $novoMaximo = $pedidoMax - ($pedidoTec['quantidade'] - $consumo['valor']);
                $this->session->set_flashdata('danger', 'Você pode pedir no máximo ' . $novoMaximo . ' para completar o seu estoque!');
            } else {
                $this->session->set_flashdata('add',  $item . ' adicionado ao pedido.');
            }

            redirect("pedidos/fazerPedidosAdm?tecnico=$tecnico");
        }
    }

    public function resumoPedido()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $login = $this->input->get('tecnico');


            $data = date('Y-m-d');

            $this->load->model('pedidos_model');
            $pedido = $this->pedidos_model->buscaResumo($login, $data);

            $dados = array('login' => $login, 'pedido' => $pedido);

            $this->load->template('telas/resumoPedido', $dados);
        }
    }

    public function deletaPedidoResumo()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->get('id');
            $c = $this->input->get('cidade');
            $codigo = $this->input->get('codigo');
            $login = $this->input->get('login');

            $cidade = str_replace(' ', '+', $c);

            $this->load->model('pedidos_model');
            $this->pedidos_model->deleta($id);


            $dados = array();
            $this->session->set_flashdata('danger', 'Equipamento ' . $codigo . ' deletado!');
            redirect("pedidos/resumoPedido?tecnico=$login");
        }
    }

    public function atualizaResumo()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->post('id');
            $login = $this->input->post('login');
            $quantidade = $this->input->post('quantidade');
            $codigo = $this->input->post('codigo');

            $this->load->model('pedidos_model');
            $itemAtualizado = $this->pedidos_model->atualizaResumo($id, $quantidade);

            if (!$itemAtualizado) {
                $this->session->set_flashdata('danger', 'Item não pode ser atualizado!');
            } else {
                $this->session->set_flashdata('success', $codigo . ' atualizado com sucesso!');
            }

            redirect("pedidos/resumoPedido?tecnico=$login");
        }
    }


    public function finalizaPedido()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $login = $this->input->get('tecnico');
            $num_pedido = mt_rand();
            $cidade = $this->input->get('cidade');


            $this->load->model('pedidos_model');
            $pedidoPago = $this->pedidos_model->finaliza($login, $num_pedido, $cidade);

            $this->session->set_flashdata('success', 'Pedido realizado com sucesso!');
            redirect("pedidos/fazerPedidosAdm?tecnico=$login");
        }
    }

    public function adicionaMac()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->post('id');
            $mac = $this->input->post('mac');
            $login = $this->input->post('login');
            $num_pedido = $this->input->post('numpedido');
            $tecnico = $this->input->post('tecnico');
            $cidade = $this->input->post('cidade');
            $un = $this->input->post('un');
            $item = $this->input->post('item');

            $this->load->model('pedidos_model');
            $macAchado = $this->pedidos_model->addMac($id, $mac, $item);

            if ($macAchado) {
                $this->session->set_flashdata('success', 'Serial cadastrado com sucesso!');
            } else {
                $this->session->set_flashdata('danger', 'Serial não cadastrado no estoque');
            }

            redirect("pedidos/pedidosDetalhe?login=$login&tecnico=$tecnico&cidade=$cidade&un=$un&num_pedido=$num_pedido");
        }
    }
}
