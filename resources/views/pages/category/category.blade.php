@section('categories', $categories)
@section('posts', $posts)
@section('perPage', $perPage)
@section('currentPage', $currentPage)
@extends('layout.app')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/my.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/pagination.css') }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.category-menu-title') }}</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i
                                        class="las la-home"></i>{{ trans('menu.home-menu-title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ trans('menu.category-menu-title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="kanban-board__card mb-50">
                <div class="kanban-header d-flex justify-content-between align-items-center">
                    <h4>Posts</h4>
                    <div class="support-form d-flex justify-content-between align-items-center flex-wrap">
                        <div class="support-form__search">
                            <div class="support-order-search">
                                <form
                                    action="{{ route('post.search', ['language' => app()->getLocale(), 'id' => 'new']) }}"
                                    class="support-order-search__form">
                                    <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                    <input class="form-control border-0 box-shadow-none" type="search" name="search"
                                        id="search" placeholder="Search" aria-label="Search">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="action-btn">
                        <a href="{{ route('post.all', ['language' => app()->getLocale(), 'id' => 'new']) }}"
                            class="btn btn-primary">
                            <i class="fa fa-plus"></i>Add Post</a>
                    </div>
                </div>
                <section class="lists-container kanban-container ">
                    <div class="list kanban-list draggable" draggable="true">
                        <div class="kanban-tops list-tops">
                            <div class="d-flex justify-content-between align-items-center py-10">
                                <h3 class="list-title">Category List</h3>
                            </div>
                        </div>

                        <ul class="kanban-items list-items  drag-drop ">
                            @foreach($categories as $category)
                                <li class="categoryItem" data-id="{{ $category['id'] }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @if(!empty($category['child']))
                                                <i class="la la-angle-down toggle-icon"></i>
                                            @endif
                                            <a href="{{ route('category.get', ['language' => app()->getLocale(), 'id' => $category['id']]) }}"
                                                class="category-link" data-id="{{ $category['id'] }}">
                                                <div class="lists-items-title">
                                                    {{$category['name']}}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="d-inline-flex">
                                            <button type="button" class="categoryAddBtn" data-bs-toggle="modal"
                                                data-bs-target="#category-add" data-id="{{ $category['id'] }}">
                                                <i class="uil uil-plus-square"></i>
                                            </button>
                                            <button type="button" class="categoryEditBtn" data-bs-toggle="modal"
                                                data-bs-target="#category-edit" data-id="{{ $category['id'] }}">
                                                <i class="uil uil-edit"></i>
                                            </button>
                                            <button type="button" class="categoryDelBtn" data-bs-toggle="modal"
                                                data-bs-target="#category-confirmed" data-id="{{ $category['id'] }}">
                                                <i class="uil uil-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @if(!empty($category['child']))
                                        <ul class="sub-category-list" style="margin-top: 20px">
                                            @foreach($category['child'] as $child)
                                                <li class="categoryItem" data-id="{{ $child['id'] }}">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <a href="{{ route('category.get', ['language' => app()->getLocale(), 'id' => $child['id']]) }}"
                                                                class="category-link" data-id="{{ $child['id'] }}">
                                                                {{$child['name']}}
                                                            </a>
                                                        </div>
                                                        <div class="d-inline-flex">
                                                            <button type="button" class="categoryEditBtn" data-bs-toggle="modal"
                                                                data-bs-target="#category-edit" data-id="{{ $child['id'] }}">
                                                                <i class="uil uil-edit"></i>
                                                            </button>
                                                            <button type="button" class="categoryDelBtn" data-bs-toggle="modal"
                                                                data-bs-target="#category-confirmed" data-id="{{ $child['id'] }}">
                                                                <i class="uil uil-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <button class="add-card-btn" type="button" data-bs-toggle="modal"
                            data-bs-target="#category-add">
                            <img src="{{ asset('assets/img/svg/plus.svg') }}" alt="plus" class="svg">
                            Add a category
                        </button>
                    </div>
                    <div class="col-9">
                        <div class="support-ticket-system">
                            <div class="userDatatable userDatatable--ticket">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                            <tr class="userDatatable-header">
                                                <th>
                                                    <span class="userDatatable-title">ID</span>
                                                </th>
                                                <th>
                                                    <span class="userDatatable-title">Title</span>
                                                </th>

                                                <th>
                                                    <span class="userDatatable-title">Author</span>
                                                </th>

                                                <th>
                                                    <span class="userDatatable-title">isActive</span>
                                                </th>
                                                <th>
                                                    <span class="userDatatable-title">isPopular</span>
                                                </th>
                                                <th>
                                                    <span class="userDatatable-title">isBreaking</span>
                                                </th>
                                                <th class="actions">
                                                    <span class="userDatatable-title">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posts as $post)
                                                <tr>
                                                    <td>{{$post['id']}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div
                                                                class="userDatatable__imgWrapper d-flex align-items-center">
                                                                <a href="#" class="profile-image rounded-circle d-block m-0"
                                                                    style="background-image:url({{ asset('images/' . $post['img']) }}); background-size: cover;"></a>
                                                            </div>
                                                            <div class="userDatatable-inline-title">
                                                                <a href="#" class="text-dark fw-500">
                                                                    <h6>{{$post['title']}}</h6>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="userDatatable-content--priority">
                                                            {{$post['user']['name']}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-check form-switch form-switch-primary form-switch-sm">
                                                            <input type="checkbox"
                                                                class="form-check-input toggle-is-active isActive"
                                                                id="switch-s{{$post['id']}}" data-post-id="{{$post['id']}}"
                                                                {{ $post['isActive'] === 'yes' ? 'checked' : '' }} {{ !in_array(Auth::user()->role, ['admin', 'editor']) ? 'disabled' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="userDatatable-content--date">
                                                            {{$post['popular']}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-check form-switch form-switch-primary form-switch-sm">
                                                            <input type="checkbox"
                                                                class="form-check-input toggle-is-active isBreaking"
                                                                id="switch-s{{$post['id']}}" data-post-id="{{$post['id']}}"
                                                                {{ $post['isBreaking'] === 'yes' ? 'checked' : '' }}>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                            <li>
                                                                <a href="{{ route('post.all', ['language' => app()->getLocale(), 'id' => $post['id']]) }}"
                                                                    class="edit" data-id="{{ $post['category_id'] }}">
                                                                    <i class="uil uil-edit"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="remove" data-id={{$post['id']}}
                                                                    data-bs-toggle="modal" data-bs-target="#post-confirmed">
                                                                    <i class="uil uil-trash-alt"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mb-3"></div>
                                <nav class="dm-page d-flex align-items-center">
                                    @if ($perPage !== 'all')
                                        {{ $posts->appends(['per_page' => $perPage, 'page' => $currentPage])->links('vendor.pagination.custom') }}
                                    @endif

                                    <form action="{{ url()->current() }}" method="GET"
                                        class="d-flex align-items-center ml-3">
                                        <label for="per_page" class="mr-2">Show:</label>
                                        <select name="per_page" id="per_page" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10/page</option>
                                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20/page</option>
                                            <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>All</option>
                                        </select>
                                        <input type="hidden" name="page" value="{{ $currentPage }}">
                                        <!-- Keep the current page -->
                                    </form>
                                </nav>
                            </div>
                        </div>
                    </div>
            </div>
            </section>
        </div>
    </div>
</div>
</div>

<div class="modal-basic modal fade show" id="category-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-bg-white">
            <div class="modal-header">
                <h6 class="modal-title">Edit</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" novalidate>
                    <div class="form-group mb-20">
                        <label for="categoryEditName">Name</label>
                        <input type="text" class="form-control" id="categoryEditName" placeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a name.</div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryEditStatus">Status</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryEditStatus"
                                required>
                                <option value="">Choose...</option>
                                <option value="allow">Allow</option>
                                <option value="disable">Disable</option>
                            </select>
                            <div class="invalid-feedback">Please select a status.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryEditType">Type1</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryEditType"
                                required>
                                <option value="">Choose...</option>
                                <option value="default">Default</option>
                                <option value="trending">Trending</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryEditType2">Type2</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryEditType2"
                                required>
                                <option value="">Choose...</option>
                                <option value="news">News</option>
                                <option value="article">Article</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryEditPosition">Position</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryEditPosition"
                                required>
                                <option value="">Choose...</option>
                                <option value="main">Main</option>
                                <option value="more">More</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryEditHomepage">Homepage</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryEditHomepage"
                                required>
                                <option value="">Choose...</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <div class="invalid-feedback">Please select a homepage.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryEditOrder">Sort Order</label>
                        <input type="text" class="form-control" id="categoryEditOrder" placeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a order.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryEditQuery">Data Query</label>
                        <input type="text" class="form-control" id="categoryEditQuery" placeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a Data Query.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryEditTitle">SEO Title</label>
                        <input type="text" class="form-control" id="categoryEditTitle" placeholder="SEO Title">
                        <div class="invalid-feedback">Please provide an SEO title.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryEditKeywords">SEO Keywords</label>
                        <input type="text" class="form-control" id="categoryEditKeywords" placeholder="SEO Keywords">
                        <div class="invalid-feedback">Please provide SEO keywords.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryEditDescription">SEO Description</label>
                        <input type="text" class="form-control" id="categoryEditDescription"
                            placeholder="SEO Description">
                        <div class="invalid-feedback">Please provide an SEO description.</div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="card card-default card-md mb-4">
                            <label for="siteLogo">Category Image</label>
                            <div class="card-body">
                                <div class="dm-tag-wrap">
                                    <div class="dm-upload">
                                        <div class="dm-upload-avatar-siteLogo">
                                            <img class="avatrSrc siteLogo" src="{{ asset('assets/img/upload.png') }}"
                                                alt="Logo Upload" id="uploadedImage">
                                        </div>
                                        <div class="avatar-up">
                                            <input type="file" name="upload-site-logo" id="upload-site-logo"
                                                class="upload-avatar-input siteLogo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="categoryEditId" name="id">
                    <div class="d-flex justify-content-end p-2">
                        <button type="submit" class="btn btn-primary btn-sm me-2">Save</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal-basic modal fade show" id="category-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-bg-white ">
            <div class="modal-header">
                <h6 class="modal-title">Add</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('assets/img/svg/x.svg') }} " alt="x" class="svg">
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" novalidate>
                    <input type="hidden" id="categoryParentId" name="categoryParentId">
                    <div class="form-group mb-20">
                        <label for="categoryAddName">Name</label>
                        <input type="text" class="form-control" id="categoryAddName" placeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a name.</div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryAddStatus">Status</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryAddStatus"
                                required>
                                <option value="">Choose...</option>
                                <option value="allow">Allow</option>
                                <option value="disable">Disable</option>
                            </select>
                            <div class="invalid-feedback">Please select a status.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryAddType">Type1</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryAddType"
                                required>
                                <option value="">Choose...</option>
                                <option value="default">Default</option>
                                <option value="trending">Trending</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryAddType2">Type2</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryAddType2"
                                required>
                                <option value="">Choose...</option>
                                <option value="news">News</option>
                                <option value="article">Article</option>
                            </select>
                            <div class="invalid-feedback">Please select a type.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryAddPosition">Position</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryAddPosition"
                                required>
                                <option value="">Choose...</option>
                                <option value="main">Main</option>
                                <option value="more">More</option>
                            </select>
                            <div class="invalid-feedback">Please select a position.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="categoryAddHomepage">Homepage</label>
                            <select class="js-example-basic-single js-states form-control" id="categoryAddHomepage"
                                required>
                                <option value="">Choose...</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <div class="invalid-feedback">Please select a homepage.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryAddOrder">Sort Order</label>
                        <input type="text" class="form-control" id="categoryAddOrder" placeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a order.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryAddQuery">Data Query</label>
                        <input type="text" class="form-control" id="categoryAddQuery" placeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a Data Query.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryAddTitle">Seo Title</label>
                        <input type="text" class="form-control" id="categoryAddTitle" placeholder="Seo Title">
                        <div class="invalid-feedback">Please provide an SEO title.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryAddKeywords">Seo Keywords</label>
                        <input type="text" class="form-control" id="categoryAddKeywords" placeholder="Seo Keywords">
                        <div class="invalid-feedback">Please provide SEO keywords.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="categoryAddDescription">Seo Description</label>
                        <input type="text" class="form-control" id="categoryAddDescription"
                            placeholder="Seo Description">
                        <div class="invalid-feedback">Please provide an SEO description.</div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="card-body">
                            <div class="dm-tag-wrap">
                                <div class="dm-upload">
                                    <div class="dm-upload-avatar-siteFavicon">
                                        <img class="avatrSrc siteFavicon" src="{{ asset('assets/img/upload.png') }}"
                                            alt="Favicon Upload">
                                    </div>
                                    <div class="avatar-up">
                                        <input type="file" name="upload-site-favicon" id="upload-site-favicon"
                                            class="upload-avatar-input siteFavicon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end p-2">
                        <button type="submit" class="btn btn-primary btn-sm me-2">Add</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal-info-confirmed modal fade show" id="category-confirmed" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-info" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-info-body d-flex">
                    <div class="modal-info-icon warning">
                        <img src="{{ asset('assets/img/svg/alert-circle.svg') }} " alt="alert-circle" class="svg">
                    </div>
                    <div class="modal-info-text">
                        <h6>Do you Want to delete these items?</h6>
                        <p>Some descriptions</p>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-2">
                    <button type="button" class="btn btn-light btn-outlined btn-sm me-2"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info btn-sm" data-bs-dismiss="modal"
                        id="categoryDelBtn">Ok</button>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal-info-confirmed modal fade show" id="post-confirmed" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-info" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-info-body d-flex">
                    <div class="modal-info-icon warning">
                        <img src="{{ asset('assets/img/svg/alert-circle.svg') }} " alt="alert-circle" class="svg">
                    </div>
                    <div class="modal-info-text">
                        <h6>Do you Want to delete these items?</h6>
                        <p>Some descriptions</p>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-2">
                    <button type="button" class="btn btn-light btn-outlined btn-sm me-2"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info btn-sm" data-bs-dismiss="modal"
                        id="postDelBtn">Ok</button>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="modalMessage"></span>
            </div>
            <div class="modal-footer">
                <button type="button" id="modalOkButton" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var itemId, postItemId;

    function resetForm() {
        $('#addForm')[0].reset(); // Reset form fields
        $('#addForm .is-invalid').removeClass('is-invalid'); // Remove is-invalid class
        $('#addForm .invalid-feedback').remove(); // Remove any existing error messages
    }

    $(document).ready(function () {
        $('.categoryAddBtn').on('click', function () {
            const parentId = $(this).data('id');
            $('#categoryParentId').val(parentId);
        });
        $('.categoryEditBtn').on('click', function () {
            var categoryId = $(this).data('id');
            console.log(categoryId);

            // Reset form validation state
            resetFormValidation();

            // Fetch category data via AJAX
            $.ajax({
                url: '/category/edit/' + categoryId,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    populateEditModal(data);
                }
            });
        });

        // Handle form submission with validation
        $('#updateForm').on('submit', function (e) {
            e.preventDefault();

            if (validateForm()) {
                var categoryId = $('#categoryEditId').val();
                var formData = new FormData();
                formData.append('name', $('#categoryEditName').val());
                formData.append('status', $('#categoryEditStatus').val());
                formData.append('type', $('#categoryEditType').val());
                formData.append('type2', $('#categoryEditType2').val());
                formData.append('position', $('#categoryEditPosition').val());
                formData.append('isHomepage', $('#categoryEditHomepage').val());
                formData.append('sortorder', $('#categoryEditOrder').val());
                formData.append('data_query', $('#categoryEditQuery').val());
                formData.append('seo_title', $('#categoryEditTitle').val());
                formData.append('seo_keyword', $('#categoryEditKeywords').val());
                formData.append('seo_description', $('#categoryEditDescription').val());
                // Append image if selected
                if ($('#upload-site-logo')[0].files[0]) {
                    formData.append('image', $('#upload-site-logo')[0].files[0]);
                }
                formData.append('_method', 'POST'); // For Laravel method spoofing

                $.ajax({
                    url: '/category/update/' + categoryId,
                    method: 'POST',
                    data: formData,
                    processData: false, // Important: prevent jQuery from processing the data
                    contentType: false, // Important: set contentType to false
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
                    },
                    success: function (data) {
                        //alert('Category updated successfully!');
                        $('#modalMessage').text("Category updated successfully!");
                        $('#notificationModal').modal('show');
                        $('#category-edit').modal('hide');
                        //location.reload();
                    }
                });
            }
        });

        // Custom validation function
        function validateForm() {
            let isValid = true;
            // Reset all validation classes and messages
            resetFormValidation();

            // Validate each input field
            $('#updateForm input[required], #updateForm select[required]').each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.invalid-feedback').show();
                }
            });

            return isValid;
        }

        // Function to reset form validation state
        function resetFormValidation() {
            $('#updateForm input, #updateForm select').removeClass('is-invalid');
            $('#updateForm .invalid-feedback').hide();
        }

        // Function to populate edit modal fields
        function populateEditModal(data) {
            $('#categoryEditName').val(data.name);
            $('#categoryEditStatus').val(data.status);
            $('#categoryEditId').val(data.id);
            $('#categoryEditType').val(data.type);
            $('#categoryEditType2').val(data.type2);
            $('#categoryEditPosition').val(data.position);
            $('#categoryEditOrder').val(data.sortorder);
            $('#categoryEditTitle').val(data.seo_title);
            $('#categoryEditKeywords').val(data.seo_keyword);
            $('#categoryEditDescription').val(data.seo_description);
            $('#categoryEditHomepage').val(data.isHomepage);
            $('#categoryEditQuery').val(data.data_query);
            if (data.image) {
                $('#uploadedImage').attr('src', '{{ asset('images/') }}' + '/' + data.image);
            } else {
                // If no image, revert to default image
                $('#uploadedImage').attr('src', '{{ asset('assets/img/upload.png') }}');
            }
        }

        $('#addForm').on('submit', function (e) {
            e.preventDefault();
            // Clear previous validation messages
            $('#addForm .is-invalid').removeClass('is-invalid');
            $('#addForm .invalid-feedback').remove();

            // Get form values
            var categoryAddParentId = $('#categoryParentId').val();
            var categoryAddName = $('#categoryAddName').val();
            var categoryAddOrder = $('#categoryAddOrder').val();
            var categoryAddStatus = $('#categoryAddStatus').val();
            var categoryAddType = $('#categoryAddType').val();
            var categoryAddType2 = $('#categoryAddType2').val();
            var categoryAddPosition = $('#categoryAddPosition').val();
            var categoryAddTitle = $('#categoryAddTitle').val();
            var categoryAddKeywords = $('#categoryAddKeywords').val();
            var categoryAddDescription = $('#categoryAddDescription').val();
            var categoryAddHomepage = $('#categoryAddHomepage').val();
            var categoryAddQuery = $('#categoryAddQuery').val();

            // Validate form values
            var isValid = true;

            if (!categoryAddName) {
                $('#categoryAddName').addClass('is-invalid').after('<div class="invalid-feedback">Please provide a name.</div>');
                isValid = false;
            }
            if (!categoryAddStatus) {
                $('#categoryAddStatus').addClass('is-invalid').after('<div class="invalid-feedback">Please select a status.</div>');
                isValid = false;
            }
            if (!categoryAddType) {
                $('#categoryAddType').addClass('is-invalid').after('<div class="invalid-feedback">Please select a type.</div>');
                isValid = false;
            }
            if (!categoryAddType2) {
                $('#categoryAddType2').addClass('is-invalid').after('<div class="invalid-feedback">Please select a type.</div>');
                isValid = false;
            }
            if (!categoryAddPosition) {
                $('#categoryAddPosition').addClass('is-invalid').after('<div class="invalid-feedback">Please select a position.</div>');
                isValid = false;
            }
            if (!categoryAddHomepage) {
                $('#categoryAddHomepage').addClass('is-invalid').after('<div class="invalid-feedback">Please select a homepage.</div>');
                isValid = false;
            }
            if (!categoryAddQuery) {
                $('#categoryAddQuery').addClass('is-invalid').after('<div class="invalid-feedback">Please provide a Data query.</div>');
                isValid = false;
            }

            // If form is valid, send AJAX request
            if (isValid) {
                var formData = new FormData();
                formData.append('name', categoryAddName);
                formData.append('parent_id', categoryAddParentId);
                formData.append('sortorder', categoryAddOrder);
                formData.append('status', categoryAddStatus);
                formData.append('type', categoryAddType);
                formData.append('type2', categoryAddType2);
                formData.append('position', categoryAddPosition);
                formData.append('isHomepage', categoryAddHomepage);
                formData.append('data_query', categoryAddQuery);
                formData.append('seo_title', categoryAddTitle);
                formData.append('seo_keyword', categoryAddKeywords);
                formData.append('seo_description', categoryAddDescription);
                if ($('#upload-site-favicon')[0].files[0])
                    formData.append('image', $('#upload-site-favicon')[0].files[0]); // Assuming file input has id 'upload-site-favicon'
                formData.append('_method', 'POST');
                $.ajax({
                    url: '/category/add',
                    method: 'POST',
                    data: formData,
                    contentType: false, // Not setting contentType
                    processData: false, // Not processing data
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        //alert('Category added successfully!');
                        $('#modalMessage').text("Category added successfully!");
                        $('#notificationModal').modal('show');
                        resetForm(); // Reset form fields and clear validation
                        $('#category-add').modal('hide'); // Close modal
                        //location.reload(); // Reload page or perform necessary actions
                    }
                });
            }
        });

        $('#modalOkButton').on('click', function () {
            location.reload();
        });

        // Clear form and reset validation when modal is shown
        $('#category-add').on('shown.bs.modal', function () {
            resetForm();
        });

        $('.categoryDelBtn').on('click', function () {
            itemId = $(this).data('id');
        });

        $('#categoryDelBtn').on('click', function () {
            $.ajax({
                url: '/category/' + itemId, // Adjust the URL to match your route
                type: 'DELETE', // Use DELETE method
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function (response) {
                    if (response.success) {
                        //alert(response.success); // Show success message
                        $('#modalMessage').text("Category deleted successfully!");
                        $('#notificationModal').modal('show');
                        // Optionally, remove the item from the DOM
                        $('#item-' + itemId).remove();
                        $('#category-confirmed').modal('hide');
                        //location.reload();
                    } else {
                        alert('Error deleting item.');
                    }
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        $('.remove').on('click', function () {
            itemPostId = $(this).data('id');
        })

        $('#postDelBtn').on('click', function () {
            $.ajax({
                url: '/post/' + itemPostId, // Adjust the URL to match your route
                type: 'DELETE', // Use DELETE method
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.success); // Show success message
                        // Optionally, remove the item from the DOM
                        $('#item-' + itemId).remove();
                        location.reload();
                    } else {
                        alert('Error deleting item.');
                    }
                },
                error: function (xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        $('.categoryItem a').on('click', function (e) {
            // Prevent the default action if you need to (optional)
            // e.preventDefault();

            // Remove the active class from all links
            $('.categoryItem a').removeClass('active-link');

            // Add the active class to the clicked link
            $(this).addClass('active-link');
        });

        $('.isActive').change(function () {
            var postId = $(this).data('post-id');
            var isChecked = $(this).prop('checked');
            var isActive = isChecked ? 'yes' : 'no';

            // Confirm dialog before updating
            var confirmation = confirm("Are you sure you want to change the Active status?");
            if (confirmation) {
                // AJAX request to update isActive
                $.ajax({
                    url: '/update-is-active', // Replace with your Laravel route
                    method: 'POST',
                    data: {
                        isActive: isActive,
                        postId: postId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Data updated successfully');
                        // Optionally update UI or provide feedback
                    },
                    error: function (xhr, status, error) {
                        console.error('Error updating data:', error);
                        // Optionally handle errors
                    }
                });
            } else {
                // Reset checkbox state if user cancels
                $(this).prop('checked', !isChecked);
            }
        });

        $('.isBreaking').change(function () {
            var postId = $(this).data('post-id');
            var isChecked = $(this).prop('checked');
            var isBreaking = isChecked ? 'yes' : 'no';

            // Confirm dialog before updating
            var confirmation = confirm("Are you sure you want to change the Breaking status?");
            if (confirmation) {
                // AJAX request to update isBreaking
                $.ajax({
                    url: '/update-is-breaking', // Replace with your Laravel route
                    method: 'POST',
                    data: {
                        isBreaking: isBreaking,
                        postId: postId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Data updated successfully');
                        // Optionally update UI or provide feedback
                    },
                    error: function (xhr, status, error) {
                        console.error('Error updating data:', error);
                        // Optionally handle errors
                    }
                });
            } else {
                // Reset checkbox state if user cancels
                $(this).prop('checked', !isChecked);
            }
        });

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

        $('.categoryItem').each(function () {
            var $categoryItem = $(this);
            var categoryItemId = $categoryItem.attr('data-id');
            var isSubCategoryListOpen = localStorage.getItem('sub-category-list-' + categoryItemId);

            if (isSubCategoryListOpen === 'true') {
                $categoryItem.find('.sub-category-list').addClass('show');
            }
        });

        // Handle click event on toggle icon to show/hide sub-categories
        $('.toggle-icon').on('click', function (e) {
            e.preventDefault(); // Prevent default only for toggle icon click
            var $parentLi = $(this).closest('.categoryItem');
            var $subCategoryList = $parentLi.find('.sub-category-list');
            var categoryItemId = $parentLi.attr('data-id');
            var isOpen = $subCategoryList.hasClass('show');

            // Collapse all other sub-category-lists
            $('.sub-category-list').not($subCategoryList).removeClass('show');

            // Toggle visibility of current sub-categories
            $subCategoryList.toggleClass('show');

            // Store state in local storage
            localStorage.setItem('sub-category-list-' + categoryItemId, !isOpen);
        });

        // Handle click event on category-link to toggle sub-categories visibility
        $('.category-link').on('click', function (e) {
            var $parentLi = $(this).closest('.categoryItem');
            var $subCategoryList = $parentLi.find('.sub-category-list');
            var categoryItemId = $parentLi.attr('data-id');
            var categoryLinkId = $(this).attr('data-id');
            var isOpen = $subCategoryList.hasClass('show');

            // Collapse all other sub-category-lists except the current one
            $('.sub-category-list').not($subCategoryList).removeClass('show');

            // Toggle visibility of current sub-categories
            $subCategoryList.toggleClass('show');

            // Store state in local storage
            localStorage.setItem('selectCategoryId', categoryLinkId);
            localStorage.setItem('sub-category-list-' + categoryItemId, !isOpen);
        });

        $('.edit').on('click', function (e) {
            var categoryLinkId = $(this).attr('data-id');
            localStorage.setItem('selectCategoryId', categoryLinkId);
        })
    });

    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('.category-link');

        // Retrieve the stored category ID
        const activeCategoryId = localStorage.getItem('activeCategoryId');

        // Highlight the stored category link
        if (activeCategoryId) {
            const activeLink = document.querySelector(`.category-link[data-id="${activeCategoryId}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }

        // Add click event to each link to store the clicked category ID
        links.forEach(link => {
            link.addEventListener('click', function () {
                localStorage.setItem('activeCategoryId', this.dataset.id);
            });
        });
    });
</script>
<style>
    .category-link.active {
        color: red;
        /* Change to your preferred highlight color */
    }

    .categoryItem {
        padding: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        margin-bottom: 5px;
    }

    .categoryItem:hover {
        background-color: #e0e0e0;
    }

    .categoryItem .lists-items-title {
        font-weight: bold;
    }

    .toggle-icon {
        cursor: pointer;
        margin-right: 10px;
    }

    .sub-category-list {
        display: none;
        margin-left: 30px;
        /* Adjust indentation as needed */
        list-style-type: none;
        /* Remove default list styling */
        padding-left: 0;
        /* Remove default padding */
    }

    .sub-category-list.show {
        display: block;
    }
</style>
@endsection