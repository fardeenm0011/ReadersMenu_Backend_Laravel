@section('comments', $comments)
@section('perPage', $perPage)
@section('currentPage', $currentPage)
@extends('layout.app')
@section('content')
<div class="support-ticket mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.comment-menu-title') }}</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i
                                            class="las la-home"></i>{{ trans('menu.home-menu-title') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ trans('menu.comment-menu-title') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
            <div class="col-12">
                <div class="support-ticket-system" style="padding: 25px">
                    <div class="userDatatable userDatatable--ticket">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Comments</h4>
                            <div class="support-form d-flex justify-content-between align-items-center flex-wrap">
                                <div class="support-form__search">
                                    <div class="support-order-search">
                                        <form
                                            action="{{ route('employee.search', ['language' => app()->getLocale(), 'id' => 'new']) }}"
                                            class="support-order-search__form">
                                            <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search"
                                                class="svg">
                                            <input class="form-control border-0 box-shadow-none" type="search"
                                                name="search" id="search" placeholder="Search" aria-label="Search">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">ID</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Post Title</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Comment By</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Description</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created at</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">isActive</span>
                                        </th>
                                        <th class="actions">
                                            <span class="userDatatable-title">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td>{{$comment['id']}}</td>
                                            <td>
                                                <div class="userDatatable-content--subject">
                                                    {{$comment->post->title}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="userDatatable__imgWrapper d-flex align-items-center">
                                                        <a href="#" class="profile-image rounded-circle d-block m-0"
                                                            style="background-image:url({{ asset('images/' . $comment->user->avatar) }}); background-size: cover;"></a>
                                                    </div>
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>{{$comment->user->name}}</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                            <div class="userDatatable-content--subject">
                                                    {{$comment->content}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content--date">
                                                    {{ $comment['created_at']->format('Y.m.d') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="form-check form-switch form-switch-primary form-switch-sm">
                                                    <input type="checkbox"
                                                        class="form-check-input toggle-is-active isActive"
                                                        id="switch-s{{$comment['id']}}" data-post-id="{{$comment['id']}}" 
                                                        {{ $comment['isActive'] === 'yes' ? 'checked' : '' }} {{ !in_array(Auth::user()->role, ['admin', 'editor']) ? 'disabled' : '' }} >
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                    <li>
                                                        <a data-bs-toggle="modal" data-bs-target="#comment-edit"
                                                            data-id="{{ $comment['id'] }}" class="edit">
                                                            <i class="uil uil-edit"></i>
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
                                {{ $comments->appends(['per_page' => $perPage, 'page' => $currentPage])->links('vendor.pagination.custom') }}
                            @endif


                            <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center ml-3">
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
        <!-- ends: .row -->
    </div>
</div>

<div class="modal-basic modal fade show" id="comment-edit" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <label for="commentEditTitle">Post Title</label>
                        <input type="text" class="form-control" id="commentEditTitle" placeholder="Duran Clayton" disabled
                            required>
                        <div class="invalid-feedback">Please provide a title.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="commentEditName">Comment By</label>
                        <input type="text" class="form-control" id="commentEditName" placeholder="Duran Clayton" disabled
                            required>
                        <div class="invalid-feedback">Please provide a name.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="commentEditDescription">Description</label>
                        <textarea class="form-control" id="commentEditDescription" placeholder="Enter description" required></textarea>
                        <div class="invalid-feedback">Please provide a description.</div>
                    </div>
                    <input type="hidden" id="commentEditId" name="id">
                    <div class="d-flex justify-content-end p-2">
                        <button type="submit" class="btn btn-primary btn-sm me-2">Save</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal-info-confirmed modal fade show" id="employee-confirmed" tabindex="-1" role="dialog"
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
                        id="employeeDelBtn">Ok</button>
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
    var itemId;

    $(document).ready(function () {
        $('.edit').on('click', function () {
            var commentId = $(this).data('id');

            // Reset form validation state
            resetFormValidation();

            // Fetch employee data via AJAX
            $.ajax({
                url: '/comment/edit/' + commentId,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    populateEditModal(data);
                }
            });
        });

        function resetFormValidation() {
            $('#updateForm input, #updateForm select').removeClass('is-invalid');
            $('#updateForm .invalid-feedback').hide();
        }

        function populateEditModal(data) {
            $('#commentEditName').val(data.post.user.name);
            $('#commentEditTitle').val(data.post.title);
            $('#commentEditDescription').val(data.content);
            $('#commentEditId').val(data.id);
        }

        $('#updateForm').on('submit', function (e) {
            e.preventDefault();

            if (validateForm()) {
                var commentId = $('#commentEditId').val();
                var commentEditName = $('#commentEditName').val();
                var commentEditTitle = $('#commentEditTitle').val();
                var commentEditDescription = $('#commentEditDescription').val();

                $.ajax({
                    url: '/comment/' + commentId,
                    method: 'PUT',
                    data: {
                        content: commentEditDescription,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        //alert('employee updated successfully!');
                        $('#modalMessage').text("Comment updated successfully!");
                        $('#notificationModal').modal('show');
                        $('#comment-edit').modal('hide');
                        //location.reload();
                    }
                });
            }
        });

        function validateForm() {
            let isValid = true;
            // Reset all validation classes and messages
            resetFormValidation();

            // Validate each input field
            $('#updateForm input[required]').each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.invalid-feedback').show();
                }
            });

            return isValid;
        }

        $('#modalOkButton').on('click', function () {
            location.reload();
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
                    url: '/update-comment-is-active', // Replace with your Laravel route
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
    })
</script>

@endsection