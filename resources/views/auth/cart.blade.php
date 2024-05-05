<x-app-layout>
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
        <div class="flex flex-col text-center w-full mb-20">
        <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">カート一覧</h1>
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
        @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
        @endif
        @if($cartItems->isEmpty())
        <p>カートは空です。</p>
        @else
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
            <tr class="text-center">
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">画像</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">数量</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"></th>
            </tr>
            </thead>
        <tbody>
        @foreach($cartItems as $cartItem)
            <tr class="text-center">
                <td class="flex justify-center"><img src="{{ Storage::url($cartItem->item->img_path) }}" class="rounded-full w-16 h-16 object-cover object-center"></td>
                <td>{{ $cartItem->item->name }}</td>
                <td>{{ $cartItem->item->price }}円</td>
                <td >{{ $cartItem->quantity }}</td>
                <td>
                    <form action="{{ route('cart.delete', [$cartItem->id]) }}" method="GET" onsubmit="return confirm('本当に削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">
                            削除
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
        <div class="mt-4 ">
            <strong>合計金額: {{ $totalPrice }} 円</strong>
        </div>
        @endif
        </div>
        <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto underline">
            <a class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="{{ route('dashboard') }}">商品一覧に戻る</a>
        </div>
            @if(!$cartItems->isEmpty())
            <!-- カートが空でない場合の表示 -->
            <div class="flex items-center justify-center">
                <form action="{{ route('payment.create') }}" method="GET" class="flex items-center">
                    <button type="submit" class="bg-blue-500 text-white rounded-md p-2 ml-2 hover:bg-blue-600 transition duration-300">決済へ</button>
                </form>
            </div>
            @endif
    </div>
    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>