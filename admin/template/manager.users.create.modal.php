<form action="manager/user/save" method="post">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel">Створення облікового запису</h4>
  </div>
  <div class="modal-body">
   <div class="form-message hidden"><i class="fa fa-exclamation-triangle"></i> <span class="text"></span></div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-user"></i></span>
	  <input type="text" class="form-control required" name="NewLogin" placeholder="Логін" data-minlength="3" maxlength="50">
	  <span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span>
   </div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
	  <select class="form-control selectpicker show-menu-arrow" name="NewPrivileges" data-selected="1" data-show-icon="true">
	    <option value="1" data-icon="fa-user">Користувач</option>
	    <option value="2" data-icon="fa-pencil">Модератор</option>
	    <option value="3" data-icon="fa-user-secret">Адміністратор</option>
	  </select>
   </div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
	  <input type="password" class="form-control required" name="NewPassword" placeholder="Пароль" data-minlength="6" maxlength="18">
   </div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
	  <input type="password" class="form-control required" name="NewPasswordConfirm" placeholder="Повторити пароль" data-minlength="6" maxlength="18">
   </div>
  </div>
  <div class="modal-footer">
	<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Створити користувача</button>
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Відміна</button>
  </div>
</form>
<script src="js/form.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap-select.init.js"></script>