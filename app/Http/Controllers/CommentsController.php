<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Http\Requests\CommentsRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'comment_post_ID', 'comment_parent');

        $data['article_id'] = $request->input('comment_post_ID');
        $data['parent_id'] = $request->input('comment_parent');

        $atr = [
            'article_id' => 'integer|required',
            'parent_id' => 'integer|required',
            'text' => 'string|required',
        ];
        if (!Auth::check()) {
            $atr = Arr::add($atr, 'name', 'required|max:255');
            $atr = Arr::add($atr, 'email', 'email|required|max:255');
            $atr = Arr::add($atr, 'site', 'required|max:255');
        }

        $validator = Validator::make($data, $atr);

        if ($validator->fails()) {
            return Response::json(['error' => $validator->errors()->all()]);
        }

        $user = Auth::user();

        $comment = new Comment($data);


        if ($user) {
            $comment->user_id = $user->id;
            $comment->name = ''; $comment->site = ''; $comment->email = '';
        }

        $comment->load('user');

        $data['id'] = $comment->id;
        $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
        $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;

        $post = Article::find($data['article_id']);
        $post->comments()->save($comment);

        $data['hash'] = md5($data['email']);

        $view_comment = view(env('THEME') . '.content_one_comment', compact('data'))->render();

        return Response::json(['success' => true, 'comment' => $view_comment, 'data' => $data]);

    }
}
