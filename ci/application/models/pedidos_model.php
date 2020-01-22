<?php

class Pedidos_model extends CI_Model
{
    public function pedidosHome($ddd)
    {
        $pedidos = $this->db->query("SELECT nome, data_pedido, cidade, un, num_pedido, grupo, login, status, COUNT(quantidade) as quantidade,
         SUM(quantidade) as itens FROM pedidos WHERE status = 'aguardando' AND ddd = '$ddd' GROUP BY num_pedido")->result_array();

        return $pedidos;
    }

    public function buscaPedido($nomeTecnico, $cidade, $un, $num_pedido)
    {
        $pedidoTecnico = $this->db->query("SELECT item, quantidade, data_pedido, codigoItem, num_pedido, mac, id, grupo FROM pedidos WHERE nome = '$nomeTecnico' AND cidade = '$cidade' AND un = '$un' AND num_pedido = '$num_pedido'")->result_array();

        return $pedidoTecnico;
    }


    public function deletaPedido($num_pedido)
    {
        $this->db->where('num_pedido', $num_pedido);
        $this->db->delete('pedidos');
    }

    public function pagaPedido($num_pedido, $nome, $login)
    {
        $dados = array(
            'status' => 'PAGO',
            'data_pagamento' => date('Y-m-d'),
            'quem' => $nome
        );
        $this->db->where('num_pedido', $num_pedido);
        $this->db->update('pedidos', $dados);

        $ci = $this->db->query("SELECT cidade FROM tecnicos WHERE login = '$login'")->row_array();
        $cidade = $ci['cidade'];



        $pedidoPago = $this->db->query("SELECT codigoItem, quantidade, grupo, mac FROM pedidos WHERE login = '$login' AND num_pedido = '$num_pedido' AND cidade = '$cidade' AND status = 'pago'")->result_array();
        foreach ($pedidoPago as $p) :
            if ($p['grupo'] == 'MISCELANEAS') {
                $codigoItem = $p['codigoItem'];
                $quantidade = $p['quantidade'];

                $quantidadeAtual = $this->db->query("SELECT quantidade FROM estoque WHERE cidade = '$cidade' AND codigoItem = '$codigoItem'")->row_array();
                $novaQuantidade = $quantidadeAtual['quantidade'] - $quantidade;

                //}
                $this->db->set('quantidade', $novaQuantidade, FALSE);
                $this->db->where('cidade', $cidade);
                $this->db->where('codigoItem', $codigoItem);
                $this->db->update('estoque');
            } else {
                $mac = $p['mac'];
                $this->db->where('mac', $mac);
                $this->db->delete('estoque');
            }
        endforeach;


        $this->load->model('estoque_model');
        $this->estoque_model->trataSaldoNegativo();
    }

    public function pedidosPagos($ddd, $cidade, $data)
    {
        $pedidos = $this->db->query("SELECT nome, data_pedido, cidade, un, num_pedido, status, quem, COUNT(quantidade) as quantidade,
         SUM(quantidade) as itens FROM pedidos WHERE status = 'pago' AND ddd = '$ddd' AND cidade = '$cidade' AND data_pagamento = '$data' GROUP BY num_pedido")->result_array();

        return $pedidos;
    }

    public function buscaData()
    {
        $datas = $this->db->query("SELECT data_pagamento FROM pedidos GROUP BY data_pagamento")->result_array();

        return $datas;
    }

    public function calculaMes($mes, $ddd)
    {
        $mes = $this->db->query("SELECT data_pagamento, COUNT(num_pedido) as data_pagamento FROM pedidos WHERE status = 'pago' AND MONTH(data_pagamento) = $mes AND ddd = '$ddd'
      GROUP BY num_pedido")->result_array();
        return $mes;
    }

    public function criaResumo(
        $tecnico,
        $nome,
        $codigoItem,
        $item,
        $quantidade,
        $data_pedido,
        $responsavel,
        $un,
        $cidade,
        $ddd,
        $grupo,
        $pedidoMax
    ) {
        if ($grupo != "EQUIPAMENTOS") {
            $quantidadePedido = $this->db->query("SELECT SUM(quantidade) as quantidade FROM pedidos WHERE codigoItem = '$codigoItem' AND cidade = '$cidade' AND login = '$tecnico'")->row_array();
            $qtdItem = $this->db->query("SELECT quantidade as qtd, pedidoMax as maximo FROM estoque WHERE codigoItem = '$codigoItem' AND cidade = '$cidade'")->row_array();
            $consumo = $this->db->query("SELECT *, SUM(valor_utilizado) as quantidade FROM consumotecnico WHERE tecnico = '$tecnico' AND material = '$item'")->row_array();
            //Verifica se a quantidade do estoque é maior que a quantidade solicitada, caso contrario retorna erro.
            if ($qtdItem['qtd'] >= $quantidade) {
                //Verificar se o que está sendo solicitado é menor que o pedido máximo do item.
                if ($pedidoMax >= $quantidade) {
                    //Verifica se existe um pedido
                    if ($quantidadePedido['quantidade'] == 0) {

                        $dados = array(
                            'login' => $tecnico,
                            'nome' => $nome,
                            'codigoItem' => $codigoItem,
                            'item' => $item,
                            'quantidade' => $quantidade,
                            'data_pedido' => $data_pedido,
                            'responsavel' => $responsavel,
                            'un' => $un,
                            'cidade' => $cidade,
                            'ddd' => $ddd,
                            'status' => 'provisorio',
                            'grupo' => $grupo
                        );
                        $this->db->insert('pedidos', $dados);
                    } else {
                        //Verifica a quantidade consumida e subtrai da solicitada 
                        if ($quantidade <= $pedidoMax - ($quantidadePedido['quantidade'] - $consumo['quantidade']))  {
                           
                            $dados = array(
                                'login' => $tecnico,
                                'nome' => $nome,
                                'codigoItem' => $codigoItem,
                                'item' => $item,
                                'quantidade' => $quantidade,
                                'data_pedido' => $data_pedido,
                                'responsavel' => $responsavel,
                                'un' => $un,
                                'cidade' => $cidade,
                                'ddd' => $ddd,
                                'status' => 'provisorio',
                                'grupo' => $grupo
                            );
                            $this->db->insert('pedidos', $dados);
                        } else {
                            return 'pedidoMaximo';
                        }
                    }
                } else {
                    return 'maximo';
                }
            } else {
                return 'insuficiente';
            }
        } else {
            if ($quantidade > 1) {
                return 'equipamentos';
            } else {
                $qtdItem = $this->db->query("SELECT COUNT(codigoItem) as qtd FROM estoque WHERE codigoItem = '$codigoItem' AND cidade = '$cidade'")->row_array();
                if ($qtdItem['qtd'] >= $quantidade) {
                    $dados = array(
                        'login' => $tecnico,
                        'nome' => $nome,
                        'codigoItem' => $codigoItem,
                        'item' => $item,
                        'quantidade' => $quantidade,
                        'data_pedido' => $data_pedido,
                        'responsavel' => $responsavel,
                        'un' => $un,
                        'cidade' => $cidade,
                        'ddd' => $ddd,
                        'status' => 'provisorio',
                        'grupo' => $grupo
                    );
                    $this->db->insert('pedidos', $dados);
                } else {
                    return 'insuficiente';
                }
            }
        }
    }
    public function buscaResumo($login, $data)
    {
        $this->db->where('login', $login);
        $this->db->where('data_pedido', $data);
        $this->db->where('status', 'provisorio');
        return $this->db->get('pedidos')->result_array();
    }

    public function deleta($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pedidos');
    }

    public function atualizaResumo($id, $quantidade)
    {
        $dados = array('quantidade' => $quantidade);
        $this->db->where('id', $id);
        $this->db->where('status', 'provisorio');
        return $this->db->update('pedidos', $dados);
    }

    public function finaliza($login, $num_pedido, $cidade)
    {
        $dados = array('status' => 'AGUARDANDO', 'num_pedido' => $num_pedido);
        $this->db->where('login', $login);
        $this->db->where('data_pagamento', null);
        $this->db->update('pedidos', $dados);
    }

    public function addMac($id, $mac, $item)
    {
        $macEstoque = $this->db->query("SELECT mac FROM estoque WHERE mac = '$mac' AND item = '$item'")->row_array();

        if ($macEstoque['mac']) {
            $dados = array('mac' => $mac);
            $this->db->where('id', $id);
            $this->db->where('item', $item);
            $this->db->update('pedidos', $dados);
            return true;
        } else {
            return false;
        }
    }

    public function buscaQuantidade($login, $item)
    {
        $quantidadePedido = $this->db->query("SELECT SUM(quantidade) as quantidade FROM pedidos WHERE item = '$item' AND login = '$login'")->row_array();
        return $quantidadePedido;
    }
}
