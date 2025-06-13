@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.Contact Us') }}
@endpush

@section('content')
@if (session()->get('success_message'))
@push('toastr')
    <script>

    </script>
@endpush

@endif
<div class="space" id="contact-sec">
    <div class="container">
        <div class="map-sec">
            <div class="map">
                @php
                    $contact_info = \App\Models\Admin\ContactInfo::find(1);
                @endphp
                {!! $contact_info->location !!}
            </div>
        </div>
        <div class="row">
            <div class="col-xl-5 mb-30 mb-xl-0">
                <div class="me-xxl-5 mt-60">
                    <div class="title-area mb-25">
                        <h2 class="border-title h3">{{ __('admin_local.Have Any Questions?') }}</h2>
                    </div>
                    <p class="mt-n2 mb-25">{{ __('admin_local.Have a inquiry or some feedback for us? Fill out the form below to contact our team.') }}</p>
                    <div class="contact-feature">
                        <div class="contact-feature-icon">
                            <i class="fal fa-location-dot"></i>
                        </div>
                        <div class="media-body">
                            <p class="contact-feature_label">{{ __('Our Address') }}</p>
                            <a href="https://www.google.com/maps" class="contact-feature_link">{!! $contact_info->address !!}</a>
                        </div>
                    </div>
                    <div class="contact-feature">
                        <div class="contact-feature-icon">
                            <i class="fal fa-phone"></i>
                        </div>
                        <div class="media-body">
                            <p class="contact-feature_label">{{ __('admin_local.Phone Number') }}</p>
                            <a href="tel:{!! $contact_info->phone !!}" class="contact-feature_link">{{ __('admin_local.Mobile') }}:<span>{!! $contact_info->phone !!}</span></a>
                        </div>
                    </div>
                    <div class="contact-feature">
                        <div class="contact-feature-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <p class="contact-feature_label">{{ __('admin_local.Email') }}</p>
                            <span class="contact-feature_link">{!! $contact_info->email !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="contact-form-wrap" data-bg-src="{{ asset('public/bipebd/assets/img/bg/contact_bg_1.png') }}">
                    <span class="sub-title">{{ __('admin_local.Contact With Us') }}!</span>
                    <h2 class="border-title">{{ __('admin_local.Get in Touch') }}</h2>
                    <p class="mt-n1 mb-30 sec-text">{{ __('admin_local.Get in touch with us for any questions, feedback, or  support needs. We are here to help you every step of the way.') }}</p>
                    <form action="{{ route('sendMessages') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control style-white @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('admin_local.Your Name') }} *">
                                    <i class="fal fa-user"></i>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control style-white @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('admin_local.Email Address') }} *">
                                    <i class="fal fa-envelope"></i>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="subject" id="subject" class="single-select nice-select form-select style-white @error('subject') is-invalid @enderror">
                                        <option value="">{{ __('admin_local.Select Subject') }} *</option>
                                         @php
                                            $course_categories = \App\Models\Admin\Course\CourseCategory::where([['category_status',1],['category_delete',0]])->get();
                                        @endphp
                                        @foreach ($course_categories as $course_category)
                                        <option value="{{ $course_category->id }}" {{ old('subject')==$course_category->id?'selected':'' }}>{{ $course_category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="tel" class="form-control style-white @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" placeholder="{{ __('admin_local.Phone Number ')}}*">
                                    <i class="fal fa-phone"></i>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <textarea name="message" id="message" cols="30" rows="3" class="form-control style-white @error('message') is-invalid @enderror" placeholder="{{ __('admin_local.Write Your Message')}} *">{{ old('message') }}</textarea>
                                    <i class=""> <span id="append_word_cont">0</span> / 50</i>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-btn col-12 mt-10">
                                <button class="th-btn">{{ __('admin_local.Send Message') }}<i class="fas fa-long-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('js')
<script>
$(document).ready(function () {
    let text = $('#message').val().trim();
    let wordCount = text === '' ? 0 : text.split(/\s+/).length;
    $('#append_word_cont').text(wordCount);
});
const maxWords = 50;
$('#message').on('input', function () {
    let text = $(this).val().trim();
    let words = text.split(/\s+/).filter(word => word.length > 0);
    let wordCount = words.length;

    if (wordCount > maxWords) {
        words = words.slice(0, maxWords);
        console.log(words);

        $(this).val(words.join(" "));
        wordCount = maxWords;
        toastr.error("{{ __('admin_local.You can not type more then 50 words') }}",{timeOut:5000,showMethod:'slideDown'});
    }

    $('#append_word_cont').text(wordCount);
});
</script>
@endpush
