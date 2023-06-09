<x-app-layout>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit post') }}
            </h2>
            <Link href="{{route('posts.index')}}" class="border rounded-md shadow-sm font-bold py-2 px-4 focus:outline-none focus:ring focus:ring-opacity-50 bg-indigo-500 hover:bg-indigo-700 text-white border-transparent focus:border-indigo-300 focus:ring-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                  </svg>
            </Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <x-splade-form :default="$post" method="PUT" :action="route('posts.update', $post)" class="space-y-4 max-w-md mx-auto p-4 bg-white rounded-md">
                    <x-splade-input name="published_at" label="Date (Datetime componente)" date time/>

                    <x-splade-input name="name" label="Name (Input component)" />

                    <x-splade-select name="category_id" :options="$categories" label="Category (Simple select component)" />

                    <x-splade-select name="tags[]" :options="$tags" multiple relation choices label="Tags (Multiple select component)" />

                    <x-splade-checkboxes name="tags" :options="$tags" relation label="Tags (Multiple checkboxes component)"/>

                    <x-splade-file name="image" label="Image (Single file component)" filepond preview />

                    <x-splade-textarea name="content" label="Content (Text area component)" />

                    <x-splade-input name="position" label="Position (Number component)" type="number"/>

                    <x-splade-checkbox name="visible" value="1" false-value="0" label="Visible (Single checkbox component)" />

                    <x-splade-group name="visible" label="Visible (Radio group component)" inline>
                        <x-splade-radio name="visible" value="1" label="Visible" />
                        <x-splade-radio name="visible" value="0" label="Hidden" />
                    </x-splade-group>

                    <x-splade-submit class="mt-4" label="Edit"/>
                </x-splade-form>
            </div>
        </div>
    </div>
</x-app-layout>
