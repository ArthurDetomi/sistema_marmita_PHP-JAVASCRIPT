<?php
namespace Sistema\Model;
use \Sistema\DB\Sql;
use \Sistema\Model;

class User extends Model{

    public static function login($login, $password)
    {   
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_user WHERE deslogin = :LOGIN",array(
            ":LOGIN"=>$login
        ));
        if(count($results[0]) === 0){
            throw new \Exception("Esse usuário não existe, verifique se digitou os dados corretamente.");
        }
        $data = $results[0];
        if(password_verify($password, $data["despassword"]) === true){
            $user = new User();

        }else{
            throw new \Exception("Esse usuário não existe, verifique se digitou os dados corretamente.");
        }
    }
    
}
?>