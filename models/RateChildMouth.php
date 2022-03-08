<?php
require_once 'libraries/Database.php';

class RateChildMouth
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function userRatedCm($username, $email)
    {
        $this->db->query('SELECT cm_id FROM rating WHERE username = :username OR username = :email GROUP BY cm_id');
        $this->db->bind(':username', $username);
        $this->db->bind(':username', $email);
        $userRcm = $this->db->resultSet();
        if ($userRcm) {
            return $userRcm;
        } else {
            return false;
        }
    }

    public function ratedChildMouth()
    {
        $this->db->query('SELECT cm.id, cm.child_text,  
        COALESCE(AVG(r.rating_number), 0) as rate 
        FROM childs_mouth as cm 
        LEFT JOIN rating as r 
        ON cm.id = r.cm_id 
        GROUP BY cm.id
        ORDER BY RAND()');
        $results = $this->db->resultSet();
        if ($results) {
            return $results;
        } else {
            return false;
        }
    }

    public function setChildValue($data)
    {
        $this->db->query('INSERT INTO rating (cm_id, rating_number, username) VALUES (:id, :rating, :username)');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':username', $data['username']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}