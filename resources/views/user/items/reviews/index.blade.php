<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レビュー一覧
        </h2>
    </x-slot>

    <x-item-summary :item="$item" :rating=$rating />

    <div class="py-12">
        <div class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class="container px-5 py-24 mx-auto">
                            @foreach($reviews as $review)
                            <div class="-my-8 divide-y-2 divide-gray-100">
                                <div class="py-8 flex flex-wrap md:flex-nowrap">
                                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                                        <span class="font-semibold title-font text-gray-700">ユーザー名: {{ $review->user->name }}</span>
                                        <span class="mt-1 text-gray-500 text-sm">{{ $review->created_at }}</span>
                                        <!-- <span class="mt-1 text-gray-700 text-md text-center">評価: {{ $review->rating }}</span> -->
                                        <div class="flex items-center">
                                            <div class="text-sm text-gray-500 mr-2">評価: </div>
                                            <div id="star-rating" class="flex" data-score="{{ $review->rating }}"></div>
                                            <div class="ml-2">{{ $review->rating }}</div>
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
                                    <div class="my-auto">
                                        @if($user->id === $review->user_id)
                                        <button onclick="location.href='{{ route('user.items.reviews.edit', ['item' => $item->id, 'review' => $review->id]) }}'" class="text-white bg-indigo-400 border-0 py-2 px-4 w-20 focus:outline-none hover:bg-indigo-500 rounded">編集
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="p-2 w-full flex justify-around mt-4">
            <button type="button" onclick="location.href='{{ route('user.items.show', ['item' => $item->id]) }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
            <button onclick="location.href='{{ route('user.items.reviews.create', ['item' => $item->id ]) }}'" class="mt-2 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">レビューを書く</button>
        </div>

    </div>
    <script src="{{ mix('js/read-more.js') }}"></script>
    <script src="{{ mix('js/star-rating.js') }}"></script>

</x-app-layout>
