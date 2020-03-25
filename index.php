<?php
require_once 'library/init.php';
cleanImages();

if (!empty($_GET['delete']) && is_numeric($_GET['delete'])) {
	$remove = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->table('places'), $_GET['delete']);
	if ($remove['user'] == $_SESSION['facebook']['id']) {
		$db->queryf("DELETE FROM %s WHERE `id`='%d' AND `user`='%d'", $db->table('places'), $_GET['delete'], $_SESSION['facebook']['id']);
		header('Location: ' . $settings['fullAddress']);
	}
} else if (!empty($_GET['id']) && is_numeric($_GET['id']))
	$place = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->table('places'), $_GET['id']);
else if (!empty($_GET['category']) && in_array($_GET['category'], array_keys($settings['categories'])))
    $jscategory = $_GET['category'];
?>
<!DOCTYPE html>
<html>
<!--
Interested in the code?
Write us on info@<?php print($settings['host'])?> and become one of our team.
-->
<head>
	<meta charset="UTF-8" />
	<title>Pandemic <?php print($settings['country'])?> — Connecting you with neighbors, volunteers and information.</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta name="keywords" content="pandemic, corona, covid, covid-19, covid19, kovid, baltics, latvia, lithuania, estonia">
	<meta name="description" content="In the time of crisis, you're not alone. Pandemic <?php print($settings['country'])?> is connecting you with neighbors, volunteers and places.">
	<meta property="og:type" content="website">
<?php if (empty($place)) { ?>
	<meta property="og:url" content="<?php print($settings['fullAddress'])?>">
	<meta property="og:title" content="Pandemic <?php print($settings['country'])?>">
	<meta property="og:description" content="Connecting you with neighbors, volunteers and places. Providing you with the official information about the state of pandemics.">
	<meta property="og:image" content="<?php print($settings['fullAddress'])?>assets/images/share.png?covid">
<?php } else {
	$image = json_decode($place['photos'], true);
	if (!empty($image)) {
?>
	<meta property="og:url" content="<?php print($settings['fullAddress'])?>?id=<?php print($place['id'])?>">
<?php } else { ?>
	<meta property="og:image" content="<?php print($settings['fullAddress'])?>assets/images/share.png?covid">
<?php } ?>
	<meta property="og:title" content="<?php print(htmlspecialchars($place['title']))?>">
	<meta property="og:description" content="<?php print(htmlspecialchars($place['description']))?>">
	<meta property="og:image" content="<?php print($settings['fullAddress'].$settings['upload']['path']['images'].$image[0]['name'].'.'.$image[0]['ext'])?>">
<?php } ?>
	<meta property="fb:app_id" content="<?php print($settings['facebook']['app']['id'])?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="msapplication-TileColor" content="#00aeef">
	<meta name="theme-color" content="#00aeef">
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>assets/style/style.css?v2" />
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>assets/style/chat.css" />
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>assets/style/info-window.css" />
	<link rel="stylesheet" type="text/css" href="<?php print($settings['fullAddress'])?>assets/style/baguetteBox.min.css" />
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

	<script type="text/javascript" src="//maps.google.com/maps/api/js?libraries=geometry&amp;key=AIzaSyAFvIwqQmwrhlPhxG_el4wxikwbVbplSXo"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type='text/javascript' src="<?php print($settings['fullAddress'])?>assets/scripts/chart.js"></script>
	<script type='text/javascript' src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

	<link rel="icon" type="image/png" href="<?php print($settings['fullAddress'])?>assets/images/icon.png?covid" />
