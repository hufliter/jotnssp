<?php echo doctype('html5'); ?>
<html><head>
	<title>upload</title>
	<link href="<?=base_url()?>assets/css/uploadify.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
</head><body>
	<h1>Uploadify Demo</h1>
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="userfile" type="file" multiple="true">
	</form>

	<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},'fileObjName':'userfile','fileTypeDesc':'jpg','auto':false,
				'swf'      : '<?php echo base_url(); ?>assets/js/uploadify/uploadify.swf',
				'uploader' : '<?php echo base_url(); ?>zuploadify/uploadifyUploader/',
				'fileTypeExts'     : '*.jpg;*.gif;*.png;*.jpeg;',
			    'onUploadSuccess' : function(file, data, response) {
        			console.log(data);
			    }
			});
		});
	</script>
</body></html>
