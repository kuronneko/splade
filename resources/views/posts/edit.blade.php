<x-app-layout>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit post') }}
            </h2>
            <Link href="/posts" class="border rounded-md shadow-sm font-bold py-2 px-4 focus:outline-none focus:ring focus:ring-opacity-50 bg-indigo-500 hover:bg-indigo-700 text-white border-transparent focus:border-indigo-300 focus:ring-indigo-200">
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
                    <x-splade-input name="name" label="Name" />
                    <x-splade-input name="content" label="Content" />
                    <x-splade-submit class="mt-4" />
                </x-splade-form>
            </div>
        </div>
    </div>
</x-app-layout>
