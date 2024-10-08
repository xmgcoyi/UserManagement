<?php declare(strict_types=1);

namespace App\Gateway;


use PDO;

class AdminGateway extends AbstractGateway
{
    protected $table = 'admins';

    public function getPasswordHashByUsername(string $username) : string | null
    {
        $sql = 'select password_hash from admins where username = :username';
        $query = $this->pdo->prepare($sql);
        $query->execute(['username' => $username]);
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result->password_hash;
        }

        return null;
    }

    public function countByUsernameAndPassword(string $username, string $password):int
    {
        $sql = "select UserName,Password from admins where UserName=:username and Password=:password";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount();
    }

    public function countPasswordByPasswordAndUsername(string $username, string $password):int
    {
        $sql = "select Password from admins where UserName=:username and Password=:password";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount();
    }

    public function updatePasswordByUsername($username, $newpassword)
    {
        $con = "update admin set Password=:newpassword where UserName=:username";
        $chngpwd1 = $this->pdo->prepare($con);
        $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        return $chngpwd1->execute();
    }

    public function updateAdminUsernameAndEmail($name, $email)
    {
        $sql="update admin set username=(:name), email=(:email)";
        $query = $this->pdo->prepare($sql);
        $query-> bindParam(':name', $name, PDO::PARAM_STR);
        $query-> bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
    }
}