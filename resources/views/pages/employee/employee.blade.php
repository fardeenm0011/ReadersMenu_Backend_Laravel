@section('employees', $employees)
@section('perPage', $perPage)
@section('currentPage', $currentPage)
@section('editorCount', $editorCount)
@section('contentCount', $contentCount)
@section('userCount', $userCount)
@extends('layout.app')
@section('content')
<div class="support-ticket mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.employee-menu-title') }}</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i
                                            class="las la-home"></i>{{ trans('menu.home-menu-title') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ trans('menu.employee-menu-title') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
            <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">
                <!-- Card 2 -->
                <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div class="ap-po-details__titlebar">
                                <h1>{{$employees->count()}}</h1>
                                <p>Total Employee</p>
                            </div>
                            <div class="ap-po-details__icon-area">
                                <div class="svg-icon order-bg-opacity-primary">
                                    <img class="svg" src="{{ asset('assets/img/svg/ticket.svg') }}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Card 2 End  -->
            </div>
            <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">
                <!-- Card 2 -->
                <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div class="ap-po-details__titlebar">
                                <h1>{{$editorCount}}</h1>
                                <p>Editor</p>
                            </div>
                            <div class="ap-po-details__icon-area">
                                <div class="svg-icon order-bg-opacity-secondary">
                                    <img class="svg" src="{{ asset('assets/img/svg/ticket-green1.svg') }}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Card 2 End  -->
            </div>
            <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">
                <!-- Card 2 -->
                <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div class="ap-po-details__titlebar">
                                <h1>{{$contentCount}}</h1>
                                <p>Content Team</p>
                            </div>
                            <div class="ap-po-details__icon-area">
                                <div class="svg-icon order-bg-opacity-warning">
                                    <img class="svg" src="{{ asset('assets/img/svg/clock-ticket1.svg') }}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Card 2 End  -->
            </div>
            <div class="col-xxl-3 col-sm-6  col-ssm-12 mb-30">
                <!-- Card 2 -->
                <div class="ap-po-details ap-po-details--ticket radius-xl d-flex justify-content-between">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div class="ap-po-details__titlebar">
                                <h1>{{$userCount}}</h1>
                                <p>Normal User</p>
                            </div>
                            <div class="ap-po-details__icon-area">
                                <div class="svg-icon order-bg-opacity-success">
                                    <img class="svg" src="{{ asset('assets/img/svg/check-circle1.svg') }}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Card 2 End  -->
            </div>
            <div class="col-12">
                <div class="support-ticket-system" style="padding: 25px">
                    <div class="userDatatable userDatatable--ticket">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Employees</h4>
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
                            <div class="action-btn">
                                <a data-bs-toggle="modal" data-bs-target="#employee-add" class="btn btn-primary">
                                    <i class="fa fa-plus"></i>Add Employee</a>
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
                                            <span class="userDatatable-title">Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Email</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Role</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Joined at</span>
                                        </th>
                                        <th class="actions">
                                            <span class="userDatatable-title">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{$employee['id']}}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="userDatatable__imgWrapper d-flex align-items-center">
                                                        <a href="#" class="profile-image rounded-circle d-block m-0"
                                                            style="background-image:url({{ asset('images/' . $employee['avatar']) }}); background-size: cover;"></a>
                                                    </div>
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>{{$employee['name']}}</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content--subject">
                                                    {{$employee['email']}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content d-inline-block">
                                                    <span
                                                        class="bg-opacity-success  color-success userDatatable-content-status active">{{$employee['role']}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content--date">
                                                    {{ $employee['created_at']->format('Y.m.d') }}
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                    <li>
                                                        <a data-bs-toggle="modal" data-bs-target="#employee-password"
                                                            data-id="{{ $employee['id'] }}" class="password">
                                                            <i class="uil uil-lock"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-bs-toggle="modal" data-bs-target="#employee-edit"
                                                            data-id="{{ $employee['id'] }}" class="edit">
                                                            <i class="uil uil-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="remove" data-id={{$employee['id']}} data-bs-toggle="modal"
                                                            data-bs-target="#employee-confirmed">
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
                                {{ $employees->appends(['per_page' => $perPage, 'page' => $currentPage])->links('vendor.pagination.custom') }}
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

<div class="modal-basic modal fade show" id="employee-edit" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <label for="employeeEditName">Name</label>
                        <input type="text" class="form-control" id="employeeEditName" placeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a name.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="employeeEditEmail">Email</label>
                        <input type="text" class="form-control" id="employeeEditEmail" placeholder="Duran@gmail.com"
                            required>
                        <div class="invalid-feedback">Please provide a email.</div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="employeeEditRole">Role</label>
                            <select class="js-example-basic-single js-states form-control" id="employeeEditRole"
                                required>
                                <option value="">Choose...</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="content">Content Team</option>
                                <option value="user">User</option>
                            </select>
                            <div class="invalid-feedback">Please select a role.</div>
                        </div>
                    </div>
                    <input type="hidden" id="employeeEditId" name="id">
                    <div class="d-flex justify-content-end p-2">
                        <button type="submit" class="btn btn-primary btn-sm me-2">Save</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal-basic modal fade show" id="employee-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-bg-white">
            <div class="modal-header">
                <h6 class="modal-title">Add</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{ route('employee.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="account-profile d-flex align-items-center mb-4">
                        <div class="ap-img pro_img_wrapper">
                            <input id="file-upload" type="file" name="avatar" class="d-none" accept="image/*">
                            <!-- Profile picture image-->
                            <label for="file-upload">
                                <img id="profile-pic" class="ap-img__main rounded-circle wh-120 bg-lighter d-flex"
                                    src="{{ asset('assets/img/author/profile.png') }}" alt="profile">
                                <span class="cross" id="remove_pro_pic">
                                    <img src="{{ asset('assets/img/svg/camera.svg') }}" alt="camera" class="svg">
                                </span>
                            </label>
                        </div>
                        <div class="account-profile__title">
                            <h6 class="fs-15 ms-20 fw-500 text-capitalize">profile photo</h6>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="employeeAddName">Name</label>
                        <input type="text" class="form-control" id="employeeAddName" name="name"
                            placeholder="Duran Clayton" required>
                        <div class="invalid-feedback">Please provide a name.</div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="employeeAddEmail">Email</label>
                        <input type="email" class="form-control" id="employeeAddEmail" name="email"
                            placeholder="Duran@gmail.com" required>
                        <div class="invalid-feedback">Please provide an email.</div>
                    </div>
                    <div class="form-group mb-20">
                        <div class="countryOption">
                            <label for="employeeAddRole">Role</label>
                            <select class="js-example-basic-single js-states form-control" id="employeeAddRole"
                                name="role" required>
                                <option value="">Choose...</option>
                                <option value="1">Admin</option>
                                <option value="2">Editor</option>
                                <option value="3">Content Team</option>
                                <option value="4">User</option>
                            </select>
                            <div class="invalid-feedback">Please select a role.</div>
                        </div>
                    </div>
                    <div class="form-group mb-20">
                        <label for="employeeAddPassword">Password</label>
                        <input type="password" class="form-control" id="employeeAddPassword" name="password" required>
                        <div class="invalid-feedback">Please provide a password.</div>
                    </div>
                    <input type="hidden" id="employeeAddId" name="id">
                    <div class="d-flex justify-content-end p-2">
                        <button type="submit" class="btn btn-primary btn-sm me-2">Save</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal-basic modal fade show" id="employee-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-bg-white">
            <div class="modal-header">
                <h6 class="modal-title">Edit</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                </button>
            </div>
            <div class="modal-body">
                <form id="updatePasswordForm" novalidate>
                    <div class="form-group mb-20">
                        <label for="employeeSetPassword">Password</label>
                        <input type="text" class="form-control" id="employeeSetPassword" Passwordeholder="Duran Clayton"
                            required>
                        <div class="invalid-feedback">Please provide a password.</div>
                    </div>
                    <input type="hidden" id="employeeEditPasswordId" name="id">
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
            var employeeId = $(this).data('id');

            // Reset form validation state
            resetFormValidation();

            // Fetch employee data via AJAX
            $.ajax({
                url: '/employee/edit/' + employeeId,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    populateEditModal(data);
                }
            });
        });

        $('.password').on('click', function () {
            var employeeId = $(this).data('id');

            // Reset form validation state
            resetPasswordFormValidation();

            // Fetch employee data via AJAX
            $.ajax({
                url: '/employee/edit/' + employeeId,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    populateEditPasswordModal(data);
                }
            });
        });

        function resetFormValidation() {
            $('#updateForm input, #updateForm select').removeClass('is-invalid');
            $('#updateForm .invalid-feedback').hide();
        }

        function resetPasswordFormValidation() {
            $('#updatePasswordForm input, #updatePasswordForm select').removeClass('is-invalid');
            $('#updatePasswordForm .invalid-feedback').hide();
        }

        function populateEditModal(data) {
            $('#employeeEditName').val(data.name);
            $('#employeeEditEmail').val(data.email);
            $('#employeeEditRole').val(data.role);
            $('#employeeEditId').val(data.id);
        }
        function populateEditPasswordModal(data) {
            $('#employeeEditPasswordId').val(data.id);
        }

        $('#updateForm').on('submit', function (e) {
            e.preventDefault();

            if (validateForm()) {
                var employeeId = $('#employeeEditId').val();
                var employeeEditName = $('#employeeEditName').val();
                var employeeEditEmail = $('#employeeEditEmail').val();
                var employeeEditRole = $('#employeeEditRole').val();

                $.ajax({
                    url: '/employee/' + employeeId,
                    method: 'PUT',
                    data: {
                        name: employeeEditName,
                        email: employeeEditEmail,
                        role: employeeEditRole,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        //alert('employee updated successfully!');
                        $('#modalMessage').text("Employee updated successfully!");
                        $('#notificationModal').modal('show');
                        $('#employee-edit').modal('hide');
                        //location.reload();
                    }
                });
            }
        });

        $('#updatePasswordForm').on('submit', function (e) {
            e.preventDefault();

            if (validatePasswordForm()) {
                var employeeId = $('#employeeEditPasswordId').val();
                var employeeSetPassword = $('#employeeSetPassword').val();

                $.ajax({
                    url: '/employee/password/' + employeeId,
                    method: 'PUT',
                    data: {
                        password: employeeSetPassword,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        //alert('employee updated successfully!');
                        $('#modalMessage').text("Password updated successfully!");
                        $('#notificationModal').modal('show');
                        $('#employee-edit').modal('hide');
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
            $('#updateForm input[required], #updateForm select[required]').each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.invalid-feedback').show();
                }
            });

            return isValid;
        }

        function validatePasswordForm() {
            let isValid = true;
            // Reset all validation classes and messages
            resetPasswordFormValidation();

            // Validate each input field
            $('#updatePasswordForm input[required]').each(function () {
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

        $('.remove').on('click', function () {
            itemId = $(this).data('id');
        });

        $('#employeeDelBtn').on('click', function () {
            $.ajax({
                url: '/employee/' + itemId, // Adjust the URL to match your route
                type: 'DELETE', // Use DELETE method
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function (response) {
                    if (response.success) {
                        //alert(response.success); // Show success message
                        $('#modalMessage').text("Employee deleted successfully!");
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
    })


    document.getElementById('file-upload').addEventListener('change', function (event) {
        const file = event.target.files[0]; // Access the first file in the FileList
        const reader = new FileReader();

        if (file) {
            reader.onload = function (e) {
                document.getElementById('profile-pic').src = e.target.result;
            }
            reader.readAsDataURL(file); // Read the file as a data URL
        } else {
            console.error('No file selected');
        }
    });

    document.getElementById('remove_pro_pic').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('file-upload').value = '';
        document.getElementById('profile-pic').src = '{{ asset('assets/img/author/profile.png') }}';
    });

</script>

@endsection