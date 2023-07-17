<?php

namespace Geovendas\StoreX\Controllers;

use Geovendas\StoreX\Model\Stock;

class StockController extends Stock
{
    private $stockModel;

    protected function __construct()
    {
        $this->stockModel = new Stock();
    }

    public function update(array $produto): array
    {
        $idProduto = $this->stockModel->checkIfProductExists($produto);
        if($idProduto) {
            return $this->stockModel->updateProduct($idProduto, $produto['quantidade']);
        } else {
            return $this->stockModel->addProduct($produto);
        }
    }
}