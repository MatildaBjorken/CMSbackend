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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // code that deals with the request from one method
    $result = $article->getAllArticles();
    $rows = $result->rowCount();
    //check if there is posts
    if ($rows > 0) {
        //post array
        $final_array = array();
        //the data is here
        $final_array['articles'] = array();

        //fetch it
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            //extract this and have that as a variable
            extract($row);

            //now we have access to them
            //post item for each post
            $record = array(
                'title'=>$title,
                'body'=> html_entity_decode($body),
                'created_at'=>$created_at,
                'id'=>$id,
            );
            //push everything to the articles
            //loop through each posts and do it for each
            array_push($final_array['articles'], $record);
        }

        //turn it to JSON and output
        json_encode($final_array);
        echo json_encode($final_array);

    }else {
        echo 'silly billy, there are no records! Add your first article already, yeay!';
    }


}