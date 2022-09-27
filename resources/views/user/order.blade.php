<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レビュー一覧
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class="container px-5 py-5 mx-auto">
                            @foreach($orders as $order)
                            @foreach($order->products as $product)
                            <div class="-my-2 divide-gray-200 border-b-2">
                                <div class="py-8 flex flex-wrap md:flex-nowrap">
                                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col border-r-2">
                                        <span class="font-semibold title-font text-gray-700">購入日: {{ $order->created_at->format('Y/m/d') }}</span>
                                    </div>
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <div class="md:flex md:items-center mb-2">
                                            <div class="md:w-3/12">
                                                <!-- @if($product->imageFirst->filename !== null)
                                                <img src="{{ asset('storage/products/' . $product->imageFirst->filename) }}" alt="">
                                                @else
                                                <img src="">
                                                @endif -->
                                                <a href="{{ route('user.items.show', ['item' => $product->id ]) }}">
                                                    <x-thumbnail filename="{{ $product->imageFirst->filename ?? '' }}" type="products" />
                                                </a>
                                            </div>
                                            <div class="md:w-9/12 md:ml-2">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <div>
                                                            <span class="text-gray-500">商品名: </span>{{ $product->name }}
                                                        </div>
                                                        <div>
                                                            <span class="text-gray-500">商品単価: </span>{{ number_format($product->price) }} 円
                                                        </div>
                                                        <div>
                                                            <span class="text-gray-500">商品個数: </span>{{ $product->pivot->quantity }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-500">メーカー名: </span>{{ $product->maker->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
