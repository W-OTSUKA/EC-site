<x-admin-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ optional(Auth::user())->name }} 様
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-4 mx-auto">
                            <div class="flex flex-col w-full mb-10">
                                <h1 class="text-center sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">カテゴリー登録</h1>
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf

                        <div class="flex items-center mb-4">
                            <div class="flex-1 mr-2">
                                <label for="name" class="block text-sm font-medium text-gray-600">追加カテゴリー名</label>
                                <input type="text" name="name" id="category_id" class="form-input mt-1 block w-full">
                            </div>
                            <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded mt-6">登録する</button>
                        </div>
                        
                    </form>
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                            <tr>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">登録カテゴリー一覧</th>
                                <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <form action="{{ route('admin.delete', [$category->id]) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded" onclick="return db_delete('本当に実行しますか？')">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            var errorMessage = "{{ session('error') }}";
            if(errorMessage) {
                alert(errorMessage);
            }
        }
    </script>

</x-admin-layout>