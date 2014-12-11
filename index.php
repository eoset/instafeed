<html>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</head>
<body style="background-color: #000000; overflow-y: hidden;">
	<div class="container-fluid">
		<!--Append images through script-->
	</div>

	<script>
		var images = [];

		$(document).ready(function(){
			getImages();
		});

		function addImage(obj)
		{
			var html = "";
			html += "<div class='col-md-3'>";
			html += "<img name='"+obj.id+"' src='"+obj.src+"' style='padding-bottom: 15px; padding-top: 15px; width: 100%;'/>";
			html += "<div style='position: relative; top: -32px; background-color: #000000; opacity: 0.5; color: #FFFFFF;'>@"+obj.username+"</div>";
			html += "</div>";
			$(".container-fluid").prepend(html);
		}

		function getImages()
		{
			$.ajax({
				type: "POST",
				url: "getImages.php",
				data: {tag:"<?php echo $_GET['tag'] ?>"}
			})
			.done(function(data){
				//console.log(JSON.parse(data));
				var obj = JSON.parse(data);
				for(var i = 0; i<obj.length; i++)
				{
					var exists = false;

					for(var j = 0; j<images.length; j++)
					{
						if(obj[i].src == images[j].src)
						{
							exists = true;
							break;
						}
					}

					if(exists) continue;

					images.push(obj[i]);
					addImage(obj[i]);
				}
				setTimeout(pageScroll, 500);
				$(".container-fluid").animate({
						opacity: 1,
					}, 2000);
			});
			
		}

		var scroll = 0;

		function pageScroll() {
			$(document).scrollTop($(document).scrollTop()+1);
			var newScroll = $(document).scrollTop();
			if(newScroll == scroll && scroll != 0)
			{

				$( ".container-fluid" ).animate({
					opacity: 0,
				}, 2000, function() {
					$(document).scrollTop(0);
					getImages();
				});
				
			}
			else
			{
				scroll = newScroll;
				scrolldelay = setTimeout('pageScroll()',20);
			}
		}
	</script>
</body>
</html>