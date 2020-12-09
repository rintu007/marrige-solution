@extends('welcome.layouts.welcomePageMaster') 

@push('meta')


<title> @if($page->meta_title) {!! $page->meta_title !!} @elseif ($blogParameter->title) {!! $blogParameter->title !!} @else {{ env('APP_NAME_BIG') }} | Bridegroombd @endif </title>

<meta name="description" @if($page->meta_description) content="{{ $page->meta_description }}" @else content="{{ $websiteParameter->meta_description ?: 'Matrimony Service in Bangladesh
Marriage Media Service provider in Bangladesh
Matchmaker Service in Bangladesh Looing for Marriage Media In Bangladesh? Taslima marriage media is the trustworthy media in Dhaka, Bangladesh. We offer you the best matched life parner according to your profile. Create a free account and search your partner.' }}" @endif >

<meta name="keywords" @if($page->meta_keywords) content="{{ $page->meta_keywords }}" @else content="{{ $page->tags }}" @endif >
@endpush

@push('css')

<style>
    /* footer top */

#footer-top {
    background-color: #252525;
    margin-top: 50px;
}

#footer_bottom {
    background-color: #363636;
}


/* partner section */

.partners {
    margin-bottom: 150px;
}

@media (min-width: 300px) and (max-width: 576px) {
    .partners {
        margin-bottom: 150px;
    }
}


/* partner section */


/******************************************
footer section
******************************************/

.footer-logo {
    margin-top: -17px;
}

.f-icon {
    transition: 0.5s ease;
    padding: 1px 0 0 5px;
}

.footer-icon {
    margin-top: -10px;
}

span.f-icon-text i {
    background-color: #252525;
    color: #fff;
    padding: 10px;
    border-top: 2px solid #fff;
    border-bottom: 2px solid #fff;
    border-right: 1px solid #fff;
    border-left: 1px solid #fff;
}

span.f-icon-text:hover i {
    /* background-color: #D81F26; */
    color: #d81f26;
}


/* .f-top-content{
margin-top:-90px;
} */

.f-top-bottom-section {
    padding: 70px 0 0 0;
}

.f-subscribe {
    background-color: #363636;
    margin-top: -70px;
}

@media (min-width: 300px) and (max-width: 676px) {
    .f-subscribe {
        background-color: #363636;
        margin-top: 10px;
    }
}

.newslatter {
    color: #d81f26;
    font-family: Monstserrat;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
}

#validationTooltipUsernamePrepend {
    border: 1px solid #d81f26;
    background: #d81f26;
    color: #fff;
    font-family: Monstserrat;
}

.subscribe-form {
    border-radius: 0;
}


/* bottom section */

.f-bottom-title {
    color: #d81f26;
    font-family: Montserrat;
    font-weight: bold;
    border-bottom: 1px solid #d81f26;
}

.address-icon {
    width: 10%;
    flex-wrap: wrap;
    float: left;
    color: #d81f26;
}

.address-text {
    width: 90%;
    float: left;
    color: #fff;
}

.footer-menu li a {
    font-family: Montserrat;
    font-weight: 100;
    color: #fff;
    font-size: 15px;
    transition: 0.3s;
}

.footer-menu li:hover a {
    color: #d81f26;
    text-decoration: none;
}


/* bottom section */


/*scroll to top start*/

a.scroll-to-top {
    position: fixed;
    right: 15px;
    bottom: 15px;
    display: none;
    width: 50px;
    height: 50px;
    text-align: center;
    color: #fff;
    background: #d81f26;
    transition: 0.3s;
    line-height: 46px;
    z-index: 9999;
}

.scroll-to-top:focus,
.scroll-to-top:hover i {
    color: #d81f26;
}

.scroll-to-top:hover {
    background: #252525;
}

.scroll-to-top i {
    font-weight: 800;
    font-size: 18px;
}

.rounded {
    border-radius: 0;
}


/*scroll to to end*/


/* footer top */

.footer-text {
    position: relative;
    line-height: 40px;
}

.footer-text span {
    position: absolute;
    vertical-align: middle;
}
</style>
{{-- <link href="{{asset('css/userProfile.css')}}" rel="stylesheet" /> --}}
@endpush

@section('content')
@auth
<?php $me = Auth::user(); ?>
@endauth
 @include('welcome.parts.page')
@endsection

@push('js') 

{{-- <script src="{{asset('js/userProfile.js')}}"></script> --}}


@endpush
