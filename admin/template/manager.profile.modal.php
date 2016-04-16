<form action="manager/user/profile/save" method="post">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel">Профіль</h4>
</div>
<div class="modal-body">
<div class="form-message hidden"><i class="fa fa-exclamation-triangle"></i> <span class="text"></span></div>
<h4>Логін</h4>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-user"></i></span>
  <input type="text" class="form-control required" name="NewLogin" placeholder="Логін" value="<?php echo $ssID->login; ?>" data-minlength="3" maxlength="50">
  <span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span>
</div>
<h4>Зміна паролю</h4>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
  <input type="password" class="form-control" name="OldPassword" placeholder="Старий пароль" data-minlength="6" maxlength="18">
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
  <input type="password" class="form-control" name="NewPassword" placeholder="Новий пароль" data-minlength="6" maxlength="18">
</div>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
  <input type="password" class="form-control" name="NewPasswordConfirm" placeholder="Повторити пароль" data-minlength="6" maxlength="18">
</div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Зберегти зміни</button>
<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Відміна</button>
</div>
</form>
<script src="js/jquery-cookie.js"></script>
<script src="js/form.js"></script>