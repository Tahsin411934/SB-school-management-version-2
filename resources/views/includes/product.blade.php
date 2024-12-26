<section id="Projects"
    class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">


    @if ($products)
        @foreach ($products as $c)
            <div class="w-72 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                <a href="#">
                    <img src="{{ asset($c->photo) }}" alt="Product" class="h-80 w-72 object-cover rounded-t-xl" />
                    <div class="px-4 py-3 w-72">
                        <span class="text-gray-400 mr-3 uppercase text-xs">{{ $c->category->name }}</span>
                        <span class="text-gray-400 mr-3 uppercase text-xs">{{ $c->subCategory->name }}</span>
                        <p class="text-lg font-bold text-black truncate block capitalize"> {{ $c->name }}</p>
                        <div class="flex items-center">
                            <form method="POST" action="{{ URL::to('store-transaction/' . $c->id) }}">
                                @csrf
                                <button type="submit"
                                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span
                                        class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Buy Now
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    @endif



</section>
