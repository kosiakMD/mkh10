<ul>
	<li><a href="manager/content"><i class="fa fa-file fa-2x"></i></a></li>
	<li><a href="manager/categories"><i class="fa fa-list-alt fa-2x"></i></a></li>
	<li><a href="manager/navigation"><i class="fa fa-compass fa-2x"></i></a></li>
	<li><a href="manager/events"><i class="fa fa-calendar fa-2x"></i></a></li>
	<li><a href="manager/files"><i class="fa fa-hdd-o fa-2x"></i></a></li>
	<li><a href="manager/upload"><i class="fa fa-download fa-2x"></i></a></li>
	<li><a href="manager/backup/db"><i class="fa fa-database fa-2x"></i></a></li>
	<li><a href="manager/backup/files"><i class="fa fa-file-archive-o fa-2x"></i></a></li>
	<li><a href="manager/stats"><i class="fa fa-area-chart fa-2x"></i></a></li>
	<?php if($ssID->privileges == 4): ?>
	<li><a href="manager/system"><i class="fa fa-gears fa-2x"></i></a></li>
	<li><a href="manager/users"<i class="fa fa-users fa-2x"></i></a></li>
	<li><a href="manager/logs"><i class="fa fa-clock-o fa-2x"></i></a></li>
	<?php endif; ?>
  </ul>