@extends('layout.app')

@section("title", "Login")

@section("content")
    <div class="absolute w-screen h-screen flex justify-center bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 z-40 overflow-hidden">
        <div class="absolute rotate-45 w-80 h-80 bg-gradient-to-r from-indigo-500 to-purple-500 top-10 left-10 z-10"></div>
        <div class="absolute rotate-45 w-96 h-96 bg-gradient-to-r from-purple-500 to-indigo-500 top-60 right-20 z-10"></div>
        <div class="self-center bg-white py-12 px-20 rounded-lg z-20 drop-shadow-2xl">
            @yield("form")
        </div>
    </div>
@endsection
