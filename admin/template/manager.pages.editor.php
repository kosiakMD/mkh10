<div class="row">
<div class="input-group">	
<span class="input-group-addon"><i class="fa fa-file"></i></span>
<input type="hidden" name="PageID" value="<?php echo ((isset($PageData)) ? $PageData->id : 'NULL'); ?>">
<input type="text" class="form-control required" name="PageTitle" id="PageTitle" value="<?php if(isset($PageData)) echo $PageData->title; ?>" placeholder="Назва сторінки" maxlength="255">
</div>   
<div class="input-group">	
<span class="input-group-addon"><i class="fa fa-link"></i></span>
<input type="text" class="form-control" name="PageAlias" id="PageAlias" value="<?php if(isset($PageData)) echo $PageData->alias; ?>" placeholder="Посилання на сторінку" maxlength="255"<?php if(isset($PageData) && is_null($PageData->alias)) echo ' disabled'; ?>>
<span class="input-group-addon"><input type="checkbox" id="PageAliasEnabled" name="PageAliasEnabled"<?php if(isset($PageData) && !is_null($PageData->alias)) echo ' checked'; ?>></span>
</div>   
<div class="input-group">	
<span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
<select class="form-control selectpicker show-menu-arrow" data-selected="<?php if(isset($PageData)) echo $PageData->category_id; ?>" name="PageCategory">
  <option value="0">-- Без категорії --</option>
  <?php echo $CategoriesData; ?>
</select>
</div>  
<div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-sort"></i></span>
	  <input type="number" class="form-control required" id="PagePosition" name="PagePosition" value="<?php echo ((isset($PageData)) ? $PageData->position : '1'); ?>" min="1" max="9999" placeholder="Позиція сторінки" data-minlength="1" maxlength="4">
   </div>
<div class="input-group">	
<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
<select class="form-control selectpicker show-menu-arrow" name="PageIcon" data-size="10" data-selected="<?php if(isset($PageData)) echo $PageData->icon; ?>" data-show-subtext="true" data-show-icon="true">
  <option value=""></option>
  <?php include_once($ROOT.'/template/manager.icons.list.php'); ?>
</select>
</div>  
<div class="input-group">	
<input class="to-labelauty" type="checkbox" name="PageActive" data-labelauty="Прихована|Активна"<?php if(isset($PageData) && $PageData->activity == 1) echo ' checked'; ?>>
<input class="to-labelauty" type="checkbox" name="PageFullscreen" data-labelauty="З меню|Повноекранна"<?php if(isset($PageData) && $PageData->fullscreen == 1) echo ' checked'; ?>>
<input class="to-labelauty" type="checkbox" name="PageDetails" data-labelauty="Приховати деталі|Показати деталі"<?php if(isset($PageData) && $PageData->details == 1) echo ' checked'; ?>>
</div>  
  <div id="editplace" class="required">
	<textarea name="content" id="editor"><?php if(isset($PageData)) echo $PageData->html; ?></textarea>
  </div>
</div>
<hr>
<div class="row text-right">
  <button type="button" class="btn btn-success" id="SavePage"><i class="fa fa-floppy-o"></i> Зберегти сторінку</button>
</div>