<div class="row">
<?php if(in_array($RouteID, array(11, 19))): ?>
<ol class="breadcrumb">
  <li><a href="manager/<?php echo (($RouteID === 19) ? 'upload' : 'files'); ?>"><?php echo $ROOT; ?></a></li>
  <?php echo $PathBreadCrums; ?>
</ol>
<?php endif; ?>
<div id="tablewrapper" class="col-md-12">
	<div id="tableheader">
		<div class="search-form">
		   <select id="columns" class="form-control" onchange="sorter.search('query')"></select>
		   <div class="input-group searchbox">	
			<input type="text" class="form-control" id="query" onkeyup="sorter.search('query')" placeholder="Введіть запит...">
			<span class="input-group-addon"><i class="fa fa-search"></i></span>
		   </div>   
		</div>
		<div class="details">
			<div><button class="btn btn-default disabled"><i class="fa fa-list-alt"></i> Записи <span id="startrecord"></span>-<span id="endrecord"></span> з <span id="totalrecords"></span></button></div>
			<div><button class="btn btn-default" onclick="sorter.reset()" data-placement="top" title="Не сортувати"><i class="fa fa-remove"></i> Відміна</button></div>
		</div>
	</div>
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="table table-condensed table-hover table-striped">
		<thead>
		<tr>
			<?php if($RouteID === 9): ?>
			<th width="20" class="nosort"><h3><input type="checkbox" class="to-labelauty-icon" id="SelectAll"></h3></th>
			<th width="30" class="nosort"><h3> </h3></th>
			<th width="20" class="nosort"><h3></h3></th>
			<th width="50" class="nosort"><h3>ID</h3></th>
			<th><h3>Назва</h3></th>
			<th width="40"><h3>Розмір</h3></th>
			<th width="100"><h3>Автор</h3></th>
			<th width="100"><h3>Перегл.</h3></th>
			<th width="100"><h3>Категорія</h3></th>
			<th width="50"><h3>Поз.</h3></th>
			<th width="80"><h3>Створено</h3></th>
			<th width="160"><h3>Змінено</h3></th>
			<th width="180" class="nosort"><h3>Дії</h3></th>
			<?php endif; ?>
			<?php if(in_array($RouteID, array(11, 19))): ?>
			<?php if($RouteID === 11): ?>
			<th width="20" class="nosort"><h3><input type="checkbox" class="to-labelauty-icon" id="SelectAll"></h3></th>
			<?php endif; ?>
			<th width="20" class="nosort"><h3></h3></th>
			<th id="left"><h3>Ім'я файлу</th>
			<th width="130"><h3>Тип файлу</h3></th>
			<th width="150"><h3>Розмір файлу</h3></th>
			<th width="150"><h3>Права доступу</h3></th>
			<th width="100"><h3>Дата</h3></th>
			<th width="100"><h3>Час</h3></th>
			<?php if($RouteID === 11): ?>
			<th width="175" class="nosort"><h3>Операції</h3></th>
			<?php endif; ?>
			<?php endif; ?>
			<?php if($RouteID === 18): ?>
			<th width="20" class="nosort"><h3></h3></th>
			<th width="20"><h3>ID</h3></th>
			<th id="left"><h3>Ім'я користувача</th>
			<th width="185"><h3>Остання активність</h3></th>
			<th width="120"><h3>IP-адреса</h3></th>
			<th width="120" class="nosort"><h3>Операції</h3></th>
			<?php endif; ?>
			<?php if($RouteID === 22): ?>
			<th width="20" class="nosort"><h3><input type="checkbox" class="to-labelauty-icon" id="SelectAll"></h3></th>
			<th width="20" class="nosort"><h3></h3></th>
			<th width="20"><h3>ID</h3></th>
			<th id="left"><h3>Назва</th>
			<th width="185"><h3>Автор</h3></th>
			<th width="120"><h3>Сторінки</h3></th>
			<th width="80"><h3>Створено</h3></th>
			<th width="160"><h3>Змінено</h3></th>
			<th width="120" class="nosort"><h3>Операції</h3></th>
			<?php endif; ?>
			<?php if($RouteID === 26): ?>
			<th width="30" class="nosort"><h3> </h3></th>
			<th width="20" class="nosort"><h3></h3></th>
			<th width="20"><h3>ID</h3></th>
			<th id="left" width="180"><h3>Підпис</th>
			<th width="60"><h3>Тип</h3></th>
			<th width="80"><h3>Позиція</h3></th>
			<th width="150"><h3>Значення</h3></th>
			<th width="160"><h3>Дата зміни</h3></th>
			<th width="120" class="nosort"><h3>Операції</h3></th>
			<?php endif; ?>
			<?php if($RouteID === 29): ?>
			<th width="20" class="nosort"><h3></h3></th>
			<th width="20"><h3>ID</h3></th>
			<th id="left"><h3>Дія</th>
			<th width="120"><h3>Користувач</h3></th>
			<th width="160"><h3>Дата</h3></th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php if(isset($TableData)){ echo $TableData; } ?>
		</tbody>
	</table>
	<div id="tablefooter">
	  <div id="tablenav">
		<div>
			<div class="btn-group">
				<button class="btn btn-default" onclick="sorter.move(-1,true)"><i class="fa fa-fast-backward"></i></button>
				<button class="btn btn-default" onclick="sorter.move(-1)"><i class="fa fa-backward"></i></button>
				<button class="btn btn-default"><div class="page">Сторінка <span id="currentpage"></span> з <span id="totalpages"></span></div></button>
				<button class="btn btn-default" onclick="sorter.move(1)"><i class="fa fa-forward"></i></button>
				<button class="btn btn-default" onclick="sorter.move(1,true)"><i class="fa fa-fast-forward"></i></button>
			</div>
			</div>
			<div>
				<select id="pagedropdown" class="form-control"></select>
			</div>
			<div>
				<button class="btn btn-default" onclick="sorter.showall()"><i class="fa fa-eye"></i> показати всі</button>
			</div>
		</div>
		<div id="tablelocation">
			<div>
				<div class="input-group searchbox">	
				<span class="input-group-addon"><i class="fa fa-file"></i> Записів на сторінку</span>
				<select class="form-control" onchange="sorter.size(this.value)">
					<option value="5">5</option>
					<option value="10" selected="selected">10</option>
					<option value="20">20</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			   </div>
			</div>
		</div>
	</div>
  </div>
</div>
<hr class="hidden-print">