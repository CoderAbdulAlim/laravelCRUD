<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Post Form -->
                    @auth
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="title" :value="__('Post Title')" />
                            <input name="title" id="title" class="border-gray-300 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="body" :value="__('Post Body')" />
                            <textarea name="body" id="body" rows="6" class="border-gray-300 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>
                        <div class="mt-6">
                            <x-primary-button type="submit" class="ms-3">
                                {{ __('Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Post Title</th>
                                <th scope="col" class="px-6 py-4">Written By</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($posts->count())
                            @foreach($posts as $post)
                            <tr class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $post->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $post->title }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $post->user->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <a href="#" class="text-gray-500 hover:text-gray-600">Show</a>
                                    <!-- ($post->user_id == auth()->id()) -->
                                    <!-- ($post->ownerBy(auth()->user())) -->
                                    @if(auth()->user()->ownsPost($post))
                                    <a href="#" class="text-blue-500 hover:text-blue-600">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <p>There are no post.</p>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
        {{ $posts->links() }}
    </div>
</x-app-layout>