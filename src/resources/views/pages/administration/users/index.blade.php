@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("users"))

@section('content')
<section class="content-header">
    @can('accessRoute', 'administration.users.create')
        <a class="btn btn-primary" href="/administration/users/create">
            {{ __("Create a new User") }}
        </a>
    @endcan
    @can('accessRoute', 'core.export.getUsers')
        <button id="exportButton"
            class="btn btn-primary margin-l-2"
            @click="getExport">
            {{ __("Export") }}
        </button>
    @endcan
    @include('laravel-enso/core::partials.breadcrumbs')
</section>
<section class="content">
    <div class="row" v-cloak>
        <div class="col-md-12 table-responsive">
            <data-table source="/administration/users">
                <span slot="data-table-title">{{ __("Registered Users") }}</span>
                @include('laravel-enso/core::partials.modal')
            </data-table>
        </div>
    </div>
    @can('accessApiTokens')
        <!-- <div class="row" v-cloak>
            <div class="col-md-12">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div> -->
    @endcan
</section>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('/js/users/index.js') }}"></script>
@endpush