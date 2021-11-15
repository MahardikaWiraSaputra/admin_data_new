<!-- Sidebar Starts -->
<?php 
	
	//getting user data
	$user = $this->ion_auth->user()->row(); 

	//getting all user perssions
	$users_permissions = group_priviliges();

	$new_arr = array();

	foreach ($users_permissions as $key => $value) 
	{
		$new_arr[$value] = $value;
	}

?>

<div id="wrapper">
    <div id="layout-static">
        <div class="static-sidebar-wrapper sidebar-default">
            <div class="static-sidebar">
                <div class="sidebar">
					<div class="widget">
				        <div class="widget-body">
				            <div class="userinfo">
				                <div class="avatar">
				                	<?php 
				                		if (empty($user->user_img)) 
				                		{
				                			
				                	?>
				                		<img src="<?php bs() ?>public/assets/img/default_user.png" class="img-responsive img-circle" width="200" alt="">
				                	<?php	
				                		} 
				                		else {
				                	?>
				                    	<img src="<?php bs() ?>uploads/<?php echo $user->user_img ?>" class="img-responsive img-circle" width="200" alt="">
				                	<?php		
				                		}
				                		

				                	 ?>
				                </div>
				                <div class="info">
				                    <span class="username">
				                        <?php
								            echo $user->first_name.' '.$user->last_name;
								        ?>
					     	        </span>
				                    <span class="useremail">
				                        <?php
								            echo $user->email;
								        ?>
								    </span>
				                </div>
				            </div>
				        </div>
    				</div>
					<div class="widget stay-on-collapse" id="widget-sidebar">
				        <nav role="navigation" class="widget-body">
					<ul class="acc-menu">
						<li class="nav-separator"><span>Explore</span></li>
						<li>
							<a href="<?= base_url('users/Auth') ?>">
								<i class="ti ti-home"></i><span>Dashboard</span><span class="badge badge-teal">2</span>
							</a>
						</li>
							
						<li><a href="javascript:;"><i class="ti ti-user"></i><span>Users</span></a>
							<ul class="acc-menu">
							
								<?php if (in_array('View Users',$new_arr)): ?>
									
									<li>
										<a href="<?= base_url('users') ?>">
											<i class="ti ti-angle-right"></i> View Users
										</a>
									</li>

								<?php endif ?>
							
								<?php if (in_array('Add Users',$new_arr)): ?>

									<li>
									  	<a href="<?= base_url('users/create_user') ?>">
									  		<i class="ti ti-angle-right"></i> Add Users
									  	</a>
									</li>

								<?php endif ?>
									
							</ul>
						</li>
						<li><a href="javascript:;"><i class="fa fa-users"></i><span>Groups & Permissions</span></a>
							<ul class="acc-menu">
								<li>
									<a href="<?= base_url('users/User_groups') ?>">
										<i class="ti ti-angle-right"></i> View Groups
									</a>
								</li>
							
								<?php if (in_array('Create Groups',$new_arr)): ?>
									
									<li>
										<a href="<?= base_url('users/User_groups/create_group') ?>">
											<i class="ti ti-angle-right"></i> Create Groups
										</a>
									</li>

								<?php endif ?>
							

								<?php if (in_array('Permissions',$new_arr)): ?>		

									<li>
										<a href="<?= base_url('users/User_groups/permissions') ?>">
											<i class="ti ti-angle-right"></i> Permissions
										</a>
									</li>

								<?php endif ?>
							
							</ul>
						</li>

						<?php if (in_array('email members',$new_arr)): ?>	

						<li>
							<a href="<?php bs() ?>users/email/email_members">
								<i class="fa fa-envelope-o" aria-hidden="true"></i>
									<span>Email Members</span>
							</a>
						</li>

						<?php endif ?>

						<?php if (in_array('blog', $new_arr)): ?>
							
						<li>
							<a href="javascript:;">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									<span>Blog</span>
							</a>

							<ul class="acc-menu">
								<li>
									<a href="<?= base_url('blog/posts') ?>">
										<i class="ti ti-angle-right"></i> Add New Post
									</a>
								</li>
							
								<li>
									<a href="<?= base_url('blog/posts/manage_posts') ?>">
										<i class="ti ti-angle-right"></i> Manage Posts
									</a>
								</li>

								<li>
									<a href="<?= base_url('blog/posts/trashed_posts') ?>">
										<i class="ti ti-angle-right"></i> Trashed Posts
									</a>
								</li>

								<li>
									<a href="<?= base_url('blog/BlogSettings') ?>">
										<i class="ti ti-angle-right"></i> Blog Settings
									</a>
								</li>

								<li>
									<a href="<?= base_url('blog/Tags') ?>">
										<i class="ti ti-angle-right"></i> Add Tags
									</a>
								</li>
								
								<li>
									<a href="<?= base_url('blog/BlogCategory') ?>">
										<i class="ti ti-angle-right"></i> Add Categories 
									</a>
								</li>
							</ul>
						</li>

						<?php endif ?>
						

		                <?php if (in_array('Profile',$new_arr)): ?>

		                    <li>
		                        <a href="<?= base_url('users/Profile') ?>">
		                            <i class="fa fa-list"></i><span>Profile</span>
		                        </a>
		                    </li>

		                <?php endif ?>    


						<?php if (in_array('Setup',$new_arr)): ?>	
							<li>
								<a href="javascript:;"><i class="ti ti-settings"></i><span>Setup</span></a>
								<ul class="acc-menu">
									<li>
										<a href="<?= base_url('site_config') ?>">
											<i class="ti ti-angle-right"></i><span>General</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url('site_config/Login_setup') ?>">
											<i class="ti ti-angle-right"></i><span>Login</span>
										</a>
									</li>	
								</ul>
							</li>
						<?php endif ?>

						
						<?php if (in_array('Social Login Setup',$new_arr)): ?>		

						<li>
							<a href="javascript:;"><i class="fa fa-wrench"></i><span>Social Login</span></a>
							<ul class="acc-menu">
								<li>
									<a href="<?= base_url('site_config/fb_config') ?>">
										<i class="ti ti-facebook"></i> Facebook Config
									</a>
								</li>
								<li>
									<a href="<?= base_url('site_config/twitter_config') ?>">
										<i class="ti  ti-twitter"></i> Twitter Config
									</a>
								</li>
								<li>
									<a href="<?= base_url('site_config/google_config') ?>">
										<i class="ti  ti-google"></i> Google Config
									</a>
								</li>
								<li>
									<a href="<?= base_url('site_config/insta_config') ?>">
										<i class="ti ti-instagram"></i> Instagram Config
									</a>
								</li>
								<li>
									<a href="<?= base_url('site_config/linkedin_config') ?>">
										<i class="ti ti-linkedin"></i> Linkedin Config
									</a>
								</li>	

							</ul>
						</li>

						<?php endif ?>

						<?php if (in_array('Backup & Export Users',$new_arr)): ?>	
								
							<li>
								<a href="<?= base_url('site_config/backup') ?>">
									<i class="ti ti-server"></i><span>Backup & Export Users</span>
								</a>
							</li>

						<?php endif ?>
							

						<li class="nav-separator"><span>Extras</span></li>
							
						<li>
							<a href="<?= base_url('blog/BlogFrontend') ?>" target="_blank">
								<i class="fa fa-address-card-o"></i><span>Visit Blog</span>
							</a>
						</li>	
							

						<li>
							<a href="<?= base_url('blog/BlogFrontend/home') ?>" target="_blank">
								<i class="fa fa-television"></i><span>Front End</span>
							</a>
						</li>	
						
						<li>
							<a href="<?= base_url('extras/dashboard') ?>" target="">
								<i class="ti ti-home"></i><span>Dashboard</span>
							</a>
						</li>
						<li><a href="javascript:;"><i class="ti ti-layout"></i><span>Layout</span></a>
							<ul class="acc-menu">
								<li><a href="<?php bs('extras/layout_grids') ?>">Grid Scaffolding</a></li>
								<li><a href="<?php bs('extras/layout_static_leftbar') ?>">Static Sidebar</a></li>
								<!-- <li><a href="<?php bs('extras/layout_sidebar_scroll') ?>">Scroll Sidebar</a></li> -->
								<!-- <li><a href="<?php bs('extras/layout_horizontal') ?>">Horizontal Nav</a></li> -->
								<li><a href="<?php bs('extras/layout_boxed') ?>">Boxed</a></li>	
							</ul>
						</li>
						<li><a href="javascript:;"><i class="ti ti-pencil"></i><span>Forms</span></a>
							<ul class="acc-menu">
								<li><a href="<?php bs('extras/ui_forms') ?>">Form Layout</a></li>
								<li><a href="<?php bs('extras/form_components') ?>">Form Components</a></li>
								<li><a href="<?php bs('extras/form_pickers') ?>">Pickers</a></li>
								<li><a href="<?php bs('extras/form_wizard') ?>">Form Wizard</a></li>
								<li><a href="<?php bs('extras/form_validation') ?>">Form Validation</a></li>
								<li><a href="<?php bs('extras/form_masks') ?>">Form Masks</a></li>
								<li><a href="<?php bs('extras/form_dropzone') ?>">Dropzone Uploader</a></li>
								<li><a href="<?php bs('extras/form_summernote') ?>">Summernote</a></li>
								<li><a href="<?php bs('extras/form_markdown') ?>">Markdown Editor</a></li>
								<li><a href="<?php bs('extras/form_xeditable') ?>">Inline Editor</a></li>
								<li><a href="<?php bs('extras/form_gridforms') ?>">Grid Forms</a></li>
							</ul>
						</li>
						<li>
							<a href="<?php bs('extras/buttons') ?>"><i class="fa fa-plus-circle"></i>
								<span>buttons</span></a>
						</li>
						<li>
							<a href="<?php bs('extras/app_inbox') ?>">
								<i class="ti ti-email"></i>
									<span>Inbox</span>
										<span class="badge badge-danger">3</span>
							</a>
						</li>
					</ul>
				</nav>
				    </div>


				</div>
            </div>
        </div>

<!-- Sidebar Ends -->


		