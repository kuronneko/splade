<?php

namespace App\Forms;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeForm;
use ProtoneMedia\Splade\AbstractForm;
use ProtoneMedia\Splade\FormBuilder\Checkbox;
use ProtoneMedia\Splade\FormBuilder\Date;
use ProtoneMedia\Splade\FormBuilder\File;
use ProtoneMedia\Splade\FormBuilder\Text;
use ProtoneMedia\Splade\FormBuilder\Input;
use ProtoneMedia\Splade\FormBuilder\Select;
use ProtoneMedia\Splade\FormBuilder\Submit;
use ProtoneMedia\Splade\FormBuilder\Datetime;
use ProtoneMedia\Splade\FormBuilder\Number;
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
            Datetime::make('published_at')
            ->label('Date (Datetime componente)')
            ->required(),

            Input::make('name')
            ->label('Name (Input component)')
            ->rules('required', 'max:255'),

            Select::make('category_id')
            ->label('Category (Simple select component)')
            ->options(Category::pluck('name', 'id')->toArray()) /* El selector simple, se carga con un Array cuyo contenido es el "id" y "name" de la entidad Category */
            ->required(),

            Select::make('tags[]')
            ->label('Tags (Multiple select component)')
            ->options(Tag::pluck('name', 'id')->toArray()) /* El selector multiple, se carga con un Array cuyo contenido es el "id" y "name" de la entidad Tag */
            ->multiple() /* Convierte el selector simple a un selector multiple */
            ->choices() /* Librería para facilitar la selección de los elementos */
            ->required(),

            File::make('image')
            ->label('Image (Single file component)')
            ->filepond() /* Utiliza la libreria filepond para crear un file input más bakán */
            ->preview() /* Genera una preview de la imagen adjunta */
            ->maxSize('10Mb')
            ->required()
            ->accept(['image/png', 'image/jpeg']),

            Textarea::make('content')
            ->label('Content (Text area component)')
            ->rules('required', 'max:255'),

            Number::make('position')
            ->label('Position (Number component)')
            ->minValue(1)
            ->maxValue(999999999)
            ->required(),

            Checkbox::make('visible')
            ->label('Visible (Single checkbox component)')
            ->value(1),

            Submit::make()->label('Create'),
        ];
    }

}
