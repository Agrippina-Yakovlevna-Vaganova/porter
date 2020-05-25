<?php
// ini_set('display_errors', 1);
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
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/7583396cb7.js" crossorigin="anonymous"></script>
</head>
<body>
  
<div class="wrap">
<div class="container">
 
  <div class="aside">

     <p class="check"><?php echo e($check['name']); ?>:Login</p>

     <div class="logout">
      <a href="/logout">Logout</a>
     </div>

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
      <?php if($item->name !== "deleted" && in_array($item->id, $match)): ?>
       <p>Name:<?php echo e($item->name); ?></p>

       <?php if(Auth::check() && $user->name === $item->name): ?>
        <a href="delete/<?php echo e($item->id); ?>"><img class="trash" src="<?php echo e(asset('images/trash.jpg')); ?>" alt=""></a>
       <?php endif; ?>

       <p>Title:<?php echo e($item->title); ?></p>



      <?php endif; ?>

      <?php 

      try{
       $paths = [];

       $id = $item->id;
       
       $idsimage = App\Post::find($id)->images;

       foreach ($idsimage as $image){
        $A = $image->path;
        array_push($paths, $A);
       };
       
       $num = count($paths);

       $paths = str_replace('public/', 'storage/', $paths);

       array_push($many, $paths);

       $tocomment = App\Post::find($id)->comments;
      }catch(Exception $e){
        echo "予期せぬエラーが発生しました。";
      };
      ?> 

      <?php if($item->name !== "deleted" && in_array($item->id, $match)): ?>

       <img src="<?php echo e(asset($paths[0])); ?>" alt="" width="90%" height="300px" class="<?php echo e($id); ?>">

       <p><span class="sheets">1</span><?php echo "/" . $num?></p>
       
       <div class="nextprev">
        <button type="button" class="<?php echo e($id); ?> prev"><<</button>
        <button type="button" class="<?php echo e($id); ?> next">>></button>
       </div>
 
       <?php if($item->text): ?>
        <p><?php echo e($item->text); ?></p>
       <?php endif; ?>
       
       <?php if(Auth::check()): ?>
        <div class="addcomment"> 
        <a href="http://192.168.33.10:8000/comment/<?php echo $user->name . "/" . $item->id ?>">comment</a>
        </div>
       <?php endif; ?>

       <?php if(count($item->comments) > 0): ?>
       <button type="button" class="show_btn">show comment</button>
       <div class="comment">
        <ul>
         <?php $__currentLoopData = $item->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <li>
          <p>name:<?php echo e($commenter->name); ?></p>
          <p><?php echo e($commenter->comment); ?></p>
         </li>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="more_btn">コメントをもっとみる</button>
        <button type="button" class="close_btn">非表示にする</button>
       </div>
       <?php endif; ?>

      <?php endif; ?> 
     </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </ul>
 </div>
</div>

<script src="<?php echo e(asset('js/home.js')); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function() {
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
    var base_url = '<?php echo url('/'); ?>';
   
    $(this).parent().prevAll('img').first().attr('src', base_url+"/"+path);

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
     var base_url = '<?php echo url('/'); ?>';
  
     $(this).parent().prevAll('img').first().attr('src', base_url+"/"+path);

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
       user_id: userid,
       _token: '<?php echo e(csrf_token()); ?>' 
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
<?php /**PATH /home/vagrant/laravel_insta/resources/views/home/index3re.blade.php ENDPATH**/ ?>