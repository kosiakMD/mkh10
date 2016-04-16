<div id="UploadErrors"></div>
<?php include_once 'table.php'; ?>
<div class="form-group">
  <input id="UploadFileInput" type="file" name="my_file[]" data-upload-url="manager/upload/handler/<?php if(!empty($ManagerPath)){ echo $ManagerPath.'/'; } ?>" multiple class="file">
</div>