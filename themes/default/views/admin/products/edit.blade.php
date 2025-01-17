<x-admin-layout>
    <x-slot name="title">
        {{ __('Products') }}
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-md sm:rounded-lg dark:bg-darkmode2 dark:shadow-gray-700">
                <div class="p-6 bg-white sm:px-20 dark:bg-darkmode2">
                    <div class="grid grid-cols-1 md:grid-cols-2 mt-4">
                        <div class="text-2xl dark:text-darkmodetext">
                            Update product {{ $product->name }}
                        </div>
                        <div class="relative inline-block text-left justify-end">
                            <button type="button"
                                class="dark:hover:bg-darkmode absolute top-0 right-0 dark:text-darkmodetext dark:bg-darkmode2 inline-flex w-max justify-end bg-white px-2 py-2 text-base font-medium rounded-md text-gray-700 mr-4"
                                id="menu-button" aria-expanded="true" aria-haspopup="true"
                                data-dropdown-toggle="moreOptions">
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                    </path>
                                </svg>
                            </button>
                            <div class="absolute hidden w-max origin-top-right bg-white rounded-md shadow-lg dark:bg-darkmode ring-1 ring-black ring-opacity-5 z-[1]"
                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                                id="moreOptions">
                                <div class="py-1 grid grid-cols-1" role="none">
                                    <a href="{{ route('admin.products.extension', $product->id) }}"
                                        class="block px-4 py-2 text-base text-gray-700 dark:text-darkmodetext dark:hover:bg-darkmode2 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem" tabindex="-1" id="menu-item-0">Extension Settings</a>
                                    <button
                                        class="block px-4 py-2 text-base text-gray-700 dark:text-darkmodetext dark:hover:bg-darkmode2 hover:bg-gray-100"
                                        role="menuitem" tabindex="-1" id="menu-item-0"
                                        onclick="document.getElementById('duplicate').submit()">
                                        {{ __('Duplicate') }}
                                    </button>
                                    <button
                                        class="block px-4 py-2 text-base text-gray-700 dark:text-darkmodetext dark:hover:bg-darkmode2 hover:bg-gray-100 hover:text-red-900 dark:hover:text-red-300"
                                        role="menuitem" tabindex="-1" id="menu-item-0"
                                        onclick="document.getElementById('delete').submit()">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}"
                                id="delete">
                                @csrf
                                @method('DELETE')
                            </form>
                            <form method="POST" action="{{ route('admin.products.duplicate', $product->id) }}"
                                id="duplicate">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <div class="mt-6 text-gray-500 dark:text-darkmodetext dark:bg-darkmode2">
                        <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="name">{{ __('Name') }}</label>

                                <input id="name" class="block w-full mt-1 rounded-lg dark:bg-darkmode" type="text"
                                    name="name" value="{{ $product->name }} " required autofocus />
                            </div>
                            <div class="mt-4 ">
                                <label for="description">{{ __('Description') }}</label>

                                <textarea id="description" class="block w-full mt-1 rounded-lg dark:bg-darkmode" name="description" required rows="4">{{ $product->description }}</textarea>
                            </div>
                            <div class="mt-4">
                                <label for="price">{{ __('Price') }}</label>

                                {{ config('settings::currency_sign') }}<input id="price"
                                    class="block w-full mt-1 rounded-lg dark:bg-darkmode" type="number" name="price"
                                    min="0" step="0.01" value="{{ number_format($product->price, 2) }}"
                                    required />
                            </div>
                            <div class="mt-4">
                                <label for="image">{{ __('Image') }}</label>
                                <p>Only upload a new image if you want to replace the existing one</p>
                                <input id="image" class="block w-full mt-1 rounded-lg dark:bg-darkmode" type="file"
                                    name="image" @if ($product->image == 'null') disabled @endif />
                                <div class="mt-2">
                                    <label for="no_image">No Image</label>
                                    <input type="checkbox" name="no_image" id="no_image" value="1"
                                        class="form-input w-4 h-4" @if ($product->image == 'null') checked @endif>
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-32 h-32 mt-4"
                                        id="prodctimg" onerror="removeElement(this)">
                                    <script>
                                        function removeElement(element) {
                                            element.onerror = "";
                                        }
                                        document.getElementById('no_image').addEventListener('change', function() {
                                            document.getElementById('image').disabled = this.checked;
                                            document.getElementById('prodctimg').classList.toggle('hidden');
                                        });
                                        // Listen for file uploads then display the image
                                        document.getElementById('image').addEventListener('change', function() {
                                            if (this.files && this.files[0]) {
                                                var img = document.getElementById('prodctimg');
                                                img.classList.remove('hidden');
                                                img.src = URL.createObjectURL(this.files[0]);
                                            }
                                        });
                                        if (document.getElementById('no_image').checked) {
                                            document.getElementById('image').disabled = true;
                                            document.getElementById('prodctimg').classList.add('hidden');
                                        }
                                    </script>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="category">{{ __('Category') }}</label>
                                <select id="category" class="block w-full mt-1 rounded-lg dark:bg-darkmode" name="category_id"
                                    required>
                                    @if ($categories->count())
                                        @foreach ($categories as $category)
                                            @if ($category->id == $product->category_id)
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}
                                                </option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="">No categories found</option>
                                    @endif
                                </select>
                                <div class="flex items-center justify-end mt-4 text-blue-700">
                                    <a href="{{ route('admin.categories.create') }}">Create Category</a>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <button type="submit"
                                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 dark:text-darkmodetext">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
