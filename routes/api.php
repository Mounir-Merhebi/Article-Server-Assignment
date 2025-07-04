<?php

$apis = [
    '/articles'             => ['controller' => 'ArticleController', 'method' => 'getAllArticles'],
    '/add_articles'         => ['controller' => 'ArticleController', 'method' => 'AddArticles'],  
    '/delete_articles'      => ['controller' => 'ArticleController', 'method' => 'deleteAllArticles'],
    '/update_articles'      => ['controller' => 'ArticleController', 'method' => 'UpdateArticles'],
    '/articlesBycategoryId' => ['controller' => 'ArticleController', 'method' => 'getAllArticles_ByCategoryId'], 
    '/CategoryNameByarticleId' => ['controller' => 'ArticleController', 'method' => 'getCategoryNameByArticle_id'],   

    '/categories'         => ['controller' => 'CategoryController', 'method' => 'getAllCategories'],
    '/add_categories'     => ['controller' => 'CategoryController', 'method' => 'AddCategories'],
    '/delete_categories'  => ['controller' => 'CategoryController', 'method' => 'deleteAllCategories'],
    '/update_categories'  => ['controller' => 'CategoryController', 'method' => 'UpdateCategory'],  

   // '/login'         => ['controller' => 'AuthController', 'method' => 'login'],
   // '/register'         => ['controller' => 'AuthController', 'method' => 'register'],

];

