<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;

use Illuminate\View\View;
use App\Tables\PostsTable;
use Illuminate\Http\Request;
use App\Forms\CreatePostForm;
use App\Forms\EditPostForm;
use App\Services\ImageService;
use ProtoneMedia\Splade\Facades\Toast;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EditPostFormRequest;
use App\Http\Requests\CreatePostFormRequest;

class PostController extends Controller
{
    public function index(): View
    {
        return view('posts.index', [
/*      En PostsTable se encuentra la query para poder renderizar la tabla. */
            'posts' => PostsTable::class
        ]);
    }

    public function create(): View
    {
/*      Se genera un formulario utilizando el form builder de splade. */
        $form = CreatePostForm::make();
        return view('posts.create', [
            'form' => $form,
        ]);
    }

    public function store(Request $request, CreatePostForm $form)
    {
        $validatedData = $form->validate($request);

        $post = new Post();
        $post->published_at = $validatedData['published_at'];
        $post->name = $validatedData['name'];
        $post->category_id = $validatedData['category_id'];
        $post->content = $validatedData['content'];
        $post->position = $validatedData['position'];
        $post->visible = $request->visible;
        $post->image = ImageService::uploadImagen($validatedData['image'], 'posts');

        $post->save();

        $post->tags()->attach($validatedData['tags']);

        Toast::title('Your post was created!')
        ->autoDismiss(3)
        ->center();

        return redirect()->route('posts.index');
    }

    public function edit(Post $post): View
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::pluck('name', 'id')->toArray(),
            'tags' => Tag::pluck('name', 'id')->toArray(),
        ]);
    }

    public function update(EditPostFormRequest $request, Post $post)
    {
/*      El formulario de edición no fue generado utilizando el Form Builder de Splade, sino con las etiquetas que este proporciona (<x-splade-form />).
        De esta forma se puede validar la información utilizando los métodos convencionales de Laravel (EditPostFormRequest). */
        $validatedData = $request->validated();

        $post->published_at = $validatedData['published_at'];
        $post->name = $validatedData['name'];
        $post->category_id = $validatedData['category_id'];
        $post->content = $validatedData['content'];
        $post->position = $validatedData['position'];
        $post->visible = $request->visible;

/* Ignora las imagenes "blob" generadas para el preview del editar. También en caso de retornar desde "uploadImagen" con algún error, no se hará el registro */
        if ($validatedData['image']->getClientOriginalName() != 'blob') {
            $imageUrl = ImageService::uploadImagen($validatedData['image'], 'posts');
            if (!str_contains($imageUrl, 'error')) {
                $post->image = $imageUrl;
            }
        }

        $post->update();

        $post->tags()->detach();
        $post->tags()->attach($validatedData['tags']);

        Toast::title('Your post was updated!')
        ->autoDismiss(3)
        ->center();

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $filePath = 'public/images/' . basename($post->image);
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $post->tags()->detach();

        $post->delete();

        Toast::title('Your post was deleted!')
        ->autoDismiss(3)
        ->centerBottom();

        return redirect()->route('posts.index');
    }

}
