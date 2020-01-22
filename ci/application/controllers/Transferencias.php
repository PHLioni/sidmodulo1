<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transferencias extends CI_Controller
{

    public function historicoTransferencias()
    {
        $usuarioLogado = $this->session->userdata("usuario_logado");
        if (!$usuarioLogado) {
            redirect("/");
        } else {
            $segmento = $this->input->get('segmento');

            $this->load->model('transferencia_model');
            $transferencias = $this->transferencia_model->buscaTransferencias($segmento);

            $this->load->helper('formataData');
            $dados = array('transferencias' => $transferencias);
            $this->load->template('telas/transferencias', $dados);
        }
    }
}
