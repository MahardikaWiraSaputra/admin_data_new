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




<div class="widget stay-on-collapse" id="widget-sidebar">
	<nav role="navigation" class="widget-body">
	<ul class="acc-menu">

		<li class="nav-separator"><span>MENU</span></li>
		<li>
			<a href="<?= base_url('main') ?>">
			<i class="ti ti-home"></i><span>Dashboard</span>
			<!-- <span class="badge badge-teal">2</span> -->
			</a>
		</li>

		<div id="sidemenus"></div>

		<?php if (in_array('Register Surat',$new_arr)): ?>
		<li>
			<a href="<?php bs() ?>office/register_surat">
			<i class="fa fa-envelope-o" aria-hidden="true"></i>
			<span>Register Surat</span>
			</a>
		</li>
		<?php endif ?>

	</ul>
	</nav>
</div>


							</div><!-- /sidebar -->
            </div>
        </div>

<!-- Sidebar Ends -->
