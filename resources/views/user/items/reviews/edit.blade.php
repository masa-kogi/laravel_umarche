<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-item-summary :item="$item" :avgScore="$avgScore" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="post" action="{{ route('user.items.reviews.update', ['item' => $item->id, 'review' => $review->id]) }}">
                        @csrf
                        @method('put')
                        <div class="-m-2">
                            <!-- <div class="p-2 w-1/2 mx-auto">
                                <label for="rating" class="leading-7 text-sm text-gray-600">点数 ※必須</label>
                                <div class="relative flex justify-around">
                                    <div><input type="radio" name="rating" value="1" {{ $review->rating === 1 ? 'checked' : '' }} class="mr-2">1</div>
                                    <div><input type="radio" name="rating" value="2" {{ $review->rating === 2 ? 'checked' : '' }} class="mr-2">2</div>
                                    <div><input type="radio" name="rating" value="3" {{ $review->rating === 3 ? 'checked' : '' }} class="mr-2">3</div>
                                    <div><input type="radio" name="rating" value="4" {{ $review->rating === 4 ? 'checked' : '' }} class="mr-2">4</div>
                                    <div><input type="radio" name="rating" value="5" {{ $review->rating === 5 ? 'checked' : '' }} class="mr-2">5</div>
                                </div>
                            </div> -->
                            <div class="p-2 w-1/2 mx-auto">
                                <label for="rating" class="leading-7 text-sm text-gray-600">点数 ※必須</label>
                                <div class="flex">
                                    <div id="star-score-edit" class="flex" data-score="{{ $review->score }}"></div><span>
                                        <input id="hint" name="rating" class="ml-3">
                                </div>
                            </div>

                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="comment" class="leading-7 text-sm text-gray-600">感想 ※必須</label>
                                    <textarea id="comment" name="comment" rows="10" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $review->comment }}</textarea>
                                </div>
                            </div>


                            <div class="p-2 w-full flex justify-around mt-4">
                                <button type="button" onclick="location.href='{{ route('user.items.reviews.index', ['item' => $item->id]) }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                            </div>
                        </div>
                    </form>
                    <form id="delete_{{ $review->id }}" method="post" action="{{ route('user.items.reviews.destroy', ['item' => $item->id, 'review' => $review->id]) }}">
                        @csrf
                        @method('delete')
                        <div class="p-2 w-full flex justify-around mt-32">
                            <a href="#" data-id="{{ $review->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        'use strict'

        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除しますか？')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
    <script src="{{ mix('js/star-rating.js') }}"></script>

</x-app-layout>
