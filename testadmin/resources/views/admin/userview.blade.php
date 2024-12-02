@extends('admin.layouts.app')
@section('content')
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">User Details</h3>
                </div>
            </div>

            <div class="card-body">
                <!-- User Information Section -->
                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-3">User Information</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Mobile Number:</strong> {{ $user->mobileno }}</li>
                    </ul>
                </div>
                
                <!-- Business/Personal Details Section -->
                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-3">Details</h5>
                    
                    @if($user->businesses->isNotEmpty())
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->businesses as $business)
                                <tr>
                                    <td>
                                        @if($business->logo_image)
                                            <img src="{{ asset('images/' . $business->logo_image) }}" alt="Logo" style="width: 50px; height: auto;">
                                        @else
                                            <span>No Logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $business->business_name }}</td>
                                    <td>{{ $business->email }}</td>
                                    <td>{{ $business->mobile_no }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($user->personal)
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @if($user->personal->logo)
                                            <img src="{{ asset('images/' . $user->personal->logo) }}" alt="Logo" style="width: 50px; height: auto;">
                                        @else
                                            <span>No Logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->personal->name }}</td>
                                    <td>{{ $user->personal->email_id }}</td>
                                    <td>{{ $user->personal->mobile_number }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p>No additional details available for this user.</p>
                    @endif
                </div>
            </div>
                
        </div>
    </div>
    <!--end::Container-->
</div>
@endsection