</head>
<body>
	<div id="preloader">
		<h1>Pandemic <strong><?php print($settings['country'])?></strong></h1>
		<div class="cube-wrapper">
			<div class="cube-folding">
				<span class="leaf1"></span>
				<span class="leaf2"></span>
				<span class="leaf3"></span>
				<span class="leaf4"></span>
			</div>
			<span class="loading" id="preload-status">Fetching <strong>all</strong> data…</span>
		</div>
		<div class="preloader-footer"><strong><a href="#terms-and-conditions">Terms & Conditions</a></strong></div>
	</div>

	<?php /* Facebook JS Connection */ ?>
	<script type="text/javascript">
		window.fbAsyncInit = () => {
			FB.init({
				appId:  <?php print(json_encode($settings['facebook']['app']['id']))?>,
				cookie: true,
				status: true,
				xfbml: true,
				version: 'v3.2'
			});
			FB.getLoginStatus();
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
		<div class="custom-img" person_id="{{{person_id}}}" style="background-image: url({{{img}}})"></div>
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

	<header class="header preload-hide">
		<div class="container">
			<a class="logo" href="<?php print($settings['fullAddress'])?>">
				<?php include('assets/images/corona.svg'); ?>
				<span><?php print($settings['host'])?></span>
			</a>
			<nav>
				<span class="dd">
					<a href="#">Baltics</a>
					<ul class="dropdown">
						<li><a href="<?php print($fullAddress)?>"><?php print($settings['country'])?></a></li>
						<?php
						foreach ($settings['hosts'] as $host => $country) {
							if ($country === $settings['country']) continue;
							print('<li><a href="https://'.$host.'/" title="Pandemics '.$country.'">'.$country.'</a></li>');
						}
						?>
					</ul>
				</span>
				<span><a href="https://global.pandemic.lv/" id="global-data">Global</a></span>
				<?php if (!empty($_SESSION['facebook']['id'])) { ?>
					<span><a rel="leanModal" href="#add-ad">Create service</a></span>
					<span><a rel="leanModal" href="#profile">Profile</a></span>
				<?php } ?>
				<span><a rel="leanModal" href="#about">About</a></span>
                <span class="dd">
                    <a href="#">Categories</a>
                    <ul class="dropdown">
                        <?php foreach($settings['categories'] as $key => $category) { ?><li><a href="<?php print($settings['fullAddress'])?>?category=<?php print($key)?>"><span><?php print($category)?></span></a></li><?php } ?>
					</ul>
                </span>
                <span class="dd">
                    <a href="#">Settings</a>
                    <ul class="dropdown">
						<li><a href="#" onclick="pandemicSettings('toggle', 'data', $(this));"><span><strong>&#10004;</strong> Display quarantines</span></a></li>
						<li><a href="#" onclick="pandemicSettings('toggle', 'people', $(this));"><span><strong>&#10004;</strong> People locations</span></a></li>
						<li><a href="#" onclick="pandemicSettings('toggle', 'places', $(this));"><span><strong>&#10004;</strong> Show places</span></a></li>
					</ul>
				</span>
				<?php if (empty($_SESSION['facebook']['id'])) { ?>
				<span><a href="#" class="login-fb"><?php include('assets/images/ico/facebook-social-symbol.svg'); ?> Log In</a></span>
				<?php } else { ?>
				<span><a href="?logout" onclick="FB.logout();">Log out</a></span>
				<?php } ?>
			</nav>
			<a href="#" class="nav-toggle hidden-md hidden-lg"><hr><hr><hr></a>
		</div>
	</header>

	<a rel="leanModal" href="#legends" id="openLegends" style="display: none;">&nbsp;</a>
	<div id="modals">
		<div class="lean-modal modal-sm" id="legends">
			<div class="modal-container">
				<div class="modal-wrapper">
					<div class="modal-header">
						<a href="#" class="modal_close close-modal">×</a>
					</div>
					<div class="modal-content bodytext">
						<h2>Point meanings</h2>
						<ul>
							<li><img src="<?php print($fullAddress)?>assets/images/markers/red.png" alt="Red locations" style="width: 15px;" /> <span style="color: #ff0000; font-weight: bold;">Red locations</span> are data defining where someone that's tested COVID-19 positive, has originated from. Not their current or actual location.</li>
							<li><img src="<?php print($fullAddress)?>assets/images/markers/green.png" alt="Green locations" style="width: 15px;" /> <span style="color: #00ff54; font-weight: bold;">Green locations</span> are just people that are using this platform. It's anyone that has authorized their Facebook profile, and shared their location. These points are not defining their health status in any way. You can change this information in "<em>Profile</em>" section, once authorized.</li>
							<li><img src="<?php print($fullAddress)?>assets/images/markers/blue.png" alt="Blue locations" style="width: 15px;" /> <span style="color: #00aeef; font-weight: bold;">Blue locations</span> are services, volunteers, anything that every authorized user can publish on the map using the "<em>Create service</em>" section.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

<?php
if (!empty($_SESSION['facebook']['id'])) {
	$userData = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->table('users'), $_SESSION['facebook']['id']);
?>
		<div class="lean-modal modal-sm" id="add-ad">
			<div class="modal-container">
				<div class="modal-wrapper">
					<div class="modal-header">
						<span>Add an service</span>
						<a href="#" class="modal_close close-modal">×</a>
					</div>
					<div class="modal-content bodytext">
						<div class="form">
							<div class="text">
								<label for="title">Title <span>(max. 25 symbols)</span></label>
								<input type="text" id="title" name="title" placeholder="Title" maxlength="25" value="" required="">
							</div>

                            <div class="select">
								<label for="category">Category</label>
                                <select name="category" id="category">
                                    <option>Choose one</option>
                                    <?php foreach ($settings['categories'] as $key => $category) { ?><option value="<?php print($key)?>"><?php print($category)?></option><?php } ?>
                                </select>
							</div>

							<div class="input textarea">
								<label for="description">Description <span>(max. 400 symbols)</span></label>
								<textarea id="description" name="description" rows="5" placeholder="Description" maxlength="400"></textarea>
							</div>

							<div class="img-upload">
								<label>Pick some pictures</label>
								<form id="img-upload" action="library/upload.php" class="dropzone" enctype="multipart/form-data">
									<div class="fallback file">
										<input name="file" type="file" />
									</div>
								</form>
							</div>

							<div class="input-row">
								<div class="input-col lg-4-12">
									<div class="text">
										<label for="phone">Phone <small>(optional)</small></label>
										<input type="text" id="phone" name="phone" placeholder="Phone number">
									</div>
								</div>

								<div class="input-col lg-4-12">
									<div class="text">
										<label for="email">E-mail <small>(optional)</small></label>
										<input type="text" id="email" name="email" placeholder="E-mail address">
									</div>
								</div>

								<div class="input-col lg-4-12">
									<div class="text">
										<label for="email">Website <small>(optional)</small></label>
										<input type="text" id="website" name="website" placeholder="https://www.">
									</div>
								</div>
							</div>

							<div class="checkbox">
								<div>
									<input type="checkbox" id="signup-agree" name="signup-agree" value="1"><label for="signup-agree"><span></span>I have read and accept the <a rel="leanModal" href="#terms-and-conditions">Terms <em>&</em> Conditions</a></label>
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
								<a class="button filled blue disabled confirm lg-1-1" id="post-the-ad" href="#"><span>Continue with location &rarr;</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="lean-modal modal-sm" id="profile">
			<div class="modal-container">
				<div class="modal-wrapper">
					<div class="modal-header">
						<span>Your profile</span>
						<a href="#" class="modal_close close-modal">×</a>
					</div>
					<div class="modal-content bodytext">
						<div class="form">
							<div class="text">
								<label for="nickname">Pseudonym <span>(max. 12 symbols)</span></label>
								<input type="text" id="nickname" name="nickname" placeholder="Choose a nickname" maxlength="12" value="<?php print(htmlspecialchars($userData['pseudo']))?>">
							</div>

							<div class="text">
								<label for="status">Status message <span>(max. 40 symbols)</span></label>
								<input type="text" id="status" name="status" placeholder="Let us know…" maxlength="40" value="<?php print(htmlspecialchars($userData['status']))?>">
							</div>

                            <div class="select">
								<label for="profilecat">Category</label>
                                <select name="profilecat" id="profilecat">
                                    <option>Choose one</option>
                                    <?php foreach ($settings['categories'] as $key => $category) { ?><option value="<?php print($key)?>"<?php if ($userData['category'] === $key) print(' selected')?>><?php print($category)?></option><?php } ?>
                                </select>
							</div>

                            <div class="select">
								<label for="mapdisplay">Display</label>
                                <select name="mapdisplay" id="mapdisplay">
                                    <option value="1"<?php if ($userData['display'] === '1') print(' selected')?>>Yes, show me on map</option>
									<option value="0"<?php if ($userData['display'] === '0') print(' selected')?>>No, hide me from the map</option>
                                </select>
							</div>

							<div class="input textarea">
								<label for="profiledesc">Description <span>(max. 360 symbols)</span></label>
								<textarea id="profiledesc" name="profiledesc" rows="5" placeholder="Description" maxlength="360"><?php print(htmlspecialchars($userData['description']))?></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="input-row">
							<div class="input-col lg-1-2">
								<a class="button outline gray lg-1-1 close-modal" href="#"><span>Cancel</span></a>
							</div>
							<div class="input-col lg-1-2">
								<a class="button filled blue confirm lg-1-1" id="save-profile" href="#"><span>Save profile</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php } ?>

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
						<a class="button filled blue agree" rel="leanModal" href="#add-ad"><span>Accepting fully</span></a>
						<a class="button outline gray disagree" onclick="alert('Unfortunately, we have to seperate our ways, but we just want to let you know…'); return true;" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><span>Disagree</span></a>
					</div>
				</div>
			</div>
		</div>

		<div id="lean-mask"></div>
	</div>

	<div class="map-ct preload-hide">
		<div id="map" class="preload-hide">
			&nbsp;
		</div>
	</div>
	<a class="button filled green" href="#" style="display: none;" id="save-location"><span><strong>Ready</strong> to publish!</span></a>
	<div class="mask">&nbsp;</div>

