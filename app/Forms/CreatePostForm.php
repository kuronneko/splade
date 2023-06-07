<?php

namespace App\Forms;

use App\Models\Category;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Date;
use ProtoneMedia\Splade\FormBuilder\File;
use ProtoneMedia\Splade\FormBuilder\Text;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\FormBuilder\Datetime;
use ProtoneMedia\Splade\FormBuilder\Textarea;

class CreatePostForm extends AbstractForm
{
    public function configure(SpladeForm $form)
    {
        $form
            ->action(route('posts.store'))
            ->method('POST')
            ->class('space-y-4 max-w-md mx-auto p-4 bg-white rounded-md"')
            ->fill([
                //
            ]);
    }

    public function fields(): array
    {

        return [
            Datetime::make('published_at')->label('Date')->required(),
            Input::make('name')->label('Name')->rules('required', 'max:255'),
            Select::make('category_id')->label('Category')->options(Category::pluck('name', 'id')->toArray())->required(),
            File::make('image')
            ->filepond()
            //->server()   // Enables asynchronous uploads of files
            ->preview()  // Show image preview
            ->maxSize('10Mb')
            ->label('Image')->required(),
            Textarea::make('content')->label('Content')->rules('required', 'max:255'),
            Submit::make()->label('Create'),
        ];
    }

}
