<!DOCTYPE html>
<html>
	<head>
		<title>Jake's Scouter</title>
		<base href = "http://localhost:8000/">
	</head>
	<?php
	$modifier = "";
	$link_modifier = "";
	if (!$_GET["game"] == '') {
		if (!$_GET["event"] == '') {
			if (!$_GET["team"] == '') {
				echo "<h1>Robot Stats : " . $_GET["team"] . " : " . $_GET["event"] . " : " . $_GET["game"] . "</h1>";
				$modifier = "data/Games/" . $_GET["game"] . "/Events/" . $_GET["event"] . "/Teams/" . $_GET["team"] . "/";
			}
			else {
				echo "<h1>Teams : " . $_GET["event"] . " : " . $_GET["game"] . "</h1>";
				$modifier = "data/Games/" . $_GET["game"] . "/Events/" . $_GET["event"] . "/Teams/";
				$link_modifier = "/?game=" . $_GET["game"] . "&event=" . $_GET["event"] . "&team=";
			}
		}
		else {
			echo "<h1>Events : " . $_GET["game"] . "</h1>";
			$modifier = "data/Games/" . $_GET["game"] . "/Events/";
			$link_modifier = "/?game=" . $_GET["game"] . "&event=";
			$new_folder = "Teams";
		}
	}
	else {
		echo "<h1>Games</h1>";
		$modifier = "data/Games/";
		$link_modifier = "/?game=";
		$new_folder = "Events";
	}
	
	$question_string = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "?"));
	$and_string = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "&"));
	if (!empty($question_string)) {
		if (empty($and_string)) {
			echo '<a href = "' . $question_string  . '" target = "_self">Go Back</a>';
		}
		else {
			echo '<a href = "' . $and_string  . '" target = "_self">Go Back</a>';
		}
	}
	else {
		echo "<br>";	
	}
	
	echo '<body bgcolor=white path="' . $modifier . '" base_link="' . $_SERVER['REQUEST_URI'] . '">';
		echo '<script type="text/javascript" src="scouter.js"></script>';
		
		if (!$_GET["team"] == '') {

			//I didn't feel like getting rid of it, so I just hid it.
			//Change to false to get back
			if (true) {
				$box_style = ' style="display: none"';
				$break = '';
			}
			else{
				$box_style = '';
				$break = '<br>';
			}			
					
			if (!file_exists($modifier . "data.txt")) {
				$new_data_file = fopen($modifier . "data.txt", "w");
				fclose($new_data_file);
			}
			$data_file = fopen($modifier . "data.txt", "r") or die("File not found.");
			echo '<table border="10"><tr><td><img src = "' . $modifier . '/image" width = "450" height = "300"/></td></tr></table>';
			echo '<h1' . $box_style . '>Scouting:</h1>';
			
			function getBetweenStrings($string, $start, $end){
				$string = ' ' . $string;
				$ini = strpos($string, $start);
				if ($ini == 0) return '';
				$ini += strlen($start);
				$len = strpos($string, $end, $ini) - $ini;
				return substr($string, $ini, $len);
			}
			
			function checkFile($tag_name, $file_name) {
				$lines = file($file_name);
				foreach ($lines as $lineNumber => $line) {
					if (strpos($line, $tag_name . "<@J@a@k@e@>") !== false) {
						return true;
					}
				}
				return false;
			}
			
			function getData($tag_name, $file_name) {
				$lines = file($file_name);
				foreach ($lines as $lineNumber => $line) {
					if (strpos($line, $tag_name . "<@J@a@k@e@>") !== false) {
						break;
					}
				}
				return getBetweenStrings($line, "<@J@a@k@e@>", "<@P@e@v@e@r@l@y@>");
			}
			if (getData("Matches", $modifier . "data.txt") == '') {
				$style = ' style="display: none"';
			}
			else{
				$style = '';
			}
			echo '<table border="10" class="matches"' . $style . '>';
				$match_number = 1;
				echo '<tr id="top_bar">';
					echo '<th>Match #</th>';
					$matches = explode("<@Z@>", getData("Matches", $modifier . "data.txt"));
					foreach($matches as $value){
						echo '<td>' . $value . '</td>';
						$match_number++;
					}
				echo '</tr>';
				$databoxes = explode("<@Z@>", getData("Databoxes", $modifier . "../../../../template.txt"));
				$color = "Black";
				$division = false;
				echo '<form id="updater" action="robot.php" method="post">';
				foreach($databoxes as $value){
					if (strpos($value, '<@@') !== false) {
						$color = getBetweenStrings($value, "@Z@", "@@>");
						$value = getBetweenStrings($value, "<@@", "@Z@");
						$division = true;
					}
					if (!empty($value)) {
						echo '<tr id="' . $value . '">';
					}
					if ($division === true) {
						echo '<th colspan="' . $match_number . '"' . $style . '><font color="' . $color . '">' . $value . '</font></th>';
					}
					else {
						echo '<td><font color="' . $color . '">' . $value . '</font></td>';
						if (strpos(file_get_contents($modifier . "data.txt"), $value . "<@J@a@k@e@>") === false) {
								$data = fopen($modifier . "data.txt", "a") or die("Unable to open file!");
								fwrite($data, $value . "<@J@a@k@e@><@P@e@v@e@r@l@y@>\n");
								fclose($data);
						}
						$valueValues = explode("<@Z@>", getData($value, $modifier . "data.txt"));
						$string_array = array();
						$match_number_array = array();
						foreach($valueValues as $value_in){
							if (!empty($value_in)) {
								$i = 0;
								foreach($matches as $match_number_value){
									if ($match_number_value == getBetweenStrings($value_in, "<", "::")) {
										$string_array[$i] = getBetweenStrings($value_in, "::", ">");
										$match_number_array[$i] = $match_number_value;
									}
									$i++;
								}
							}
						}
						for ($j = 0; $j < ($match_number - 1); $j++) {
							$box_name = $matches[$j] . "::" . $value;
							if ($box_name == $match_number_array[$j] . "::" . $value) {
								echo '<td><input type="text" name="' .  $box_name . '" id="' . $box_name . '" size="4" value="' . $string_array[$j] . '"></td>';
							}
							else {
								echo '<td><input type="text" name="' .  $box_name . '" id="' . $box_name . '" size="4" value=""></td>';
							}
						}
					}
					echo '</tr>';
					$division = false;
				}
			echo '</table>';

			$questions = explode("<@Z@>", getData("Textboxes", $modifier . "../../../../template.txt"));
			foreach($questions as $value){
				if (strpos(file_get_contents($modifier . "data.txt"), $value . "<@J@a@k@e@>") === false) {
						$data = fopen($modifier . "data.txt", "a") or die("Unable to open file!");
						fwrite($data, $value . "<@J@a@k@e@><@P@e@v@e@r@l@y@>\n");
						fclose($data);
				}
				echo '<p' . $box_style . '>' . $value . ':</p>';
				echo '<textarea rows="10" cols="100" name="' .  $value . '" id="' . $value . '"' . $box_style . '>' . getData($value, $modifier . "data.txt") . '</textarea>';
			}
			echo $break;
			echo '<h1' . $box_style . '>Pit Scouting:</h1>';
			$pitquestions = explode("<@Z@>", getData("PitTextboxes", $modifier . "../../../../template.txt"));
			foreach($pitquestions as $value){
				if (strpos(file_get_contents($modifier . "data.txt"), $value . "<@J@a@k@e@>") === false) {
						$data = fopen($modifier . "data.txt", "a") or die("Unable to open file!");
						fwrite($data, $value . "<@J@a@k@e@><@P@e@v@e@r@l@y@>\n");
						fclose($data);
				}
				echo '<p' . $box_style . '>' . $value . '</p>';
				echo '<textarea rows="10" cols="100" name="' .  $value . '" id="' . $value . '"' . $box_style . '>' . getData($value, $modifier . "data.txt") . '</textarea>';
			}
			echo $break;
			
			if (!$_GET["team"] == '') {
				echo '<input id="robot_toolbox_button" type="button" value="Toggle Toolbox" onclick="toggleRoboToolbox();"/>';
			}
			else {
				echo '<input id="robot_toolbox_button" type="button" value="Toggle Toolbox" onclick="toggleRoboToolbox("robo_toolbox");" style="display: none"/>';
			}	
			//Toolbox
			echo '<table border="10" class="robo_toolbox" style="display: none">

				<tr><td>';
				echo '<input type="submit" value="Upload Boxes" onclick="updateBoxes();">';
				echo '</form>
				</tr></td>

				<tr><td><form id="match_adder" action="robot.php" method="post">
					Input new Match: <input type="text" name="number">
					<input type="submit" onclick="addMatch();">
				</form></td></tr>';

				echo '<tr><td>Selected Match: <select id="match_selector">';
				$matches_selector = explode("<@Z@>", getData("Matches", $modifier . "data.txt"));
				foreach($matches_selector as $match_number){
					echo '<option>' . $match_number. '</option>';
				}
				echo '</select></td>
				
				<tr><td><form id="match_deleter" action="robot.php" method="post">
					<input type="submit" class="delete" value="Delete Selected Match" onclick="return deleteMatch();"/>
				</form></td></tr>
				';

			echo '</table>';		
			
			fclose($data_file);
		}
		else {
			$data_file = fopen($modifier . "../data.txt", "r") or die("File not found.");
			echo '<table border="10">';
			while(!feof($data_file)) {
				$line_text = trim(preg_replace('/\s\s+/', ' ', fgets($data_file)));
				echo "<tr>";
				if (!empty($line_text)) {
					if (!is_dir($modifier . $line_text)){
						mkdir($modifier . $line_text, 0755);
					}
					if (!is_dir($modifier . $line_text . "/" . $new_folder)) {
						mkdir($modifier . $line_text . "/" . $new_folder, 0755);
					}
					if (!file_exists($modifier . $line_text . "/data.txt")) {
						$new_data_file = fopen($modifier . $line_text . "/data.txt", "w");
						fclose($new_data_file);
					}
					echo "<td>" . '<img src = "' . $modifier . $line_text . '/image" width = "150" height = "100"/>' . "</td>";
					echo "<td>" . '<a href = "scouter.php' . $link_modifier . $line_text . '" target = "_self">' . $line_text . '</a>' . "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			fclose($data_file);
		}
		
		if ($_GET["team"] == '') {
			echo '<input id="toolbox_button" type="button" value="Toggle Toolbox" onclick="toggleToolbox();"/>';
		}
		else {
			echo '<input id="toolbox_button" type="button" value="Toggle Toolbox" onclick="toggleToolbox();" style="display: none"/>';
		}
		?>
		<table border="10" class="toolbox" style="display: none">
			<tr><td><form id="list_element_adder" action="list.php" method="post">
				Input new List Element: <input type="text" name="name">
				<input type="submit" onclick="addListElement();">
			</form></td></tr>
			<tr><td>Selected Element: <select id="selector">
				<?php
				$data_file = fopen($modifier . "../data.txt", "r") or die("Unable to open file!");
				while(!feof($data_file)) {
					$line_text = trim(preg_replace('/\s\s+/', ' ', fgets($data_file)));
					if (!empty($line_text)) {
						echo '<option>' . $line_text . '</option>';
					}
				}
				fclose($data_file);
				?>
			</select></td></tr>
			<tr><td><form id="image_uploader" action="image.php" method="post" enctype="multipart/form-data">
				Select image to upload:
				<input type="file" name="file_upload" id="file_upload">
				<input type="submit" value="Upload Image" name="submit" onclick="uploadImage();">
			</form>
			<form id="image_deleter" action="image.php" method="post">
				<input type="submit" class="delete" value="Delete Image" onclick="return deleteImage();"/>
			</form></td></tr>
			<tr><td><form id="list_element_deleter" action="list.php" method="post">
				<input type="submit" class="delete" value="Delete Selected List Element" onclick="return deleteListElement();"/>
			</form></td></tr>
		</table>
	</body>
</html>
