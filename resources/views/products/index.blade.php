<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Products') }}
            </h2>
            <a class="flex"  href="{{ route('products.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="ml-1">Add Product</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a class="flex" href="{{ route('products.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="ml-1">Add Product</span>
                    </a>
                    <section class="grid grid-cols-1 p-8 sm:grid-cols-2 lg:grid-cols-3 gap-10 section-bg-color">
                        @foreach($products as $product)
                            <div class="shadow-md rounded-2xl bg-white flex flex-col gap-6 p-2">
                                <figure class="w-full h-52 relative flex justify-center items-center">
                                    <img
                                        src="{{ asset('storage/'.($product->image_path ?? '')) }}"
                                        class="max-w-full w-auto max-h-full h-auto" alt="#"/>
                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="bg-gradient-to-r from-slate-300 to-slate-500 text-white absolute right-3 top-6 z-10 font-bold px-3 py-1 w-fit rounded-2xl uppercase leading-8">
                                        Edit
                                        </a>
                                </figure>
                                <div class="flex flex-col gap-4 px-4 grow">
                                    <div class="flex justify-between">
                                        <h1 class="text-3xl font-bold leading-8">
                                            ${{number_format($product->price ?? 0,2)}}
                                        </h1>
                                        <form action="{{ route('products.destroy',$product->id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="delete-product bg-red-600 from-slate-300 to-slate-500 py-2 px-6 text-lg font-bold leading-6 uppercase text-white rounded-md"
                                                    title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="flex flex-col grow">
                                        <h2 class="text-lg font-bold leading-8 uppercase text-black line-clamp-1 text-gray-600">
                                            {{ $product->name ?? ''}}
                                        </h2>
                                        <p class="text-lg font-normal leading-7 para-text-color grow text-gray-500">
                                            {{ $product->description ?? '' }}
                                        </p>
                                    </div>
                                    <a
                                        href="{{ route('products.show', $product->id) }}"
                                        class="text-center bg-gradient-to-r from-slate-300 to-slate-500 py-2 px-6 text-lg font-bold leading-6 uppercase text-white rounded-md">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
    </div>
    @push('js_after_stack')
        <script>
            $('.delete-product').click(function (e) {
                e.preventDefault() // Don't post the form, unless confirmed
                if (confirm('Are you sure?')) {
                    // Post the form
                    $(e.target).closest('form').submit() // Post the surrounding form
                }
            });
        </script>
    @endpush
</x-app-layout>
