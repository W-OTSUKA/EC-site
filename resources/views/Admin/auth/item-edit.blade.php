<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ optional(Auth::user())->name }} 様
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-4 mx-auto">
                        <div class="flex flex-col  w-full mb-10">
                            <h1 class="text-center sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">編集</h1>
                            <form method="POST" action="{{ route('admin.item_update', ['id' => $item->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH') <!-- HTTPメソッドを指定 -->
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-600 dark:text-gray-200">商品名</label>
                                    <input type="text" name="name" id="name" value="{{ $item->name }}" class="mt-1 p-2 w-full border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-600 dark:text-gray-200">価格</label>
                                    <input type="text" name="price" id="price" value="{{ $item->price }}" class="mt-1 p-2 w-full border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="memo" class="block text-sm font-medium text-gray-600 dark:text-gray-200">商品説明</label>
                                    <textarea name="memo" id="memo" class="mt-1 p-2 w-full border rounded-md">{{ $item->memo }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="category_id" class="block text-sm font-medium text-gray-600 dark:text-gray-200">カテゴリー選択</label>
                                    <select name="category_id" id="category_id"  class="mt-1 p-2 w-full border rounded-md">
                                        <option value="">カテゴリーを選択してください</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <!-- 元々登録されている画像を表示 -->
                                    @if($item->img_path)
                                        <img src="{{ Storage::url($item->img_path) }}" alt="商品画像" class="mx-auto mb-4 max-w-48 h-auto">
                                    @endif
                                    <label for="name" class=" block text-sm font-medium text-gray-700">商品画像</label>
                                    <input type="file" name="img_path" id="img_path" class="form-input mt-1 block w-full">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded">更新する</button>
                                </div>
                            </form>
                            <div class="flex mt-4  mx-auto underline ">
                                    <a class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.dashboard') }}">商品一覧に戻る</a>
                                </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-admin-layout>