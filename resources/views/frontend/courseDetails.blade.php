@extends('frontend.layouts.master')

@section('title', 'Course Details')

@section('content')

    <section class="courseDetails marginTop">
        <div class="contentDetails w-100 h-50 p-5">
            {!! $course->course_information !!}
        </div>
    </section>
    <section class="card py-4 px-2 my-4 courseInfo">
        <div class="d-flex justify-content-around align-items-center ">
            <div class="courseImg ">
                <img src="{{ $course->image }}" alt="ImageCourseDetails" width="200">
            </div>
            <div class="coursePrice">
                <h4 class="fw-bold">السعر : {{ $course->price }} <span class="text-start">EGP</span></h4>
                <div class="buy">
                    <a href="{{ route('checkout',$course->id) }}"><button class="btn main-btn fw-bold">اشتري الان</button></a>
                </div>
            </div>
        </div>
    </section>
@endsection
