<template>
	<aside id="sidebar" class="control-sidebar" :class="'control-sidebar-' + sidebarTheme">
	  	<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
	    	<!-- <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li> -->
	    	<li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
	  	</ul>
	  	<div class="tab-content">
    	<div class="tab-pane active" id="control-sidebar-settings-tab">
	    		<label class="control-sidebar-subheading">
    				<slot name="general-settings"></slot>
	    		<button class="btn btn-xs btn-warning pull-right" @click="resetToDefault"><slot name="reset"></slot></button>
	    		</label>
	      		<hr>
	      		<form method="post">
	        		<div class="form-group">
	          			<label class="control-sidebar-subheading">
	          				<slot name="language"></slot>
	            			<li class="dropdown pull-right" style="list-style-type: none;">
	              				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					                <i class="flag-icon" :class="language.flag"></i>
					            </a>
					            <ul class="dropdown-menu language-selector">
					                <li v-for="language in languages">
					                  	<a @click="setLanguage(language.name)">
					                    	<i class="flag-icon" :class="language.flag">
					                    	</i>
					                  	</a>
					                </li>
					            </ul>
					        </li>
					    </label>
					</div>
			    </form>
				<hr>
		      	<label class="control-sidebar-subheading">
		      		<slot name="start-tutorial"></slot>
		        	<i class="pull-right fa fa-question"
						style="cursor: pointer;"
						@click="startTutorial">
					</i>
	      		</label>
	      		<hr>
		      	<label class="control-sidebar-subheading">
		      		<slot name="state-save"></slot>
		      		<span class="pull-right">
		          		<input id="dt-state-save"
			                type="checkbox"
			                class="toggle"
			                v-model="globalPreferences.dtStateSave"
			                @change="setPreference()">
		        		<label for="dt-state-save"><i></i></label>
	        		</span>
		      	</label>
		      	<hr>
	<!--
				<label class="control-sidebar-subheading">
	        		<slot name="fixed"></div>
	        		<div class="mk-trc pull-right" data-color="black" data-text="true" data-align="right">
		          		<input id="header-fixed"
			                type="checkbox"
			                v-model="globalPreferences.headerFixed"
			                @change="setPreference">
		          		<label for="header-fixed"><i></i></label>
	        		</div>
	      		</label>
	      		<hr>
	-->
	      		<div class="hidden-xs">
	        		<label class="control-sidebar-subheading">
				        <slot name="collapse"></slot>
				        <span class="pull-right">
				            <input id="sidebar-collapse"
				                  type="checkbox"
				                  class="toggle"
				                  v-model="globalPreferences.collapsedSidebar"
				                  @change="setPreference()">
				            <label for="sidebar-collapse"><i></i></label>
			            </span>
				    </label>
				    <hr>
				</div>
		      	<label class="control-sidebar-subheading">
		      		<slot name="color-theme"></slot>
		        	<li class="dropdown pull-right" style="list-style-type: none;">
		          		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		            		{{ globalPreferences.theme }}
		          		</a>
		          		<ul class="dropdown-menu color-theme-selector">
		            		<li v-for="theme in themeList">
				              	<a @click="setTheme(theme)">
				                	{{ theme }}
	              				</a>
	            			</li>
	          			</ul>
	        		</li>
	      		</label>
	      		<hr>
	    	</div>
	  	</div>
	</aside>
</template>

<script>

	export default {

		props: {
			currentRoute: {
				type: String,
				required: true
			},
			themes: {
				type: String,
				required: true
			},
			langs: {
				type: String,
				required: true
			},
		},
		data: function() {
			return {
			    themeList: JSON.parse(this.themes),
			    languages: JSON.parse(this.langs),
			    globalPreferences: Preferences
			}
		},
		computed: {
	        bodyClass:function() {
	            let result = 'sidebar-mini skin-';
	            result += this.globalPreferences.theme;
	            result += this.globalPreferences.headerFixed ? ' fixed' : '';
	            result += this.globalPreferences.collapsedSidebar ? ' sidebar-collapse' : '';

	            return result;
	        },
	        language: function() {
	        	let lang = this.globalPreferences.lang
	        	return this.languages.find(function(language) {
	        		return language.name == lang;
	        	});
	        },
	        sidebarTheme: function() {
	        	return this.globalPreferences.theme.indexOf('light') != -1 ? 'light' : 'dark';
	        }
		},
		methods: {
			getTutorial: function(route, state) {
				axios.get('/system/tutorials/getTutorial/' + route).then((response) => {
			        let tour = new Tour({
			            backdrop: true,
			            template: " \
			            	<div class='popover tour'> \
								<div class='arrow'> \
								</div> \
								<p class='popover-title'> \
								</p> \
								<div class='popover-content'> \
								</div> \
								<nav class='popover-navigation'> \
									<div class='btn-group'> \
										<button class='btn' \
											data-role='prev'> \
											<i class='fa fa fa-step-backward'> \
											</i> \
										</button> \
										<button class='btn' \
											data-role='next'> \
											<i class='fa fa-step-forward'> \
											</i> \
										</button> \
									</div> \
									<button class='btn margin-left-xs' \
										data-role='end'> \
										<i class='fa fa-stop'> \
										</i> \
									</button> \
								</nav> \
							</div>",
			        });

			        tour.addSteps(response.data);

			        if (state) {
			            tour.init();
			            tour.start();
			        } else {
			            tour.restart();
			        }
			    });
			},
		    setLanguage: function(lang) {
		    	this.globalPreferences.lang = lang;
				this.setPreference(true);
		    },
		    setTheme: function(theme) {
		    	$('body').removeClass('skin-' + this.globalPreferences.theme).addClass('skin-' + theme);
				this.globalPreferences.theme = theme;
				this.setPreference();
		    },
		    setBodyClass:function() {
		        $('body').removeClass();
		        $('body').addClass(this.bodyClass);
		    },
		    checkTutorialState: function() {
		    	if (document.cookie.indexOf("tour_end") == -1) {
					this.getTutorial(this.currentRoute, true);
			    }
		    },
		    startTutorial: function() {
				$('#sidebar').removeClass('control-sidebar-open');
				this.getTutorial(this.currentRoute, false);
		    },
		    setPreference: function(reload = false) {

		        this.setBodyClass();

		        axios.patch('/core/preferences/setPreferences', {key: 'global', value: JSON.stringify(this.globalPreferences)}).then((response) => {
		        	if (reload) {
		        		window.location.reload();
		        	}
		        });
		    },
		    resetToDefault: function() {
		    	axios.post('/core/preferences/resetToDefaut', { key: 'global' }).then((response) => {
		    		window.location.reload();
	    		});
		    }
		},
		mounted: function() {
			initBootstrapSelect('select.select', '100%', true, $.fn.selectpicker.defaults.noneSelectedText);
		    this.checkTutorialState();
		}
	 }

</script>