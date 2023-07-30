@if (session()->has('message'))
    <div>
        {{ session()->get('message')}}
    </div>

@endif


@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif

<x-guest-layout>
    <form method="POST" action="/photos" enctype="multipart/form-data">
        @csrf

        <!-- Photo Upload -->
        <div>
            <x-input-label for="photo" :value="__('Select Photo')" />
            <input id="photo" class="block mt-1 w-full" type="file" name="photo" required />
            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>

        <!-- Category Selection -->
        <div class="mt-4">
            <x-input-label for="category" :value="__('Category')" />
            <select id="category" class="block mt-1 w-full" name="category" required>
                <option value="wedding">Wedding</option>
                <option value="product">Product</option>
                <option value="outdoor">Outdoor</option>
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <!-- Rank Input -->
        <div class="mt-4">
            <x-input-label for="rank" :value="__('Rank')" />
            <input id="rank" class="block mt-1 w-full" type="number" name="rank" required />
            <x-input-error :messages="$errors->get('rank')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <!-- Add Cancel Button if needed -->
            <x-secondary-button href="{{route('dashboard')}}" class="mr-4">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Upload Photo') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
