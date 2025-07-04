<?php
require_once("Model.php");

class Article extends Model{

    private int $id; 
    private string $name; 
    private string $author; 
    private string $description; 
    private int $category_id;
    
    protected static string $table = "articles";

    public function __construct(array $data){
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->author = $data["author"];
        $this->description = $data["description"];
        $this->category_id = $data["category_id"];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCategoryId(): ?int {
        return $this->category_id;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function setAuthor(string $author){
        $this->author = $author;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function setCategoryId(?int $category_id): void {
        $this->category_id = $category_id;
    }


    public function toArray(){
        return [$this->id, $this->name, $this->author, $this->description, 'category_id' => $this->category_id];
    }

    public static function findByCategoryID(mysqli $mysqli, $category_id){
        $sql = "SELECT * FROM articles WHERE category_id = ?";
        
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $category_id);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[] = $row;
        }
        return $objects;
    }



    public static function findCategoryByArticle_id(mysqli $mysqli, $id){
        $sql = "SELECT categories.name FROM categories
                RIGHT JOIN articles ON articles.category_id = categories.id  
                WHERE articles.id = ?";
        
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result();
        $row = $data->fetch_assoc();
        return $row;
    }
    
}


