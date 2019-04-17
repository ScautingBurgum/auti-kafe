<div id="imagevlak" class="pages" style='padding: 15px'>
	<form name="upload" action="/admin/?action=submit" method="POST" enctype="multipart/form-data">
		<label for='image[]'>Select image to upload: </label><br /><input type="file" name="image[]" multiple><br /><hr><br />
		<input type="submit" name="upload" value="upload">
	</form>
	<?php
	if(!empty($result->error)){
		foreach($result->error as $errMsg){
			echo $errMsg;
		}
	}
	if(!empty($result->info)){
		foreach($result->info as $infoMsg){
			echo $infoMsg;
		}
	}
	?>
</div>