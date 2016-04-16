    <div class="modal vertical-centered fade bs-example-modal-sm" id="LoginLoaderWindow" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="LoaderLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		  <div class="modal-body">	 
			<center>
			   <div><img id="loader" src="img/login.gif"></div>
			   <div><br>Зачекайте, будь ласка...</div>
			</center>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade bs-example-modal-lg" id="MessageDialog" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="LoaderLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		 <form action="support" method="post">
		  <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title">Повідомлення до адміністратора</h4>
		  </div>
		  <div class="modal-body">	 
		   <div class="form-message hidden"><i class="fa fa-exclamation-triangle"></i> <span class="text"></span></div>
		   <div class="input-group">
			  <span class="input-group-addon"><i class="fa fa-user"></i></span>
			  <input type="text" class="form-control required" name="UserName" placeholder="Прізвище Ім'я По батькові" data-minlength="1" maxlength="50" autofocus>
			  <span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span></span>
		   </div>
		   <div class="input-group">
			  <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
			  <input type="text" class="form-control required" name="UserEmail" placeholder="Електронна адреса для відповіді" data-minlength="10" maxlength="255">
		   </div>
		   <div class="input-group">
			  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
			  <textarea class="form-control required" name="UserMessage" placeholder="Ваше повідомлення" data-minlength="10" maxlength="100"></textarea>
		   </div>
		   <div class="input-group">
			  <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>
			  <input type="text" class="form-control required cleared" name="UserCaptcha" placeholder="Цифровий код" data-minlength="4" maxlength="4">
			  <span class="input-group-btn">
				<button class="btn btn-default" type="button" id="RefreshCaptcha" title="Оновити код" data-placement="top"><i class="fa fa-refresh"></i></button>
			  </span>
		   </div>
		   <img src="captcha?<?php echo rand(); ?>" class="captcha" id="CaptchaImage">
		  </div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="SendMessageButton"><i class="fa fa-check"></i> Надіслати повідомлення</button>
		  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Закрити</button>
		  </div> 
		  <script src="js/feedback.js"></script>
		 </form>
		</div>
	  </div>
	</div>
    <div class="container">
	  <div class="row">
	    <div class="col-xs-12 login-box">
		  <form name="LoginForm">
		  <div class="panel panel-default">
		    <div class="panel-heading"><h4><i class="fa fa-lock"></i> Вхід до системи</h4></div>
			<div class="panel-body hidden" id="warningMessage">
			  <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Для роботи необхідна підтримка cookies!</div>
			</div>
		    <div class="panel-body hidden">
			 <div class="alert alert-danger fade in hidden" id="errorMessage">
			   <i class="fa fa-exclamation-triangle"></i> <span class="alert-text"></span>
			   <button type="button" class="close" aria-hidden="true">&times;</button>
			 </div>
			 <div class="input-group">
			  <span class="input-group-addon"><i class="fa fa-user"></i></span>
			  <input type="text" class="form-control" name="Login" id="Login" placeholder="Логін" autofocus>
			 </div>
			<div class="input-group">
			  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
			  <input type="password" class="form-control" name="Password" id="Password" placeholder="Пароль">
			</div>
		  </div>
		  <div class="panel-footer hidden text-right">
		  <button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Вхід до системи</button>
		  <a class="btn btn-default pull-left" data-toggle="modal" data-target="#MessageDialog" data-placement="right" title="Зв'язок з адміністратором"><i class="fa fa-envelope"></i></a>
		  </div>
		</div>
		</form>
	   </div>
	  </div>
	</div>