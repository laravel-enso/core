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
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header with-border" style="text-align:center">
                        <div class="box-title">
                            {{ __("Edit") }}
                        </div>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus">
                                </i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        {!! Form::model($owner, ['method' => 'PATCH', 'url' => '/administration/owners/'.$owner->id]) !!}
                        <div class="row">
                            @include('laravel-enso/core::administration.owners.form')
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('roleList') ? ' has-error' : '' }}">
                                    {!! Form::label('roleList', __('Roles')) !!}
                                    <small class="text-danger" style="float:right;">
                                        {{ $errors->first('roleList') }}
                                    </small>
                                    {!! Form::select('roleList[]', $roles, null, ['class' => 'form-control select', 'multiple' => 'multiple']) !!}
                                </div>
                            </div>
                        </div>
                        <center>
                            {!! Form::submit(__("Save"), ['class' => 'btn btn-primary']) !!}
                        </center>
                        {!! Form::close() !!}
                    </div>
                </div>

                @if(!is_null(config('comments.commentables.owner')))
                    <comments :id="{{ $owner->id }}"
                        type="owner"
                        v-if="{{ $owner }}">
                    </comments>
                @endif
                @if(!is_null(config('documents.documentables.owner')))
                    <documents :id="{{ $owner->id }}"
                        :file-size-limit="5000000"
                        type="owner"
                        v-if="{{ $owner }}">
                    </documents>
                @endif
                @if(!is_null(config('contacts.contactables.owner')))
                    <contacts :id="{{ $owner->id }}"
                        type="owner"
                        v-if="{{ $owner }}">
                    </contacts>
                @endif

                @if(false)
                    <box theme="primary"
                        icon="fa fa-lightbulb-o"
                        title="Box Component"
                        border open collapsible
                        removable refresh search
                        solid footer
                        :overlay="loading"
                        @refresh="refresh()"
                        :badge="5">
                        <span slot="btn-box-tool">
                            <button class="btn btn-box-tool btn-sm"
                                @click="customAction()">
                                <i class="fa fa-handshake-o"></i>
                            </button>
                        </span>
                        Box Body
                        <span slot="footer">Footer</span>
                    </box>

                    <small-box icon="fa fa-shopping-cart"
                        theme="bg-olive"
                        title="Title"
                        body="Body">
                    </small-box>

                    <info-box theme="bg-red"
                        icon="fa fa-star-o"
                        text="What about this"
                        number="77,430"
                        progress="75"
                        description="Super progress">
                    </info-box>

                    <div class="row">
                        <div class="col-md-6">
                            <box-widget theme="bg-orange"
                                :image="avatarLink"
                                name="First and Last Name"
                                position="Developer"
                                :items="[{'label': 'Projects', 'value': 12, 'badge': 'bg-blue'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}, {'label': 'Themes', 'value': 21, 'badge': 'bg-yellow'}]">
                            </box-widget>
                        </div>
                    </div>

                    <user-widget
                        theme="bg-blue"
                        :avatar="avatarLink"
                        background="/images/pic.jpg"
                        name="First and Last Name"
                        position="Developer"
                        :items="[{'label': 'Themes', 'value': 21}, {'label': 'Tests', 'value': 56}, {'label': 'Projects', 'value': 12},{'label': 'Projects', 'value': 12}]">
                    </user-widget>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app',

            data: {
                loading: false,
                avatarLink: '/core/avatars/' + (Store.user.avatarId || 'null')
            },

            methods: {
                customAction() {
                    alert('pressed');
                },
                refresh() {
                    alert('refresh');
                }
            }
        });

    </script>

@endpush