<?php
namespace Sistema\Model;
use \Sistema\DB\Sql;
use \Sistema\Model;

class User extends Model{

    const SESSION = "User";

    public static function login($login, $password)
    {   
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN",array(
            ":LOGIN"=>$login
        ));
        if(count($results) === 0){
            throw new \Exception("Esse usuário não existe, verifique se digitou os dados corretamente.");
        }
        $data = $results[0];
        if(password_verify($password, $data["despassword"]) === true){
            $user = new User();
            $user->setData($data);
            $_SESSION[User::SESSION] = $user->getValues();
            return $user;
        }else{
            throw new \Exception("Esse usuário não existe, verifique se digitou os dados corretamente.");
        }
    }

    public static function verifyLogin($inadmin = true)
    {
        if(
            !isset($_SESSION[User::SESSION]) 
            ||
            !$_SESSION[User::SESSION] 
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ){
            header("Location: /sistemamarmita/admin/login");
            exit;
        }
    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
    }
    
}
?>