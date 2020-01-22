<?php

class Estoque_model extends CI_Model
{

    public function buscaMiscelaneas($cidade)
    {
        $this->db->where('grupo', 'miscelaneas');
        $this->db->where('cidade', $cidade);
        return $this->db->get('estoque')->result_array();
    }

    public function cadastraMis($codigo, $item, $quantidade, $valor, $segmento, $cidade, $data_entrega, $ddd, $maximo, $sp)
    {
        $cod = $this->db->query("SELECT codigoItem FROM estoque WHERE codigoItem = '$codigo' AND cidade = '$cidade' AND grupo = '$segmento'")->row_array();

        if ($cod['codigoItem'] != $codigo && $cod['cidade'] != $cidade) {
            $dados = array(
                'codigoItem' => $codigo,
                'item' => $item,
                'quantidade' => $quantidade,
                'valor_un' => $valor,
                'grupo' => $segmento,
                'cidade' => $cidade,
                'ddd' => $ddd,
                'data_entrega' => $data_entrega,
                'pedidoMax' => $maximo,
                'sp' => $sp,
                'valor_total' => $quantidade * $valor,
            );
            return $this->db->insert('estoque', $dados);
        } else {

            return;
        }
    }

    public function cidadesEstoque($ddd)
    {
        $cidades = $this->db->query("SELECT cidade, grupo FROM aux WHERE ddd = '$ddd' GROUP BY cidade")->result_array();
        return $cidades;
    }

    public function deleta($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('estoque');
    }

    public function deletaModelo($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('modelos');
    }

    public function buscaEquipamentos($cidade)
    {
        $this->db->where('grupo', 'equipamentos');
        $this->db->where('cidade', $cidade);
        return $this->db->get('modelos')->result_array();
    }

    public function buscaEquipamentosMac($cidade, $codigo)
    {
        $this->db->where('grupo', 'equipamentos');
        $this->db->where('cidade', $cidade);
        $this->db->where('codigoItem', $codigo);
        return $this->db->get('modelos')->result_array();
    }

    public function cadastraEquipamento($codigo, $item, $tecnologia, $valor, $segmento, $cidade, $ddd, $sp)
    {

        $cod = $this->db->query("SELECT codigoItem FROM estoque WHERE codigoItem = '$codigo' AND cidade = '$cidade' AND grupo = '$segmento'")->row_array();

        if ($cod['codigoItem'] == $codigo) {

            return 'existe';
        } else {

            $dados = array(
                'codigoItem' => $codigo,
                'item' => $item,
                'tecnologia' => $tecnologia,
                'valor_un' => $valor,
                'grupo' => $segmento,
                'cidade' => $cidade,
                'ddd' => $ddd,
                'sp' => $sp,
                
            );

            $this->db->insert('modelos', $dados);
            return 'inserido';
        }
    }

    public function debitarEstoque($codigo, $quantidade, $cidadeOrigem)
    {
        $quantidadeAtual = $this->db->query("SELECT COUNT(codigoItem) as qtd FROM estoque WHERE cidade = '$cidadeOrigem' AND codigoItem = '$codigo'")->row_array();
        $novaQuantidade = $quantidadeAtual['qtd'] - $quantidade;

        $this->db->set('quantidade', $novaQuantidade, FALSE);
        $this->db->where('codigoItem', $codigo);
        $this->db->where('cidade', $cidadeOrigem);
        $this->db->update('estoque');
    }

    public function transfereEquipamento(
        $codigo,
        $item,
        $quantidade,
        $cidadeOrigem,
        $cidadeDestino,
        $segmento,
        $ddd,
        $data_transferencia,
        $usuario
    ) {

        $dados = array(
            'codigoItem' => $codigo,
            'item' => $item,
            'quantidade' => $quantidade,
            'grupo' => $segmento,
            'ddd' => $ddd,
            'cidadeOrigem' => $cidadeOrigem,
            'cidadeDestino' => $cidadeDestino,
            'data_transferencia' => $data_transferencia,
            'quem' => $usuario
        );

        $this->db->insert('transferencias', $dados);
        return 'inserido';
    }

