<?php 
require("../connection/connection.php");
require("../models/category.php");

$categories = [
    ['name' => 'Technology'],
    ['name' => 'Health'],
    ['name' => 'Science'],
    ['name' => 'Education'],
    ['name' => 'Travel'],
    ['name' => 'Lifestyle'],
    ['name' => 'Food'],
    ['name' => 'Sports'],
    ['name' => 'Politics'],
    ['name' => 'Entertainment'],
];

foreach($categories as $category){
    $newCategory = Category::create($mysqli, $category);
}

