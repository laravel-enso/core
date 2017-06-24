@extends('laravel-enso/core::layouts.app')

@section('content')

    <section class="content-header">
        @can('access-route', 'administration.owners.edit')
        <a class="btn btn-primary" href="/administration/owners/{{ $owner->id }}/edit">
            {{ __("Edit") }}
        </a>
        @endcan
        @include('laravel-enso/menumanager::breadcrumbs')
    </section>
    <section class="content">
        <div class="row" v-cloak>

            <input type="hidden" id="partnerId" value="{{$owner->id}}">

            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center">
                            {{ $owner->name }}
                        </h3>
                        <p class="text-muted text-center">
                            {{ $owner->fiscal_code }}
                        </p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>
                                    {{ __("Active") }}
                                </b>
                                <a class="pull-right">
                                    {{ $owner->is_active ? 'Yes' : 'No' }}
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>
                                    Sold
                                </b>
                                <a class="pull-right">
                                    54.545 RON
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>
                                    Facturi restante
                                </b>
                                <a class="pull-right">
                                    8
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>
                                    Documente de plata
                                </b>
                                <a class="pull-right">
                                    2
                                </a>
                            </li>
                        </ul>
                        <strong>
                            <i class="fa fa-map-marker margin-r-5">
                            </i>
                            {{ __("Address") }}
                        </strong>
                        <p class="text-muted">
                            {{ $owner->city . ' ' . ' ' . $owner->county . ' ' . $owner->address }}
                        </p>
                        <hr>
                            <strong>
                                <i class="fa fa-pencil margin-r-5">
                                </i>
                                Contact
                            </strong>
                            - {{ $owner->contact or 'N/A'}}
                            <p>
                                <span data-toggle="tooltip" title="{{ __("Phone") }}">
                                    <i class="fa fa-phone">
                                    </i>
                                    {{ $owner->phone or 'N/A'}}
                                </span>
                                /
                                <span data-toggle="tooltip" title="{{ __("Email") }}">
                                    <i class="fa fa-envelope-o">
                                    </i>
                                    {{ $owner->email or 'N/A'}}
                                </span>
                            </p>
                            <hr>
                                <strong>
                                    <i class="fa fa-exclamation">
                                    </i>
                                    Alerte
                                </strong>
                                <p>
                                    <span class="label label-danger ml-5">
                                        Restant
                                    </span>
                                    <span class="label label-success ml-5">
                                        Bun Platnic
                                    </span>
                                    <span class="label label-info ml-5">
                                        Fara istoric
                                    </span>
                                </p>
                            </hr>
                        </hr>
                    </div>
                </div>
            </div>
            <div class="col-md-9">

                @if ($owner->is_active)
                <div class="box-body">
                    <ul class="nav nav-tabs">
                        <li class="{{ session()->has('nav') || $errors->count() ? '' : 'active' }}">
                            <a data-toggle="tab" href="#activity">
                                Activitate
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="{{ session()->has('nav') || $errors->count() ? '' : 'active' }} tab-pane" id="activity">
                            <!-- Post -->
                            <div class="post">
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                                </p>
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                                </p>
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                                        Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                                </p>

                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                </div>
                @else
                <div class="box box-primary">
                    <center>
                        <h3 style="color:grey">
                            Partenerul nu este activ
                        </h3>
                        <br>
                    </center>
                </div>
                @endif
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
