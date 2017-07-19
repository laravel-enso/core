@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __('Entities'))

@section('content')
<section class="content-header">
    @can('access-route', 'administration.owners.create')
    <a class="btn btn-primary" href="/administration/owners/create">
        {{ __("Create Entity") }}
    </a>
    @endcan
    @include('laravel-enso/menumanager::breadcrumbs')
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

    <script>

        const vm = new Vue({
            el: '#app'
        });

    </script>

@endpush
