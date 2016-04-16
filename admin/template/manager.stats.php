<div class="row">
<div class="input-group daterange" data-start-date="<?php echo $StatsRange->start; ?>" data-end-date="<?php echo $StatsRange->end; ?>">
	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	<input type="text" class="form-control start readonly" name="start" value="<?php echo $StatsRange->start_value; ?>" readonly>
	<span class="input-group-addon">до</span>
	<input type="text" class="form-control end readonly" name="end" value="<?php echo $StatsRange->end; ?>" readonly>
</div>
</div>
<div id="graph"></div>
<script src="js/bootstrap-datetimepicker-range.min.js"></script>
<script src="js/manager.stats.init.js"></script>