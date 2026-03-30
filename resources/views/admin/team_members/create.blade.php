@extends('layouts.app')

@section('title', isset($team_member) ? 'Edit Team Member' : 'Add Team Member')

@section('css')
    <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="nav-icon fa fa-users"></i> 
                    {{ isset($team_member) ? 'Edit Team Member' : 'Add Team Member' }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.team_members.index') }}">Management Team</a></li>
                    <li class="breadcrumb-item active">{{ isset($team_member) ? 'Edit' : 'Create' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            {{ isset($team_member) ? 'Edit Team Member' : 'Add New Team Member' }}
        </h3>
    </div>
    <form method="POST" action="{{ isset($team_member) ? route('admin.team_members.update', $team_member->id) : route('admin.team_members.store') }}" enctype="multipart/form-data">
        <div class="card-body">
            @csrf
            @if(isset($team_member))
                @method('PUT')
            @endif

            @include('admin.team_members._form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i> Save
            </button>
            <a href="{{ route('admin.team_members.index') }}" class="btn btn-secondary ml-2">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ url('js/admin/team_members.js') }}"></script>
@endpush
