<?php

require_once('instaLoop.php');

class instaLoop
{

	public function run(){

		$tag = $_POST["tag"];

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
			$id = 1;

			foreach(json_decode($result)->data as $item)
			{
				$src = $item->images->standard_resolution->url;
				$url = $item->link;
				$username = $item->user->username;
				$fullname = $item->user->full_name;
				
				$images[] = array(
					"id" => $id++,
					"src" => htmlspecialchars($src),
					"url" => htmlspecialchars($url),
					"username" => htmlspecialchars($username),
					"fullname" => htmlspecialchars($fullname)
					);
			}

			return json_encode(array_reverse($images));
		}
	}
}