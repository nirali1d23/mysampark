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
                           Image Edit 
                       </h3>
                    </div>
                    <!--begin::Form-->
                    <form class="form" id="dynamic_form" action="{{ route('storeimage') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Upload Club Logo -->
                           
                            <div class="form-group">
                                <label for="exampleSelect1">Select Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="exampleSelect1">
                                 @foreach ($categories as $item)
                                 <option value="{{ $item->id }}">{{ $item->name }}</option>
                             @endforeach

                                </select>
                               </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Image: <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" placeholder="Enter title" name="image" />
                                   
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
    </div>z`
    <!--end::Container-->
</div>
<script></script>
@endsection



