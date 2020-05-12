<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
  <title>Comment</title>
  <link rel="stylesheet" href="{{ secure_asset('/css/comment.css') }}" >
</head>
<body>
  <div class="comment">
   <h1>Comment!</h1>
   <form action="#" method="post">
   @csrf
     <textarea name="text" id="" cols="30" rows="10"></textarea>
     <input type="hidden" name="name" value="{{$name}}">
     <input type="hidden" name="postid" value="{{$id}}">
     <input type="submit" value="Submit">
   </form>
  </div>
</body>
</html>  
