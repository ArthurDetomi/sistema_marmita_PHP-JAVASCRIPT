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

    public static function listAllUsers()
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson)ORDER BY b.desperson");
        return $results;
    }

    public function saveData()
    {
        $sql = new Sql();
        $results = $sql->select("CALL sp_save_users (:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)",array(
            ":desperson"=>$this->getdesperson(),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>User::getHashPassword($this->getdespassword()),
            ":desemail"=>$this->getdesemail(),
            ":nrphone"=>$this->getnrphone(),
            ":inadmin"=>$this->getinadmin(),
        ));
        $this->setData($results[0]);
    }

    public static function getHashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, [
            'cost'=>12
        ]);
    }

    public function chargeUser($iduser)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser",array(
            ":iduser"=>$iduser
        ));
        $this->setData($results[0]);
    } 
    
    public function updateUser()
    {
        $sql = new Sql();
        $results = $sql->select("CALL sp_save_usersupdate (:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)",array(
            ":iduser"=>$this->getiduser(),
            ":desperson"=>$this->getdesperson(),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>User::getHashPassword($this->getdespassword()),
            ":desemail"=>$this->getdesemail(),
            ":nrphone"=>$this->getnrphone(),
            ":inadmin"=>$this->getinadmin(),
        ));
        $this->setData($results[0]);
    }

    public function deleteUser()
    {
        $sql = new Sql();
        $sql->query("CALL sp_delete_users (:iduser)",array(
            ":iduser"=>$this->getiduser()
        ));
    }
}
?>