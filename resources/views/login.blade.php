@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-screen">   
        <form action="{{ route('loginSubmit') }}" method="POST">
            @csrf
            <h1 class="flex justify-center text-[40px] font-bold">Login</h1>
            <div class="bg-slate-300 px-[100px] py-[50px] rounded-xl">
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 :text-white">Your name</label>
                    <input name="name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500" placeholder="name" required>
                    @if (Session::has('errorName'))
                        <div class="text-sm text-[red]">
                            {{ Session::get('errorName') }}
                        </div>
                    @endif
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 :text-white">Your password</label>
                    <input name="password" type="password" placeholder="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500" required>
                    @if (Session::has('errorPassword'))
                        <div class="text-sm text-[red]">
                            {{ Session::get('errorPassword') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Submit</button>
            </div>
        </form>
    </div>
@endsection