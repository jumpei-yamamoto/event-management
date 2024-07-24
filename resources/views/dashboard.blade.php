<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Your Event URLs</h3>
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('generate.url') }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Generate New Event URL
                        </button>
                    </form>

                    @if($urls->count() > 0)
                        <ul class="list-disc pl-5">
                            @foreach($urls as $url)
                                <li class="mb-2">
                                    <a href="{{ route('events.index', $url->url) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ route('events.index', $url->url) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>You haven't generated any Event URLs yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>