@extends('layouts.app')
@section('title', 'Service Details')

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Service Details</h3>
        <div>
            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $service->name }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Category</th>
                            <td>
                                @if($service->category == 'laboratory')
                                    <span class="badge bg-blue">Laboratory</span>
                                @elseif($service->category == 'imaging')
                                    <span class="badge bg-purple">Imaging</span>
                                @else
                                    <span class="badge bg-green">Procedure</span>
                                @endif
                            </td>
                        </tr>
                        @if($service->sub_category)
                        <tr>
                            <th>Sub Category</th>
                            <td>{{ $service->sub_category }}</td>
                        </tr>
                        @endif
                        @if($service->short_name)
                        <tr>
                            <th>Short Name</th>
                            <td>{{ $service->short_name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Price</th>
                            <td>{{ get_currency() }} {{ number_format($service->price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>{{ $service->duration_minutes }} minutes</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($service->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Show on Frontend</th>
                            <td>
                                @if($service->show_on_frontend)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Home Visit Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Available</th>
                            <td>
                                @if($service->home_visit_available)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                        @if($service->home_visit_available && $service->home_visit_price)
                        <tr>
                            <th>Additional Price</th>
                            <td>+ {{ get_currency() }} {{ number_format($service->home_visit_price, 2) }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            @if($service->description || $service->preparation || $service->specimen_type)
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Additional Information</h5>
                </div>
                <div class="card-body">
                    @if($service->description)
                    <div class="mb-3">
                        <strong>Description</strong>
                        <p class="text-muted">{{ $service->description }}</p>
                    </div>
                    @endif
                    
                    @if($service->specimen_type)
                    <div class="mb-3">
                        <strong>Specimen Type</strong>
                        <p class="text-muted">{{ $service->specimen_type }}</p>
                    </div>
                    @endif

                    @if($service->preparation)
                    <div>
                        <strong>Preparation Instructions</strong>
                        <p class="text-muted">{{ $service->preparation }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
