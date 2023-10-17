@extends('layouts.app')

@section('content')
<x-navbar />
<div class="px-[200px] py-10">    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        @if (Auth::user()->role != 'manager')
        <x-nav-link class="w-[190px]" :href="route('createPurchases')" :active="request()->routeIs('createPurchases')">
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Create Purchases</button>
        </x-nav-link>
        @else
        <div class="my-5 flex gap-4">
            <a href="{{ route('purchase.export.excel') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Export Excel</a>
            <a href="{{ route('purchase.export.pdf') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Export PDF</a>
            <a href="{{ route('purchase.export.csv') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Export CSV</a>
        </div>
        @endif
        <table class="w-full text-sm text-left text-gray-500 :text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white :text-white :bg-gray-800">
                Purchases Transaction
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 :bg-gray-700 :text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="py-3">
                        Product Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    @if (Auth::user()->role != 'manager')
                    <th scope="col" class="px-8 py-3">
                        Action
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr class="bg-white border-b :bg-gray-800 :border-gray-700">
                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap :text-white">
                            {{ date('d F Y', strtotime($purchase->date)) }}
                        </th>
                        <th scope="row" class="py-4 font-medium text-gray-900 whitespace-nowrap :text-white">
                            @php
                                $product = $products->find($purchase->purchaseDetails->inventory_id);
                            @endphp
                            @if ($product)
                                {{ $product->name }}
                            @endif
                        </th>
                        <td class="px-6 py-4">
                            {{ $purchase->purchaseDetails->qty }}
                        </td>
                        <td class="px-6 py-4">
                            Rp. {{ number_format($purchase->purchaseDetails->price, 0,',','.') }}
                        </td>
                        @if (Auth::user()->role != 'manager')
                        <td class="py-4 flex items-center gap-5">
                            <a href="{{ route('purchases.edit', ['idPurchase' => $purchase->id]) }}" class="font-medium text-blue-600 :text-blue-500 hover:underline">Edit</a>
                            <button id="delete-button" data-url="{{ route('deletePurchase', ['idPurchase' => $purchase->id]) }}"  type="submit" class="font-medium text-blue-600 :text-blue-500 hover:underline">Delete</button>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="py-5">
        {{ $purchases->links() }}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteButtons = document.querySelectorAll('#delete-button');
        
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var url = button.getAttribute('data-url');

                Swal.fire({
                    title: 'Apakah kamu yakin ingin Menghapus ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                });
            });
        });
    });
</script>
@endsection