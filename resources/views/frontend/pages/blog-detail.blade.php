@extends('frontend.layouts.master')

@section('title', 'E-TECH || Blog Detail page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home-user') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Blog Single Sidebar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Blog Single -->
    <section class="blog-single section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="blog-single-main">
                        <div class="row">
                            <div class="col-12">
                                <div class="image">
                                    <img src="{{ asset('image/blog/' . $blog->image) }}" alt="{{ $blog->image }}">
                                </div>
                                <div class="blog-detail">
                                    <h2 class="blog-title">{{ $blog->name }}</h2>
                                    <div class="blog-meta">
                                        <span class="author"><a href="javascript:void(0);"><i class="fa fa-user"></i>By {{ $blog->user->name }}
                                            </a><a href="javascript:void(0);"><i
                                                    class="fa fa-calendar"></i>{{ $blog->created_at->format('M d, Y') }}</a><a
                                                href="javascript:void(0);"></span>
                                    </div>
                                    <div class="sharethis-inline-reaction-buttons"></div>
                                    <div class="content">
                                        <p>{!! $blog->content !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget search">
                            <form class="form" method="GET" action="">
                                <input type="text" placeholder="Search Here..." name="search">
                                <button class="button" type="sumbit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">Recent post</h3>
                            @foreach ($recent_blogs as $blog)
                                <!-- Single Post -->
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{ asset('image/blog/') . $blog->image }}" alt="{{ $blog->image }}">
                                    </div>
                                    <div class="content">
                                        <h5><a href="#">{{ $blog->name }}</a></h5>
                                        <ul class="comment">
                                            <li><i class="fa fa-calendar"
                                                    aria-hidden="true"></i>{{ $blog->created_at->format('d M, y') }}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                {{ $blog->user->name ?? 'Anonymous' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Post -->
                            @endforeach
                        </div>
                        <!--/ End Single Widget -->

                        <!-- Single Widget -->
                        <!--/ End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blog Single -->
@endsection
@push('styles')
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons'
        async='async'></script>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {

            (function($) {
                "use strict";

                $('.btn-reply.reply').click(function(e) {
                    e.preventDefault();
                    $('.btn-reply.reply').show();

                    $('.comment_btn.comment').hide();
                    $('.comment_btn.reply').show();

                    $(this).hide();
                    $('.btn-reply.cancel').hide();
                    $(this).siblings('.btn-reply.cancel').show();

                    var parent_id = $(this).data('id');
                    var html = $('#commentForm');
                    $(html).find('#parent_id').val(parent_id);
                    $('#commentFormContainer').hide();
                    $(this).parents('.comment-list').append(html).fadeIn('slow').addClass('appended');
                });

                $('.comment-list').on('click', '.btn-reply.cancel', function(e) {
                    e.preventDefault();
                    $(this).hide();
                    $('.btn-reply.reply').show();

                    $('.comment_btn.reply').hide();
                    $('.comment_btn.comment').show();

                    $('#commentFormContainer').show();
                    var html = $('#commentForm');
                    $(html).find('#parent_id').val('');

                    $('#commentFormContainer').append(html);
                });

            })(jQuery)
        })
    </script>
@endpush
