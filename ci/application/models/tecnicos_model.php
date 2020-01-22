<?php

class Tecnicos_model extends CI_Model
{

    public function buscaT($login, $ddd)
    {

        $this->db->where('login', $login);
        $this->db->where('ddd', $ddd);
        return $this->db->get('tecnicos')->row_array();
    }

    public function cadastra($login, $nome, $un, $cidade, $ddd, $responsavel)
    {
        $this->db->where('login', $login);
        $tecnico = $this->db->get('tecnicos')->row_array();
        if ($tecnico['login'] == $login) {
            return 'existe';
        } else {
            $dados = array(
                'login' => $login,
                'nome' => $nome,
                'un' => $un,
                'cidade' => $cidade,
                'ddd' => $ddd,
                'responsavel' => $responsavel
            );
            $this->db->insert('tecnicos', $dados);
            return 'ok';
        }
    }

    public function tecnicos($cidadeEscolhida,$ddd)
    {
        $this->db->where('cidade', $cidadeEscolhida);
        $this->db->where('ddd', $ddd);
        return $this->db->get('tecnicos')->result_array();
    }

    public function deletaTecnico($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tecnicos');
    }

    public function atualizaTec($login, $nome, $un, $cidade, $ddd, $responsavel)
    {

        $dados = array(
            'login' => $login,
            'nome' => $nome,
            'un' => $un,
            'cidade' => $cidade,
            'ddd' => $ddd,
            'responsavel' => $responsavel
        );
        $this->db->where('login', $login);
        return $this->db->update('tecnicos', $dados);
    }
}
