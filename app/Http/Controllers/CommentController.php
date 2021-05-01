<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $comment;
    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }    
    public function index() {
        return response() -> json([
            'status' => 'success',
            'data'   => Comment::with('article')->get()
        ]);
    }
    public function create(Request $request) {
        $v = Validator::make($request->all(), [
            'comment' => 'required',
            'article_id' => 'required|exists:articles,id',
        ]);
        $comment = $this->comment->create([
            'user_id' => auth()->guard('api')->user()->id,
            'comment' => $request->comment,
            'article_id' => $request->article_id,
        ]);
        return response() -> json([
            'status' => 'success',
            'data'   => new CommentResource($comment),
        ]);
    }
}
