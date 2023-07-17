<?php

namespace Geovendas\StoreX\Model;

use Geovendas\StoreX\Connections\ConnPDO;
use \PDO;
use \PDOException;

class Stock extends ConnPDO
{
    private PDO $connPdo;

    protected function __construct()
    {
        $this->connPdo = parent::connect();
    }

    protected function checkIfProductExists(array $produto): int
    {
        $sql = "SELECT id FROM estoque
                WHERE produto = ? AND
                cor = ? AND
                tamanho = ? AND
                deposito = ? AND
                data_disponibilidade = ?"
        ;
        $stmt = $this->connPdo->prepare($sql);
        $stmt->execute([
            $produto['produto'],
            $produto['cor'],
            $produto['tamanho'],
            $produto['deposito'],
            $produto['data_disponibilidade']
        ]);
        return $stmt->fetchColumn();
    }

    protected function addProduct(array $produto): array
    {
        try {
            $this->connPdo->beginTransaction();
            $sql = "INSERT INTO estoque (produto, cor, tamanho, deposito, data_disponibilidade, quantidade)
                    VALUES (?, ?, ?, ?, ?, ?)"
            ;
            $stmt = $this->connPdo->prepare($sql);
            $stmt->execute([
                $produto['produto'],
                $produto['cor'],
                $produto['tamanho'],
                $produto['deposito'],
                $produto['data_disponibilidade'],
                $produto['quantidade']
            ]);
            $this->connPdo->commit();
            return ['status' => 'ok'];
        } catch (PDOException $e) {
            $this->connPdo->rollback();
            return [
                'status' => 'error',
                'msg' => 'Erro ao adicionar produto ao estoque: ' . $e->getMessage()
            ];
        }
    }

    protected function updateProduct(int $id, int $qtd): array
    {
        try {
            $this->connPdo->beginTransaction();
            $sql = "UPDATE estoque
                    SET quantidade = quantidade + ?
                    WHERE id = ?"
            ;
            $stmt = $this->connPdo->prepare($sql);
            $stmt->execute([$qtd, $id]);
            $this->connPdo->commit();
            return ['status' => 'ok'];
        } catch (PDOException $e) {
            $this->connPdo->rollback();
            return [
                'status' => 'error',
                'msg' => 'Erro ao atualizar registro no estoque: ' . $e->getMessage()
            ];
        }
    }
}