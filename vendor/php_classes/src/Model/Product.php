<?php
namespace Sistema\Model;
use \Sistema\DB\Sql;
use \Sistema\Model;

class Product extends Model
{
    public static function listAllProducts()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_products ORDER BY vlsize DESC");
    }

    public function saveProduct()
    {
        $sql = new Sql();
        $results = $sql->select("CALL sp_save_products (:idproduct, :desproduct, :vlprice, :vlsize, :desurl)",array(
            ":idproduct"=>$this->getidproduct(),
            ":desproduct"=>$this->getdesproduct(),
            ":vlprice"=>$this->getvlprice(),
            ":vlsize"=>$this->getvlsize(),
            ":desurl"=>$this->getdesurl()
        ));
        $this->setData($results);
    }

    public function chargeProduct($idproduct)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct",array(
            ":idproduct"=>$idproduct
        ));
        $this->setData($results[0]);
    }

    public function deleteProduct()
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct",array(
            ":idproduct"=>$this->getidproduct()
        ));
    }

    public function checkPhotoProduct()
    {
        if(file_exists($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."sistemamarmita".DIRECTORY_SEPARATOR."res".DIRECTORY_SEPARATOR."site".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."products".DIRECTORY_SEPARATOR.$this->getidproduct().".jpg")){
            $url = "/sistemamarmita/res/site/img/products/".$this->getidproduct().".jpg";
        }else{
            $url = "/sistemamarmita/res/site/img/products/product.jpg";
        }
        return $this->setdesphoto($url);
    }

    public function getValues()
    {
        $this->checkPhotoProduct();
        $values = parent::getValues();
        return $values;
    }

    public function setPhotoProduct($file)
    {   
        if($file["tmp_name"] !== ""){
            $extension = explode(".",$file["name"]);
            $extension = end($extension);

            switch($extension){
                case "jpg":
                case "jpeg":
                    $image = imagecreatefromjpeg($file["tmp_name"]);
                break;

                case "gif":
                    $image = imagecreatefromgif($file["tmp_name"]);
                break;

                case "png":
                    $image = imagecreatefrompng($file["tmp_name"]);
                break;
            }
            $destination = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."sistemamarmita".DIRECTORY_SEPARATOR."res".DIRECTORY_SEPARATOR."site".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."products".DIRECTORY_SEPARATOR.$this->getidproduct().".jpg";
            imagejpeg($image, $destination);
            imagedestroy($image);
            $this->checkPhotoProduct();
        }
    }

    public static function checkList($list)
    {   
        foreach($list as &$row){
            $p = new Product();
            $p->setData($row);
            $row = $p->getValues();
        }
        return $list;
    }

}
?>