@extends('admin.layouts.app')

@section('content')
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">
                            Edit Application Parameter
                        </h3>
                    </div>
                    <!--begin::Form-->
                    <form class="form" id="dynamic_form" action="{{ route('storeappparameter') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="card-body">
                            <!-- Parameters Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Name</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_name" value="{{ $namedata->X_Left ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_name" value="{{ $namedata->Y_Top ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_name" value="{{ $namedata->font_size ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_name" value="{{ $namedata->font_color ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst" value="{{ $namedata->monst ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_name" value="{{ $namedata->letter ?? '' }}" />
                                    {{-- <input type="text" class="form-control" placeholder="Enter letter" name="letter" value="{{ $namedata->letter ?? '' }}" /> --}}
                                </div>
                            </div>
                            
                            <!-- Similarly for Email Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Email</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_email" value="{{ $emaildata->X_Left ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_email" value="{{ $emaildata->Y_Top ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_email" value="{{ $emaildata->font_size ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_email" value="{{ $emaildata->font_color ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_email" value="{{ $emaildata->monst ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_email" value="{{ $emaildata->letter ?? '' }}" />
                                </div>
                            </div>

                            <!-- Similarly for Website Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Website</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_website" value="{{ $websitedata->X_Left ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_website" value="{{ $websitedata->Y_Top ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_website" value="{{ $websitedata->font_size ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_website" value="{{ $websitedata->font_color ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_website" value="{{ $websitedata->monst ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_website" value="{{ $websitedata->letter ?? '' }}" />
                                </div>
                            </div>

                            <!-- Similarly for Mobile Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Mobile</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_mobile" value="{{ $mobiledata->X_Left ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_mobile" value="{{ $mobiledata->Y_Top ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_mobile" value="{{ $mobiledata->font_size ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_mobile" value="{{ $mobiledata->font_color ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_mobile" value="{{ $mobiledata->monst ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_mobile" value="{{ $mobiledata->letter ?? '' }}" />
                                </div>
                            </div>

                            <!-- Similarly for Address Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Address</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_address" value="{{ $addressdata->X_Left ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_address" value="{{ $addressdata->Y_Top ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_address" value="{{ $addressdata->font_size ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_address" value="{{ $addressdata->font_color ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_address" value="{{ $addressdata->monst ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_address" value="{{ $addressdata->letter ?? '' }}" />
                                </div>
                            </div>

                            <!-- Similarly for Company Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Company</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_company" value="{{ $companydata->X_Left ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_company" value="{{ $companydata->Y_Top ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_company" value="{{ $companydata->font_size ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_company" value="{{ $companydata->font_color ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_company" value="{{ $companydata->monst ?? '' }}" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_company" value="{{ $companydata->letter ?? '' }}" />
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" id="submitbutton" name="submit" class="btn btn-primary mr-2">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
@endsection
