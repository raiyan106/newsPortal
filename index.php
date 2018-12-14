<?php 

if(isset($_GET['submit'])){
		if(!empty($_GET["query"])){

			if(empty($_GET["pageNumber"])){
			$query_url = 'https://content.guardianapis.com/search?api-key=9112a877-0ed4-4161-9e37-324c74ba65b3&q='.urlencode($_GET["query"]).'&show-fields=thumbnail,header&page-size=8&page=1';
		}
		else{
			$query_url = 'https://content.guardianapis.com/search?api-key=9112a877-0ed4-4161-9e37-324c74ba65b3&q='.urlencode($_GET["query"]).'&show-fields=thumbnail,header&page-size=8&page='.$_GET['pageNumber'];
			 
		}
		$result_json = file_get_contents($query_url);
		$resArray = json_decode($result_json,true);
	}
}
 ?>

 <!DOCTYPE html>
 <html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>The Daily Prophet</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet"> 

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
 <body>
 	<?php 
 		if(!empty($_GET['query']))
  			$q=urlencode($_GET["query"]);
  	?>

 	<a href="<?php echo "index.php?query=$q&submit=";  ?>" ><h1 style="    font-size: 50px;
    text-align: center;
    text-decoration: underline;
    font-style: italic;
    font-family: cursive;
    padding: 25px 0px;">The Daily Prophet</h1>
 	</a>

 	<?php if(!empty($resArray)){ ?>
 	<h3 style="margin: 20px 30px"><?php echo (empty($_GET['pageNumber'])) ? 'Result Page: 1': 'Result Page:'.' '.$_GET['pageNumber']; ?></h3>
 	<?php } ?>

 	<div style="padding: 65px 0px;">
	<div class="form-group">
		<div class="container">
		<div class="jumbotron">
	 	<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="GET">
	 		 <label for="searchForNews">Search for News</label>
	 		<input type="text" class="form-control" id="searchForNews" aria-describedby="searching" name="query" placeholder="...">
	 		<small id="searching" class="form-text text-muted">Get the hottest news of today</small>
	 		<button id="searchBtn" style="display: block; margin:20px 0px;" name="submit" type="submit" class="btn btn-lg btn-primary">Search</button>
	 	</form>
	 </div>
	 </div>
	</div>
	</div>  



<?php if(empty($resArray) || $resArray['response']['total']==0){ ?>

	<h1 class="alert alert-danger" role="alert" style="text-align: center;">No news found</h1>

<?php }else{ ?>

	 <div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row" style="display:flex;flex-wrap: wrap">	
					<!-- post -->
					<?php foreach ($resArray['response']['results'] as $news) {  ?>
						<?php 
						$t = strtotime($news['webPublicationDate']);
						$time= date('l, jS F-Y',$t);

						 ?>

					<div class="col-md-6">
						<div class="post">
							<img class="post-img img-responsive" src="<?php echo $news['fields']['thumbnail'] ?>" alt="Image not Found">
							<div class="post-body">
								<div class="post-meta">
									<p style="display:inline-block;"class="post-category cat-1" ><?php echo $news['sectionName'] ?></p>
									<span class="post-date"><?php echo $time; ?></span>
								</div>
								<h3 class="post-title"><a target="blank" href="<?php echo $news['webUrl']; ?>"><?php echo $news['webTitle'] ?></a></h3>
							</div>
						</div>
					</div>
					<!-- /post -->

				<?php } ?>
			</div>	
		</div>
	</div>

<?php } ?>


<?php if(!empty($resArray)){ ?>

<nav aria-label="...">
<div class="container">
  <ul class="pagination">
  	<?php  if($resArray['response']['total']!=0){ ?>
  		<?php for($i=2;$i<=20;$i++){ ?>
    	<li class="page-item"><a class="page-link" href="<?php echo "index.php?query=$q&submit=&pageNumber=$i"; ?>"> <?php echo $i; ?> </a></li>
   		 <?php } ?>
	<?php } ?>
    
  </ul>
</div>
</nav>
<?php } ?>

<a href="#" style="    position: fixed;
    bottom: 0em;
    right: 0em;
    display: inline-block;
    background: grey;
    color: white;
    padding: 10px;">Go Top</a>


 <script type="text/javascript">
	Notification.requestPermission();

 	const btn = document.getElementById('searchBtn');


 	btn.addEventListener('click',function(){
 		 var n = new Notification("New search Made");
 	});

 </script>

 </body>
 </html>