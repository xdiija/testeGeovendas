<?php

namespace Geovendas\StoreX\Controllers;

use Geovendas\StoreX\Model\Stock;

class StockController extends Stock
{
    private $stockModel;

    public function __construct()
    {
        $this->stockModel = new Stock();
    }

    public function update(array $produto): array
    {
        $result = $this->stockModel->checkIfProductExists($produto);
        if($result['status'] == 'ok') {
            return $this->stockModel->updateProduct($result['id'], $produto['quantidade']);
        } else {
            return $this->stockModel->addProduct($produto);
        }
    }

    public function remove(int $id): array
    {
        return $this->stockModel->removeProduct($id);
    }

    public function getById(int $id): array
    {
        return $this->stockModel->getProductById($id);
    }
}