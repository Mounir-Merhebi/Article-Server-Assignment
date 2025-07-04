<?php
require(__DIR__ . "/../models/Category.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/CategoryService.php");
require(__DIR__ . "/../services/ResponseService.php");

class CategoryController{
    
    public function getAllCategories(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $categories = Category::all($mysqli);
            $categories_array = CategoryService::categoryToArray($categories); 
            echo ResponseService::success_response($categories_array);
            return;
        }

        $id = $_GET["id"];
        $Category = Category::find($mysqli, $id)->toArray();
        echo ResponseService::success_response($Category);
        return;
    }


    public function AddCategories() {
        global $mysqli;
    
        if (!isset($_GET['name'])) {
            echo json_encode(["success" => false, "message" => "Missing data"]);
            exit;
        }
    
        $data = [
            'name' => $_GET['name'],
        ];
    
        $Category = Category::create($mysqli, $data);
    
        echo ResponseService::success_response($Category);
    }    

    
    public function deleteAllCategories() {
        global $mysqli;
    
        if (!isset($_GET["id"])) {
            $categoriesDeleted = Category::deleteAll($mysqli);
            if ($categoriesDeleted) {
                echo ResponseService::success_response("All categories have been deleted");
            } else {
                echo ResponseService::error_response("Failed to delete categories or no categories to delete");
            }
            return;
        }
    
        $id = $_GET["id"];
        $deleted = Category::delete($mysqli, (int)$id);
    
        if ($deleted) {
            echo ResponseService::success_response("The Category with ID $id has been deleted");
        } else {
            echo ResponseService::error_response("Category with ID $id could not be deleted");
        }
    }


public function UpdateCategory() {
        global $mysqli;
    
        if (!isset($_GET['id']) && !isset($_GET['name'])) {
            echo json_encode(["success" => false, "message" => "Missing data"]);
            exit;
        }
        
        $data = [
            'id' => (int)$_GET['id'],
            'name' => $_GET['name'],
        ];

       
        $success = Category::update($mysqli, $data);
    
        if ($success) {
            echo ResponseService::success_response("Category with ID {$data['id']} has been updated.");
        } else {
            echo ResponseService::error_response("Failed to update Category with ID {$data['id']}");
        }
    }
    
}   