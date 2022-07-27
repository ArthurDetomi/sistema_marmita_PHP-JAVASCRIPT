<?php
namespace Sistema\Model;
use \Sistema\DB\Sql;
use \Sistema\Model;
class Sale extends Model{
    public static function listAllSales()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_registro_venda ORDER BY idvenda");
    }
    
    public function chargeSale($idvenda)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_registro_venda WHERE idvenda = :idvenda",array(
            ":idvenda"=>$idvenda
        ));
        $this->setData($results[0]);
    }

    public function deleteSale()
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_registro_venda WHERE idvenda = :idvenda",array(
            ":idvenda"=>$this->getidvenda()
        ));
    }

    public function updateSale()
    {
        $sql = new Sql();
        $sql->query("UPDATE tb_registro_venda SET describeVenda = :describeVenda, vltotal = :vltotal WHERE idvenda = :idvenda",array(
            ":describeVenda"=>$this->getdescribeVenda(),
            ":vltotal"=>$this->getvltotal(),
            ":idvenda"=>$this->getidvenda(),
        ));
    }
}
?>