<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Autenticar extends CI_Controller
{
    public function logar()
    {
        $this->load->model('usuarios_model');
        $user = $this->input->post('usuario');
        $senha = md5($this->input->post('senha'));
        $usuario = $this->usuarios_model->buscaUser($user, $senha);
        

        if ($usuario['usuario'] == 'claro001' && $usuario['senha'] == md5('@claro!')) {
            redirect('cadastro/criaCadastro');
        } elseif ($usuario) {
            date_default_timezone_set('America/Sao_Paulo');
            $id = $usuario['id'];
            $nome = $usuario['nome'];
            $sobrenome = $usuario['sobrenome'];
            $login = $usuario['usuario'];
            $ddd = $usuario['ddd'];
            $data = date('Y-m-d');            
            $tempo = date('H:i:s');

            $this->usuarios_model->registraLog($id, $nome, $sobrenome, $login, $ddd, $data, $tempo);
            $this->session->set_userdata('usuario_logado', $usuario);
            redirect('home/index');
        } else {
            $this->session->set_flashdata('danger', 'Usuario ou senha inválido!');
            redirect('/');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('usuario_logado');
        redirect('/');
    }

    public function cadastrar()
    {
        $this->load->model('usuarios_model');
        $nome = $this->input->post('nome');
        $usuario = $this->input->post('usuario');
        $ddd = $this->input->post('ddd');
        $senha = $this->input->post('senha');
        $sobrenome = $this->input->post('sobrenome');

        $this->load->model('usuarios_model');
        $verificaUser = $this->usuarios_model->verificaUser();


        if ($nome == null || $usuario == null || $senha == null) {
            $this->session->set_flashdata('danger', 'Todos os campos devem estar preenchidos!');
            redirect('cadastro/criaCadastro');
        } else {
            foreach ($verificaUser as $v) :
                if ($v['usuario'] == $usuario) :
                    $this->session->set_flashdata('danger', 'Usuario já cadastrado!');
                    redirect('cadastro/criaCadastro');
                endif;
            endforeach;
            $this->session->set_flashdata('success', 'Usuario cadastrado com sucesso!');
            $usuario = $this->usuarios_model->cadastraUsuario($nome, $usuario, $ddd, $senha, $sobrenome);
            redirect('/');
        }
    }
}
