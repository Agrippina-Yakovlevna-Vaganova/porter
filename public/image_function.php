<?php

 function save() {
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
       $message = "予期せぬエラーが発生しました。";
 };
};
