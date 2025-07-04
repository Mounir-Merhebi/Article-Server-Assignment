<?php 
require("../connection/connection.php");

$query = "CREATE TABLE articles (
    id INT(11) AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(255) NOT NULL, 
    author VARCHAR(255) NOT NULL, 
    description TEXT NOT NULL,
    category_id INT(11),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
)";

$execute = $mysqli->prepare($query);
$execute->execute();
