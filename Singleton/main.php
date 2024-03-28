<?php

require_once 'database.php';

$config = Database::config("data.json");

$db = Database::getInstance();
print_r($db->getConfig());
print_r($db->query("INSERT INTO users (id, username, email) VALUES (12, 'john', '@mail.ru')"));

$rows = $db->query("SELECT * FROM users");

foreach ($rows as $row){
    echo $row['id']." ".$row['username']." ".$row['email']."\n";
}