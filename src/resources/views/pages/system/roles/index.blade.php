@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Roles"))

@section('content')

<section class="content-header">
    <a class="btn btn-primary" href="/system/roles/create">
        {{ __("Create Role") }}
    </a>
    @include('laravel-enso/core::partials.breadcrumbs')
</section>
<section class="content">
    <div class="row" v-cloak>
        <div class="col-md-12">
            <data-table source="/system/roles">
                <span slot="data-table-title">{{ __("Roles") }}</span>
                @include('laravel-enso/core::partials.modal')
            </data-table>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/vendor/laravel-enso/pages/index.js') }}"></script>
@endpush