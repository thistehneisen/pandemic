<?php
require_once 'library/init.php';
cleanImages();
if (!empty($_GET['delete']) && is_numeric($_GET['delete'])) {
	$remove = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->classifieds, $_GET['delete']);
	if ($remove['user'] == $_SESSION['facebook']['id']) {
		$db->queryf("DELETE FROM %s WHERE `id`='%d' AND `user`='%d'", $db->classifieds, $_GET['delete'], $_SESSION['facebook']['id']);
		header('Location: ' . $settings['fullAddress']);
	}
}
if (!empty($_GET['id']) && is_numeric($_GET['id']))
	$classified = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->classifieds, $_GET['id']);
if (!empty($_GET['category']) && in_array($_GET['category'], array_keys($settings['categories'])))
    $jscategory = $_GET['category'];
?>
<!DOCTYPE html>
<html>
<!--
Interested in the code?
Write us on info@pandemic.lv and become one of our team.
-->
<head>
	<meta charset="UTF-8" />
	<title>Pandemic.lv — Quality information from neighbors.</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta name="keywords" content="pandemic, corona, covid, covid-19, covid19, kovid">
	<meta name="description" content="Find information about the pandemic situation, around you, from the people — besides you.">
	<meta property="og:type" content="website">
<?php if (empty($classified)) { ?>
	<meta property="og:url" content="<?php print($settings['fullAddress'])?>">
	<meta property="og:title" content="Pandemic.lv — Quality information from neighbors.">
	<meta property="og:description" content="Find information about the pandemic situation, around you, from the people — besides you.">
	<meta property="og:image" content="<?php print($settings['fullAddress'])?>assets/images/share.png">
<?php } else {
	$image = json_decode($classified['photos'], true);
	if (!empty($image)) {
?>
	<meta property="og:url" content="<?php print($settings['fullAddress'])?>?id=<?php print($classified['id'])?>">
<?php } else { ?>
	<meta property="og:image" content="<?php print($settings['fullAddress'])?>assets/images/share.png">
<?php } ?>
	<meta property="og:title" content="<?php print(htmlspecialchars($classified['title']))?>">
	<meta property="og:description" content="<?php print(htmlspecialchars($classified['description']))?>">
	<meta property="og:image" content="<?php print($settings['fullAddress'].$settings['upload']['path']['images'].$image[0]['name'].'.'.$image[0]['ext'])?>">
<?php } ?>
	<meta property="fb:app_id" content="<?php print($settings['facebook']['app']['id'])?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msapplication-TileColor" content="#a62f2e">
	<meta name="theme-color" content="#a62f2e">
	<script type='text/javascript' src="<?php print($settings['fullAddress'])?>vendor/needim/noty/lib/noty.min.js"></script>
	<script type='text/javascript' src="<?php print($settings['fullAddress'])?>assets/.js/chart.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>vendor/needim/noty/lib/noty.css" />
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>assets/style/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>assets/style/info-window.css" />
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>assets/style/baguetteBox.min.css" />

	<script type="text/javascript" src="//maps.google.com/maps/api/js?libraries=geometry&amp;key=AIzaSyAFvIwqQmwrhlPhxG_el4wxikwbVbplSXo"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-migrate-3.1.0.min.js"></script>

	<link rel="icon" type="image/png" href="<?php print($settings['fullAddress'])?>assets/images/icon.png" />