<?php if (isset($_GET['chat'])) { ?>

<!-- add chat loader details -->

<script type="text/javascript">

	function loadMessages(){
		req({a:'chat',m:'fetch', t:'p',r:'1'}, function(res) {
        	$('#subholder').html('');
        	if (res.msgs){
	        	for (var i = res.msgs.length - 1; i >= 0; i--) {
	        		$('#subholder').prepend('<div class="message sender'+ res.msgs[i].sender +'">'+ res.msgs[i].message +'</div>');
	        		console.log(res.msgs[i].sender);
	        	};
        	}
    	});
	}

	$( document ).ready(function() {

		var input = document.getElementById("chatholder");
		// Execute a function when the user releases a key on the keyboard
		input.addEventListener("keyup", function(event) {
		  // Number 13 is the "Enter" key on the keyboard
		  if (event.keyCode === 13) {
			  	req({a:'chat',m:'send', t:'p',r:'1',msg:$('#chatholder').val()}, function(res) {
			  		$('#subholder').append('<div class="message senderMe">'+ $('#chatholder').val() +'</div>');
			  		$('.typing-1').center();
			  		$('#chatholder').val("");
		    	});
		  }
		});

		loadMessages();

		setInterval(function(){
			$('.custom-content').unbind();
			$('.custom-content').find('.send-message-user').on( "click", function() {
				console.log($(this).parent().parent().parent().find('.custom-img').attr('person_id'));
				window.location.replace("/?chat=" + $(this).parent().parent().parent().find('.custom-img').attr('person_id'));
				//loadMessages($(this).find('.custom-img').attr('person_id'));
			});
		}, 1000);


		$( ".message" ).on( "click", function() {
			loadMessages();
		});
	});
</script>


<div class="center" id="chatbox">
  <div class="contacts">
    <i class="fas fa-bars fa-2x"></i>
    <h2>Rooms</h2>
    <div class="contact">
      <div class="pic rogers"></div>
      <div class="badge">0</div>
      <div class="name">Alvis Zaldis</div>
      <div class="message">Xyz ziņa viena divas</div>
    </div>
  </div>
  <div class="chat">
    <div class="contact bar">
      <div class="pic stark"></div>
      <div class="name" id="contact_source_name">
        
      </div>
      <div class="seen" id="contact_source_time">
        Today
      </div>
    </div>
    <div class="messages" id="chat">
      <div class="time">
        Time seperator for good look
      </div>
      <span id="subholder">
	  </span>
      <div class="message stark">
        <div class="typing typing-1"></div>
        <div class="typing typing-2"></div>
        <div class="typing typing-3"></div>
      </div>
    </div>
    <div class="input">
      <i class="fas fa-camera"></i><i class="far fa-laugh-beam"></i><input id="chatholder" placeholder="Type your message here!" type="text" /><i class="fas fa-microphone"></i>
    </div>
  </div>
</div>
<script type="text/javascript">
    // Chat
    var chat = document.getElementById('chat');
	chat.scrollTop = chat.scrollHeight - chat.clientHeight;
</script>
<?php } ?>

<footer class="preload-hide">
	<input type="text" id="chatbox" placeholder="Enter your message…" />
</footer>

<?php /* Settings */ ?>
<script type="text/javascript">
	fullAddress = <?php print(json_encode($settings['fullAddress']))?>;
	openPlace = <?php print($place['id'] ?? 'undefined')?>;
	category = "<?php print($jscategory)?>";
	country = <?php print(json_encode($settings['country']))?>;
	latitude = <?php print($settings['latitude'])?>;
	longitude = <?php print($settings['longitude'])?>;
	<?php if (!empty($_SESSION['facebook']['id'])) { ?>fbId = <?php print($_SESSION['facebook']['id'])?>;<?php } ?>
</script>

<script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.3/handlebars.min.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/gmaps.min.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/snazzy-info-window.min.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/dropzone.min.js"></script>
<script type="text/javascript" src="<?php print($settings['fullAddress'])?>assets/scripts/baguetteBox.min.js"></script>
<script type='text/javascript' src="<?php print($settings['fullAddress'])?>assets/scripts/pandemic.js?v2"></script>
</body>
</html>
