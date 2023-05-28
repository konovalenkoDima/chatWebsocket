@extends('layout.app')

@section('title', "Messager")

@section("content")
    <div class="h-screen overflow-hidden flex flex-col ">
        @include("partial.header")
        <div class="grid grid-cols-4 divide-x divide-orange-500 flex-auto">
            <div class="h-full bg-slate-100">
                @include("partial.side")
            </div>
            <div class="col-span-3 h-full">
                @include("partial.main")
            </div>
        </div>
    </div>
@endsection
