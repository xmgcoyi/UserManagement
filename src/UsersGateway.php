<?php

namespace Application;

use PDO;

class UsersGateway extends AbstractGateway
{
    public function findByEmail($email)
    {
        $sql = "SELECT * from users where email = (:email);";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function countByEmailPasswordAndStatus($email, $password, $status)
    {
        $sql = "SELECT email,password FROM users WHERE email=:email and password=:password and status=(:status)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $query->rowCount();
    }

    public function countByUsernameAndPassword($username, $password)
    {
        $sql = "SELECT Password FROM users WHERE email=:username and password=:password";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $query->rowCount();
    }

    public function updateById($name, $email, $mobileno, $designation, $image, $idedit)
    {
        $sql = "UPDATE users SET name=(:name), email=(:email), mobile=(:mobileno), designation=(:designation), Image=(:image) WHERE id=(:idedit)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':designation', $designation, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->bindParam(':idedit', $idedit, PDO::PARAM_STR);
        $query->execute();
    }

    public function updatePasswordByUsername($newpassword, $username)
    {
        $con = "update users set password=:newpassword where email=:username";
        $chngpwd1 = $this->pdo->prepare($con);
        $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
    }

    /**
     * @return int
     */
    public function countIds()
    {
        $sql = "SELECT id from users";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $query->rowCount();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id)
    {
        $sql = "delete from users WHERE id=:id";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        return $query->execute();
    }

    /**
     * @param $memstatus
     * @param $aeid
     * @return bool
     */
    public function updateStatusById($memstatus, $aeid)
    {
        $sql = "UPDATE users SET status=:status WHERE  id=:aeid";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':status', $memstatus, PDO::PARAM_STR);
        $query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
        return $query->execute();
    }

    /**
     * @return array
     */
    public function findAllUsers()
    {
        $sql = "SELECT * from  users ";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return [$results, $query->rowCount()];
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $sql = "SELECT * from users;";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     * @param $gender
     * @param $mobileno
     * @param $designation
     * @param $image
     * @param $status
     * @return bool
     */
    public function insertUser($name, $email, $password, $gender, $mobileno, $designation, $image, $status)
    {
        $sql = "INSERT INTO users(name,email, password, gender, mobile, designation, image, status) VALUES(:name, :email, :password, :gender, :mobileno, :designation, :image, :status)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':designation', $designation, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $success = $query->execute();

        return $success;
    }

    /**
     * @param $email
     * @return bool
     */
    public function deleteByEmail($email)
    {
        $sql = 'delete from users where email = :email';
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        return $query->execute();
    }
}