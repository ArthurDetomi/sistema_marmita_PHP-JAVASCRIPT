<?php
namespace Sistema\DB;

class Sql{
    
    const HOSTNAME = "localhost";
    const USERNAME = "arthurdetomi";
    const PASSWORD = "db1234";
    const DBNAME = "db_sistema_marmita";
    private $conn;

    public function __construct(){
        $this->conn = new \PDO(
            "mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME,Sql::USERNAME,Sql::PASSWORD
        );
    }

    public function setParams($instancia, $parametros = array())
    {
        foreach($parametros as $key => $value){
            $this->bindParam($instancia, $key, $value);
        }
    }

    public function bindParam($instancia, $key, $value)
    {
        $instancia->bindParam($key, $value);
    }

    public function query($rawQuery, $params = array())
    {   
        $inst = $this->conn->prepare($rawQuery);
        $this->setParams($inst, $params);
        $inst->execute();
    }

    public function select($rawQuery, $params = array())
    {
        $inst = $this->conn->prepare($rawQuery);
        $this->setParams($inst, $params);
        $inst->execute();
        return $inst->fetchAll(\PDO::FETCH_ASSOC);
    }
}



?>