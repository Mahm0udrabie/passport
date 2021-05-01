<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\CreatePostArticleResource;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $model;
    public function __construct(Article $model)
    {
        $this->model = $model;
    }
    public function index()
    {
       $response = Article::with(['comments.user'])->latest()->paginate(10);
        // $response = Article::with('user')->latest()->get();
        return response()->json([
            "status" => "success",
            // "data" => $response,
            "data"   => ArticleResource::collection($response),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $v = Validator::make($request->all() , [
            'body' => 'required',
            'title'  => 'required'
        ]);
        $post = $this->model->create([
            'user_id' => auth()->guard('api') -> user() ->id,
            'body'    => $request->body,
            'title'   => $request->title,
        ]);
        return response() -> json([
            'status' => "success",
            // 'data'   => $post,
            'data' => new CreatePostArticleResource($post)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = ['message' =>  'store function'];
        return response($response, 200);
    }
    public function show_users() {
        $response = ['data' =>  User::all()];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = ['message' =>  'show function'];
        return response($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = ['message' =>  'edit function'];
        return response($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = ['message' =>  'update function'];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = ['message' =>  'destroy function'];
        return response($response, 200);
    }
}
