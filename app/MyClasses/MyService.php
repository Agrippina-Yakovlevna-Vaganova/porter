<?php
namespace App\MyClasses;

use Illuminate\Http\Request;
use App\Http\Requests\HomeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Image;
use App\Post;
use App\User;

class MyService
{

  
  public function _construct()
  {

  }
  
  public function save(Request $request){

    $name = Auth::user()->name;
       
    $post = new Post();

    $post->name = $name;
    $post->title = $request->title;
    $post->text = $request->text;
    $post->save();

    foreach ($request->file('files') as $number => $file) {
      //複数のリクエストファイルは番号をファイル名の連想配列で送られるのでそれを一つずつ取得

      $name = Auth::user()->name;
      //画像ファイルの形式取得
      $ext = $file['image']->guessExtension();
      //１意な１３桁の文字列
      $unique = uniqid();

      $filename = "{$name}_({$number})__{$unique}.{$ext}";
      //画像を上の名前でpublicのimageフォルダに保存
      $path = $file['image']->storeAs('public/images',$filename);
      //データベースにpathも保存(ここでpostidに関連づけてimageを保存している。)
      $post->images()->create(['path'=> $path]);
     }

    }


  public function delete($id = ''){
    // 削除するためのパスたちをidから特定
    $idsimage = Post::find($id)->images;

    $paths = [];

    // 画像ファイルを削除するために画像のパスたちをidから特定
    foreach ($idsimage as $image){
      $A = $image->path;
      array_push($paths, $A);
     };
            
    //ファイル削除
    Storage::delete($paths);
            
    //タイトル,コメント削除
    $todelete = Post::find($id);
     
    $todelete->name = "deleted";
    $todelete->title = "deleted";
    $todelete->text= "deleted";
    $todelete->save();
  }
     

}