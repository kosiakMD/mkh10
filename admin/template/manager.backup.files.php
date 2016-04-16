<div class="row">
<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped">
<thead>
<tr>
  <th width="20"><input type="checkbox" class="to-labelauty-icon" id="SelectAll"></th>
  <th width="20"></th>
  <th id="left">Назва файлу</th>
  <th width="180">Дата створення</th>
  <th width="80">Операції</th>
</tr>
</thead>
<tbody>
<?php echo $TableData; ?>
</tbody>
</table>
</div>
<hr>
<div class="row text-right">
  <button type="button" id="CreateBackup" class="btn btn-success"><i class="fa fa-floppy-o"></i> Створити резервну копію</button>
  <button type="button" class="btn btn-default confirmation pull-left" data-toggle="popover" data-popover-href="manager/files/delete/" data-popover-content="Ви впевнені, що хочете видалити всі відмічені файли?" data-placement="top" title="Видалення файлів"><i class="fa fa-trash"></i> Видалити відмічені</button>
</div>