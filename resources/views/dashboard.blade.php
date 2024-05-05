<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ optional(Auth::user())->name }} 様
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">商品一覧</h1>
                    <div class="mb-16"></div>
                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center justify-center mb-4">
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
                </div>
                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-16 mx-auto">
                        <div class="flex flex-wrap -m-4">
                            @foreach($values as $value)
                            <div class="lg:w-1/4 md:w-1/2 p-4 w-full text-center">
                                <a href="{{ route('item.details', ['id' => $value->id]) }}" class="block relative h-48 rounded overflow-hidden">
                                    <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="{{ Storage::url($value->img_path) }}">
                                </a>
                                <div class="mt-4 text-center">
                                    <h2 class="text-gray-900 title-font text-lg font-medium">{{ $value->name }}</h2>
                                    <p class="mt-1">{{ $value->price }}円</p>
                                    <p class="mt-1">
                                        <form action="{{ route('cart.add', ['item_id' => $value->id]) }}" method="post" >
                                            @csrf
                                            <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded">
                                                カートに追加
                                            </button>
                                        </form>
                                    </p>
                                </div>
                            </div>
                            
                            @endforeach
                        </div>
                        <div class="mt-6"></div>
                        <div>
                            {{ $values->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
