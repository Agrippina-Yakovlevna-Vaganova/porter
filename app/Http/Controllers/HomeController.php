<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests\HomeRequest;
use App\MyClasses\MyService;
use Illuminate\Support\Facades\Auth;
use App\Image;
use App\Post;
use App\User;
use App\Good;
use App\Comment;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function get(Request $request){

       $data = Post::all();
       $path = Image::all();
       $comment = Comment::all();

       if(Auth::check()){
          $user = Auth::user();
          $check = $user->name;
       }else{
          $user = "";
          $check = "";
       }
       
       $material = [
          'data' => $data,
          'path' => $path,
          'check' => $check,
          'user' => $user,
          'comment' => $comment,
       ];

       return view('home.index1re', $material);
    }


    public function post(Request $request, MyService $myservice)
    {   
        $rules =  [
            'title' => 'required',
            'files' => 'required',
            'files.*.image'  => 'required|image|mimes:jpeg,png,jpg'
         ];
         $messages = [
            'title.required' => 'タイトルは必ず入力してください',
            'files.required' => 'ファイルは必ず選択してください',
            'files.mimes' => 'ファイルの形式をjpeg.png.,jpgのいずれかにしてください'
         ];
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             return redirect('/home')
           ->withErrors($validator)
           ->withInput();
         }
         $myservice->save($request);
         return redirect('/home');
    }

    
    
    public function logout(){
          Auth::logout();
          return redirect('/home');
    }

    
    public function delete($id = '', MyService $myservice){
          $myservice->delete($id);
          $previouspage = url()->previous();
          return redirect($previouspage);
    }

   public function comment($name, $id){
      $arg = [
         'id' => $id,
         'name' => $name,
      ];
      return view('home.index2re', $arg);
   }

   public function commentpost(Request $request){
      $comment = new Comment();
      $comment->name = $request->name;
      $comment->post_id = $request->postid;
      $comment->comment = $request->text;
      $comment->save();
      return redirect('/home');
   }

   public function favorite($id){
      $data = Post::all();
      $path = Image::all();
      $comment = Comment::all();
      $check = [];
      $match = [];

      if(Auth::check()){
         $user = Auth::user();
         $check = Auth::user();
      }else{
         $user = "";
         $check['name'] = "";
      }

      $good_records = Good::where('user_id', $id)->get()->toArray();
      foreach($good_records as $item){
         $x = $item["post_id"];
        array_push($match, $x);
      }
       
      $material = [
         'data' => $data,
         'path' => $path,
         'check' => $check,
         'user' => $user,
         'comment' => $comment,
         'match' => $match,
      ];
       
      return view('home.index3re', $material);
   }

   }
