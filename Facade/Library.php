<?php
require_once 'database.php';

interface Library{
    public function borrowBook($bookName,$username);
    public function returnBook($bookName,$username);
    public function searchBook($bookName);
    public function bookIsAvailable($bookName);
    public function history($username);
}

class LibraryFacade implements Library {
    protected BookInventory $bookInventory;
    protected UserManagement $userManagement;

    public function __construct($bookInventory,$userManagement){
        $this->bookInventory = $bookInventory;
        $this->userManagement = $userManagement;
    }

    public function borrowBook($bookName, $username){
        if(!$this->bookInventory->getBook($bookName)){
            echo "This book doesn't exist\n";
        }else{
            $this->bookInventory->borrow($bookName,$username);
            $this->bookInventory->descrease($bookName);
        }
    }

    public function returnBook($bookName, $username){
        if(!$this->bookInventory->userHasThisBook($bookName,$username))
            echo "You don't have this book\n";
        else
            $this->bookInventory->returnBook($bookName,$username);
    }

    public function searchBook($bookName){
        if($this->bookInventory->getBook($bookName))
            echo "This book is exist\n";
        else
            echo "This book doesn't exist\n";
    }

    public function bookIsAvailable($bookName){
        if(!$this->bookInventory->getBook($bookName))
            echo "This books is out of stock or doesn't exist\n";
        else
            echo "You can get this book\n";
    }

    public function register(){
        $this->userManagement->register();
    }

    public function verify($username, $password){
        return $this->userManagement->verify($username,$password);
    }

    public function history($username){
        echo "Here's your history\n";
        print_r($this->bookInventory->history($username));
    }

    public function availableBooks(){
        echo "Here's the available books\n";
        print_r($this->bookInventory->availableOptions());
    }
}

class BookInventory {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function history($username){
        return $this->db->history($username);
    }

    public function userHasThisBook($bookName,$username){
        if($this->db->userHasThisBook($bookName,$username))
            return true;
        return false;
    }

    public function borrow($bookName,$username){
        $this->db->borrow($bookName,$username);
    }

    public function descrease($bookName){
        $this->db->decrease($bookName);
    }

    public function returnBook($bookName,$username){
        if(!$this->db->getBook($bookName))
            echo "There's no such book\n";
        else
            $this->db->returnBook($bookName,$username);
    }

    public function getBook($name){
        return $this->db->getBook($name);
    }

    public function availableOptions(){
        $books = $this->db->availableBooks();
        $options = '';
        foreach($books as $book){
            $options .= $book['title']."\n";
        }
        return $options;
    }
}

class UserManagement{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function register(){
        $username = readline("Enter your username: ");
        $password = readline("Enter your password: ");
        $passwordConfirm = readline("Enter your password again: ");

        if($password === $passwordConfirm){
            $this->db->create([
                'username'=>$username,
                'password'=>password_hash($password,PASSWORD_DEFAULT)
            ]);
        }
    }

    public function verify($username, $password){
        if($this->db->validate($username,$password)){
            return true;
        }
        return false;
    }
}

function client(LibraryFacade $library){
    $resp = readline("Do you have an account yes/no? ");
    if($resp=="no"){
        $library->register();
    }
    echo "\nLog in\n";
    $username = readline("Enter your username: ");
    $password = readline("Enter your password: ");

    $option = null;
    if($library->verify($username,$password)){
        echo welcome();
        while($option!='0'){
            echo options();
            $option = readline();

            switch ($option) {
                case 1:
                    $name = readline("Enter the book name: ");
                    $library->searchBook($name);
                    break;
                case 2:
                    $name = readline("Enter the book name: ");
                    $library->bookIsAvailable($name);
                    break;
                case 3:
                    $library->availableBooks();
                    $name = readline("Enter the book name: ");
                    $library->borrowBook($name, $username);
                    break;
                case 4:
                    $name = readline("Enter the book name: ");
                    $library->returnBook($name, $username);
                    break;
                case 5:
                    $library->history($username);
                    break;
                case 0:
                    echo "Goodbye!";
                    break;
                default:
                    echo "Invalid option.";
            }
        }
    }
}

function options(): string{
    return "\n1. Search book\n2. Check if book is available\n3. Borrow a Book\n4. Return a Book\n5. View your history\n0. Exit\n";
}

function welcome(): string{
    return "\nWelcome to our Library!\nChoose your option:";
}

$userManagement = new UserManagement();
$bookManagement = new BookInventory();

$library = new LibraryFacade($bookManagement,$userManagement);

client($library);

function test(){
    $bookManagement = new BookInventory();
    $userManagement = new UserManagement();
    $library = new LibraryFacade($bookManagement, $userManagement);

    // Test Case 1: Search for a book
    echo "Test Case 1: Search for a book\n";
    $library->searchBook("To Kill a Mockingbird");

    // Test Case 2: Check if a book is available
    echo "\nTest Case 2: Check if a book is available\n";
    $library->bookIsAvailable("To Kill a Mockingbird");

    // Test Case 3: Borrow a book
    echo "\nTest Case 3: Borrow a book\n";
    $library->borrowBook("To Kill a Mockingbird", "testuser");

    // Test Case 4: Return a book
    echo "\nTest Case 4: Return a book\n";
    $library->returnBook("To Kill a Mockingbird", "testuser");

    // Test Case 5: Attempt to borrow a book that doesn't exist
    echo "\nTest Case 5: Attempt to borrow a book that doesn't exist\n";
    $library->borrowBook("Non-existent Book", "testuser");

    // Test Case 6: Attempt to return a book that hasn't been borrowed
    echo "\nTest Case 6: Attempt to return a book that hasn't been borrowed\n";
    $library->returnBook("To Kill a Mockingbird", "testuser");

    // Test Case 7: Attempt to search for a non-existent book
    echo "\nTest Case 7: Attempt to search for a non-existent book\n";
    $library->searchBook("Blabla Book");
}