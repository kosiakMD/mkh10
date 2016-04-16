$(document).ready(function(){	
	$('#UploadFileInput').fileinput({
		overwriteInitial: false,
		maxFilesNum: 10,
		allowedPreviewTypes: 'image',
		elErrorContainer: '#UploadErrors'
	}).on('fileuploaded', function(event, data, previewId, index) {
		setTimeout(function(){
			$('#UploadFileInput').fileinput('clear');
		}, 1000);
	}).on('filebrowse', function() {
		$('#UploadFileInput').fileinput('clear');
		$('#UploadSuccess').addClass('hidden');
	}).on('fileuploaderror', function(event, data, previewId, index) {
		//alert(JSON.stringify(data));
	});
});