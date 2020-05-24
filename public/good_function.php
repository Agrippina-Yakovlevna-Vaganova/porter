<?php


function getPostData($p_id){
	try{
      // $url = parse_url(getenv("DATABASE_URL"));
      // $dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
      // $pdo = new PDO($dsn, $url['user'], $url['pass']);
      // $pdo = new PDO('pgsql:dbname=portfolio host=127.0.0.1 port=5432', 'postgres', 'Bossmanbig123');
      // $pdo = new PDO('mysql:dbname=portfolio;host=127.0.0.1', 'layman', 'Bossmanbig123');
      $pdo = new PDO('mysql:dbname=xs935265_portfolioportfolio;host=sv10353.xserver.jp', 'xs935265_layman', 'Bossmanbig123');
		  $sql = 'SELECT * FROM posts WHERE id = :p_id'; 
      $stmt = $pdo->prepare($sql);
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
      //  $url = parse_url(getenv("DATABASE_URL"));
      //  $dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
      //  $pdo = new PDO($dsn, $url['user'], $url['pass']);
      //  $pdo = new PDO('pgsql:dbname=portfolio host=127.0.0.1 port=5432', 'postgres', 'Bossmanbig123');
      //  $pdo = new PDO('mysql:dbname=portfolio;host=127.0.0.1', 'layman', 'Bossmanbig123');
       $pdo = new PDO('mysql:dbname=xs935265_portfolio;host=sv10353.xserver.jp', 'xs935265_layman', 'Bossmanbig123');
       $sql = 'SELECT * FROM goods WHERE post_id = :p_id';
       $stmt = $pdo->prepare($sql);
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
      //  $url = parse_url(getenv("DATABASE_URL"));
      //  $dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
      //  $pdo = new PDO($dsn, $url['user'], $url['pass']); 
      //  $pdo = new PDO('pgsql:dbname=portfolio host=127.0.0.1 port=5432', 'postgres', 'Bossmanbig123');
      //  $pdo = new PDO('mysql:dbname=portfolio;host=127.0.0.1', 'layman', 'Bossmanbig123');
       $pdo = new PDO('mysql:dbname=xs935265_portfolio;host=sv10353.xserver.jp', 'xs935265_layman', 'Bossmanbig123');
		   $sql = 'SELECT * FROM goods WHERE post_id = :p_id AND user_id = :u_id';
       $stmt = $pdo->prepare($sql);
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