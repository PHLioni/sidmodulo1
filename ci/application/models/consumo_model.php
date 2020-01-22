<?php

class Consumo_model extends CI_Model
{

    public function buscaConsumo($login, $item){
        $dados = $this->db->query("SELECT *, SUM(valor_utilizado) as valor FROM consumotecnico
        WHERE tecnico = '$login' AND material = '$item'")->row_array();
        return $dados;
    }

}
