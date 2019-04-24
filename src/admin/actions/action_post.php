<?php
if(isset($_SESSION['username'])) {
?>
<div id="postvlak" class="pages" style='padding: 15px'>
	<form name="upload" action="?action=submit" enctype="multipart/form-data" method="post">
	<?php
	$query = "SELECT * FROM `evenement` WHERE id = $count";
	if($query = mysqli_query($conn, $query)) {
		$items = mysqli_fetch_array($query);
	}
	?>
	<input type="hidden" value="<?php echo $count; ?>" name="id">
	<label for="titel">Titel:</label><br /><input type="text" id="titel" name="titel" value="<?php if(isset($count) && $count !== '') { echo $items['titel']; } ?>" required><br />
	<hr><label for="text">Text:</label><br /><textarea id="text" cols="60" rows="10" name="text"></textarea><br />
	<hr><label for="date">Datum:</label><input id="date" type="date" name="date" value="<?php if(isset($count) && $count !== '') { echo $items['datetime']; } ?>" required><br />
		<?php
		$query = "SELECT picturecount FROM evenement WHERE id = $count";
		if($query = mysqli_query($conn, $query)) {
			$numpicsarr = mysqli_fetch_row($query);
		}
		if(isset($numpicsarr)) {
			$numpics = $numpicsarr[0];
		} else {
			$numpics = 0;
		}
			echo "<label for='amount'>Selecteer hoeveel foto's</label><input type='number' name='amount' value='" . $numpics . "'><br /><hr><br />";
			?>
			<label for='image[]'>Select image to upload: </label><br /><input type="file" name="image[]" multiple><br /><hr><br />
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
			echo"<div style='display: table-cell;width: 100%;'>";
			$query = "SELECT id,artikel_id FROM images";
			if($query = mysqli_query($conn, $query)) {
				$numrows = mysqli_num_rows($query);
				while($result = mysqli_fetch_assoc($query)) {
					$picId = $result['id'];
					$artikel_id = $result['artikel_id'];
					if($artikel_id == $count && strlen($count) >= 1) {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					echo "<div style='float:left; margin: 5px;min-width: 200px;min-height: 200px;' class='imagediv'><img style='max-width: 200px; max-height: 200px' src='image.php?id=$picId' name='image' /><br /><input style='margin-left: calc(50% - 7px);margin-top: 5px;' type='radio' value='$picId' name='pictureids[]' $checked></div>";
					/*
					echo "<div style='float:left; margin: 5px;' class='imagediv'><img style='max-width: 200px; max-height: 200px' src='image.php?id=$picId' name='image' /><br />
					<input style='margin-left: calc(50% - 7px);margin-top: 5px;' type='checkbox' value='$picId' name='pictureids[]' $checked></div>";
					*/
				}
			}
			echo "</div><hr><br/>";

		?>
	<input id="submit" type="submit" name="submit" value="Submit"></form>
	<script>
		$('.imagediv').click(function(){
		  	$(this).find('input[type="radio"]').prop('checked', true);
		});
	</script>
</div>
<?php
}
?>