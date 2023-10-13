@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('css/reponsive.css')}}">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="{{asset('css/style.scss')}}">

<section class="about_section layout_padding">
    <div class="create-posts">
        <form method="POST" action="{{ route('create_articles') }}" enctype="multipart/form-data">
            @csrf
            <div class=" box-header">
                <textarea name="title" id="" cols="30" rows="10" placeholder="Nhập bài viết"></textarea>
                <div class="box-content">
                    <div class="box-submit">
                        <input type="file" id="file-upload" name="file[]" multiple />
                        <button type="submit" class="btn-posts">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid">
        @foreach($posts as $items)

        <div class="box">
            @if(isset($items[0]->media_url))
            <div class="img-box">
                @foreach($items as $p)
                <img class="dynamic-image" src="{{$p->media_url}}" alt="" />
                @endforeach
            </div>
            @endif

            <div class="detail-box show-post ">
                <a href="">{{$items[0]->name}}</a>
                <p>{{$items[0]->created_at}}</p>
                <p>
                    {{$items[0]->content}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
