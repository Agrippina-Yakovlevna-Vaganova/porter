<?php
require('good_function.php');
if(isset($_POST['post_id'])){
   $p_id = $_POST['post_id'];
   $u_id = $_POST['user_id'];

   try{
      
     $dbh = new PDO('pgsql:dbname=portfolio host=127.0.0.1 port=5432', 'postgres', 'Bossmanbig123');
  
     $sql = 'SELECT * FROM goods WHERE post_id = :p_id AND user_id = :u_id';
     $stmt = $dbh->prepare($sql);
     $stmt->bindParam(':p_id', $p_id);
     $stmt->bindParam(':u_id', $u_id);
     $stmt->execute();

   if(Count($stmt->fetchAll())){
     $sql = 'DELETE FROM goods WHERE post_id = :p_id AND user_id = :u_id';
     $stmt = $dbh->prepare($sql);
     $stmt->bindParam(':p_id', $p_id);
     $stmt->bindParam(':u_id', $u_id);
     $stmt->execute();
     echo count(getGood($p_id));
  }else{
     $sql = 'INSERT INTO goods (post_id, user_id) VALUES ( :p_id, :u_id)';
     $stmt = $dbh->prepare($sql);
     $stmt->bindParam(':p_id', $p_id);
     $stmt->bindParam(':u_id', $u_id);
     $stmt->execute();
     echo count(getGood($p_id));
  }
  }catch(Exception $e){
     ini_set('error_log', '/var/log/error.log');
     error_log('エラー発生:'.$e->getMessage());
   }
}
?>