<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Comment;
use Illuminate\Support\Facades\Redirect;
session_start();

class CommentController extends Controller
{
    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id',$product_id)->get();
        $output = '';
        $stt = 0;
        foreach($comment as $key => $com){
            $stt++;
            $output.= '<div class="row style_comment">
                        <div class="col-md-2" style="padding-left: 0">
                         
                         <img width="80%" src="public/frontend/images/Pikachu.jpg" class="img img-responsive img-thumbnail">
                        </div>
                        <div class="col-md-10" style="padding-left: 0">
                         <p style="color:green;">@'.$com->commenter.'</p>
                         <p style="color:#000;">'.$com->comment_date.'</p>
                         <p>'.$com->comment_content.'</p>
                        </div>
                       </div>
                       <p></p>';
        }
        echo $output;
        if($stt==0){
            echo '<i style="color:blue; padding-left: 360px;">No comment</i>';
        }
        elseif($stt==1){
            echo '<i style="color:blue; padding-left: 360px;">1 comment</i>';
        }
        else{
            echo '<i style="color:blue; padding-left: 360px;">'.$stt.' comments</i>';
        } 
    }

    public function send_comment(Request $request){
        $product_id = $request->product_id;
        $commenter = $request->commenter;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->comment_content = $comment_content;
        $comment->commenter = $commenter;
        $comment->comment_product_id = $product_id;
        $comment->save();
        
    }

    public function comment(){
        $all_comment = Comment::orderby('comment_id','DESC')->join('tbl_product','tbl_product.product_id','=','tbl_comment.comment_product_id')->paginate(10);
        return view('admin.comment.comment_list')->with(compact('all_comment'));
    }

    public function delete_comment(Request $request, $comment_id){
        $comment = Comment::find($comment_id);
        $comment->delete();
        Session::put('message','Delete comment successfully');
        return redirect()->back();
    }

    public function search_comment(Request $request){
        $keywords = $request->keywords_submit;
        $search_comment = Comment::orderby('comment_id','DESC')->join('tbl_product','tbl_product.product_id','=','tbl_comment.comment_product_id')->where('product_name','like','%'.$keywords.'%')->get();
        return view('admin.comment.search_comment')->with('search_comment',$search_comment);
      
    }
}
