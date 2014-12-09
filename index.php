<?php

class instaLoop
{

	public function run(){

		$tag = 'visma';

		$url="https://api.instagram.com/v1/tags/".$tag."/media/recent?client_id=f41890a186f648b68342b142def75708&count=50";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);

		$images = array();

		if($result)
		{
			foreach(json_decode($result)->data as $item)
			{
				$src = $item->images->standard_resolution->url;
				$url = $item->link;
				$caption = $item->caption->text;

				$images[] = array(
					"src" => htmlspecialchars($src),
					"url" => htmlspecialchars($url),
					"caption" => htmlspecialchars($caption)
					);
			}
			return $images;
			die();
		}
	}
}

$instaLoop = new instaLoop;
$images = $instaLoop->run();
?>
<html>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #000000;" onLoad="pageScroll()">
	<div class="container-fluid">
		<?php
		foreach($images as $image)
		{
			echo "<img class='col-md-3' src=".$image['src']." />";
			//echo "<div class='well well-sm'>".$image['caption']."</div>";
		}

		?>
	</div>

	<script>
		function pageScroll() {
	    window.scrollBy(0,1);
	    scrolldelay = setTimeout('pageScroll()',10);
		}


		setTimeout(function(){
   		
   		document.body.scrollTop = document.documentElement.scrollTop = 0;
   		window.location.reload(1);
		}, 60000);
	</script>
</body>
</html>