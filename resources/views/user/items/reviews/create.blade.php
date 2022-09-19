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
                    <form method="post" action="{{ route('user.items.reviews.store', ['item' => $item->id]) }}">
                        @csrf
                        <div class="-m-2">
                            <!-- <div class="p-2 w-1/2 mx-auto">
                                <label for="rating" class="leading-7 text-sm text-gray-600">点数 ※必須</label>
                                <div class="relative flex justify-around">
                                    <div><input type="radio" name="rating" value="1" {{ old('rating') === 1 ? 'checked' : '' }} class="mr-2">1</div>
                                    <div><input type="radio" name="rating" value="2" {{ old('rating') === 2 ? 'checked' : '' }} class="mr-2">2</div>
                                    <div><input type="radio" name="rating" value="3" {{ old('rating', 3) === 3 ? 'checked' : '' }} class="mr-2">3</div>
                                    <div><input type="radio" name="rating" value="4" {{ old('rating') === 4 ? 'checked' : '' }} class="mr-2">4</div>
                                    <div><input type="radio" name="rating" value="5" {{ old('rating') === 5 ? 'checked' : '' }} class="mr-2">5</div>
                                </div>
                            </div> -->

                            <div class="p-2 w-1/2 mx-auto">
                                <label for="rating" class="leading-7 text-sm text-gray-600">点数 ※必須</label>
                                <div class="flex">
                                    <div id="star-score-post" class="flex"></div>
                                    <input id="hint" name="rating" class="ml-3">
                                </div>
                            </div>

                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="comment" class="leading-7 text-sm text-gray-600">感想 ※必須</label>
                                    <textarea id="comment" name="comment" rows="10" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('comment') }}</textarea>
                                </div>
                            </div>


                            <div class="p-2 w-full flex justify-around mt-4">
                                <button type="button" onclick="location.href='{{ route('user.items.reviews.index', ['item' => $item->id]) }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">投稿する</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/star-rating.js') }}"></script>
</x-app-layout>
