<?php 

require(__DIR__ . "/../models/Article.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ArticleService.php");
require(__DIR__ . "/../services/ResponseService.php");

class ArticleController{
    
    public function getAllArticles(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $articles = Article::all($mysqli);
            $articles_array = ArticleService::articlesToArray($articles); 
            echo ResponseService::success_response($articles_array);
            return;
        }

        $id = $_GET["id"];
        $article = Article::find($mysqli, $id)->toArray();
        echo ResponseService::success_response($article);
        return;
    }


    public function AddArticles() {
        global $mysqli;
    
        if (!isset($_GET['name']) || !isset($_GET['author']) || !isset($_GET['description']) || !isset($_GET['category_id'])) {
            echo json_encode(["success" => false, "message" => "Missing data"]);
            exit;
        }
    
        $data = [
            'name' => $_GET['name'],
            'author' => $_GET['author'],
            'description' => $_GET['description'],
            'category_id' => $_GET['category_id']
        ];
    
        $article = Article::create($mysqli, $data);
    
        echo ResponseService::success_response($article);
    }    

    
    public function deleteAllArticles() {
        global $mysqli;
    
        if (!isset($_GET["id"])) {
            $articlesDeleted = Article::deleteAll($mysqli);
            if ($articlesDeleted) {
                echo ResponseService::success_response("All articles have been deleted");
            } else {
                echo ResponseService::error_response("Failed to delete articles or no articles to delete");
            }
            return;
        }
    
        $id = $_GET["id"];
        $deleted = Article::delete($mysqli, (int)$id);
    
        if ($deleted) {
            echo ResponseService::success_response("The article with ID $id has been deleted");
        } else {
            echo ResponseService::error_response("Article with ID $id could not be deleted");
        }
    }


public function UpdateArticles() {
        global $mysqli;
    
        if (!isset($_GET['id']) && !isset($_GET['name']) &&  !isset($_GET['author']) &&  !isset($_GET['description']) &&  !isset($_GET['category_id'])) {
            echo json_encode(["success" => false, "message" => "Missing data"]);
            exit;
        }
        
        $data = [
            'id' => (int)$_GET['id'],
            'name' => $_GET['name'],
            'author' => $_GET['author'],
            'description' => $_GET['description'],
            'category_id' => $_GET['category_id'] 
        ];

       
        $success = Article::update($mysqli, $data);
    
        if ($success) {
            echo ResponseService::success_response("Article with ID {$data['id']} has been updated.");
        } else {
            echo ResponseService::error_response("Failed to update article with ID {$data['id']}");
        }
    }


    public function getAllArticles_ByCategoryId(){
        global $mysqli;

        $category_id = $_GET['category_id'];
        if(isset($_GET['category_id'])){
            $articles = Article::findByCategoryID($mysqli, $category_id); 
            echo ResponseService::success_response($articles);
            return;
        } 
        else{
            echo ResponseService::success_response("Please enter the category id");
        }
    } 


    public function getCategoryNameByArticle_id(){
        global $mysqli;

        $id = $_GET['id'];
        if(isset($_GET['id'])){
            $articles = Article::findCategoryByArticle_id($mysqli, $id); 
            echo ResponseService::success_response($articles);
            return;
        } 
        else{
            echo ResponseService::success_response("Please enter the article id");
        }
    } 


    
}  

//To-Do:

//1- Try/Catch in controllers ONLY!!! 
//2- Find a way to remove the hard coded response code (from ResponseService.php)
//4- Create a BaseController and clean some imports 