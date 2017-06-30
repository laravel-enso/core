@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __('Profile'))

@section('content')

	<section class="content-header">
			@include('laravel-enso/menumanager::breadcrumbs')
			@includeIf('laravel-enso/impersonate::start')
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-5">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-square user-avatar"
							:src="avatarLink"
							alt="User Image">
						@can('update-profile', $user)
							<center class="margin-top-xs margin-bottom-xs" v-cloak>
								<file-uploader v-if="!store.user.avatar_id"
									@upload-successful="store.user.avatar_id = $event.id"
									url="/core/avatars">
									<span slot="upload-button">
										<i class="fa fa-camera btn btn-xs btn-success">
										</i>
									</span>
								</file-uploader>
								<i class="btn btn-xs btn-danger"
									@click="deleteAvatar(store.user.avatar_id)"
									v-if="store.user.avatar_id">
									<i class="fa fa-trash-o btn-danger"></i>
								</i>
							</center>
						@endcan
						<h3 class="profile-username text-center"> {{ $user->full_name }} </h3>

						<p class="text-muted text-center"> {{ $user->role->display_name }} </p>

						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b> {{ __("Member Since") }} </b> <a class="pull-right"> {{ $user->created_at }} </a>
							</li>
							<li class="list-group-item">
								<b> {{ __("Logins") }} </b> <a class="pull-right">  {{ $user->logins->count() }}  </a>
							</li>
							<li class="list-group-item">
								<b> {{ __("Actions") }} </b> <a class="pull-right"> {{ $user->action_logs->count() }} </a>
							</li>
						</ul>
					</div>
				</div>

				@can('updateProfile', $user)
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"> {{ __("Personal Info") }} </h3>
						</div>
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
					</div>
				@endcan
			</div>

			<div class="col-md-7">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"> {{ __("Route access history") }} </h3>
					</div>
					<div class="box-body">
						<ul class="timeline timeline-inverse">
							@foreach($timeline as $event)
							<li class="time-label">
								<span class="bg-red">
									{{ $event->created_at }}
								</span>
							</li>
							<li>
								<i class="fa fa-user bg-aqua"></i>
								<div class="timeline-item">
									<span class="time"><i class="fa fa-clock-o"></i> {{ $event->created_at }} </span>
									<h3 class="timeline-header no-border">
										{{ $event->permission->description }}
									</h3>
								</div>
							</li>
							@endforeach
						</ul>
						{{ $timeline->links() }}
					</div>
				</div>
			</div>
		</div>
</section>

@endsection

@push('scripts')

	<script>
		const vm = new Vue({
		    el: '#app',

		    computed: {
		    	avatarLink() {

		    	    if(this.store.user.id != this.profileUserId) {
		    	        return '/core/avatars/' + this.profileAvatarId;
					}

		    		return '/core/avatars/' + (this.store.user.avatar_id || 'null');
		    	},
		    },

		    data: {
		    	store: Store,
				profileAvatarId: '{{$user->avatar_id}}' || 'null',
				profileUserId: '{{$user->id}}'
		    },

		    methods: {
		        deleteAvatar(id) {
		            axios.delete('/core/avatars/' + id).then(response => {
		                this.store.user.avatar_id = null;
		            }).catch(error => {
		            	this.reportEnsoException(error);
		            });
		        }
		    }
		});
	</script>

@endpush