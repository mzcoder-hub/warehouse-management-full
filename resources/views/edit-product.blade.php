@extends('layouts.app')

@section('content')
    <x-navbar />
    @if (Auth::user()->role === 'super admin')
        <div>
            <section class="bg-white :bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 :text-white">Edit product</h2>
                    <form action="{{ route('update', ['id' => $product->id]) }}" method="POST">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="w-full">
                                <label for="code"
                                    class="block mb-2 text-sm font-medium text-gray-900 :text-white">code</label>
                                <input value="{{ $product->code }}" type="text" name="code" id="code"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500"
                                    placeholder="Product code" required="">
                            </div>
                            <div class="w-full">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 :text-white">Product Name</label>
                                <input value="{{ $product->name }}" type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500"
                                    placeholder="product name" required="">
                            </div>
                            <div class="w-full">
                                <label for="price"
                                    class="block mb-2 text-sm font-medium text-gray-900 :text-white">Price</label>
                                <input value="{{ $product->price }}" type="number" name="price" id="price"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500"
                                    placeholder="Rp. 1999" required="">
                            </div>
                            <div>
                                <label for="stock"
                                    class="block mb-2 text-sm font-medium text-gray-900 :text-white">Stock</label>
                                <input value="{{ $product->stock }}" type="number" name="stock" id="stock"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500"
                                    placeholder="12" required="">
                            </div>
                            <div>
                                <label for="commision_rate"
                                    class="block mb-2 text-sm font-medium text-gray-900 :text-white">Commision Rate</label>
                                <input value="{{ $product->commision_rate }}" type="number" name="commision_rate"
                                    id="commision_rate"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-primary-500 :focus:border-primary-500"
                                    placeholder="Rp. 1999" required="">
                            </div>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm bg-blue-600 font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 :focus:ring-primary-900 hover:bg-blue-500">
                            Update product
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
                            window.location.href = '{{ route('inventories') }}';
                        }
                    });
                });
            </script>
        @endif
    @endif
@endsection
