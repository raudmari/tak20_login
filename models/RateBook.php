<?php

require_once 'libraries/Database.php';

class RateBook
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function userRatedBooks($username, $email)
    {
        $this->db->query('SELECT book_id FROM rating WHERE username = :username OR username = :email GROUP BY book_id');
        $this->db->bind(':username', $username);
        $this->db->bind(':username', $email);
        $userRB = $this->db->resultSet();
        if ($userRB) {
            return $userRB;
        } else {
            return false;
        }
    }

    public function ratedBooks()
    {
        $this->db->query('SELECT tb.id, tb.book_name, tb.book_author, 
        COALESCE(AVG(r.rating_number), 0) as rate 
        FROM top_books as tb 
        LEFT JOIN rating as r 
        ON tb.id = r.book_id 
        GROUP BY tb.id');
        $results = $this->db->resultSet();
        if ($results) {
            return $results;
        } else {
            return false;
        }
    }

    public function setBookValue($data)
    {
        $this->db->query('INSERT INTO rating (book_id, rating_number, username) VALUES (:id, :rating, :username)');
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