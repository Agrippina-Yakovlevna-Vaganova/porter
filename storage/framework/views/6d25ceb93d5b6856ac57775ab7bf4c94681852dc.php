<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/home.css">
</head>
<body>
 
<div class="container">
 
  <div class="aside">

    <div class="login">
     <ul>
      <li>
       <a href="/register">新規登録</a>
      </li>
      <li>
      <a href="/login">ログイン</a>
      </li>
     </ul>
    </div>

    <!-- <form action="" method="post">
      <?php echo csrf_field(); ?> -->
      <div class="postbutton"> 
       <input type="submit" name="post_1" value="投稿する！" class="post_1">
      </div>
    <!-- </form> -->


  </div>

  <div class="contents">
   <ul>
     <li>image</li>
   </ul>
  </div>

</div>


<div id="form_div" class="visible">
  <form action="#" method="post">
    <p id="batu">✖</p>
     <?php echo csrf_field(); ?>

      <li>Title</li>
       <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <li><?php echo e($message); ?></li>
       <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
       <input type="text" name="title" value="<?php echo e(old('title')); ?>">

      <li>Photo</li>
       <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <li><?php echo e($message); ?></li>
       <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
       <div id="input-file">
        <input type="file" id="01" name="file" class="file" multiple>
        <div class="file_button">ファイルを選択する</div>
       </div>
       <ul id='filenames'></ul>

       <li>Comment</li>
       <?php $__errorArgs = ['text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <li><?php echo e($message); ?></li>
       <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
       <textarea type="text" name="text" value="<?php echo e(old('text')); ?>"></textarea>
    
       <div class="postbutton_frame">
        <input type="submit" name="imagepost" value="送信する" class="postsubmit">
       </div> 
  </form>
</div>


<script src="js/home.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>

</script>

</body>
</html>
<?php /**PATH C:\Users\fghjz.LAPTOP-VM64TKHN\Desktop\laravel_insta\resources\views/home.blade.php ENDPATH**/ ?>