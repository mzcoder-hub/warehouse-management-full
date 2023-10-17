@extends('layouts.app')

@section('content')
    <x-navbar />
    @if (Auth::user()->role === 'super admin')
        <div class="px-[200px] py-10">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <x-nav-link class="w-[190px]" :href="route('create')" :active="request()->routeIs('create')">
                    <button
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Create
                        New Inventories</button>
                </x-nav-link>
                <table class="w-full text-sm text-left text-gray-500 :text-gray-400">
                    <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white :text-white :bg-gray-800">
                        Inventories
                        <p class="mt-1 text-sm font-normal text-gray-500 :text-gray-400">Menyediakan segala jenis barang</p>
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 :bg-gray-700 :text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Code
                            </th>
                            <th scope="col" class="py-3">
                                name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Stock
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Commision Rate
                            </th>
                            <th scope="col" class="px-8 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventori)
                            <tr class="bg-white border-b :bg-gray-800 :border-gray-700">
                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap :text-white">
                                    {{ $inventori->code }}
                                </th>
                                <th scope="row" class="py-4 font-medium text-gray-900 whitespace-nowrap :text-white">
                                    {{ $inventori->name }}
                                </th>
                                <td class="px-6 py-4">
                                    Rp. {{ number_format($inventori->price, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $inventori->stock }}
                                </td>
                                <td class="px-6 py-4">
                                    Rp. {{ number_format($inventori->commision_rate, 2, ',', '.') }}
                                </td>
                                <td class="py-4 flex items-center gap-5">
                                    <a href="{{ route('edit', ['id' => $inventori->id]) }}"
                                        class="font-medium text-blue-600 :text-blue-500 hover:underline">Edit</a>
                                    {{-- <form action="{{ route('delete', ['id' => $inventori->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form> --}}
                                    <button id="delete-button" data-url="{{ route('delete', ['id' => $inventori->id]) }}"
                                        type="submit"
                                        class="font-medium text-blue-600 :text-blue-500 hover:underline">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="py-5">
                {{ $inventories->links() }}
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var deleteButtons = document.querySelectorAll('#delete-button');

                deleteButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
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
    @elseif (Auth::user()->role === 'sales')
        <div class="mt-[100px] px-[100px]">
            <div class="grid grid-cols-5 gap-5 py-4">
                @foreach ($inventories as $inventori)
                    <div
                        class="w-[230px] p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="pb-4 flex flex-col gap-2 text-white text-sm">
                            <label><span class="font-bold">Code:</span> {{ $inventori->code }}</label>
                            <p><span class="font-bold">Product Name:</span>
                                {{ \Illuminate\Support\Str::limit($inventori->name, 7, '...') }}</p>
                            <p><span class="font-bold">Price:</span> Rp {{ number_format($inventori->price, 0, ',', '.') }}
                            </p>
                            <p><span class="font-bold">Stock:</span> {{ $inventori->stock }}</p>
                        </div>

                        <a href="{{ route('createSales', ['idProduct' => $inventori->id]) }}">
                            <button
                                class="bg-blue-700 w-full text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Jual</button>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="py-5">
                {{ $inventories->links() }}
            </div>
        </div>
    @endif
@endsection
