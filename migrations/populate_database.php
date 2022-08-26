<?php

require_once 'src/connection.php';

$db->query('USE '. DB_NAME);

function callApi(string $url) 
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result);
    return $result;
}

$postsUri = 'https://jsonplaceholder.typicode.com/posts';
$commentsUri = 'https://jsonplaceholder.typicode.com/comments';



$postsData = callApi($postsUri);

$postsCount = 0;
$stmt = $db->prepare('INSERT INTO posts (userId, id, title, body) VALUES (:userId, :id, :title, :body)');
foreach ($postsData as $post) {
    $stmt->execute([
        'userId' => $post->userId,
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body
    ]);
    $postsCount++;
}

$commentsData = callApi($commentsUri);

$commentsCount = 0;
$stmt = $db->prepare('INSERT INTO comments (postId, id, name, email, body) VALUES (:postId, :id, :name, :email, :body)');
foreach ($commentsData as $comment) {
    $stmt->execute([
        'postId' => $comment->postId,
        'id' => $comment->id,
        'name' => $comment->name,
        'email' => $comment->email,
        'body' => $comment->body
    ]);
    $commentsCount++;
}
echo "Loaded $postsCount posts and $commentsCount comments.";