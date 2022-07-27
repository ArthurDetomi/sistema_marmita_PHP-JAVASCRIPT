<?php
namespace Sistema\Model;
use \Sistema\DB\Sql;
use \Sistema\Model;

class Category extends Model{

    public static function listAllCategories()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
    }

    public function createCategory($nameCategory)
    {
        $sql = new Sql();
        $sql->query("UPDATE tb_categories SET descategory = :categoria",array(
            ":categoria"=>$nameCategory
        ));
    }

    public function saveCategory()
    {
        $sql = new Sql();
        $results = $sql->select("CALL sp_save_categories (:idcategory, :descategory)",array(
            ":idcategory"=>$this->getidcategory(),
            ":descategory"=>$this->getdescategory()
        ));
        $this->setData($results);
    }
    
    public function chargeCategory($idcategory)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory",array(
            ":idcategory"=>$idcategory
        ));
        $this->setData($results[0]);
    }

    public function deleteCategory()
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory",array(
            ":idcategory"=>$this->getidcategory()
        ));
    }

    public function getProductsInCategory($related = true)
    {
        $sql = new Sql();
        if($related === true){
            return $sql->select("SELECT * FROM tb_products WHERE idproduct IN(SELECT a.idproduct FROM tb_products a INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct WHERE b.idcategory = :idcategory)",array(
                ":idcategory"=>$this->getidcategory()
            ));
        }else{
            return $sql->select("SELECT * FROM tb_products WHERE idproduct NOT IN(SELECT a.idproduct FROM tb_products a INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct WHERE b.idcategory = :idcategory)",array(
                ":idcategory"=>$this->getidcategory()
            ));
        }
    }

    public function addProductInCategory(Product $product)
    {
        $sql = new Sql();
        $sql->query("INSERT INTO tb_productscategories (idcategory, idproduct) VALUES (:idcategory, :idproduct)",array(
            ":idcategory"=>$this->getidcategory(),
            ":idproduct"=>$product->getidproduct()
        ));
    }

    public function removeProductInCategory(Product $product)
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_productscategories WHERE idcategory = :idcategory and idproduct = :idproduct",array(
            ":idcategory"=>$this->getidcategory(),
            ":idproduct"=>$product->getidproduct()
        ));
    }


}


?>