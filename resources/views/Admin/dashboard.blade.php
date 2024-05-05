<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ optional(Auth::user())->name }} 様
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-1 mx-auto">
                          <div class="flex flex-col text-center w-full mb-20">
                            <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">商品一覧</h1>
                            
                            
                            
                            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center justify-center mb-4">
                              @csrf
                              <div>
                                <div class="mb-4">
                                  <div class="flex items-center">
                                      <input type="text" name="search" placeholder="商品を検索" class="p-2 w-full md:w-64 border rounded-md focus:outline-none focus:border-blue-500">
                                      <button type="submit" class="bg-blue-500 text-white rounded-md p-2 ml-2 hover:bg-blue-600 transition duration-300">検索</button>
                                  </div>
                              </div>
                              <div class="mb-4 flex items-center">
                                  <select name="category_id" id="category_id" class="p-2 w-full md:w-64 border rounded-md focus:outline-none focus:border-blue-500">
                                      <option value="">カテゴリーを選択してください</option>
                                      @foreach($categories as $category)
                                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                                      @endforeach
                                  </select>
                                  <button type="submit" class="bg-blue-500 text-white rounded-md p-2 ml-2 hover:bg-blue-600 transition duration-300">検索</button>
                              </div>
                              
                              
                          </form>
                          </div>
                          <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                              <thead>
                                <tr>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品画像</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">カテゴリー名</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                                  <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                  <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($values as $value)
                                <tr>
                                    <td class="text-center"><img src="{{ Storage::url($value->img_path) }}" class="rounded-full w-16 h-16 object-cover object-center"></td>
                                    <td class="py-2">{{ $value->name }}</td>
                                    <td class="py-2">{{ $value->category->name }}</td>
                                    <td class=>{{ $value->price }}円</td>
                                    <td>
                                        <form action="{{ route('admin.itemEdit.create', ['id' => $value->id]) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded">編集</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.item.delete', [$value->id]) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded" onclick="return db_delete('本当に実行しますか？')">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                              </tbody>
                            </table>
                          </div>
                          <div>
                            {{ $values->links() }}
                          </div>
                        </div>
                      </section>
                </div>
            </div>
        </div>
    </div>
    <script>
        function db_delete() {
            if (!window.confirm("削除しますか？")) {
                return false;
            } else {
                return true;
            }
        };
    </script>
</x-admin-layout>
