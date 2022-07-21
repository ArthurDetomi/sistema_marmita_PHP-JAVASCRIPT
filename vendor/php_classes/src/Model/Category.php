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

}


?>