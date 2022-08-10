<?php
namespace Sistema\Model;
use \Sistema\Model;
use \Sistema\DB\Sql;
use \Sistema\Model\Product;

class Purchase{

    private $description = "";
    private $vltotal = 0;
    private $paymentMethod = "";
    
    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    public function getListProducts($json)
    {

        $array = json_decode($json, true);

        for($i = 0;$i < count($array);$i++){

            $this->registerSaleInfo($array[$i]["idproduct"], $array[$i]["quantidade"]);

        }

    }

    private function registerSaleInfo($idproduct, $qtdVenda)
    {
        $product = new Product();//cria nova instancia da classe produto
        $product->chargeProduct($idproduct); //carrega o produto

        $this->getDescription($product, $qtdVenda); //gera a descrição
        $this->sumValueTotal($product, $qtdVenda); //somar valor total da compra
    }

    private function getDescription(Product $product, $qtdVenda)
    {
       $this->description .= $qtdVenda." ".$product->getdesproduct()."s Tamanho ".$product->getvlsize()."-"; //separar por traço cada descrição
    }

    private function sumValueTotal(Product $product, $qtdVenda)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT vlprice * :qtd as vltotal FROM tb_products WHERE idproduct = :idproduct",array(
            ":qtd"=>$qtdVenda,
            ":idproduct"=>$product->getidproduct()
        ));

        $this->vltotal += (double)$results[0]["vltotal"];
    }

    public function registerSale()
    {

        if($this->description != "" && $this->vltotal > 0){

            $sql = new Sql();
            $sql->query("INSERT INTO tb_registro_venda (describeVenda, vltotal, forma_pagamento) VALUES(:descri, :vltotal, :pagamento)",array(
                ":descri"=>$this->description,
                ":vltotal"=>$this->vltotal,
                ":pagamento"=>$this->paymentMethod
            ));

        }

    }

    
}
?>