<?php

class Usuarios_model extends CI_Model
{
    public function buscaUser($user, $senha)
    {
        $this->db->where('usuario', $user);
        $this->db->where('senha', $senha);
        $usuario = $this->db->get('usuarios')->row_array();
        return $usuario;
    }

    public function cadastraUsuario($nome, $usuario, $ddd, $senha, $sobrenome)
    {
        $dados = array(
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'ddd' => $ddd,
            'usuario' => $usuario,
            'senha' => md5($senha)
        );

        return $this->db->insert('usuarios', $dados);
    }

    public function verificaUser()
    {
        return $this->db->query("SELECT usuario FROM usuarios")->result_array();
    }

    public function registraLog($id, $nome, $sobrenome, $login, $ddd, $data, $tempo)
    {

        return $this->db->query("INSERT INTO _log (id_user, nome, login, sobrenome, ddd, data_acesso, horaAcesso) 
        value ('$id','$nome', '$login', '$sobrenome', '$ddd', '$data', CURRENT_TIME())");
    }

 
}
