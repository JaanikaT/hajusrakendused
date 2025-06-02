<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post, Request $request)
    {
        //dd($post, $request);
        $post->comments()->create($request->validate([
            'comment'=> 'required',
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //dd($comment);
        if ($comment->user_id !== auth()->id()) {
            return back()->with('flash',[
                'type' => 'error', 
                'message' => 'Saad kustutada ainult enda lisatud kommentaari.',
            ]);
        }
    
        $comment->delete();
    
        return redirect()->back()->with('flash',[
            'type' => 'success', 
            'message' => 'Kommentaar kustutatud',
        ]);
    }
}
