<?php

declare(strict_types=1);// enforces strict types for PHP, like typescript

// add some headers, header function is built into PHP. headers needed for HTTP!
header("Access-Control-Allow-Origin: *"); // completely public, allows CORS
header("Content-Type: application/json; charset=UTF-8"); // content type is JSON

include_once '../config/database.php';
include_once '../objects/article.php';


//instantiate db and connect
$db_connection = (new Database()) ->getConnection();


//instantiate posts object

$article = new Article($db_connection);

//get id
//so we can get something.com?id=3, 3 in this case, get from a parameter
//if that is set, then get the id else end it
$article->id = isset($_GET['id']) ? $_GET['id']+0 : die();

//get single post

$article->getSingleArticle($article->id);

//return json data
//create array

$article_arr = array(
    'id'=> $article->id,
    'title' => $article->title,
    'body'=> $article->body
);

//convert to json data
print_r(json_encode($article_arr));