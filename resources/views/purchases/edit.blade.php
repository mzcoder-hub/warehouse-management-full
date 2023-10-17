@extends('layouts.app')

@section('content')
    <x-navbar />
    <div>
        <section class="bg-white :bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 :text-white">Edit Purchases product</h2>
                <form action="{{ route('updatePurchase', ['idPurchase' => $purchases->id]) }}" method="POST">
                    @csrf
                    <div>
                        <label for="price"
                            class="block mb-2 text-sm font-medium text-gray-900 :text-white">Products</label>
                        <input type="text" id="product" disabled value="{{ $product['name'] }}"
                            data-price="{{ $product['price'] }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500">
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div>
                            <label for="qty"
                                class="block mb-2 text-sm font-medium text-gray-900 :text-white">qty</label>
                            <input type="number" value="{{ $purchases->purchaseDetails->qty }}" oninput="calculatePrice()"
                                min="0" max="{{ $maxStock }}" name="qty" id="qty"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500">
                        </div>
                        <div class="w-full">
                            <label for="price"
                                class="block mb-2 text-sm font-medium text-gray-900 :text-white">Price</label>
                            <input disabled type="text" onchange="calculatePrice()"
                                value="Rp. {{ number_format($purchases->purchaseDetails->price, 0, ',', '.') }}" name="price"
                                id="price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500">
                            <input type="hidden" name="hiddenPrice" id="hiddenPrice">
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex ms-center px-5 py-2.5 mt-4 sm:mt-6 text-sm bg-blue-600 font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 :focus:ring-primary-900 hover:bg-blue-500">
                        Submit Purchase
                    </button>
                </form>
            </div>
        </section>
    </div>
    @if (session('successUpdate'))
        <script>
            window.addEventListener('DOMContentLoaded', function(event) {
                swal.fire({
                    title: '{{ session('successUpdate') }}',
                    icon: 'success'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('purchases.index') }}';
                    }
                });
            });
        </script>
    @endif
    <script>
        function calculatePrice() {
            var qtyInput = document.getElementById('qty').value;
            var productPrice = parseFloat(document.getElementById('product').getAttribute('data-price'));
            var totalPrice = qtyInput * productPrice;

            if (!isNaN(totalPrice)) {
                var formattedPrice = "Rp. " + totalPrice.toLocaleString('id-ID');
                document.getElementById('price').value = formattedPrice;
                // Update hidden input with the calculated price
                document.getElementById('hiddenPrice').value = totalPrice;
            }
        }
    </script>
@endsection
