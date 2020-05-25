<?php
error_reporting(E_ALL);
require('good_function.php');
$many=[];

if(Auth::check()){
  $userid = $user->id;
}else{
  $userid = "";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="<?php echo e(secure_asset('css/home.css')); ?>">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/7583396cb7.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="wrap">
 
<div class="container">
 
  <div class="aside">

    <div class="login">
     <ul>
      <li>
       <a href="/register">Create</a>
      </li>
      <li>
       <a href="/login">Login</a>
      </li>
     </ul>
    </div>

    <?php if(Auth::check()): ?>
    <?php echo csrf_field(); ?> 
     <div class="postbutton"> 
      <input type="submit" name="post_1" value="Post" class="post_1">
     </div>

     <p class="check"><?php echo e($check); ?>:Login</p>

     <div class="logout">
      <a href="/logout">Logout</a>
     </div>

     <div class="favorite">
      <a href="http://por-por-poppo.herokuapp.com/home/favorite/<?php echo e($user->id); ?>">My favorite</a>
     </div>
    <?php endif; ?>
  
    <ul>
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

     <?php $__errorArgs = ['files'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
      <li><?php echo e($message); ?></li>
     <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </ul>
   
  </div>

  <div class="contents">
   <ul>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <li>
      <?php if($item->name !== "deleted"): ?>

       <p>Name:<?php echo e($item->name); ?></p>

       <?php if(Auth::check() && $user->name === $item->name): ?>
        <a href="delete/<?php echo e($item->id); ?>"><img class="trash" src="<?php echo e(secure_asset('images/trash.jpg')); ?>" alt=""></a>
       <?php endif; ?>

       <p>Title:<?php echo e($item->title); ?></p>
       
       <?php if(isset($user->id)): ?>
        <i class="far fa-thumbs-up fa-2x <?php if(isGood($user->id, $item->id)){ echo 'clicked';}; ?>" id="<?php echo e($item->id); ?>"></i>
       <span><?php if(getGood($item->id) === null){echo "0";}else{echo count(getGood($item->id));}; ?></span>
       <?php endif; ?>

      <?php endif; ?>

      <?php 
      
      try{
       $id = $item->id;

       $idsimage = App\Post::find($id)->images;

       $paths = [];
       
       foreach ($idsimage as $image){
         $A = $image->path;
         array_push($paths, $A);
       }

       $num = count($paths);

       $paths = str_replace('public/', 'storage/', $paths);

       array_push($many, $paths);

       $tocomment = App\Post::find($id)->comments;

      }catch(Exception $e){
        echo "予期せぬエラーが発生しました。";
      };
      ?> 

      <?php if($item->name !== "deleted"): ?>
       <img src="<?php echo e(secure_asset($paths[0])); ?>" alt="" width="90%" height="300px" class="<?php echo e($id); ?>">
       <p><span class="sheets">1</span><?php echo "/" . $num?></p>

       <div class="nextprev">
        <button type="button" class="<?php echo e($id); ?> prev">&lt;&lt;</button>
        <button type="button" class="<?php echo e($id); ?> next">&gt;&gt;</button>
       </div>
      
       <?php if(isset($item->text)): ?>
        <p><?php echo e($item->text); ?></p>
       <?php endif; ?>
       
       <?php if(Auth::check()): ?>
        <div class="addcomment"> 
         <a href="http://por-por-poppo.herokuapp.com/comment/<?php echo $user->name . "/" . $item->id;  ?>">comment</a>
        </div>
       <?php endif; ?>

       <?php if(count($item->comments) > 0): ?>
       <button type="button" class="show_btn">show comments</button>
       <div class="comment">
        <ul>
         <?php $__currentLoopData = $item->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <li>
          <p>name:<?php echo e($commenter->name); ?></p>
          <p><?php echo e($commenter->comment); ?></p>
         </li>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="more_btn">more </button>
        <button type="button" class="close_btn">close</button>
       </div>
       <?php endif; ?>

      <?php endif; ?> 
     </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </ul>
 </div>

</div>


<div id="form_div" class="visible">
  <form action="/home" method="post" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <p id="batu">✖</p>
    
      <p>Title</p>
       <input type="text" name="title" value="<?php echo e(old('title')); ?>">

      <p>Photo</p>

       <div id="input-file">
        <input type="file" id="01" name="files[][image]" class="file" multiple>
        <div class="file_button">ファイルを選択する</div>
       </div>

       <ul id='filenames'></ul>

      <p>Comment</p>
       <textarea type="text" name="text" value="<?php echo e(old('text')); ?>"></textarea>
    
     <div class="postbutton_frame">
      <input type="submit" name="imagepost" value="Submit" class="postsubmit" onclick="this.disabled = true;">
     </div> 
  </form>
</div>

</div>

<script src="<?php echo e(secure_asset('js/home.js')); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function() {
    //多重送信
  $('.postsubmit').click(function() {
    $(this).prop('disabled', true);
    $("form").submit();
  })
  //image表示
  var many = (<?= json_encode($many) ?>);

  var number = '';
  var paths = '';
  var i = 0;
  $('.next').click(function() {

    let number = $(this).attr('class')[0];
    var paths  = many[number-1];
    var length = paths.length;
    var tocut = $(this).parent().prevAll('img').attr('src');
    var keys = tocut.match(/(?<=\().*?(?=\))/);
    var key = keys[0];

    if(key < length-1){
    key++;
    let path  = paths[key];
    $(this).parent().prevAll('img').first().attr('src', path);
    $(this).parent().prev("p").children("span").html(key + 1);
    };
  });

  $('.prev').click(function() {

    let number = $(this).attr('class')[0];
    var paths  = many[number -1];
    var length = paths.length;
    var tocut = $(this).parent().prevAll('img').attr('src');
    var keys = tocut.match(/(?<=\().*?(?=\))/);
    var key = keys[0];

    if(key > 0){
    key = key - 1;
    let path  = paths[key];
    $(this).parent().prevAll('img').first().attr('src', path);
    $(this).parent().prev('p').children('span').html(key + 1);
    };
  });


  //いいね
  $('.far').on('click',function(e){
      e.stopPropagation();
      var kore = $(this);
      var postid = $(this).attr('id');
      <?php if($userid){
        echo "var userid = " . $userid  . ";";
      }?>
  $.ajax({
     url: 'good.php',
     type: 'POST',
     data:{
       post_id: postid,
       user_id: userid
       }
     }).done(function(data){
        //いいね総数
        $(kore).next('span').html(data);
        $(kore).toggleClass('clicked');

     }).fail(function(msg) {
        console.log('fail'); 
  });
 

 });


  //コメント
  var defaultNum = 3;
  var addNum = 3;
  var currentNum = 0;

  $('.comment').each(function() {
   $(this).find(".more_btn").hide();
   $(this).hide();
   
    
   $(".show_btn").click(function() {
    $(this).next(".comment").show();
    $(this).hide();
  
    if($(this).next('.comment').find("li").length > 3){
       $(this).next(".comment").find(".more_btn").show();
       $(this).next(".comment").find(".close_btn").show();
    }else{
       $(this).next(".comment").find(".close_btn").show();
    }
   }); 

   $(this).find("li:not(:lt("+defaultNum+"))").hide();
   currentNum = defaultNum;

   $(".more_btn").click(function() {
    currentNum += addNum;
    $(this).parent().find("li:lt("+currentNum+")").slideDown();
    
    if($(this).parent('.comment').find("li").length <= currentNum) {
     currentNum = defaultNum;   
     $(".more_btn").hide();
    }  
   });
   
    $(".close_btn").click(function() {
     $(this).parent().find("li:gt(2)").slideUp();
     $(this).parent().prev(".show_btn").show();
     $(this).hide(); 
     $(".comment").hide();
    });
  });
});
</script>

</body>
</html>
<?php /**PATH /home/xs935265/production/laravel/resources/views/home/index.blade.php ENDPATH**/ ?>