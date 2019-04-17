<div id="deletevlak" class="pages" style='padding: 15px'>
	<?php
	if(isset($_GET["pagenr"]) && $_GET['pagenr'] != 0 && is_numeric($_GET['pagenr'])) {
		$limitget = htmlspecialchars($_GET["pagenr"]);
		$limitget = $limitget-1;
		if($limitget == 0) {
			$limit = 0;
		} else {
			$limit = $limitget*20;
		}
	} else {
		$limit = 0;
	}
	$artquery = "SELECT * FROM `evenement` LIMIT $limit,20";
	$artcounts = "SELECT count(id) FROM `evenement`";
	if($artquery = mysqli_query($conn, $artquery)) {
		echo '<div style="width:75%;height:350px;position:relative;overflow:hidden;">';
		$whilecounter = 0;
		$whilestyle = 0;
		while($result = mysqli_fetch_assoc($artquery)) {
			if($whilecounter < 10) {
				$styleside = "style='width:45%;position:absolute;left:10px;top:" . $whilestyle*35 . "px;'";
			} else {
				$whilestyle = 0;
				$styleside = "style='width:45%;position:absolute;left:50%;top:" . $whilestyle*35 . "px;'";
			}
			?>			
			<form method='post' action="" name='artsubmit' <?php echo $styleside; ?> >
				<input type='hidden' name='artformid' value='<?php echo $result['id']; ?>'></input>
				<input type='submit' value='<?php echo $result['titel']; ?>'></input>
			</form>
			<?php
			$whilestyle++;
			$whilecounter++;
		}
		if($artcounts = mysqli_query($conn, $artcounts)) {
			$artscounts = mysqli_fetch_array($artcounts);
			//var_dump($artscounts);
			$finalcount = $artscounts[0];
			$finalcount = ceil($finalcount/20);
		}
		echo '</div><div style="width:100%;"><span style="margin-left: 10px;">Page: ';
		for($i=1;$i<$finalcount+1;$i++) {
			echo '<a name="deletevlak" href="?pagenr=' . $i . '">'.$i.'</a>';
		}
		echo '</span></div>';
	}
	if(strlen($count) >= 1) {
		$query = "SELECT * FROM evenement WHERE id = $count";
		if($query = mysqli_query($conn, $query)) {
			$items = mysqli_fetch_array($query,MYSQLI_ASSOC);
			if(isset($count) && $count !== '') {
				$restitel = $items['titel'];
				$resdate = $items['datetime'];
				$resid = $items['id'];
			} else {
				$restitel = '';
				$resdate = '';
				$resid = '';
			}
			echo '<hr>Titel: <br />' . $restitel . '<br /><hr>
			Datum: ' . $resdate . '<br />
			<form action="/admin/?action=post" method="post">
			<input type="hidden" name="id" value="'.$resid.'">
			<input id="showbutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" 
			<?php echo 'value="Show" name="showbutton">
			<input id="editbutton" type="submit" value="Edit" name="editbutton">
			</form>';

		} else {
			echo("Error description: " . mysqli_error($conn));
		}
		echo '<form action="/admin/?action=submit" method="post">
		<input type="hidden" name="id" value="'.$resid.'">
		<input id="deletebutton" type="submit" '; ?> onclick="return confirm('Are you sure?')" 
		<?php echo 'value="Delete" name="deletebutton">
		</form>';
	} else {
		echo("Error description: " . mysqli_error($conn));
	}
?>
</div>
