<?php

class Transferencia_model extends CI_Model
{ 

    public function buscaTransferencias($segmento){
        $this->db->where('grupo', $segmento);
        return $this->db->get('transferencias')->result_array();
    }
 


}
