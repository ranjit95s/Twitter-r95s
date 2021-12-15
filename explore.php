<?php
include 'core/init.php';
$user_id = $_SESSION['user_id'];
$user = $getFromU->userData($user_id);
$notify = $getFromM->getNotificationCount($user_id);

if ($getFromU->loggedIn() === false) {
	header('Location:index.php');
}
// $getFromU->delete('comments', array('commentID' => 9));
// $getFromU->create('users',array('username' => 'dany','email' => 'dany12@gmail.com','password'=> md5('password')));
// $getFromU->update('users',$user_id,array('username' => 'danynew','email' => 'danynew45@gmail.com'));

if (isset($_POST['tweet'])) {
	$status = $getFromU->checkInput($_POST['status']);
	$tweetImage = '';

	if (!empty($status) or !empty($_FILES['file']['name'][0])) {
		if (!empty($_FILES['file']['name'][0])) {
			$tweetImage = $getFromU->uploadImage($_FILES['file']);
		}
		if (strlen($status) > 140) {
			$error = "tweet must be in 140 length";
		}
		$tweet_id = $getFromU->create('tweets', array('status' => $status, 'tweetBy' => $user_id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));
		preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);


		if (!empty($hashtag)) {
			$getFromT->addTrend($status);
		}
		$getFromT->addMention($status, $user_id, $tweet_id);
	} else {
		$error = "Type or choose image to tweet";
	}
}

$newsUrl = 'https://newsapi.org/v2/top-headlines?country=in&apiKey=e45251087cc14ec4936926a8b95adcf9';
$res = file_get_contents($newsUrl);
$NewsData = json_decode($res);


?>

<!--
	This template created by Meralesson.com 
	This template only use for educational purpose 
	-->
<!DOCTYPE HTML>
<html>

<head>
	<title>Tweety / Explore</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Heebo:400,700|Open+Sans:400,700');

		:root {
			--color: #ffffff;
			--transition-time: 0.5s;
		}


		a {
			color: inherit;
		}

		/* .cards-wrapper {
  display: grid;
  justify-content: center;
  align-items: center;
  grid-template-columns: 1fr 1fr 1fr;
  grid-gap: 4rem;
  padding: 4rem;
  margin: 0 auto;
  width: max-content;
} */

		.card {
			font-family: 'Heebo';
			--bg-filter-opacity: 0.5;
			background-image: linear-gradient(rgba(0, 0, 0, var(--bg-filter-opacity)), rgba(0, 0, 0, var(--bg-filter-opacity))), var(--bg-img);
			height: 20em;
			width: 99.9%;
			font-size: 1.5em;
			/* margin-right: 1em; */
			color: var(--bg-text-color);
			/* border-radius: 1em 1em 0em 0em; */
			padding: 1em;
			/* margin: 2em; */
			display: flex;
			align-items: flex-end;
			background-size: cover;
			box-sizing: border-box;
			background-position: center;
			box-shadow: 0 0 5em -1em var( --primary-background-color);
			transition: all, var(--transition-time);
			position: relative;
			overflow: hidden;
			border: 1px solid var( --primary-border-color);
			text-decoration: none;
		}

		.card:hover {
			transform: rotate(0);
		}

		.card h1 {
			margin: 0;
			font-size: 1.5em;
			line-height: 1.2em;
		}

		.card p {
			font-size: 0.75em;
			font-family: 'Open Sans';
			margin-top: 0.5em;
			line-height: 2em;
		}

		.card .tags {
			display: flex;
		}

		.card .tags .tag {
			font-size: 0.75em;
			background: rgba(255, 255, 255, 0.5);
			border-radius: 0.3rem;
			padding: 0 0.5em;
			/* margin-right: 0.5em; */
			line-height: 1.5em;
			transition: all, var(--transition-time);
		}

		/* .card:hover .tags .tag {
  background: var(--color);
  color: white;
} */

		.card .date {
			position: absolute;
			top: 0;
			right: 0;
			font-size: 0.75em;
			padding: 1em;
			line-height: 1em;
			opacity: .8;
		}

		.card .date-a {
			position: absolute;
			top: 0;
			left: 0;
			font-size: 1em;
			padding: 1em;
			color: var(--bg-text-color);
			line-height: 1em;
			opacity: .8;
		}

		.card:before,
		.card:after {
			content: '';
			transform: scale(0);
			transform-origin: top left;
			border-radius: 50%;
			position: absolute;
			left: -50%;
			top: -50%;
			z-index: -5;
			transition: all, var(--transition-time);
			transition-timing-function: ease-in-out;
		}

		.card:before {
			background: #ddd;
			width: 250%;
			height: 250%;
		}

		.card:after {
			background: var( --primary-background-color);
			width: 200%;
			height: 200%;
		}

		/* .card:hover {
  color: var(--color);
} */
		/* .card:hover:before, .card:hover:after {
  transform: scale(1);
} */
		.card-grid-space .num {
			font-size: 3em;
			margin-bottom: 1.2rem;
			margin-left: 1rem;
			display: none;
		}
		.info {
			font-size: 1.2em;
			display: flex;
			padding: 1em 3em;
			display: none;
			height: 3em;
		}
		.info img {
			height: 3em;
			margin-right: 0.5em;
		}
		.info h1 {
			font-size: 1em;
			font-weight: normal;
		}
		/* MEDIA QUERIES */
		@media screen and (max-width: 1285px) {}
		@media screen and (max-width: 900px) {
			.cards-wrapper {
				grid-template-columns: 1fr;
			}
			.info {
				justify-content: center;
			}
			.card-grid-space .num {
				margin-left: 0;
				text-align: center;
			}
		}
		@media screen and (max-width: 500px) {
			.card {
				/* max-width: calc(100vw - 4rem); */
				width: 99%;
				font-size: 4vw;
				right: 4px;
			}
		}
		@media screen and (max-width: 450px) {
			.info {
				display: block;
				text-align: center;
			}
			.info h1 {
				margin: 0;
			}
			.search-engine {
				width: 98% !important;
			}
			.search-pro li input[type="text"] {
          
            font-size: 15px;
         
        }
		}
	</style>
