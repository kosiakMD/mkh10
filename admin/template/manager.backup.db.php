<div class="row">
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> Дамп бази даних успішно створено!</div>
  <div id="DumpCode">
	<pre class="brush: sql">
	<?php echo $DumpData; ?>
	</pre>
  </div>  
</div>
<hr>
<div class="row text-right">
  <a href="manager/backup/db/get" class="btn btn-success" target="_blank"><i class="fa fa-upload"></i> Скачати копію БД</a>
</div>