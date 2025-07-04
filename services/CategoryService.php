<?php 

class CategoryService {

    public static function categoryToArray($categories_db){
        $results = [];

        foreach($categories_db as $c){
             $results[] = $c->toArray(); 
        } 

        return $results;
    }



}