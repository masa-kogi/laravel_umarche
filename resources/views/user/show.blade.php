<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:justify-around">
                        <div class="md:w-1/2">
                            <!-- Slider main container -->
                            <div class="swiper-container">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    <div class="swiper-slide">
                                        @if($product->imageFirst->filename !== null)
                                        <img src="{{ asset('storage/products/' . $product->imageFirst->filename) }}" alt="">
                                        @else
                                        <img src="">
                                        @endif
                                    </div>
                                    <div class="swiper-slide">
                                        @if($product->imageSecond->filename !== null)
                                        <img src="{{ asset('storage/products/' . $product->imageSecond->filename) }}" alt="">
                                        @else
                                        <img src="">
                                        @endif
                                    </div>
                                    <div class="swiper-slide">
                                        @if($product->imageThird->filename !== null)
                                        <img src="{{ asset('storage/products/' . $product->imageThird->filename) }}" alt="">
                                        @else
                                        <img src="">
                                        @endif
                                    </div>
                                    <div class="swiper-slide">
                                        @if($product->imageFourth->filename !== null)
                                        <img src="{{ asset('storage/products/' . $product->imageFourth->filename) }}" alt="">
                                        @else
                                        <img src="">
                                        @endif
                                    </div>
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination"></div>

                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>

                                <!-- If we need scrollbar -->
                                <div class="swiper-scrollbar"></div>
                            </div>
                        </div>
                        <div class="md:w-1/2 ml-4">
                            <div class="flex justify-between">
                                <h2 class="mb-4 text-sm title-font text-gray-500 tracking-widest">{{ $product->category->name }}</h2>

                                <h1 class="mb-4 text-gray-900 text-2xl title-font font-medium"><span class="text-sm text-gray-500">メーカー名: </span>{{ $product->maker->name }}</h1>
                                <!-- <h2 class="mb-4 text-sm title-font text-gray-500 tracking-widest">{{ $product->maker->name }}</h2> -->
                            </div>
                            <div class="flex justify-between">
                                <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium"><span class="text-sm text-gray-500">商品名: </span>{{ $product->name }}</h1>
                                <!-- <div>
                                    <div id="star" class="flex"></div>
                                </div> -->
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-500 mr-2">評価: </div>
                                    <div id="star-avg-score" class="flex" data-score="{{ $avgScore }}"></div>
                                    <div class="ml-2">{{ $avgScore }}</div>
                                </div>
                            </div>
                            <p class="mb-4 leading-relaxed">
                                @if(strlen($product->information) > 200)
                                {{ Str::limit($product->information, 200, '') }}
                                <span class="read-more-show hide_content text-blue-600">続きを見る</span>
                                <span class="read-more-content">
                                    {{ Str::substr($product->information, 50, strlen($product->information)) }}
                                    <span class="read-more-hide hide_content  text-blue-600">隠す</span>
                                </span>
                                @else
                                {{ $product->information }}
                                @endif
                            </p>
                            <div class="flex justify-around items-center">
                                <div>
                                    <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}</span><span class="text-sm text-gray-700">円(税込)</span>
                                </div>
                                <form method="post" @auth action="{{ route('user.cart.add') }}" @else action="{{ route('user.guest.cart.add') }}" @endauth>
                                    @csrf
                                    <div class="flex items-center">
                                        <span class="mr-3">数量</span>
                                        <div class="relative">
                                            <select name="quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                                @for($i=1; $i<=$quantity; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <button class="flex ml-auto text-white bg-indigo-500 border-0 mt-1 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="w-2/3 mx-auto border rounded mt-4 bg-white border-gray-200">
                            <section class="text-gray-600 body-font overflow-hidden">
                                <div class="container px-5 py-5 mx-auto">
                                    <div class="flex justify-end"><img class="block h-8 w-auto fill-current text-gray-600 mr-2" src="{{ asset("images/speech_bubble.svg") }}" alt="">{{ count($reviews) }}件</div>
                                    <div class="text-right mb-4 text-blue-600"><a href=" {{ route('user.items.reviews.index', ['item' => $product->id ]) }}">全てのレビューを見る</a></div>
                                    @foreach($reviews as $review)
                                    <div class="-my-8 divide-y-2 divide-gray-100">
                                        <div class="py-8 flex flex-wrap md:flex-nowrap">
                                            <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                                                <span class="font-semibold title-font text-gray-700">ユーザー名: {{ $review->user->name }}</span>
                                                <span class="mt-1 text-gray-500 text-sm">{{ $review->created_at }}</span>
                                                <div class="flex items-center">
                                                    <div class="text-sm text-gray-500 mr-2">評価: </div>
                                                    <div class="star-score flex" data-score="{{ $review->score }}"></div>
                                                    <div class="ml-2">{{ $review->score }}</div>
                                                </div>
                                            </div>
                                            <div class="md:flex-grow">
                                                <!-- <p class="leading-relaxed">{{ $review->comment }}</p> -->
                                                <!-- <p class="leading-relaxed">{{ $review->comment }}</p> -->
                                                <p class="leading-relaxed">
                                                    <!-- {!! nl2br(e(Str::limit($review->comment, 30, 'もっと見る'))) !!} -->
                                                    @if(strlen($review->comment) > 200)
                                                    {{ Str::limit($review->comment, 200, '') }}
                                                    <span class="read-more-show hide_content text-blue-600">続きを見る</span>
                                                    <span class="read-more-content">
                                                        {{ Str::substr($review->comment, 50, strlen($review->comment)) }}
                                                        <span class="read-more-hide hide_content  text-blue-600">隠す</span>
                                                    </span>
                                                    @else
                                                    {{ $review->comment }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </section>
                        </div>

                        <div class="border-t border-gray-400 my-8"></div>
                        <div class="mb-4 text-center">この商品を販売しているショップ</div>
                        <div class="mb-4 text-center">{{ $product->shop->name }}</div>
                        <div class="mb-4 text-center">
                            @if($product->shop->filename !== null)
                            <img class="mx-auto object-cover w-40 h-40 rounded-full" src="{{ asset('storage/shops/' . $product->shop->filename) }}" alt="">
                            @else
                            <img src="">
                            @endif
                        </div>
                        <div class="mb-4 text-center">
                            <button data-micromodal-trigger="modal-1" href='javascript:;' type="button" class="ml-auto text-white bg-gray-400 border-0 py-2 px-6 focus:outline-none hover:bg-gray-500 rounded">ショップの詳細を見る</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
                <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                    <header class="modal__header">
                        <h2 class="text-xl text-gray-700" id="modal-1-title">
                            {{ $product->shop->name }}
                        </h2>
                        <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                    </header>
                    <main class="modal__content" id="modal-1-content">
                        <p>
                            {{ $product->shop->information }}
                        </p>
                    </main>
                    <footer class="modal__footer">
                        <button type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
                    </footer>
                </div>
            </div>
        </div>
        <script src="{{ mix('js/swiper.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ mix('js/read-more.js') }}"></script>
        <script src="{{ mix('js/star-rating.js') }}"></script>
</x-app-layout>
