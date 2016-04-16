<form name="chmod" action="manager/files/perms/set" method="post">
<input type="hidden" name="InputFileName" value="<?php echo $FileName; ?>">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Права доступу</h4>
</div>
<div class="modal-body">
<div class="form-message hidden alert"><span class="fa"></span> <span class="text"></span></div>
<center>
<div class="form-inline">
<div class="form-group pull-left">
<div class="input-group">
<span class="input-group-addon">CHMOD</span>
<input type="text" name="t_total" class="form-control required" style="width:50px;" value="<?php echo Kernel::FileChmod($FileName); ?>" data-minlength="3" maxlength="3" onKeyUp="octalchange()">
<span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span>
</div>
</div>
<div class="form-group pull-left">
<input type="text" name="sym_total" class="form-control" value="" style="width:100px;margin-left:15px;" readonly> 
</div>
</div>
<BR><BR>
<table class="table borderless" id="ChmodTable" cellpadding="2" cellspacing="0">
<tr>
<th WIDTH="100" class="titletab4">&nbsp;</td>
<th WIDTH="100" align="center" class="titletab4"><i class="fa fa-user"></i> Власник<div><?php echo ((function_exists('posix_getpwuid')) ? '('.Kernel::array_get_value(@posix_getpwuid($FileStat['uid']), 'name').')' : ''); ?></div></td>
<th WIDTH="100" align="center" class="titletab4"><i class="fa fa-briefcase"></i> Група<div><?php echo ((function_exists('posix_getgrgid')) ? '('.Kernel::array_get_value(@posix_getgrgid($FileStat['gid']),'name').')' : ''); ?></div></td>
<th WIDTH="100" align="center" class="titletab4"><i class="fa fa-asterisk"></i> Інші</td>
</tr>
<tr>
<td WIDTH="60" nowrap class="avantgo"><i class="fa fa-book"></i> Читання</td>
<td WIDTH="55" align="center" class="avant">
<input type="checkbox" name="owner4" value="4" onclick="calc_chmod()">
</td>
<td WIDTH="55" align="center" class="avantgo"><input type="checkbox" name="group4" value="4" onclick="calc_chmod()">
</td>
<td WIDTH="55" align="center" class="avant">
<input type="checkbox" name="other4" value="4" onclick="calc_chmod()">
</td>
</tr>
<tr>		
<td WIDTH="60" nowrap class="avantgo"><i class="fa fa-pencil"></i> Запис</td>
<td WIDTH="55" align="center" class="avant">
<input type="checkbox" name="owner2" value="2" onclick="calc_chmod()"></td>
<td WIDTH="55" align="center" class="avantgo"><input type="checkbox" name="group2" value="2" onclick="calc_chmod()">
</td>
<td WIDTH="55" align="center" class="avant">
<input type="checkbox" name="other2" value="2" onclick="calc_chmod()">
</td>
</tr>
<tr>		
<td WIDTH="60" nowrap class="avantgo"><i class="fa fa-bolt"></i> Виконання</td>
<td WIDTH="55" align="center" class="avant">
<input type="checkbox" name="owner1" value="1" onclick="calc_chmod()">
</td>
<td WIDTH="55" align="center" class="avantgo"><input type="checkbox" name="group1" value="1" onclick="calc_chmod()">
</td>
<td WIDTH="55" align="center" class="avant">
<input type="checkbox" name="other1" value="1" onclick="calc_chmod()">
</td>
</tr>
</table>
</center>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Зберегти зміни</button>
<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Закрити</button>
</div>
</form>
<script src="js/chmod.js"></script>
<script src="js/form.js"></script>
<script>
octalchange(); 
</script>