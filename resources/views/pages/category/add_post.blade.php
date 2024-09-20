@section('categories', $categories)
@section('post', $post)
@extends('layout.app')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/my.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="shop-breadcrumb">
                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">
                        {{ $post ? trans('menu.post-menu-edit-title') : trans('menu.post-menu-add-title') }}
                    </h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i
                                            class="las la-home"></i>{{ trans('menu.post-menu-title') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $post ? trans('menu.post-menu-edit') : trans('menu.post-menu-add') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="product-add global-shadow px-sm-30 py-sm-50 px-0 py-20 bg-white radius-xl w-100 mb-40">
                <div class="user-info-tab w-100 bg-white global-shadow radius-xl mb-50">
                    <div class="row justify-content-center">
                        <div class="col-xxl-7 col-lg-10">
                            <div class="mx-sm-30 mx-20 ">
                                <div class="ap-tab-wrapper border-bottom ">
                                    <ul class="nav px-30 ap-tab-main text-capitalize" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                                href="#v-pills-home" role="tab" aria-selected="true">
                                                <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user"
                                                    class="svg">Base Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                                href="#v-pills-messages" role="tab" aria-selected="false">
                                                <img src="{{ asset('assets/img/svg/share-2.svg') }}" alt="share-2"
                                                    class="svg">Seo Info</a>
                                        </li>
                                    </ul>
                                </div>
                                <form id="addPost" action="{{ route('post.save') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade  show active" id="v-pills-home" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab">
                                            <input type="hidden" name="post_id" value="{{ $post ? $post['id'] : '' }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->id()}}">
                                            <div class="card add-product p-sm-30 p-20 mb-30">
                                                <div class="card-body p-0">
                                                    <div class="card-header">
                                                        <h6 class="fw-500">About Post</h6>
                                                    </div>
                                                    <div class="add-product__body px-sm-40 px-20">
                                                        <div class="form-group">
                                                            <label for="name1">Post Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Post Title"
                                                                value="{{ old('title', $post['title'] ?? '') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name2">Sub Title</label>
                                                            <input type="text" class="form-control" id="subTitle"
                                                                name="sub_title" placeholder="Sub Title"
                                                                value="{{ old('title', $post['subTitle'] ?? '') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="countryOption">
                                                                <label for="countryOption">
                                                                    category
                                                                </label>
                                                                <select
                                                                    class="js-example-basic-single js-states form-control"
                                                                    id="categoryId" name="category_id">
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category['id'] }}">
                                                                            {{ $category['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <div class="countryOption">
                                                                <label for="countryOption">
                                                                    Active
                                                                </label>
                                                                <select
                                                                    class="js-example-basic-single js-states form-control"
                                                                    id="isActive" name="is_active">
                                                                    <option value="yes" {{ $post && $post['isActive'] == 'yes' ? 'selected' : '' }}>
                                                                        Allow</option>
                                                                    <option value="no" {{ $post && $post['isActive'] == 'no' ? 'selected' : '' }}>
                                                                        Disable</option>
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <div class="countryOption">
                                                                <label for="countryOption">
                                                                    Breaking
                                                                </label>
                                                                <select
                                                                    class="js-example-basic-single js-states form-control"
                                                                    id="isBreaking" name="is_breaking">
                                                                    <option value="yes" {{ $post && $post['isBreaking'] == 'yes' ? 'selected' : '' }}>
                                                                        Yes
                                                                    </option>
                                                                    <option value="no" {{ $post && $post['isBreaking'] == 'no' ? 'selected' : '' }}>
                                                                        No</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Post
                                                                Description</label>
                                                            <div class="col-lg-12">
                                                                <div class="bg-white mb-25 rounded-xl">
                                                                    <div class="dm-mailCompose ">
                                                                        <div class="dm-mailCompose__body">
                                                                            <div class="mailCompose-form-content">
                                                                                <div class="form-group">
                                                                                    <textarea name="message"
                                                                                        id="mail-message"
                                                                                        class="form-control-lg"
                                                                                        placeholder="Type your message...">{{$post ? $post['description'] : ''}}</textarea>
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
                                            <div class="card add-product p-sm-30 p-20 ">
                                                <div class="card-body p-0">
                                                    <div class="card-header">
                                                        <h6 class="fw-500">Post image</h6>
                                                    </div>
                                                    <div class="add-product__body-img px-sm-40 px-20">
                                                        <label for="upload" class="file-upload__label">
                                                            <span class="upload-product-img px-10 d-block">
                                                                <span class="file-upload">
                                                                    <img class="svg"
                                                                        src="{{ asset('assets/img/svg/upload.svg') }}"
                                                                        alt="">
                                                                    <input id="upload" class="file-upload__input"
                                                                        type="file" name="img">
                                                                </span>
                                                                <span class="pera">Drag and drop an image</span>
                                                                <span>or <a href="#" class="color-secondary">Browse</a>
                                                                    to
                                                                    choose a
                                                                    file</span>
                                                            </span>
                                                        </label>
                                                        <div class="upload-product-media d-flex flex-column align-items-start mt-25"
                                                            id="imagePreviewContainer">
                                                            <!-- Uploaded images will be displayed here -->
                                                            @if($post && $post->img)
                                                                <!-- <img src="{{ asset('images/' . $post->img) }}" alt="Post Image"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    style="max-width: 100%;"> -->
                                                                <img src="{{ asset('images/' . $post->img) }}" alt="img">
                                                                <div
                                                                    class="upload-media-area__title d-flex flex-wrap align-items-center ms-10">
                                                                    <div>
                                                                        <p>{{$post['img']}}</p>
                                                                    </div>
                                                                    <div class="upload-media-area__btn">
                                                                        <button type="button"
                                                                            class="transparent rounded-circle wh-30 border-0 color-danger remove-image-btn">
                                                                            <img class="svg"
                                                                                src="{{ asset('assets/img/svg/trash-2.svg') }}"
                                                                                alt="">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                            aria-labelledby="v-pills-messages-tab">
                                            <div class="card add-product p-sm-30 p-20 mb-30">

                                                <div class="card-body p-0">
                                                    <div class="card-header">
                                                        <h6 class="fw-500">About Seo</h6>
                                                    </div>
                                                    <div class="add-product__body px-sm-40 px-20">
                                                        <div class="form-group">
                                                            <label for="name2">Seo Title</label>
                                                            <input type="text" class="form-control" id="seoTitle"
                                                                name="seo_title" placeholder="seo title"
                                                                value="{{ old('title', $post['seo_title'] ?? '') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name2">Seo Keywords</label>
                                                            <input type="text" class="form-control" id="seoKeyword"
                                                                name="seo_keyword" placeholder="seo keywords"
                                                                value="{{ old('title', $post['seo_title'] ?? '') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name2">Seo Description</label>
                                                            <input type="text" class="form-control" id="seoDescription"
                                                                name="seo_description" placeholder="seo description"
                                                                value="{{ old('title', $post['seo_description'] ?? '') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name2">Seo Slug</label>
                                                            <input type="text" class="form-control" id="seoSlug"
                                                                name="seo_slug" placeholder="seo slug"
                                                                value="{{ old('title', $post['seo_slug'] ?? '') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="button-group add-product-btn d-flex justify-content-sm-end justify-content-center mt-40">
                                                <a href="{{ route('category.get', ['language' => app()->getLocale(), 'id' => 'all']) }}"
                                                    class="btn btn-light btn-default btn-squared fw-400 text-capitalize"
                                                    data-id="category">
                                                    Cancel
                                                </a>
                                                <button type="submit"
                                                    class="btn btn-primary btn-default btn-squared text-capitalize">{{$post ? trans('menu.post-btn-edit') : trans('menu.post-btn-add')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let selectedFiles = [];

    $(document).ready(function () {
        try {
            var selectedCategoryId = localStorage.getItem('selectCategoryId');

            if (selectedCategoryId) {
                $('#categoryId').val(selectedCategoryId);
            }
        } catch (error) {
            console.error('Error setting selected category:', error);
        }
    });

    document.getElementById('upload').addEventListener('change', function (event) {
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const files = event.target.files;

        if (selectedFiles.length + files.length > 5) {
            alert('You can only upload up to 5 images.');
            return;
        }

        Array.from(files).forEach(file => {
            selectedFiles.push(file);
            const reader = new FileReader();

            reader.onload = function (e) {
                const imgElement = document.createElement('div');
                imgElement.classList.add('upload-media-area', 'd-flex');
                imgElement.innerHTML = `
                <img src="${e.target.result}" alt="img">
                <div class="upload-media-area__title d-flex flex-wrap align-items-center ms-10">
                    <div>
                        <p>${file.name}</p>
                        <span>${(file.size / 1024).toFixed(1)} KB</span>
                    </div>
                    <div class="upload-media-area__btn">
                        <button type="button" class="transparent rounded-circle wh-30 border-0 color-danger remove-image-btn">
                            <img class="svg" src="{{ asset('assets/img/svg/trash-2.svg') }}" alt="">
                        </button>
                    </div>
                </div>
            `;
                imagePreviewContainer.appendChild(imgElement);

                imgElement.querySelector('.remove-image-btn').addEventListener('click', function () {
                    selectedFiles = selectedFiles.filter(f => f.name !== file.name);
                    imgElement.remove();
                });
            };

            reader.readAsDataURL(file);
        });
    });
</script>
@endsection