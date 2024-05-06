<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ optional(Auth::user())->name }} 様
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-4 mx-auto">
                            <div class="flex flex-col  w-full mb-10">
                                <h1 class="text-center sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">売り上げ記録</h1>
                                <form method="GET" action="{{ route('admin.purchase.create') }}" class="max-w-2xl mx-auto  ">
                                    @csrf
                                    <!-- 開始日、終了日、購入者の検索フォームを追加 -->
                                    <div class="flex space-x-4 mb-4">
                                        <!-- 開始日 -->
                                        <div class="w-1/2">
                                            <label for="start_date" class="block text-sm font-medium text-gray-700">開始日</label>
                                            <input type="date" name="start_date" id="start_date" class="mt-1 p-2 border rounded-md w-80" >
                                        </div>
                                        <!-- 終了日 -->
                                        <div class="w-1/2">
                                            <label for="end_date" class="block text-sm font-medium text-gray-700">終了日</label>
                                            <input type="date" name="end_date" id="end_date" class="mt-1 p-2 border rounded-md w-80" >
                                        </div>
                                    </div>
                                    <div>
                                        <label for="search_categories" class="block text-sm font-medium text-gray-600 dark:text-gray-200">カテゴリー選択</label>
                                        <select name="search_categories" id="search_categories"  class="mt-1 p-2 w-full border rounded-md">
                                            <option value="">カテゴリーを選択してください</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="py-6 text-center">
                                        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">検索</button>
                                    </div>
                                </form>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="text-left px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-1/7">販売日時</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/7">カテゴリー名</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/7">商品名</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-1/7">価格</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-1/7">数量</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-1/7">小計</th>
                                                <th class="w-1/7 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($values as $value)
                                            <tr>
                                                <td>{{ $value->created_at }}</td>
                                                <td>{{ $value->item->category->name}}</td>
                                                <td>{{ $value->item->name }}</td>
                                                <td>{{ $value->item->price }}円</td>
                                                <td class= "text-center">{{ $value->quantity }}</td>
                                                <td>{{ $value->item->price * $value->quantity }}円</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-4 border-t pt-4 flex justify-end">
                                        <strong class="text-xl">合計金額: {{ $totalPrice }} 円</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ $values->links() }}
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>