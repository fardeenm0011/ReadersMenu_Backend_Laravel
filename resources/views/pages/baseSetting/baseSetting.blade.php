@section('title', $title)
@section('description', $description)
@extends('layout.app')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/my.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex align-items-center user-member__title mb-30 mt-30">
                <h4 class="text-capitalize">{{ trans('menu.baseSetting-add') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
                <div class="ap-tab-wrapper border-bottom ">
                    <ul class="nav px-30 ap-tab-main text-capitalize" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <li class="nav-item">
                            <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home"
                                role="tab" aria-selected="true">
                                <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user" class="svg">Base Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages"
                                role="tab" aria-selected="false">
                                <img src="{{ asset('assets/img/svg/share-2.svg') }}" alt="share-2"
                                    class="svg">Social</a>
                        </li>
                    </ul>
                </div>
                <form id="completeForm" method="POST" action="{{ route('baseSetting.save') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade  show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            <div class="row justify-content-center">
                                <div class="col-xxl-8 col-10">
                                    <div class="mt-sm-40 mb-sm-50 mt-20 mb-20">
                                        <div class="user-tab-info-title mb-sm-40 mb-20 text-capitalize">
                                            <h5 class="fw-500">Base Information</h5>
                                        </div>
                                        <div class="edit-profile__body">
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group mb-25">
                                                        <label for="siteTitle">Site Title</label>
                                                        <input type="text" class="form-control" id="siteTitle"
                                                            name="siteTitle" placeholder="Site Title">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group mb-25">
                                                        <label for="seoKeyword">Seo Title</label>
                                                        <input type="text" class="form-control" id="seoTitle"
                                                            name="seoTitle" placeholder="Seo Title">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group mb-25">
                                                        <label for="siteLogo">Seo Keyword</label>
                                                        <input type="text" class="form-control" id="seoKeyword"
                                                            name="seoKeyword" placeholder="Seo Keyword">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group mb-25">
                                                        <label for="seoDescription">Seo Description</label>
                                                        <input type="text" class="form-control" id="seoDescription"
                                                            name="seoDescription" placeholder="Seo Description">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group mb-25">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                            placeholder="sample@email.com">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group mb-25">
                                                        <label for="phoneNumber">Phone Number</label>
                                                        <input type="tel" class="form-control" id="phoneNumber"
                                                            name="phoneNumber" placeholder="+91 123456789">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group mb-25">
                                                        <label for="address">Address</label>
                                                        <input type="text" class="form-control" id="address"
                                                            name="address" placeholder="address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="card card-default card-md mb-4">
                                                        <label for="siteLogo">Site Logo</label>
                                                        <div class="card-body">
                                                            <div class="dm-tag-wrap">
                                                                <div class="dm-upload">
                                                                    <div class="dm-upload-avatar-siteLogo">
                                                                        <img class="avatrSrc siteLogo"
                                                                            src="{{ asset('assets/img/upload.png') }}"
                                                                            alt="Logo Upload">
                                                                    </div>
                                                                    <div class="avatar-up">
                                                                        <input type="file" name="upload-site-logo"
                                                                            class="upload-avatar-input siteLogo">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="card card-default card-md mb-4">
                                                        <label for="siteFavicon">Site Favicon</label>
                                                        <div class="card-body">
                                                            <div class="dm-tag-wrap">
                                                                <div class="dm-upload">
                                                                    <div class="dm-upload-avatar-siteFavicon">
                                                                        <img class="avatrSrc siteFavicon"
                                                                            src="{{ asset('assets/img/upload.png') }}"
                                                                            alt="Favicon Upload">
                                                                    </div>
                                                                    <div class="avatar-up">
                                                                        <input type="file" name="upload-site-favicon"
                                                                            class="upload-avatar-input siteFavicon">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab">
                            <div class="row justify-content-center">
                                <div class="col-xxl-4 col-10">
                                    <div class="user-social-profile mt-40 mb-50">
                                        <div class="user-tab-info-title mb-40 text-capitalize">
                                            <h5>social link</h5>
                                        </div>
                                        <div class="edit-profile__body">
                                            <div class="mb-30">
                                                <label for="socialUrl">facebook</label>
                                                <div class="input-group flex-nowrap">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text bg-facebook border-facebook text-white wh-44 radius-xs justify-content-center"
                                                            id="addon-wrapping1">
                                                            <i class="lab la-facebook-f fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control--social"
                                                        placeholder="Url" aria-label="Facebook URL"
                                                        aria-describedby="addon-wrapping1" id="facebookUrl"
                                                        name="facebookUrl">
                                                </div>
                                            </div>
                                            <div class="mb-30">
                                                <label for="twitterUrl">twitter</label>
                                                <div class="input-group flex-nowrap">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text bg-twitter border-twitter text-white wh-44 radius-xs justify-content-center"
                                                            id="addon-wrapping2">
                                                            <i class="lab la-twitter fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control--social"
                                                        placeholder="@Username" aria-label="Twitter Username"
                                                        aria-describedby="addon-wrapping2" id="twitterUrl"
                                                        name="twitterUrl">
                                                </div>
                                            </div>
                                            <div class="mb-30">
                                                <label for="instagramUrl">instagram</label>
                                                <div class="input-group flex-nowrap">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text bg-instagram border-instagram text-white wh-44 radius-xs justify-content-center"
                                                            id="addon-wrapping4">
                                                            <i class="lab la-instagram fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control--social"
                                                        placeholder="Url" aria-label="Instagram URL"
                                                        aria-describedby="addon-wrapping4" id="instagramUrl"
                                                        name="instagramUrl">
                                                </div>
                                            </div>
                                            <div class="mb-30">
                                                <label for="googleUrl">google</label>
                                                <div class="input-group flex-nowrap">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text bg-google border-google text-white wh-44 radius-xs justify-content-center"
                                                            id="addon-wrapping5">
                                                            <i class="lab la-google fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control--social"
                                                        placeholder="Url" aria-label="Google URL"
                                                        aria-describedby="addon-wrapping5" id="googleUrl"
                                                        name="googleUrl">
                                                </div>
                                            </div>
                                            <div class="mb-30">
                                                <label for="linkedinUrl">linkedin</label>
                                                <div class="input-group flex-nowrap">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text bg-linkedin border-linkedin text-white wh-44 radius-xs justify-content-center"
                                                            id="addon-wrapping6">
                                                            <i class="lab la-linkedin fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control--social"
                                                        placeholder="Url" aria-label="LinkedIn URL"
                                                        aria-describedby="addon-wrapping6" id="linkedinUrl"
                                                        name="linkedinUrl">
                                                </div>
                                            </div>
                                            <div class="mb-30">
                                                <label for="telegramUrl">telegram</label>
                                                <div class="input-group flex-nowrap">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text bg-telegram border-telegram text-white wh-44 radius-xs justify-content-center"
                                                            id="addon-wrapping7">
                                                            <i class="lab la-telegram fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control--social"
                                                        placeholder="Url" aria-label="Telegram URL"
                                                        aria-describedby="addon-wrapping7" id="telegramUrl"
                                                        name="telegramUrl">
                                                </div>
                                            </div>
                                            <div class="mb-30">
                                                <label for="whatsappUrl">WhatsApp</label>
                                                <div class="input-group flex-nowrap">
                                                    <div class="input-group-prepend">
                                                        <span
                                                            class="input-group-text bg-whatsapp border-whatsapp text-white wh-44 radius-xs justify-content-center"
                                                            id="addon-wrapping8">
                                                            <i class="lab la-whatsapp fs-18"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control--social"
                                                        placeholder="Url" aria-label="WhatsApp URL"
                                                        aria-describedby="addon-wrapping8" id="whatsappUrl"
                                                        name="whatsappUrl">
                                                </div>
                                            </div>
                                            <div
                                                class="button-group d-flex pt-20 justify-content-md-end justify-content-start">
                                                <button
                                                    class="btn btn-light btn-default btn-squared fw-400 text-capitalize radius-md"
                                                    type="button">back</button>
                                                <button
                                                    class="btn btn-primary btn-default btn-squared text-capitalize radius-md shadow2"
                                                    type="submit">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".dm-upload-avatar-siteLogo").on("click", function (t) {
            t.preventDefault();
            $(".upload-avatar-input.siteLogo").click();
        });

        $(".upload-avatar-input.siteLogo").on("change", function () {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(".avatrSrc.siteLogo").attr("src", e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // For Site Favicon
        $(".dm-upload-avatar-siteFavicon").on("click", function (t) {
            t.preventDefault();
            $(".upload-avatar-input.siteFavicon").click();
        });

        $(".upload-avatar-input.siteFavicon").on("change", function () {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(".avatrSrc.siteFavicon").attr("src", e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    })
    document.addEventListener("DOMContentLoaded", function () {
    });
</script>
@endsection