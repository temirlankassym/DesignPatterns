<?php

class Database{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('sqlite:database.sqlite3');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function create($data){
        $username = $data['username'];
        $password = $data['password'];
        $sql = "Insert into Users (username, password) values ('$username','$password');";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        echo 'User successfully created';
    }

    public function validate($username, $password){
        $sql = "SELECT password FROM users WHERE username = '$username'";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return password_verify($password,$result[0]["password"]);
    }

    public function getBook($name){
        $sql = "SELECT title FROM books WHERE title = '$name'";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isAvailable($name){
        $sql = "SELECT title FROM books WHERE title = '$name'";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function borrow($name, $username){
        $bookId = $this->getBookId($name);
        $userId = $this->getUserId($username);
        $date = date('d-m-Y');
        $returnDate = date('d-m-Y', strtotime('+7 days'));
        $sql = "INSERT INTO rentals (book_id, user_id, rental_date, return_date) VALUES ($bookId,$userId,'$date','$returnDate');";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        echo 'Book borrowed';
    }

    public function returnBook($name, $username){
        $bookId = $this->getBookId($name);
        $userId = $this->getUserId($username);
        $sql = "DELETE FROM rentals WHERE book_id = $bookId AND user_id = $userId;";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $sql = "UPDATE books SET stock = stock + 1 WHERE title = '$name'";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        echo 'Book returned';
    }

    public function getBookId($name){
        $sql = "SELECT id FROM books WHERE title = '$name'";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['id'];
    }

    public function getUserId($username){
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['id'];
    }

    public function decrease($name){
        $sql = "UPDATE books SET stock = stock - 1 WHERE title = '$name'";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
    }

    public function userHasThisBook($name, $username){
        $bookId = $this->getBookId($name);
        $userId = $this->getUserId($username);
        $sql = "SELECT * FROM rentals WHERE book_id = $bookId AND user_id = $userId";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function history($username){
        $userId = $this->getUserId($username);
        $sql = "SELECT books.title, rentals.rental_date, rentals.return_date FROM rentals JOIN books ON rentals.book_id = books.id WHERE user_id = $userId";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function availableBooks(){
        $sql = "SELECT title FROM books WHERE stock > 0";
        $cursor = $this->db->prepare($sql);
        $cursor->execute();
        $result = $cursor->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}