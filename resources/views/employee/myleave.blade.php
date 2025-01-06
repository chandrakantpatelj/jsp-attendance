@extends('layouts.app')
@section('auth-content')
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include('employee.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('employee.header')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="page-header  d-flex justify-content-between align-items-center ">
                    <h5 class="mb-0">My Leave</h5>
                    <div class="d-flex align-items-center justify-content-end">
                        <button class="btn btn-primary add-leave-btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="ti ti-plus"></i> Add new leave
                        </button>
                        <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <form id="leaveForm"
                                action="{{ isset($leaves->id) ? route('my-leave.update', $leaves->id) : route('my-leave.store') }}"
                                method="POST">
                                @csrf
                                @if(isset($leaves->id))
                                @method('PUT')
                                @else
                                @method('POST')
                                @endif
                                <input type="hidden" name="leaves_id" id="modalLeavesId">
                                <div class="offcanvas-header">
                                    <h2 id="offcanvasRightLabel"> Add new leave</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>

                                <div class="offcanvas-body">
                                    <div class="mb-4">
                                        <label class="custom_lable">Leave type</label>
                                        <select class="form-select" aria-label="Default select example"
                                            name="leavestatus">
                                            <option selected>Select leave type</option>
                                            <option value="1"
                                                {{ old('leavestatus', $leaves->isNotEmpty() ? $leaves->first()->leavestatus === '1' : '') ? 'selected' : '' }}>
                                                First half</option>
                                            <option value="2"
                                                {{ old('leavestatus', $leaves->isNotEmpty() ? $leaves->first()->leavestatus === '2' : '') ? 'selected' : '' }}>
                                                Second half</option>
                                            <option value="3"
                                                {{ old('leavestatus', $leaves->isNotEmpty() ? $leaves->first()->leavestatus === '3' : '') ? 'selected' : '' }}>
                                                Full day</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="leaveStartDate" class="form-label custom_lable ">Start date</label>
                                        <input type="date" name="leaveStartDate"
                                            class="form-control @error('leaveStartDate') is-invalid @enderror"
                                            placeholder="Select start date" id="leaveStartDate"
                                            value="{{ old('leaveStartDate', $leaves->isNotEmpty() ? $leaves->first()->leaveStartDate : '') }}"
                                            required autofocus />
                                        @error('punch_in_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="leaveEndDate" class="form-label custom_lable ">End date</label>
                                        <input type="date" name="leaveEndDate"
                                            class="form-control @error('leaveEndDate') is-invalid @enderror"
                                            placeholder="Select end date" id="leaveEndDate"
                                            value="{{ old('leaveEndDate', $leaves->isNotEmpty() ? $leaves->first()->leaveEndDate : '') }}"
                                            required autofocus />
                                        @error('leaveEndDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="leaveTotalDay" class="form-label custom_lable">Total
                                            day’s</label>
                                        <input type="text" name="leaveTotalDay"
                                            class="form-control @error('leaveTotalDay') is-invalid @enderror"
                                            placeholder="Enter day’s" id="leaveTotalDay"
                                            value="{{ old('leaveTotalDay', $leaves->isNotEmpty() ? $leaves->first()->leaveTotalDay : '') }}"
                                            required autofocus />
                                        @error('leaveTotalDay')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="leaveReason" class="form-label custom_lable">Reason</label>
                                        <input type="text" name="leaveReason"
                                            class="form-control @error('leaveReason') is-invalid @enderror"
                                            placeholder="Enter Your Reason" id="leaveReason"
                                            value="{{ old('leaveReason', $leaves->isNotEmpty() ? $leaves->first()->leaveReason : '') }}"
                                            required autofocus />
                                        @error('leaveReason')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-3 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary from_btn"
                                            data-bs-dismiss="offcanvas">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="calendar-csvfile ms-3">
                            <h5 class="mb-0"> <i class="ti ti-file-analytics"></i>CSV files</h5>
                        </div>
                    </div>


                </div>


                <div class="container-xxl flex-grow-1">
                    <ul class="nav nav-tabs  custom_tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                                aria-selected="true">
                                All Leave
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-link-preparing"
                                aria-controls="navs-justified-link-preparing" aria-selected="false">
                                Pending
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-link-shipping"
                                aria-controls="navs-justified-link-shipping" aria-selected="false">
                                Approved
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-link-rejected"
                                aria-controls="navs-justified-link-rejected" aria-selected="false">
                                Rejected
                            </button>
                        </li>
                    </ul>
                    <div class="card ">
                        <div class="p-0">
                            <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                <div class="btn-group search_leave">
                                    <button type="button" class="btn btn-label-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Search leave type
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0);">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Another
                                                action</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Something
                                                else here</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Separated
                                                link</a></li>
                                    </ul>
                                </div>
                                <div class="info-container ">

                                    @foreach($leaves as $leave)
                                    <div class="d-flex justify-content-between leave_list ">
                                        <ul class="list-unstyled  mb-0">
                                            <?php
                                            //dd($leaves);
                                            ?>


                                            <li class="mb-2">
                                                <span class="fw-medium me-2">Leave type:</span>
                                                <span>{{ $leave->leave_type }}</span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="fw-medium me-2">Start date:</span>
                                                <span>{{ $leave->start_date }}</span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="fw-medium me-2">End date:</span>
                                                <span>{{ $leave->end_date }}</span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="fw-medium me-2">Total days:</span>
                                                <span>{{ $leave->leave_type }}</span>
                                            </li>

                                            <li>
                                                <span class="fw-medium me-2">Reason type:-</span>
                                                <span>{{ $leave->reason }}</span>
                                            </li>
                                        </ul>
                                        <div class="d-flex flex-column justify-content-between">
                                            <div class="d-flex">
                                                <button type="button" class="bg-transparent border-0"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <i class="ti ti-trash"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade " id="exampleModal" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">

                                                            <div class="modal-body ">
                                                                <button type="button" class=" deleteicon-btn">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                                <h3 class="text-center">Are you sure!</h3>
                                                                <h5 class="text-center mb-0">Are you sure want to
                                                                    delete this leave?</h5>
                                                                <div
                                                                    class="modal-btns d-flex gap-4 justify-content-center ">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button"
                                                                        class="btn btn-danger">Delete</button>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="bg-transparent border-0"
                                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvaseditRight"
                                                    aria-controls="offcanvasRight"><i class="ti ti-edit"></i>
                                                </button>
                                            </div>
                                            <h5 class="text-danger">pending</h5>
                                        </div>
                                    </div>
                                    <small class="d-block border-top fw-normal text-uppercase text-muted "></small>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <h5> Showing 03 entries</h5>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <button class="page-link bg-transparent" aria-label="Previous">
                                            <span aria-hidden="true"><i class="ti ti-chevron-left"></i></span>
                                        </button>
                                    </li>
                                    <li class="page-item"><a class="page-link bg-transparent" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link  bg-warning text-white" href="#">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link bg-transparent" href="#">3</a></li>
                                    <li class="page-item">
                                        <button class="page-link bg-transparent" aria-label="Next">
                                            <span aria-hidden="true"><i class="ti ti-chevron-right"></i></span>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    @endsection