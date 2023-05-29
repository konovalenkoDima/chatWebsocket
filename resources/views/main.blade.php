@extends('layout.app')

@section('title', "Messager")

@section("content")
    <div class="h-screen overflow-hidden flex flex-col">
        @include("partial.header")
        <div  class="overflow-hidden grid grid-cols-4 divide-x divide-orange-500 flex-auto h-fit">
            <div class="bg-slate-100 overflow-hidden hover:overflow-auto">
                @include("partial.side")
            </div>
            <div class="col-span-3 overflow-hidden">
                @include("partial.main")
            </div>
        </div>
    </div>
@endsection
