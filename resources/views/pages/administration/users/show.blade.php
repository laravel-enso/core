@extends('core::layouts.app')

@section('pageTitle', __('Profile'))

@section('content')
<section class="content-header">
    @include('core::partials.breadcrumbs')
</section>
<section class="content">
  <div class="row">
    <div class="col-md-5">
      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          @can('impersonate', $user)
            <a class="fa fa-gears pull-right" href="/administration/users/{{ $user->id }}/impersonate" v-tooltip="'Impersonate'"></a>
          @endcan
          <img class="profile-user-img img-responsive img-square user-avatar"
              src="{{ $user->avatar_link }}"
              alt="User Image">
          @can('viewProfilePage', $user)
            <center>
            <button class="btn btn-xs btn-success"
                    v-tooltip="'{{ __("Upload Avatar") }}'"
                    @click="openFileBrowser">
              <i class="fa fa-camera"></i>
            </button>
            <button class="btn btn-xs btn-danger {{ $user->avatar ? '' : 'hidden' }}"
                    id="delete-avatar"
                    data-avatar-id="{{ $user->avatar ? $user->avatar->id : null }}"
                    v-tooltip="'{{ __("Delete Avatar") }}'"
                    @click="deleteAvatar('{{ $user->avatar->id }}')">
              <i class="fa fa-trash-o btn-danger"></i>
            </button>
            </center>
            {!! Form::open(['method' => 'POST', 'url' => '/core/avatars', 'class' => 'form-horizontal', 'files' => 'true', 'id' => 'upload-avatar-form']) !!}
              <input type="file"
                    name="avatar"
                    class="hidden"
                    @change="submitAvatar">
            {!! Form::close() !!}
          @endcan
          <h3 class="profile-username text-center"> {{ $user->full_name }} </h3>

          <p class="text-muted text-center"> {{ $user->role->display_name }} </p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b> {{ __("Member Since") }} </b> <a class="pull-right"> {{ $user->created_date }} </a>
            </li>
            <li class="list-group-item">
              <b> {{ __("Logins") }} </b> <a class="pull-right">  {{ $user->logins->count() }}  </a>
            </li>
            <li class="list-group-item">
              <b> {{ __("Activity") }} </b> <a class="pull-right"> {{ $user->actionsHistories->count() }} </a>
            </li>
            <li class="list-group-item">
              <b> {{ __("Birthday") }} </b> <a class="pull-right"> {{ $user->birthday }} </a>
            </li>
          </ul>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      @can('viewProfilePage', $user)
        <!-- About Me Box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"> {{ __("Personal Info") }} </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="padding:25px">
            {!! Form::model($user, ['method' => 'PATCH', 'url' => '/administration/users/updateProfile/' . $user->id, 'class' => 'form-horizontal']) !!}
              <div class="col-xs-12">
                  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                      {!! Form::label('first_name', __("First Name")) !!}
                      <small class="text-danger" style="float:right;">
                          {{ $errors->first('first_name') }}
                      </small>
                      {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
                  </div>
              </div>
              <div class="col-xs-12">
                  <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                      {!! Form::label('last_name', __("Last Name")) !!}
                      <small class="text-danger" style="float:right;">
                          {{ $errors->first('last_name') }}
                      </small>
                      {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
                  </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group{{ $errors->has('nin') ? ' has-error' : '' }}">
                    {!! Form::label('nin', __("NIN")) !!}
                    <small class="text-danger" style="float:right;">
                        {{ $errors->first('nin') }}
                    </small>
                    {!! Form::text('nin', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                  {!! Form::label('email', __("Email")) !!}
                  <small class="text-danger" style="float:right;">
                      {{ $errors->first('email') }}
                  </small>
                  {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                  {!! Form::label('phone', __("Phone")) !!}
                  <small class="text-danger" style="float:right;">
                      {{ $errors->first('phone') }}
                  </small>
                  {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => __("Please Fill")]) !!}
                </div>
              </div>
              <center>
                {!! Form::submit(__("Update"), ['class' => 'btn btn-primary']) !!}
              </center>

            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      @endcan
    </div>
    <!-- /.col -->

    <div class="col-md-7">
      <!-- Timeline Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> {{ __("Timeline") }} </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <ul class="timeline timeline-inverse">
            <!-- timeline time label -->
            @foreach($timeline as $event)
            <li class="time-label">
                  <span class="bg-red">
                    {{ $event->created_date }}
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-user bg-aqua"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{ $event->created_time }} </span>

                <h3 class="timeline-header no-border">{{ $user->full_name }} {{ __('Accessed Route') }} {{ $event->route }}
                </h3>
              </div>
            </li>
            <!-- END timeline item -->
            <!-- timeline item -->
            @endforeach
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('/js§/users/show.js') }}"></script>
@endpush