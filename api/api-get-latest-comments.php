<?php

session_start();
if( ! isset($_SESSION['userId']) ){
  header('Location: login.php');
}
$_SESSION['userId'] = 1; // For testing via postman, delete later

$db = require_once (__DIR__.'/../private/db.php');

$iLatestCommentId = $_GET['iLatestCommentId'] ?? 0;

try{
$q = $db->prepare('SELECT * FROM view_comments WHERE commentId > :iLatestCommentId LIMIT 10');
$q->bindValue(':iLatestCommentId', $iLatestCommentId);
$q->execute();
$ajRows = $q->fetchAll();
echo json_encode($ajRows);

}catch(Exeption $ex){
  header('Content-Type: application/json');
  echo '{"message":"error '.$ex.'"}';
}
