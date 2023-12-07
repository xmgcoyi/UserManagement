<?php

namespace UserManagement;
use PDO;
class FeedbackRepository extends AbstractRepository
{
    public function selectAllByReceiver($reciver)
    {
        $sql = "SELECT * from  feedback where reciver = (:reciver)";
        $query = $this->dbh -> prepare($sql);
        $query-> bindParam(':reciver', $reciver, PDO::PARAM_STR);
        $query->execute();
        $this->results=$query->fetchAll(PDO::FETCH_OBJ);
        return $query->rowCount() > 0;
    }
    public function insert($user, $reciver, $title, $description, $attachment)
    {
        $sql="insert into feedback (sender, reciver, title,feedbackdata,attachment) values (:user,:reciver,:title,:description,:attachment)";
        $query = $this->dbh->prepare($sql);
        $query-> bindParam(':user', $user, PDO::PARAM_STR);
        $query-> bindParam(':reciver', $reciver, PDO::PARAM_STR);
        $query-> bindParam(':title', $title, PDO::PARAM_STR);
        $query-> bindParam(':description', $description, PDO::PARAM_STR);
        $query-> bindParam(':attachment', $attachment, PDO::PARAM_STR);
        $query->execute();
    }
}