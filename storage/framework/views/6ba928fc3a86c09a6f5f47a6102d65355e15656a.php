<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
  <title>Comment</title>
  <link rel="stylesheet" href="<?php echo e(asset('/css/comment.css')); ?>" >
</head>
<body>
  <div class="comment">
   <h1>Comment!</h1>
   <form action="#" method="post">
   <?php echo csrf_field(); ?>
     <textarea name="text" id="" cols="30" rows="10"></textarea>
     <input type="hidden" name="name" value="<?php echo e($name); ?>">
     <input type="hidden" name="postid" value="<?php echo e($id); ?>">
     <input type="submit" value="Submit">
   </form>
  </div>
</body>
</html>  
<?php /**PATH /home/vagrant/laravel_insta/resources/views/home/index2.blade.php ENDPATH**/ ?>