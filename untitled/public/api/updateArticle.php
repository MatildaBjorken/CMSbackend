<?php

declare(strict_types=1);// enforces strict types for PHP, like typescript

// add some headers, header function is built into PHP. headers needed for HTTP!
header("Access-Control-Allow-Origin: *"); // completely public, allows CORS
header("Content-Type: application/json; charset=UTF-8"); // content type is JSON
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/article.php';


//instantiate db and connect
$db_connection = (new Database()) ->getConnection();


//instantiate posts object

$article = new Article($db_connection);

//get the raw posted data
//get what is submitted
$data = json_decode(file_get_contents('php://input'));

//set id to update
$article->id = (int)$data->id;

//assign the data to the post
$article->title = $data->title;
$article->body = $data->body;

//update the post
//methods created in the article
//if statement in-case it wont happen

if($article->updateArticle($article->id)){
    echo json_encode(
        array('message' => 'who it works, you updated a post')
    );
}else{
    echo json_encode(
        array('message' => 'naj, is wont work, you didnt update'));
}
