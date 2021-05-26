<?php

session_start();
if( ! isset($_SESSION['userId']) ){
  header('Location: ../index.php');
}

$db = require_once (__DIR__.'/../private/db.php');

$iLatestMessageId = htmlspecialchars($_POST['LastMid']) ?? 0;

try{
$q = $db->prepare('CALL getLastMessages(:sendreId, :roomId, :iLatestMessageId)');
$q->bindValue(':sendreId', $_SESSION['userId']);
$q->bindValue(':roomId', htmlspecialchars($_GET['room']));
$q->bindValue(':iLatestMessageId', $iLatestMessageId);
$q->execute();
$ajData = $q->fetchAll();
header('Content-Type: application/json');
echo json_encode($ajData);

}catch(Exception $ex){
  header('Content-Type: application/json');
  echo '{"message":"error '.$ex.'"}';
}
