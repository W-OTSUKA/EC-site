<x-app-layout>
    <div class="container">
        @if (session('flash_alert'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">エラー: </strong>
                <span class="block sm:inline">{{ session('flash_alert') }}</span>
            </div>
        @elseif(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">成功: </strong>
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif
        <div class="p-5">
            <div class="col-6 rounded overflow-hidden shadow-lg">
                <div class="bg-gray-200 text-gray-700 px-6 py-4">Stripe決済</div>
                <div class="px-6 py-4">
                    <form id="card-form" action="{{ route('store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="card_number" class="block text-gray-700 text-sm font-bold mb-2">カード番号</label>
                            <div id="card-number" class="border rounded-md px-3 py-2"></div>
                        </div>

                        <div class="mb-4">
                            <label for="card_expiry" class="block text-gray-700 text-sm font-bold mb-2">有効期限</label>
                            <div id="card-expiry" class="border rounded-md px-3 py-2"></div>
                        </div>

                        <div class="mb-4">
                            <label for="card-cvc" class="block text-gray-700 text-sm font-bold mb-2">セキュリティコード</label>
                            <div id="card-cvc" class="border rounded-md px-3 py-2"></div>
                        </div>
                        <input type="hidden" name="totalPrice" value="{{ $totalPrice }}"/>


                        <div id="card-errors" class="text-red-500 mb-4"></div>

                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded focus:outline-none focus:bg-blue-600">支払い</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe_public_key = "{{ config('stripe.stripe_public_key') }}"
        const stripe = Stripe(stripe_public_key);
        const elements = stripe.elements();

        var cardNumber = elements.create('cardNumber');
        cardNumber.mount('#card-number');
        cardNumber.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var cardExpiry = elements.create('cardExpiry');
        cardExpiry.mount('#card-expiry');
        cardExpiry.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var cardCvc = elements.create('cardCvc');
        cardCvc.mount('#card-cvc');
        cardCvc.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('card-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var errorElement = document.getElementById('card-errors');
            if (event.error) {
                errorElement.textContent = event.error.message;
            } else {
                errorElement.textContent = '';
            }

            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('card-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</x-app-layout>
