<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Tecnicos extends CI_Controller
{

    public function dadosTecnico()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $dados = array();

            $this->load->template('telas/cadastraTecnico', $dados);
        }
    }

    public function cadastraTecnico()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $login = $this->input->post('login');
            $nome = $this->input->post('nome');
            $un = $this->input->post('un');
            $cidade = $this->input->post('cidade');
            $ddd = $this->input->post('ddd');
            $responsavel = $this->input->post('responsavel');

            $login = $this->load->modificaTexto($login);
            $nome = $this->load->modificaTexto($nome);
            $un = $this->load->modificaTexto($un);
            $cidade = $this->load->modificaTexto($cidade);
            $responsavel = $this->load->modificaTexto($responsavel);            

            $this->load->model('tecnicos_model');
            $cadastro = $this->tecnicos_model->cadastra(
                strtoupper($login),
                strtoupper($nome),
                strtoupper($un),
                strtoupper($cidade),
                strtoupper($ddd),
                strtoupper($responsavel)
            );

            if ($cadastro == "existe") {
                $this->session->set_flashdata('dan', 'Técnico já cadastrado, Acesse: Histórico/Técnicos, para atualizar um registro!');
                $dados = array();
                $this->load->template('telas/cadastraTecnico', $dados);
            } elseif ($cadastro == "ok") {
                $this->session->set_flashdata('success', 'Técnico Cadastrado com Sucesso!');
                $dados = array();
                $this->load->template('telas/cadastraTecnico', $dados);
            }
        }
    }


    public function tecnicosCadastrados()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $this->load->model('estoque_model');
            $usuario = $this->session->userdata('usuario_logado');
            $cidades = $this->estoque_model->cidadesEstoque($usuario['ddd']);

            $cidadeEscolhida = $this->input->get('selecionaCidade');
            $user = $this->session->userdata('usuario_logado');
            $ddd = $user['ddd'];

            $this->load->model('tecnicos_model');
            $tecnicos = $this->tecnicos_model->tecnicos($cidadeEscolhida, $ddd);

            $dados = array('cidadeEscolhida' => $cidadeEscolhida, 'cidades' => $cidades, 'tecnicos' => $tecnicos);
            $this->load->template('telas/tecnicosCadastrados', $dados);
        }
    }


    public function deletaTecnico()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $id = $this->input->get('id');
            $cidade = $this->input->get('cidade');

            $this->load->model('tecnicos_model');
            $this->tecnicos_model->deletaTecnico($id);

            redirect("tecnicos/tecnicosCadastrados?selecionaCidade=$cidade");
        }
    }


    public function atualizaTecnicos()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $login = $this->input->post('login');
            $nome = $this->input->post('nome');
            $un = $this->input->post('un');
            $cidade = $this->input->post('cidade');
            $ddd = $this->input->post('ddd');
            $responsavel = $this->input->post('responsavel');

            $this->load->model('tecnicos_model');
            $tecAtualizado = $this->tecnicos_model->atualizaTec(
                strtoupper($login),
                strtoupper($nome),
                strtoupper($un),
                strtoupper($cidade),
                strtoupper($ddd),
                strtoupper($responsavel)
            );

            if ($tecAtualizado) {
                $this->session->set_flashdata('success', 'Técnico Atualizado com Sucesso!');
                $dados = array();
                redirect("tecnicos/tecnicosCadastrados?selecionaCidade=$cidade");
            } else {
                $this->session->set_flashdata('danger', 'Técnico não foi cadastrado!');
                $dados = array();
                $this->load->template('telas/tecnicosCadastrados', $dados);
            }
        }
    }
}
