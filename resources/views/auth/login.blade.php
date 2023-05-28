@extends('auth.index')

@section('form')
    <form action="{{route("login.post")}}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-1 flex">
            <span class="mx-auto font-semibold text-2xl mb-10">Login</span>
        @if ($errors->any())
                <div class="border-2 border-solid p-1 border-red-700 bg-red-100 -mt-7 mb-2 drop-shadow-xl rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-700">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input name="login" type="text" placeholder="Username" class="p-2 rounded-lg font-sans border-2 border-solid border-cyan-300 drop-shadow-xl hover:border-amber-400">
            <input name="password" type="password" placeholder="Password" class="p-2 rounded-lg font-sans border-2 border-solid border-cyan-300 drop-shadow-xl hover:border-amber-400">
            <span class="p-2 space-x-4 flex items-center mx-auto">
                <input id="rememberFlag" name="remember_me" type="checkbox" class="my-auto">
                <label for="rememberFlag" class="antialiased leading-6 mb-0">Remember me</label>
            </span>
            <button type="submit" class="bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500
                    font-sans w-40 p-2 rounded-lg  drop-shadow-xl mx-auto">Login</button>
        </div>
        <div class="mt-5">
            <a href="{{route("register.init")}}" class="no-underline text-cyan-500 hover:text-amber-400">Don`t have account? Register!</a>
        </div>
    </form>
@endsection
