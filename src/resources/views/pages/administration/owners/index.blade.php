@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __('Entities'))

@section('content')
<section class="content-header">
    @can('accessRoute', 'administration.owners.create')
    <a class="btn btn-primary" href="/administration/owners/create">
        {{ __("Create a new Entity") }}
    </a>
    @endcan
    @include('laravel-enso/core::partials.breadcrumbs')
</section>
<section class="content">
    <div class="row" v-cloak>
        <div class="col-md-12">
            <data-table source="/administration/owners">
                <span slot="data-table-title">{{ __("Registered Entities") }}</span>
                @include('laravel-enso/core::partials.modal')
            </data-table>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript" src="/js/vendor/laravel-enso/pages/generic.js"></script>
@endpush
