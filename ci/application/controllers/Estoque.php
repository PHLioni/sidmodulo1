<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estoque extends CI_Controller
{

    //Função responsavel por buscar todo o estoque de miscelaneas, 
    public function estoqueMiscelaneas()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $usuario = $this->session->userdata('usuario_logado');

            //obtem a cidade selecionada na tela estoque/miscelaneas
            $cidade = $this->input->get('selecionaCidade');

            //chama o model de restornará todas as miscelaneas da cidade selecionada
            $this->load->model('estoque_model');
            $estoque = $this->estoque_model->buscaMiscelaneas($cidade);

            //chama o model que traz todas as cidades do DDD, usado no select
            $cidades = $this->estoque_model->cidadesEstoque($usuario['ddd']);

            $dados = array('estoque' => $estoque, 'cidades' => $cidades, 'cidadeEscolhida' => $cidade);

            //Model que cuida do saldo negativo, caso o item esteja zerado no estoque este model o exclui
            $this->estoque_model->trataSaldoNegativo();

            $this->load->helper('formataMoeda');

            $this->load->template('telas/estoqueMiscelaneas', $dados);
        }
    }

    //Função para cadastro de miscelaneas
    public function cadastraMiscelanea()
    {

        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        }

        //obtem todos os itens do model para cadastrar o item no estoque
        $codigo = $this->input->post('codigo');
        $item = $this->input->post('item');
        $quantidade = $this->input->post('quantidade');
        $maximo = $this->input->post('maximo');
        $valor = $this->input->post('valor');
        $segmento = $this->input->post('segmento');
        $sp = $this->input->post('grupo');
        $c = $this->input->post('cidade');
        $data = $this->input->post('data');
        $data_entrega = date("Y/m/d", strtotime($data));
        $usuario = $this->session->userdata('usuario_logado');
        $ddd = $usuario['ddd'];


        $valor_un = str_replace(',', '.', $valor);

        //função que modifica o texto, retirando os acentos
        $cidade = $this->load->modificaTexto($c);


        $this->load->model('estoque_model');
        $itemCadastrado = $this->estoque_model->cadastraMis(strtoupper($codigo), strtoupper($item), $quantidade, $valor_un, strtoupper($segmento), $cidade, $data_entrega, strtoupper($ddd), $maximo, $sp);

        if ($itemCadastrado) {
            $this->session->set_flashdata('success', 'Item ' . $codigo . ' cadastrado com sucesso!');
        } else {
            $this->session->set_flashdata('danger', 'Item já cadastrado no estoque!');
        }

        $dados = array('ddd' => $ddd);

        redirect("estoque/estoqueMiscelaneas?selecionaCidade=$cidade", $dados);
    }



    public function estoqueEquipamentos()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $usuario = $this->session->userdata('usuario_logado');

            $cidade = $this->input->get('selecionaCidade');

            $this->load->model('estoque_model');
            $estoque = $this->estoque_model->buscaEquipamentos($cidade);

            $cidades = $this->estoque_model->cidadesEstoque($usuario['ddd']);

            $dados = array('estoque' => $estoque, 'cidades' => $cidades, 'cidadeEscolhida' => $cidade);
            $this->estoque_model->trataSaldoNegativo();

            $this->load->helper('formataMoeda');
            $this->load->template('telas/estoqueEquipamentos', $dados);
        }
    }



    public function deletaEquipamento()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->get('id');
            $c = $this->input->get('cidade');
            $codigo = $this->input->get('codigo');

            $cidade = str_replace(' ', '+', $c);

            $this->load->model('estoque_model');
            $this->estoque_model->deleta($id);


            $dados = array();
            $this->session->set_flashdata('danger', 'Equipamento ' . $codigo . ' deletado!');
            redirect("estoque/estoqueEquipamentos?selecionaCidade=$cidade", $dados);
        }
    }


    public function cadastraEquipamentos()
    {

        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $codigo = $this->input->post('codigo');
            $item = $this->input->post('item');
            $tec = $this->input->post('tecnologia');
            $quantidade = $this->input->post('quantidade');
            $valor = $this->input->post('valor');
            $segmento = $this->input->post('segmento');
            $sp = $this->input->post('grupo');
            $c = $this->input->post('cidade');
            $data = $this->input->post('data');
            $data_entrega = date("Y/m/d", strtotime($data));
            $usuario = $this->session->userdata('usuario_logado');
            $ddd = $usuario['ddd'];

            //Tratamento de textos
            $tecnologia = str_replace(" ", "", $tec);
            $valor_un = str_replace(',', '.', $valor);

            $cidade = $this->load->modificaTexto($c);

            $this->load->model('estoque_model');
            $itemCadastrado = $this->estoque_model->cadastraEquipamento(strtoupper($codigo), strtoupper($item), strtoupper($tecnologia), $valor_un, strtoupper($segmento), $cidade, strtoupper($ddd), $sp);



            if ($itemCadastrado == 'existe') {
                $this->session->set_flashdata('danger', 'Item ' . $codigo . ' já existe no estoque!');
            } elseif ($itemCadastrado == 'inserido') {
                $this->session->set_flashdata('success', 'Item ' . $codigo . ' cadastrado com sucesso!');
            }

            $dados = array('ddd' => $ddd);
            redirect("estoque/estoqueEquipamentos?selecionaCidade=$cidade", $dados);
        }
    }
    public function transfereEquipamento()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {

            $codigo = $this->input->post('codigo');
            $item = $this->input->post('item');
            $quantidade = $this->input->post('quantidade');
            $co = $this->input->post('cidadeOrigem');
            $cd = $this->input->post('cidadeDestino');
            $segemento = $this->input->post('segmento');
            $data = $this->input->post('data');
            $data_transferencia = date("Y/m/d", strtotime($data));
            $usuario = $this->session->userdata('usuario_logado');
            $ddd = $usuario['ddd'];

            $cidadeOrigem = $this->load->modificaTexto($co);
            $cidadeDestino = $this->load->modificaTexto($cd);

            $this->load->model('estoque_model');

            $this->estoque_model->debitarEstoque($codigo, $quantidade, $cidadeOrigem);
            $transferencia = $this->estoque_model->transfereEquipamento(
                strtoupper($codigo),
                strtoupper($item),
                $quantidade,
                $cidadeOrigem,
                $cidadeDestino,
                strtoupper($segemento),
                strtoupper($ddd),
                $data_transferencia,
                strtoupper($usuario['nome']),
            );

            if ($transferencia) {
                $this->session->set_flashdata('success', 'Transferência realizada com sucesso!');
                $this->estoque_model->trataSaldoNegativo();
            }

            $dados = array('ddd' => $ddd);
            redirect("estoque/estoqueEquipamentos?selecionaCidade=$co", $dados);
        }
    }

    public function transfereMiscelaneas()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $codigo = $this->input->post('codigo');
            $item = $this->input->post('item');
            $quantidade = $this->input->post('quantidade');
            $co = $this->input->post('cidadeOrigem');
            $cd = $this->input->post('cidadeDestino');
            $segemento = $this->input->post('segmento');
            $data = $this->input->post('data');
            $data_transferencia = date("Y/m/d", strtotime($data));
            $usuario = $this->session->userdata('usuario_logado');
            $ddd = $usuario['ddd'];

            $cidadeOrigem = $this->load->modificaTexto($co);
            $cidadeDestino = $this->load->modificaTexto($cd);

            $this->load->model('estoque_model');

            $this->estoque_model->debitarEstoque($codigo, $quantidade, strtoupper($cidadeOrigem));
            $transferencia = $this->estoque_model->transfereMiscelaneas(
                strtoupper($codigo),
                strtoupper($item),
                $quantidade,
                $cidadeOrigem,
                $cidadeDestino,
                strtoupper($segemento),
                strtoupper($ddd),
                $data_transferencia,
                $usuario['nome'],
            );

            if ($transferencia) {
                $this->session->set_flashdata('success', 'Transferência realizada com sucesso!');
                $this->estoque_model->trataSaldoNegativo();
            }

            $dados = array('ddd' => $ddd);
            redirect("estoque/estoqueMiscelaneas?selecionaCidade=$co", $dados);
        }
    }

    public function deletaMiscelaneas()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->get('id');
            $c = $this->input->get('cidade');
            $codigo = $this->input->get('codigo');

            $cidade = str_replace(' ', '+', $c);

            $this->load->model('estoque_model');
            $this->estoque_model->deleta($id);

            $dados = array();
            $this->session->set_flashdata('danger', 'Item ' . $codigo . ' deletado!');
            redirect("estoque/estoqueMiscelaneas?selecionaCidade=$cidade", $dados);
        }
    }

    public function atualizaItem()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {

            $codigo = $this->input->post('codigo');
            $item = $this->input->post('item');
            $quantidade = $this->input->post('quantidade');
            $valor = $this->input->post('valor');
            $cidade = $this->input->post('cidade');
            $id = $this->input->post('id');
            $pedidoMax = $this->input->post('max');

            $this->load->model('estoque_model');
            $itemAtualizado = $this->estoque_model->itemAtualizado($codigo, $item, $quantidade, $valor, $cidade, $id, $pedidoMax);

            if ($itemAtualizado) {
                $this->session->set_flashdata('success', $item . ' atualizado com sucesso!');
                redirect("estoque/estoqueMiscelaneas?selecionaCidade=$cidade");
            } else {
                $this->session->set_flashdata('danger', 'Já existe um item com o codigo ' . $codigo . ' cadastrado!');
                redirect("estoque/estoqueMiscelaneas?selecionaCidade=$cidade");
            }
        }
    }

    public function atualizaEquipamento()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $codigo = $this->input->post('codigo');
            $item = $this->input->post('item');
            $quantidade = $this->input->post('quantidade');
            $tecnologia = $this->input->post('tecnologia');
            $valor = $this->input->post('valor');
            $cidade = $this->input->post('cidade');
            $id = $this->input->post('id');

            $this->load->model('estoque_model');
            $itemAtualizado = $this->estoque_model->atualizaEquip($codigo, $item, $quantidade, $tecnologia, $valor, $cidade, $id);

            if ($itemAtualizado) {
                $this->session->set_flashdata('success', $item . ' atualizado com sucesso!');
                redirect("estoque/estoqueEquipamentos?selecionaCidade=$cidade");
            } else {
                $this->session->set_flashdata('danger', 'Já existe um item com o codigo ' . $codigo . ' cadastrado!');
                redirect("estoque/estoqueEquipamentos?selecionaCidade=$cidade");
            }
        }
    }

    public function seriais()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $cidadeEscolhida = $this->input->get('cidade');
            $codigo = $this->input->get('codigoItem');

            $this->load->model('estoque_model');
            $estoque = $this->estoque_model->buscaSeriais($cidadeEscolhida, $codigo);

            $modelos = $this->estoque_model->buscaEquipamentosMac($cidadeEscolhida, $codigo);

            $quantidade = $this->estoque_model->contaModelos($codigo, $cidadeEscolhida);

            $this->load->helper('formataMoeda');
            $dados = array('cidadeEscolhida' => $cidadeEscolhida, 'estoque' => $estoque, 'modelos' => $modelos, 'quantidade' => $quantidade);
            $this->load->template('telas/seriais.php', $dados);
        }
    }

    public function cadastraMac()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $codigoItem = $this->input->post('codigo');
            $cidade = $this->input->post('cidade');
            $mac = $this->input->post('mac');
            $item = $this->input->post('item');
            $tecnologia = $this->input->post('tecnologia');
            $sp = $this->input->post('grupo');
            $data_entrega = date("Y/m/d");
            $usuario = $this->session->userdata('usuario_logado');
            $ddd = $usuario['ddd'];

            $this->load->model('estoque_model');
            $estoque = $this->estoque_model->cadastraSerial($codigoItem, $cidade, $mac, $item, $tecnologia, $data_entrega, $ddd, $sp);

            redirect("estoque/seriais?codigoItem=$codigoItem&cidade=$cidade");
        }
    }


    public function deletaMac()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->get('id');
            $c = $this->input->get('cidade');
            $codigo = $this->input->get('codigo');

            $cidade = str_replace(' ', '+', $c);

            $this->load->model('estoque_model');
            $this->estoque_model->deleta($id);


            $dados = array();
            $this->session->set_flashdata('danger', 'Equipamento ' . $codigo . ' deletado!');
            redirect("estoque/seriais?codigoItem=$codigo&cidade=$cidade", $dados);
        }
    }

    public function deletaModelo()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->get('id');
            $c = $this->input->get('cidade');
            $codigo = $this->input->get('codigo');
            $item = $this->input->get('item');

            $cidade = str_replace(' ', '+', $c);

            $this->load->model('estoque_model');
            $this->estoque_model->deletaModelo($id);


            $dados = array();
            $this->session->set_flashdata('danger', 'Modelo ' . $item . ' deletado!');
            redirect("estoque/estoqueEquipamentos?selecionaCidade=$cidade", $dados);
        }
    }
}
