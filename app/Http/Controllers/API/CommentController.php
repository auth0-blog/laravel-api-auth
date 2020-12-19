<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
  public function index()
  {
    $comments = Comment::all();
    return response()->json($comments);
  }

  /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|max:255',
      'text' => 'required'
    ]);

    $newComment = new Comment([
      'name' => $request->get('name'),
      'text' => $request->get('text')
    ]);

    $newComment->save();

    return response()->json($newComment);
  }

  /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
  public function show($id)
  {
    $comment = Comment::findOrFail($id);
    return response()->json($comment);
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
    $comment = Comment::findOrFail($id);

    $request->validate([
      'name' => 'required|max:255',
      'text' => 'required'
    ]);
    
    $comment->name = $request->get('name');
    $comment->text = $request->get('text');
    
    $comment->save();

    return response()->json($comment);
    
  }

  /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
  public function destroy($id)
  {
    $comment = Comment::findOrFail($id);
    $comment->delete();

    return response()->json(Comment::all());
  }
}