</head>
<!--Helvetica Neue-->
<body>
	<div class="wrapper">
		<!-- header wrapper -->
		<!-- ------------------------------------------------------------------------------------------------ -->
		
		<?php 
                include 'includes/entities/side-pro-link.php';
            ?>
		

					<div class="in-center">
						<div class="in-center-wrap in-ce-w-exp">
							<!--TWEET WRAPPER-->
							<section class="search-engine">
								<div class="search-pro">
									<ul>
										<!-- <img id="nav500px" style="display: none;" src="<?php echo BASE_URL.$user->profileImage;?>" alt="">  -->
										<li>
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="text" placeholder="Search Twitter" class="search" />
											<div class="search-result">
											</div>
										</li>
									</ul>
								</div>
							</section>
							<section class="cards-wrapper">
								<div class="card-grid-space">
									<?php foreach (array_slice($NewsData->articles, 0, 1) as $News) { ?>
										<a class="card" href="<?php echo $News->url; ?>" style="--bg-img: url(<?php echo $News->urlToImage;?>)" >
											<div>
												<h1> <?php echo $News->title; ?> </h1>
												<p><?php echo $News->description; ?></p>
												<div class="date-a">Watch Trending News</div>
												<div class="date"><?php echo $News->publishedAt; ?></div>
												<div class="tags">
													<div class="tag">Author :<?php echo $News->author; ?> </div>
													<div class="tag">Source :<?php echo $News->source->name; ?> </div>
												</div>
											</div>
										</a>
										<?php } ?>
								</div>
								<!-- https://images.unsplash.com/photo-1520839090488-4a6c211e2f94?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=38951b8650067840307cba514b554ba5&auto=format&fit=crop&w=1350&q=80 -->
							</section>
							<!--Tweet SHOW WRAPPER-->
							<div class="tweets">
								<!--==TRENDS==-->
								<div class="trend-wrapper">
									<div class="trend-inner">
										<div class="trend-title">
											<!-- <h3>Trends</h3> -->
										</div>
										<!-- trend title end-->
										<?php $getFromT->trends(); ?>
									</div>
									<!--TREND INNER END-->
									<div class="clear_fix" style="display:none; height:55px; width:100%;"></div>
								</div>
								<!--TRENDS WRAPPER ENDS-->
							
							</div>
							<div class="loading-div">
								<img id="loader" src="assets/images/loading.svg" style="display: none;" />
							</div>
							<!--TWEETS SHOW WRAPPER-->
							<div class="float-tweet" id="float-tweet">
								<i class="fa fa-leaf"></i>
							</div>
							<div class="popupTweet"></div>
							<!--Tweet END WRAPER-->
							<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/custome-complete-js.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/like.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/retweet.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popuptweets.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/delete.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/comment.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popupForm.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/messages.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/postMessage.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/notification.js"></script>
							<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popupEditForm.js"></script>
						</div><!-- in left wrap-->
					</div><!-- in center end -->
					<div class="in-right">
						<div class="in-right-wrap">
							<!--Who To Follow-->
							<!--WHO_TO_FOLLOW HERE-->
							<?php $getFromF->whoToFollow($user_id, $user_id); ?>
							<!--Who To Follow-->
						</div><!-- in left wrap-->
	
					</div><!-- in right end -->
					<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/follow.js"></script>
				</div>
				<!--in full wrap end-->
			</div><!-- in wrappper ends-->
		</div><!-- inner wrapper ends-->
	</div><!-- ends wrapper -->
	<?php 
                include 'includes/entities/bottom-nav.php';
            ?>
</body>

</html>