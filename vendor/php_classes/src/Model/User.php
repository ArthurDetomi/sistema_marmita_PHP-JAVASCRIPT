<?php
namespace Sistema\Model;
use \Sistema\DB\Sql;
use \Sistema\Model;
use \Sistema\Mailer;

class User extends Model{

    const SESSION = "User";
    const ERROR = "UserError";

    public static function login($login, $password)
    {   
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN",array(
            ":LOGIN"=>$login
        ));
        if(count($results) === 0){
            return NULL;
        }
        $data = $results[0];
        if(password_verify($password, $data["despassword"]) === true){
            $user = new User();
            $user->setData($data);
            $_SESSION[User::SESSION] = $user->getValues();
            return $user;
        }else{
            return NULL;
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

    public static function getEmailForgot($email)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_persons a INNER JOIN tb_users b USING(idperson) WHERE a.desemail = :desemail",array(
            ":desemail"=>$email
        ));
        if(count($results) === 0){
            return NULL;
        }else{
            $data = $results[0];
            $result_call = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)",array(
                ":iduser"=>$data["iduser"],
                ":desip"=>$_SERVER["REMOTE_ADDR"]
            ));
            if(count($result_call) === 0){
                return NULL;
            }else{
                $datarecovery = $result_call[0];
                define("SECRET_IV", pack("a16", "arthursecret"));
                define("SECRET", pack("a16", "arthursecret"));
                $code = base64_encode(openssl_encrypt(
                    $datarecovery["idrecovery"],
                    "AES-128-CBC",
                    SECRET,
                    0,
                    SECRET_IV
                ));
                $link = "localhost/sistemamarmita/admin/forgot/reset/".$code;
                $mailer = new Mailer($data["desemail"], $data["desperson"], "Redefinir senha da Marmita Maná:\n", "forgot", array(
                    "name"=>$data["desperson"],
                    "link"=>$link
                ));
                $mailer->send();
                return $data;
            }
        }
    }

    public static function validForgotDecrypt($code)
    {
        define("SECRET_IV", pack("a16", "arthursecret"));
        define("SECRET", pack("a16", "arthursecret"));
        $idrecovery = openssl_decrypt(
            base64_decode($code),
            "AES-128-CBC",
            SECRET,
            0,
            SECRET_IV
        );
        $sql = new Sql();
        
        $results = $sql->select("SELECT * FROM tb_userspasswordsrecoveries a INNER JOIN tb_users b USING(iduser) INNER JOIN tb_persons c USING(idperson) WHERE a.idrecovery = :idrecovery and a.dtrecovery is NULL AND DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW()", array(
            ":idrecovery"=>$idrecovery
        )); 

        if(count($results) === 0){
            return NULL;
        }else{
            return $results[0];
        }

    }

    public static function setForgotUsed($idrecovery)
    {
        $sql = new Sql();
        $sql->query("UPDATE FROM tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery",array(
            ":idrecovery"=>$idrecovery
        ));
    }

    public function setPassword($password)
    {
        $sql = new Sql();
        $sql->query("UPDATE tb_users SET despassword = :despassword WHERE iduser = :iduser",array(
            ":despassword"=>User::getHashPassword($password),
            ":iduser"=>$this->getiduser()
        ));
    }

    public static function setError($msg)
    {
        $_SESSION[User::ERROR] = $msg;
    }

    public static function getError()
    {
        $msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : '';
        User::clearError();
        return $msg;
    }

    public static function clearError()
    {   
        $_SESSION[User::ERROR] = NULL;
    }
}
?>