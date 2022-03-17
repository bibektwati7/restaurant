@extends('layouts.app')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row mt-0 mt-lg-8">

                <div class="col-xl-12">
                    <!--begin::Advance Table Widget 1-->
                    <div class="card card-custom card-stretch card-shadowless gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Scheme Management</span>
                                <span class="text-muted mt-3 font-weight-bold font-size-sm">Create schemes</span>
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-0">
                            <form action="{{ route('schemes.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="food">Food Name</label>
                                    <select name="food" id="food" class="form-control" required>
                                        <option value="">
                                            @foreach($foods as $food)
                                        <option value="{{ $food->id }}">
                                            {{$food->name}}
                                        </option>
                                        @endforeach
                                        </option>
                                    </select>
                                    @error('name')
                                    <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <div class="input-group">

                                        <input type="number" class="form-control" name='quantity' min="0"
                                            required /><br>
                                        @error('quantity')
                                        <div class="alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <div class="input-group">

                                        <input type="date" class="form-control" name='start_date' required /><br>
                                        @error('start_date')
                                        <div class="alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <div class="input-group">

                                        <input type="date" class="form-control" name='end_date' /><br>
                                        @error('end_date')
                                        <div class="alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success" type="submit">
                                        Create Scheme
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Advance Table Widget 1-->
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->

        <!--end::Row-->



        <!--end::Dashboard-->
        <!--end::Container-->
    </div>
</div>
@endsection