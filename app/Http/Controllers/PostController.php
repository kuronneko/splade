<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use App\Tables\PostsTable;

use Illuminate\Http\Request;
use App\Forms\CreatePostForm;
use ProtoneMedia\Splade\Facades\Toast;

class PostController extends Controller
{
    public function index(): View{
        return view('posts.index', [
            'posts' => PostsTable::class
        ]);
    }

    public function create(): View{
        $form = CreatePostForm::make();
        return view('posts.create', [
            'form' => $form,
        ]);

    }

    public function store(Request $request, CreatePostForm $form)
    {
        $validatedData = $form->validate($request);

        Post::create($validatedData);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post): View{
        return view('posts.edit', [
            'post' => $post, // Pass the post object to the view
        ]);
    }

    public function update(Request $request, Post $post, CreatePostForm $form)
    {
        $validatedData = $form->validate($request);

        $post->update($validatedData);

        Toast::title('Your post was updated!')
        ->autoDismiss(3)
        ->centerTop();

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post){
        $post->delete();

        Toast::title('Your post was deleted!')
        ->autoDismiss(3)
        ->centerTop();

        return redirect()->route('posts.index');
    }

}