    public function transfereMiscelaneas(
        $codigo,
        $item,
        $quantidade,
        $cidadeOrigem,
        $cidadeDestino,
        $segmento,
        $ddd,
        $data_transferencia,
        $usuario
    ) {

        $dados = array(
            'codigoItem' => $codigo,
            'item' => $item,
            'quantidade' => $quantidade,
            'grupo' => $segmento,
            'ddd' => $ddd,
            'cidadeOrigem' => $cidadeOrigem,
            'cidadeDestino' => $cidadeDestino,
            'data_transferencia' => $data_transferencia,
            'quem' => $usuario
        );

        $this->db->insert('transferencias', $dados);
        return 'inserido';
    }

    public function trataSaldoNegativo()
    {
        $quantidadeAtual = $this->db->query("SELECT quantidade, id FROM estoque")->result_array();

        foreach ($quantidadeAtual as $q) :
            if ($q['quantidade'] <= 0) {
                $this->db->where('id', $q['id']);
                $this->db->delete('estoque');
            }

        endforeach;
    }

    public function buscaMiscelaneasPedido($cidade)
    {
        $dados = $this->db->query("SELECT *, SUM(quantidade) as qtd FROM estoque WHERE cidade = '$cidade' GROUP BY codigoItem ORDER BY(item) ASC")->result_array();

        return $dados;
    }

    public function itemAtualizado($codigo, $item, $quantidade, $valor, $cidade, $id, $pedidoMax)
    {
        $cod = $this->db->query("SELECT id FROM estoque WHERE  id = '$id'")->row_array();

        if ($cod['id'] == $id) {
            $dados = array(
                'codigoItem' => $codigo,
                'item' => $item,
                'quantidade' => $quantidade,
                'valor_un' => $valor,
                'pedidoMax' => $pedidoMax
            );
            $this->db->where('id', $id);
            $this->db->where('cidade', $cidade);
            return $this->db->update('estoque', $dados);
        } else {
            return;
        }
    }

    public function atualizaEquip($codigo, $item, $quantidade, $tecnologia, $valor, $cidade, $id)
    {
        $cod = $this->db->query("SELECT id FROM estoque WHERE  id = '$id'")->row_array();

        if ($cod['id'] == $id) {
            $dados = array(
                'codigoItem' => $codigo,
                'item' => $item,
                'tecnologia' => $tecnologia,
                'quantidade' => $quantidade,
                'valor_un' => $valor
            );
            $this->db->where('id', $id);
            $this->db->where('cidade', $cidade);
            return $this->db->update('estoque', $dados);
        } else {
            return;
        }
    }

    public function buscaSeriais($cidade, $codigoItem)
    {
        $this->db->where('cidade', $cidade);
        $this->db->where('codigoItem', $codigoItem);
        return $this->db->get('estoque')->result_array();
    }

    public function cadastraSerial($codigoItem, $cidade, $mac, $item, $tecnologia, $data_entrega, $ddd, $sp)
    {

        $valor_un = $this->db->query("SELECT valor_un FROM modelos WHERE codigoItem = '$codigoItem' AND cidade = '$cidade' ")->row_array();
        $valor = $valor_un['valor_un'];
        $dados = array(
            'mac' => $mac,
            'codigoItem' => $codigoItem,
            'cidade' => $cidade,
            'item' => $item,
            'tecnologia' => $tecnologia,
            'data_entrega' => $data_entrega,
            'ddd' => $ddd,
            'grupo' => 'EQUIPAMENTOS',
            'valor_un' => $valor,
            'sp' => $sp,
            'quantidade' => 1,
            'valor_total' => $valor            
        );

        $this->db->insert('estoque', $dados);
    }

    public function contaModelos($codigoItem, $cidade)
    {
        return $this->db->query("SELECT valor_un, COUNT(codigoItem) as qtd FROM estoque WHERE codigoItem = '$codigoItem' AND cidade = '$cidade'")->row_array();
    }
}
