<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\View\View;

use App\Tables\PostsTable;
use Illuminate\Http\Request;
use App\Forms\CreatePostForm;
use App\Services\ImageService;
use ProtoneMedia\Splade\Facades\Toast;
use Illuminate\Support\Facades\Storage;

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

        $post = new Post();
        $post->category_id = $validatedData['category_id'];
        $post->name = $validatedData['name'];
        $post->content = $validatedData['content'];
        $post->published_at = $validatedData['published_at'];
        if ($request->hasFile('image')) {
            $imageUrl = ImageService::uploadImagen($request->file('image'));
            if (!str_contains($imageUrl, 'error')) {
                $post->image = $imageUrl;
            }
        }
        $post->save();

        //Post::create($validatedData);

        Toast::title('Your post was created!')
        ->autoDismiss(3)
        ->centerBottom();

        return redirect()->route('posts.index');
    }

    public function edit(Post $post): View{
        return view('posts.edit', [
            'post' => $post, // Pass the post object to the view
            'categories' => Category::pluck('name', 'id')->toArray(),
        ]);
    }

    public function update(Request $request, Post $post, CreatePostForm $form)
    {
        $validatedData = $form->validate($request);

        $post->category_id = $validatedData['category_id'];
        $post->name = $validatedData['name'];
        $post->content = $validatedData['content'];
        $post->published_at = $validatedData['published_at'];
        if ($request->hasFile('image')) {
            $imageUrl = ImageService::uploadImagen($request->file('image'));
            if (!str_contains($imageUrl, 'error')) {
                $post->image = $imageUrl;
            }
        }
        $post->update();

        //$post->update($validatedData);

        Toast::title('Your post was updated!')
        ->autoDismiss(3)
        ->centerBottom();

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post){
        $filePath = 'public/images/' . basename($post->image);
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
        $post->delete();

        Toast::title('Your post was deleted!')
        ->autoDismiss(3)
        ->centerBottom();

        return redirect()->route('posts.index');
    }

}
