<?php
require('good_function.php');
if(isset($_POST['post_id'])){
   $p_id = $_POST['post_id'];
   $u_id = $_POST['user_id'];
   try{
     $dbh = new mysqli('localhost', 'layman', 'Bossmanbig(123)', 'portfolio');
     $sql = 'SELECT * FROM goods WHERE post_id = ? AND user_id = ?';
     $stmt = $dbh->prepare($sql);
     $stmt->bind_param('ii', $p_id, $u_id);
     $stmt->execute();   
     $result = $stmt->get_result();
     $resultCount = count($result->fetch_all());
   if(!empty($resultCount)){
     $sql = 'DELETE FROM goods WHERE post_id = ? AND user_id = ?';
     $stmt = $dbh->prepare($sql);
     $stmt->bind_param('ii', $p_id, $u_id);
     $stmt->execute();
     echo count(getGood($p_id));
  }else{
     $sql = 'INSERT INTO goods (post_id, user_id) VALUES ( ?, ?)';
     $stmt = $dbh->prepare($sql);
     $stmt->bind_param('ii', $p_id, $u_id);
     $stmt->execute();
     echo count(getGood($p_id));
  }
  }catch(Exception $e){
     ini_set('error_log', '/var/log/error.log');
     error_log('エラー発生:'.$e->getMessage());
   }
}
?>