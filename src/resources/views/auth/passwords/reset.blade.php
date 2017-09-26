@extends('laravel-enso/core::layouts.auth')

@section('content')

    <div class="column box login">
        <h3 class="title is-3 has-text-black has-text-centered has-margin-bottom-medium">
        	<figure class="image is-24x24 logo">
			  	<img src="/images/logo.svg"/>
			</figure>
          	{{ config('app.name') }}
        </h3>
        <form class="has-margin-bottom-medium"
        	@submit.prevent="submit()">
        	<input type="hidden" name="token" value="token">
	        <div class="field">
	            <div class="control has-icons-left has-icons-right">
	                <input class="input"
	                	:class="{ 'is-danger': hasErrors, 'is-success': isSuccessful }"
	                	type="email"
	                	placeholder="Email"
	                	v-model="email">
	                <span class="icon is-small is-left">
	                    <i class="fa fa-envelope"></i>
	                </span>
	                <span class="icon is-small is-right has-text-success"
	                	v-if="isSuccessful">
				      	<i class="fa fa-check"></i>
				    </span>
				    <span class="icon is-small is-right has-text-error"
	                	v-if="hasErrors">
				      	<i class="fa fa-warning has-text-danger"></i>
				    </span>
	            </div>
	        </div>
	        <div class="field">
	            <div class="control has-icons-left has-icons-right">
	                <input class="input"
	                	:class="{ 'is-danger': hasErrors, 'is-success': isSuccessful }"
	                	type="password"
	                	placeholder="Password"
	                	v-model="password">
	                <span class="icon is-small is-left">
	                    <i class="fa fa-lock"></i>
	                </span>
	                <span class="icon is-small is-right has-text-success"
	                	v-if="isSuccessful">
				      	<i class="fa fa-check"></i>
				    </span>
				    <span class="icon is-small is-right"
	                	v-if="hasErrors">
				      	<i class="fa fa-warning has-text-danger"></i>
				    </span>
	            </div>
	        </div>
	        <div class="field">
	            <div class="control has-icons-left has-icons-right">
	                <input class="input"
	                	:class="{ 'is-danger': hasErrors, 'is-success': isSuccessful }"
	                	type="password"
	                	placeholder="Repeat Password"
	                	v-model="passwordConfirmation">
	                <span class="icon is-small is-left">
	                    <i class="fa fa-lock"></i>
	                </span>
	                <span class="icon is-small is-right has-text-success"
	                	v-if="isSuccessful">
				      	<i class="fa fa-check"></i>
				    </span>
				    <span class="icon is-small is-right"
	                	v-if="hasErrors">
				      	<i class="fa fa-warning has-text-danger"></i>
				    </span>
	            </div>
	        </div>
	        <div class="field">
	            <button class="button is-primary is-fullwidth"
	            	:class="{ 'is-loading': loading }"
	            	type="submit"
	            	@click.prevent="submit()">
	            	<span class="icon is-small">
	                  	<i class="fa fa-lock"></i>
	              	</span>
	              	<span>Login</span>
	            </button>
	        </div>
	    </form>
    </div>

@endsection

@push('scripts')

	<script>

		toastr.options.positionClass = "toast-top-center";

		const vm = new Vue({
		    el: '#app',

		    data: {
		    	loading: false,
		    	email: null,
		    	password: null,
		    	passwordConfirmation: null,
		    	token: '{{ $token }}',
		    	hasErrors: null,
		    	isSuccessful: false,
		    },

		    watch: {
		    	email: {
		    		handler() {
		    			this.hasErrors = false;
		    		}
		    	},
		    	password: {
		    		handler() {
		    			this.hasErrors = false;
		    		}
		    	},
		    	passwordConfirmation: {
		    		handler() {
		    			this.hasErrors = false;
		    		}
		    	}
		    },

		    methods: {
		    	submit() {
		    		this.loading = true;

		    		let params = {
		    			email: this.email,
		    			password: this.password,
		    			password_confirmation: this.passwordConfirmation,
		    			token: this.token
		    		};

		    		axios.post('/password/reset', params).then(response => {
		    			this.loading = false;
		    			this.isSuccessful = true;
		    			toastr.success(response.data.status);
		    			setTimeout(() => window.location.href = '/', 500);
		    		}).catch(error => {
		    			this.loading = false;
		    			this.hasErrors = true;

		    			if (error.response.status === 422) {
		    				if (error.response.data.token) {
		    					toastr.error(error.response.data.token[0]);
		    				}

		    				for (field in error.response.data) {
		    					toastr.error(error.response.data[field][0]);
		    				}

		    				return true;
		    			}

		    			this.handleError(error);
		    		});
		    	}
		    }
		});

	</script>

@endpush