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
        $userRcm = $this->db->resultSetASS();
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
        $results = $this->db->resultSetASS();
        if ($results) {
            return $results;
        } else {
            return false;
        }
    }
}