</head>
<body>
	<?php /* Facebook JS Connection */ ?>
	<script type="text/javascript">
		window.fbAsyncInit = function() {
			FB.init({
				appId      : <?php print(json_encode($settings['facebook']['app']['id']))?>,
				xfbml      : true,
				cookie		 : true,
				version    : 'v2.8'
			});

			/* Facebook */
			FB.getLoginStatus(function(response) {
				statusChangeCallback(response);
			});
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<script id="marker-content-template" type="text/x-handlebars-template">
		<section class="custom-content">
			<h1 class="custom-header">
				{{title}}
				<small>{{{subtitle}}}</small>
			</h1>
			<div class="custom-body">{{{body}}}</div>
			<div class="gallery">{{{gallery}}}</div>
			<div class="unique-url text">
				<h5>URL:</h5>
				<input type="text" value="{{url}}" />
			</div>
		</section>
	</script>

	<header class="header">
		<div class="container">
			<a class="logo" href="<?php print($settings['fullAddress'])?>">
				<?php include('assets/images/corona.svg'); ?>
				<span>pandemic.lv</span>
			</a>
			<nav>
				<?php if (!empty($_SESSION['facebook']['id'])) { ?><span><a rel="leanModal" href="#add-ad">Add your area</a></span><?php } ?>
				<span><a rel="leanModal" href="#about">About project</a></span>
                <span class="dd">
                    <a href="#">Categories</a>
                    <ul class="dropdown">
                        <?php foreach($settings['categories'] as $key => $category) { ?><li><a href="<?php print($settings['fullAddress'])?>?category=<?php print($key)?>"><?php print($category)?><span></span></a></li><?php } ?>
					</ul>
                </span>
				<?php if (empty($_SESSION['facebook']['id'])) { ?>
				<span><a href="#" class="login-fb"><?php include('assets/images/ico/facebook-social-symbol.svg'); ?> Log in</a></span>
				<?php } else { ?>
				<span><a href="?logout" onclick="FB.logout();">Log out</a></span>
				<?php } ?>
			</nav>
			<a href="#" class="nav-toggle hidden-md hidden-lg"><hr><hr><hr></a>
		</div>
	</header>

	<div id="chat_holder">
		<span class="chat_item">Corona</span>
	</div>

	<div id="modals">
		<div class="lean-modal modal-sm" id="add-ad">
			<div class="modal-container">
				<div class="modal-wrapper">
					<div class="modal-header">
						<span>Add an area</span>
						<a href="#" class="modal_close close-modal">×</a>
					</div>
					<div class="modal-content bodytext">
						<div class="form">
							<div class="text">
								<label for="title">Title <span>(max. 80 symbols)</span></label>
								<input type="text" id="title" name="title" placeholder="Title" maxlength="80" value="" required="">
							</div>

                            <div class="select">
								<label for="category">Category</label>
                                <select name="category" id="category">
                                    <option>Choose one</option>
                                    <?php foreach ($settings['categories'] as $key => $category) { ?><option value="<?php print($key)?>"><?php print($category)?></option><?php } ?>
                                </select>
							</div>

							<div class="input textarea">
								<label for="description">Description <span>(max. 360 symbols)</span></label>
								<textarea id="description" name="description" rows="5" placeholder="Description" maxlength="360"></textarea>
							</div>

							<div class="img-upload">
								<label>Choose images</label>
								<form id="img-upload" action="library/upload.php" class="dropzone" enctype="multipart/form-data">
									<div class="fallback file">
										<input name="file" type="file" />
									</div>
								</form>
							</div>

							<div class="input-row">

								<?php /*<div class="input-col lg-3-12">
									<div class="text">
										<label for="price">Price</label>
										<input type="number" id="price" name="price" min="0" step="1.00" placeholder="Price" value="0.00" required="">
									</div>
								</div>*/ ?>

								<div class="input-col lg-4-12">
									<div class="text">
										<label for="phone">Phone</label>
										<input type="text" id="phone" name="phone" placeholder="Phone" value="" required="">
									</div>
								</div>

								<div class="input-col lg-5-12">
									<div class="text">
										<label for="email">E-mail</label>
										<input type="text" id="email" name="email" placeholder="E-mail" value="" required="">
									</div>
								</div>

							</div>


							<div class="checkbox">
								<div>
									<input type="checkbox" id="signup-agree" name="signup-agree" value="1"><label for="signup-agree"><span></span>I accept the <a rel="leanModal" href="#terms-and-conditions">terms and conditions</a></label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="input-row">
							<div class="input-col lg-1-2">
								<a class="button outline gray lg-1-1 close-modal" href="#"><span>Cancel</span></a>
							</div>
							<div class="input-col lg-1-2">
								<a class="button filled blue disabled confirm lg-1-1" id="post-the-ad" href="#"><span>Create</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="lean-modal modal-lg" id="about">
			<div class="modal-container">
				<div class="modal-wrapper">
					<div class="modal-header">
						<a href="#" class="modal_close close-modal">×</a>
					</div>
					<div class="modal-content bodytext">
						<?php include('about.php'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="lean-modal modal-lg" id="terms-and-conditions">
			<div class="modal-container">
				<div class="modal-wrapper">
					<div class="modal-header">
						<a href="#sign-up" rel="leanModal" class="back"><?php include('assets/images/ico/arrow-left.svg'); ?> <span>back</span></a>
						<a href="#" class="modal_close close-modal">×</a>
					</div>
					<div class="modal-content bodytext">
						<?php include('terms.php'); ?>
					</div>
					<div class="modal-footer">
						<a class="button filled blue agree" rel="leanModal" href="#add-ad"><span>Agree</span></a>
						<a class="button outline gray disagree" rel="leanModal" href="#add-ad"><span>Disagree</span></a>
					</div>
				</div>
			</div>
		</div>

		<div id="lean-mask"></div>
	</div>
	<div class="map-ct">
	<div id="map">
		&nbsp;
	</div>
	</div>
<a class="button filled green" href="#" style="display: none;" id="save-location"><span>Ready!</span></a>
<div class="mask">&nbsp;</div>
<footer>
	<input type="text" id="chatbox" placeholder="Enter your message…" />
</footer>
<?php /* Settings */ ?>
<script type="text/javascript">
	fullAddress = <?php print(json_encode($settings['fullAddress']))?>;
	openMarker = <?php print(!empty($classified['id']) ? $classified['id'] : '""')?>;
	category = "<?php print($jscategory)?>";
	<?php if (!empty($_SESSION['facebook']['id'])) { ?>fbId = <?php print($_SESSION['facebook']['id'])?>;<?php } ?>
</script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/gmaps.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/info-window.min.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/dropzone.min.js"></script>
<script type='text/javascript' src="<?php print($settings['fullAddress'])?>assets/scripts/fastclick.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/baguetteBox.min.js"></script>
<script type='text/javascript' src="<?php print($settings['fullAddress'])?>assets/scripts/pandemic.js"></script>
</body>
</html>
