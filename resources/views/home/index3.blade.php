<?php
ini_set('display_errors', 1);
require('good_function.php');
if(Auth::check()){
  $userid = $user->id;
}else{
  $userid = "";
}
$many=[];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="{{ secure_asset('css/home.css') }}">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/7583396cb7.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="wrap">  

<div class="container">
 
  <div class="aside">

     <p class="check">{{$check['name']}}:Login</p>

     <div class="logout">
      <a href="/logout">Logout</a>
     </div>

    <ul>
     @error('title')
      <li>{{$message}}</li>
     @enderror

     @error('files')
      <li>{{$message}}</li>
     @enderror
    </ul>
   
  </div>

  <div class="contents">
   <ul>
    @foreach($data as $item)
     <li>
      @if($item->name !== "deleted" && in_array($item->id, $match))
       <p>Name:{{$item->name}}</p>

       @if (Auth::check() && $user->name === $item->name)
        <a href="delete/{{$item->id}}"><img class="trash" src="{{ secure_asset('images/trash.jpg') }}" alt=""></a>
       @endif

       <p>Title:{{$item->title}}</p>



      @endif

      <?php 
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
      ?> 

      @if($item->name !== "deleted" && in_array($item->id, $match))

       <img src="{{ secure_asset($paths[0]) }}" alt="" width="90%" height="300px" class="{{$id}}">

       <p><span class="sheets">1</span><?php echo "/" . $num?></p>
       
       <div class="nextprev">
        <button type="button" class="{{$id}} prev">&lt;&lt;</button>
        <button type="button" class="{{$id}} next">&gt;&gt;</button>
       </div>
 
       @if($item->text)
        <p>{{$item->text}}</p>
       @endif
       
       @if(Auth::check())
        <div class="addcomment"> 
        <a href="http://por-por-poppo.herokuapp.com/comment/<?php echo $user->name . "/" . $item->id ?>">comment</a>
        </div>
       @endif

       @if(count($item->comments) > 0)
       <button type="button" class="show_btn">show comment</button>
       <div class="comment">
        <ul>
         @foreach($item->comments as $commenter)
         <li>
          <p>name:{{$commenter->name}}</p>
          <p>{{$commenter->comment}}</p>
         </li>
         @endforeach
        </ul>
        <button type="button" class="more_btn">コメントをもっとみる</button>
        <button type="button" class="close_btn">非表示にする</button>
       </div>
       @endif

      @endif 
     </li>
    @endforeach
   </ul>
 </div>

</div>


<div id="form_div" class="visible">
  <form action="/home" method="post" enctype="multipart/form-data">
      @csrf
      <p id="batu">✖</p>
      
      <p>Title</p>
       <input type="text" name="title" value="{{old('title')}}">

      <p>Photo</p>

       <div id="input-file">
        <input type="file" id="01" name="files[][image]" class="file" multiple>
        <div class="file_button">ファイルを選択する</div>
       </div>

       <p>20枚まで投降できます。</p>
       <ul id='filenames'></ul>

      <p>Comment</p>
       <textarea type="text" name="text" value="{{old('text')}}"></textarea>
    
     <div class="postbutton_frame">
      <input type="submit" name="imagepost" value="送信する" class="postsubmit">
     </div> 
  </form>
</div>

</div>

<script src="{{ secure_asset('js/home.js') }}"></script>
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
    var base_url = '{!! url('/') !!}';
   
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
     var base_url = '{!! url('/') !!}';
  
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
