@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('css/reponsive.css')}}">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="{{asset('css/style.scss')}}">

<section class="about_section layout_padding">
    <div class="container-fluid">
        @foreach($posts as $items)
        <div class="box">
            @if (!empty($items->image_url))
            <div class="img-box">
                <img src="{{$items->image_url}}" alt="" />
            </div>
            @endif
            <div class="detail-box show-post @if (empty($items->image_url)) full-width @endif">
                <h2>{{$items->name}}</h2>
                <p>{{$items->created_at}}</p>
                <p>
                    {{$items->content}}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="info_section layout_padding2">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="info_contact">
                    <h5>
                        Address
                    </h5>
                    <div class="contact_link_box">
                        <a href="">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <span>
                                Location
                            </span>
                        </a>
                        <a href="">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span>
                                Call +01 1234567890
                            </span>
                        </a>
                        <a href="">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <span>
                                demo@gmail.com
                            </span>
                        </a>
                    </div>
                </div>
                <div class="info_social">
                    <a href="">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="">
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </a>
                    <a href="">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info_link_box">
                    <h5>
                        Navigation
                    </h5>
                    <div class="info_links">
                        <a class="active" href="index.html"> <i class="fa fa-angle-right" aria-hidden="true"></i> Home <span class="sr-only">(current)</span></a>
                        <a class="" href="about.html"> <i class="fa fa-angle-right" aria-hidden="true"></i> About</a>
                        <a class="" href="why.html"> <i class="fa fa-angle-right" aria-hidden="true"></i> Why Us </a>
                        <a class="" href="team.html"> <i class="fa fa-angle-right" aria-hidden="true"></i> Our Team</a>
                        <a class="" href="testimonial.html"> <i class="fa fa-angle-right" aria-hidden="true"></i> Testimonial</a>
                        <a class="" href="contact.html"> <i class="fa fa-angle-right" aria-hidden="true"></i> Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h5>
                    Newsletter
                </h5>
                <form action="">
                    <input type="text" placeholder="Enter Your email" />
                    <button type="submit">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<footer class="footer_section container-fluid">
    <p>
        &copy; <span id="displayYear"></span> All Rights Reserved.
    </p>
</footer>


@endsection
