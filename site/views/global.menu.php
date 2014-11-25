		<ul class="nav">
			<?php $user = User::getCurrentUser(); ?>
			<?php if($user != null): ?>
			<li class="right"><?php echo $user->display_name; ?> | <a href="<?php echo uri('/users/logout'); ?>">Logout</a></li>
			<?php endif; ?>
			<li><a href="<?php echo uri('/jobs/dashboard'); ?>">Dashboard</a></li>
			<li><a href="<?php echo uri('jobs/view'); ?>">Jobs</a></li>
			<?php if($user != null && $user->user_level == 10): ?>
			<li><a href="<?php echo uri('/users/view'); ?>">Users</a></li>
			<?php endif; ?>
		</ul>
