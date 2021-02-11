<?php

declare(strict_types=1);

class Article {

    //corresponds to table columns
    public int $id;
    public string $title;
    public string $body;
    public string $created_at;
    //connection object
    private PDO $conn;

    //db object, instantiate a new post
    //set that connection to the db
    public function __construct(PDO $db_connection){
        $this->conn = $db_connection;
    }


    //get all posts
    //gets info from datagrip

    //prepare statement, prepare the query and execute it
    public function getAllArticles(): PDOStatement {
        $query = 'select * from news_posts';
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement;

    }
    //get single post
    public function getSingleArticle(int $id){
        $query = 'select * from news_posts where id=:id';
        $statement = $this->conn->prepare($query);
        $statement->execute(compact('id'));
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];

    }

    //create Post
    public function createArticle():bool{
        //create query
        //use named params in PDO
        $query = 'insert into news_posts set title=:title, body=:body ';
       //prepare statement
        $statement = $this->conn->prepare($query);
        //clean data, since people are going to submit this
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));

        //bind the data
        $statement->bindParam(":title", $this->title);
        $statement->bindParam(":body", $this->body);

        //execute query
        if($statement->execute()){
            return true;
        }
        //print error if something goes wrong
        printf('error:%s. \n', $statement->error);
        return false;
    }

    //update a post
    public function updateArticle( $id): bool {
        $query = "update news_posts set title=:title, body=:body where id=:id";
        $statement = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        //$this->id = htmlspecialchars(strip_tags($this->id))+0;

        //binding data the SQL statement
        $statement->bindParam(":body", $this->body);
        $statement->bindParam(":title", $this->title);
        $statement->bindParam(":id", $this->id);

        if ($statement->execute()) {
            return true;
        }
        return false;
    }
    //delete a post
    public function deleteArticle($id): bool {
        $query = "delete from news_posts where id=:id";
        $statement = $this->conn->prepare($query);


        $statement->bindParam(":id", $this->id);

        if ($statement->execute(compact('id'))) {
            return true;
        }
        return false;
    }
}

