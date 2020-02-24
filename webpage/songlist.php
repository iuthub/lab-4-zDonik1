<?php 
function endsWith($string, $substr)
{
	$len_str = strlen($string);
	$len_substr = strlen($substr);

	if ($len_str < $len_substr) {
		return false;
	}

	for ($i = 0; $i < $len_substr; ++$i) {
		if ($string[$len_str - $len_substr + $i] !== $substr[$i]) {
			return false;
		}
	}

	return true;
}

function printSong($songname) {
	$filesize = filesize("songs/" . $songname);
	$size_unit = "";
	if ($filesize < 1024) {
		$size_unit = "b";
	}
	else if ($filesize < 1048576) {
		$filesize = round($filesize / 1024, 2);
		$size_unit = "kb";
	}
	else {
		$filesize = round($filesize / 1048576, 2);
		$size_unit = "mb";
	}

	echo "<li class=\"mp3item\">
	<a href=\"songs/$songname\">$songname</a> ($filesize $size_unit)
	</li>";
}

if (isset($_REQUEST['playlist'])) {
	$playlist = $_REQUEST['playlist'];
	if ($playlist) {
		$songs = explode("\n", file_get_contents("songs/" . $playlist, "r"));
		foreach ($songs as $song) {
			printSong(rtrim($song));
		}
	}
}
else {
	$songs = scandir("songs");
	foreach ($songs as $key) {
		if (endsWith($key, '.mp3')) {
			printSong($key);
		}
	}
	foreach ($songs as $key) {
		if (endsWith($key, '.txt')) {
			echo "<li class=\"playlistitem\">
			<a href=\"?playlist=$key\">$key</a>
			</li>";
		}
	}
}
?>



