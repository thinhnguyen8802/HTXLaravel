@extends('client.layouts.master')

@section('content')
    <div class="sidebar">@include('client.includes.sidebar')</div>
    <div class="content" >
        <section class="block" id="">
            <div class="card">
                <div class="card-header">
                    <h3>{{$blog->title}}</h3>
                </div>
                <div class="card-body">
                    <div class="thumbnail d-flex justify-content-center">
                        <img src="{{asset('storage').'/'.$blog->image}}" alt="" style="width: 500px">
                    </div>
                    <div class="content" style="width:100%">
                        {!! $blog->description !!}
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
@section('include-js')

@endsection
