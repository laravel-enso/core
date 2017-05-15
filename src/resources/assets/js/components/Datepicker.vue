<template>
	<div class="input-group date-picker">
		<i class="fa fa-times clear-button btn-box-tool"
			@click="clearDate"
			v-if="showClearButton">
		</i>
		<input type="text"
			v-update-date-picker
			:id="'date-input-' + _uid"
			class="form-control"
			:name="name"
			:value="value"
			:disabled="disabled">
		<span class="input-group-addon">
			<i class="fa fa-calendar">
			</i>
		</span>
	</div>
</template>

<script>

	export default {

		props: {

			name: {
                type: String,
                default: null
            },
			value: {
				type: String,
				default: ''
			},
			width: {
	            type: String,
	            default: '100%'
        	},
        	clearButton: {
        		type: Boolean,
        		default: false
        	},
			disabled: {
				type: Boolean,
				default: false
			}
		},
		computed: {

			showClearButton: function() {

				return this.clearButton && this.value && !this.disabled;
			}
		},
		directives: {

			updateDatePicker: {
				/* the directive is necessary to update the timepicker library
				* when the model is changed from the parent */
				update: function (el) {

			    	$(el).datepicker('update');
                    this.$emit('input',null);
                }
			}
		},
		methods: {

			clearDate: function() {

				$("#date-input-" + this._uid).datepicker('clearDates');
			},
			/* method is required so we can emit the event with the
			* proper input event value as opposed to an inline call */
			emitInputEvent: function (event) {

		      this.$emit('input', event.target.value)
		    }
		},
		mounted: function() {

			let self = this;
		    $("#date-input-" + this._uid).datepicker({
		        format: "dd-mm-yyyy",
		        language: Preferences.lang,
		        todayHighlight: true,
		        autoclose: true
		    }).on('hide', function(date) {
		    	self.$emit('input', date.format('dd-mm-yyyy'));
		    });
		}
	}

</script>

<style>

    .date-picker > i.clear-button {
      position: absolute;
      cursor: pointer;
      top: calc(50% - 12px);
      left: 2px;
      outline: none;
      z-index: 3;
      display: block;
    }

    .date-picker > i.clear-button:focus {
      opacity: .1;
    }

    .date-picker > input {
    	text-align: right;
    }

</style>