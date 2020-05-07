<?php


function getPostData($p_id){
	try{
    $dbh = new mysqli("localhost", "layman", "Bossmanbig(123)", "portfolio");
		$sql = 'SELECT * FROM posts WHERE id = ?'; 
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param('i', $p_id); 
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
       $dbh = new mysqli("localhost", "layman", "Bossmanbig(123)", "portfolio");
       $sql = 'SELECT * FROM goods WHERE post_id = ?';
       $stmt = $dbh->prepare($sql);
       $stmt->bind_param('i', $p_id);
       $stmt->execute();
       $result = $stmt->get_result();
       return $result->fetch_all();
       
    } catch (Exception $e) {
      ini_set('error_log', '/var/log/error.log');
      error_log('エラー発生:'.$e->getMessage());
  }
}


function isGood($u_id, $p_id){

  try {
       $dbh = new mysqli("localhost", "layman", "Bossmanbig(123)", "portfolio");
		   $sql = 'SELECT * FROM goods WHERE post_id = ? AND user_id = ?';
       $stmt = $dbh->prepare($sql);
	     $stmt->bind_param('ii', $p_id, $u_id);
       $stmt->execute();
       $result = $stmt->get_result();
       $resultCount = count($result->fetch_all());
       
       if($resultCount > 0){
        return true;
       }else{
        return false;  
       }
    } catch (Exception $e) {
      ini_set('error_log', '/var/log/error.log');
      error_log('エラー発生:'.$e->getMessage());
}


}