<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mt-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="md:flex md:items-center mb-2">
                <div class="md:w-3/12">
                    @if($item->imageFirst->filename !== null)
                    <img src="{{ asset('storage/products/' . $item->imageFirst->filename) }}" alt="">
                    @else
                    <img src="">
                    @endif
                </div>
                <div class="md:w-9/12 md:ml-2">
                    <div class="flex justify-between">
                        <div>
                            <span class="text-gray-500">商品名: </span>{{ $item->name }}
                        </div>
                        <div>
                            <span class="text-gray-500">メーカー名: </span>{{ $item->maker->name }}
                        </div>
                        <div class="flex items-center">
                            <div class="text-sm text-gray-500 mr-2">評価: </div>
                            <div id="star-avg-score" class="flex" data-score="{{ $avgScore }}"></div>
                            <div class="ml-2">{{ $avgScore }}</div>
                        </div>

                    </div>
                    <div>
                        <span class="text-gray-500">商品情報:</span> <br>
                        @if(strlen($item->information) > 200)
                        {{ Str::limit($item->information, 200, '') }}
                        <span class="read-more-show hide_content text-blue-600">続きを見る</span>
                        <span class="read-more-content">
                            {{ Str::substr($item->information, 50, strlen($item->information)) }}
                            <span class="read-more-hide hide_content  text-blue-600">隠す</span>
                        </span>
                        @else
                        {{ $item->information }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/read-more.js') }}"></script>
<script src="{{ mix('js/star-rating.js') }}"></script>
