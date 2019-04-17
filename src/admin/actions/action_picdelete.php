<?php
if(isset($_SESSION['username'])) {
?>
<div id="imagedelvlak" class="pages" style='padding: 15px'>
	<form action="/admin/?action=submit" method="post">
	<?php
	$query = "SELECT id,artikel_id FROM images";
	if($query = mysqli_query($conn, $query)) {
		$numrows = mysqli_num_rows($query);
		while($result = mysqli_fetch_assoc($query)) {
			$picId = $result['id'];
			echo "<div style='float:left; margin: 5px;' class='imagediv'><img style='max-width: 200px; max-height: 200px' src='image.php?id=$picId' name='image' /><br />
			<input style='margin-left: calc(50% - 7px);margin-top: 5px;' type='checkbox' value='$picId' name='picturedelids[]'></div>";
		}
	}
	?>
	<input type='submit' value='Delete images' />
	</form>
	<?php
	if(!empty($result->error)){
		foreach($result->error as $errMsg){
			echo $errMsg;
		}
	}
	?>
</div>
<?php
}
?>