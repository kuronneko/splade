<?php

namespace App\Forms;

use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Text;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Submit;
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
            Input::make('name')->label('Name')->rules('required', 'max:255'),
            Textarea::make('content')->label('Content')->rules('required', 'max:255'),
            Submit::make()->label('Create'),
        ];
    }

}
