<?php

function getPostData($p_id){

	try{
    $dbh = new PDO('pgsql:dbname=portfolio host=127.0.0.1 port=5432', 'postgres', 'Bossmanbig123');
		$sql = 'SELECT * FROM posts WHERE id = :p_id'; 
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':p_id', $p_id); 
    $stmt->execute();
    
		if($stmt){
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
	}catch(Exception $e){
    ini_set('error_log', '/var/log/error.log');
    error_log('エラー発生:'.$e->getMessage());
	}
}


function getGood($p_id){

  try {
       $dbh = new PDO('pgsql:dbname=portfolio host=127.0.0.1 port=5432', 'postgres', 'Bossmanbig123');
       $sql = 'SELECT * FROM goods WHERE post_id = :p_id';
       $stmt = $dbh->prepare($sql);
       $stmt->bindParam(':p_id', $p_id);
       $stmt->execute();
       return $stmt->fetchAll();
       
    } catch (Exception $e) {
      ini_set('error_log', '/var/log/error.log');
      error_log('エラー発生:'.$e->getMessage());
  }
}


function isGood($u_id, $p_id){
  try {
       $dbh = new PDO('pgsql:dbname=portfolio host=127.0.0.1 port=5432', 'postgres', 'Bossmanbig123');
		   $sql = 'SELECT * FROM goods WHERE post_id = :p_id AND user_id = :u_id';
       $stmt = $dbh->prepare($sql);
       $stmt->bindParam(':p_id', $p_id);
       $stmt->bindParam(':u_id', $u_id);
       $stmt->execute();
       $resultCount = Count($stmt->fetchAll());
       
       if(!empty($resultCount)){
        return true;
       }else{
        return false;  
       }
    } catch (Exception $e) {
      ini_set('error_log', '/var/log/error.log');
      error_log('エラー発生:'.$e->getMessage());
}

}