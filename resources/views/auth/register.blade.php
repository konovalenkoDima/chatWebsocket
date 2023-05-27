@extends('auth.index')

@section('form')

    <form id="login" action="{{route("register.post")}}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-1 flex">
            <span class="mx-auto font-semibold text-2xl mb-10">Register</span>
        @if ($errors->any())
                <div class="border-2 border-solid p-1 border-red-700 bg-red-100 -mt-7 mb-2 drop-shadow-xl rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input required name="login" type="text" placeholder="Username" class="p-2 rounded-lg font-sans border-2 border-solid border-cyan-300 drop-shadow-xl hover:border-amber-400">
            <input required name="email" type="email" placeholder="Email" class="p-2 rounded-lg font-sans border-2 border-solid border-cyan-300 drop-shadow-xl hover:border-amber-400">
            <input required name="password" type="password" placeholder="Password" class="p-2 rounded-lg font-sans border-2 border-solid border-cyan-300 drop-shadow-xl hover:border-amber-400">
            <input required type="password" name="confirm_password" placeholder="Confirm password" class="p-2 rounded-lg font-sans border-2 border-solid border-cyan-300 drop-shadow-xl hover:border-amber-400">
            <span class="p-2 space-x-4 flex items-center drop-shadow-xl mx-auto">
                <input id="rememberFlag" name="remember_me" type="checkbox" class="my-auto">
                <label for="rememberFlag" class="antialiased leading-6 mb-0">Remember me</label>
            </span>
                <button type="submit" class="bg-gradient-to-r from-green-400 to-blue-500 hover:from-pink-500 hover:to-yellow-500
                    font-sans w-40 p-2 rounded-lg  drop-shadow-xl mx-auto">Register</button>
        </div>
        <div class="mt-5">
            <a href="{{route("login.init")}}" class="no-underline text-cyan-500 hover:text-amber-400">Already have account? Sign in!</a>
        </div>
    </form>
@endsection
