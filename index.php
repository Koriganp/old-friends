<!DOCTYPE html>
<html lang="en-US">
	<head>

		<!-- Metadata -->

		<meta charset="utf-8"/>
		<meta name="viewport" content="width = device-width, user-scalable = no, initial-scale = 1.0, maximum-scale = 1.0, minimum-scale = 1.0"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>

		<!-- Google Fonts -->

		<link href="https://fonts.googleapis.com/css?family=Julius+Sans+One|Raleway" rel="stylesheet"/>

		<!-- Bootstrap CSS -->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"/>

		<!-- Font Awesome -->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

		<!-- My CSS -->

		<link href="styles/main.css" rel="stylesheet"/>

		<!-- jQuery, Popper.js, Bootstrap JS -->

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

		<title>Sign-in/Sign-up Modal with password reset</title>
	</head>

	<!-- Main Content -->

	<body>

		<!-- Navbar -->

		<header>
			<nav class="navbar fixed-top navbar-expand-md navbar-light site-nav">
				<a class="navbar-brand brand-text" href="#"><img class="nav-icon space" src="images/KD.png"><strong> <span class="first-letter">K</span>origan Design</strong></a>
				<button class="navbar-toggler position-toggle" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarToggler">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="text-dark my-2" href="https://korigandesign.com" target="_blank">Home </a>
						</li>
						<li class="nav-item">
							<a class="text-dark my-2" href="https://korigandesign.com/services/index.php" target="_blank"> Services </a>
						</li>
						<li class="nav-item">
							<a class="text-dark my-2" href="https://korigandesign.com/about/index.php" target="_blank"> About </a>
						</li>
						<li class="nav-item">
							<a class="text-dark my-2" href="https://korigandesign.com/portfolio/index.php" target="_blank"> Portfolio </a>
						</li>
						<li class="nav-item">
							<a class="text-dark my-2" href="https://korigandesign.com/contact/index.php" target="_blank"> Contact </a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Empty Section -->

		<section>
			<div class="container">
				<div class="row">
					<div class="col justify-content-center">
						<div class="move-down">
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Sign-in/Sign-up Buttons -->

		<main>
			<div class="jumbotron bg-white mt-5">
				<h2 class="display-3">Hi James!!</h2>
				<p class="lead font-weight-bold">So here's what I've got so far as the functionality goes. I don't have a database set up for it yet, so I can't tell if it's talking to the backend, but this is what the front end part would look like. You can go <a href="https://github.com/Koriganp/old-friends" target="_blank">here</a> to check out my code.</p>
				<hr class="my-2">
				<p class="font-weight-bold">Here's your typical sign-in/sign-up options:</p>
				<h3>Korigan Payne</h3>
				<div class="ml-5 pl-5 cd-main-nav js-main-nav">
					<ul class="cd-main-nav__list js-signin-modal-trigger">
						<li class="btn-primary"><a class="text-light cd-main-nav__item cd-main-nav__item--signin" href="#" data-signin="login">Sign in</a> </li>
						<li class="btn-primary"><a class="text-light cd-main-nav__item cd-main-nav__item--signin btn-primary" href="#" data-signin="login">Sign up</a> </li>
					</ul>
				</div>
			</div>

			<!-- Entire Modal Form -->

			<div class="cd-signin-modal js-signin-modal">
				<div class="cd-signin-modal__container">
					<ul class="cd-signin-modal__switcher js-signin-modal-switcher js-signin-modal-trigger">
						<li><a href="#" data-signin="login" data-type="login">Sign in</a></li>
						<li><a href="#" data-signin="signup" data-type="signup">New account</a></li>
					</ul>

					<div class="cd-signin-modal__block js-signin-modal-block" data-type="login">
						<form class="cd-signin-modal__form mb-5">
							<p class="cd-signin-modal__fieldset">
								<label class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace" for="signin-email">E-mail</label>
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signin-email" type="email" placeholder="E-mail">
								<span class="cd-signin-modal__error">Error message here!</span>
							</p>

							<p class="cd-signin-modal__fieldset">
								<label class="cd-signin-modal__label cd-signin-modal__label--password cd-signin-modal__label--image-replace" for="signin-password">Password</label>
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signin-password" type="text"  placeholder="Password">
								<a href="#" class="cd-signin-modal__hide-password js-hide-password">Hide</a>
								<span class="cd-signin-modal__error">Error message here!</span>
							</p>

							<p class="cd-signin-modal__fieldset">
								<input type="checkbox" id="remember-me" checked class="cd-signin-modal__input ">
								<label for="remember-me">Remember me</label>
							</p>

							<p class="cd-signin-modal__fieldset">
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width" type="submit" value="Login">
							</p>
						</form>

						<p class="cd-signin-modal__bottom-message js-signin-modal-trigger mt-5"><a href="#" data-signin="reset">Forgot your password?</a></p>
					</div>

					<div class="cd-signin-modal__block js-signin-modal-block" data-type="signup"> <!-- sign up form -->
						<form class="cd-signin-modal__form">
							<p class="cd-signin-modal__fieldset">
								<label class="cd-signin-modal__label cd-signin-modal__label--username cd-signin-modal__label--image-replace" for="signup-username">Username</label>
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-username" type="text" placeholder="Username">
								<span class="cd-signin-modal__error">Error message here!</span>
							</p>

							<p class="cd-signin-modal__fieldset">
								<label class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace" for="signup-email">E-mail</label>
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-email" type="email" placeholder="E-mail">
								<span class="cd-signin-modal__error">Error message here!</span>
							</p>

							<p class="cd-signin-modal__fieldset">
								<label class="cd-signin-modal__label cd-signin-modal__label--password cd-signin-modal__label--image-replace" for="signup-password">Password</label>
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-password" type="text"  placeholder="Password">
								<a href="#" class="cd-signin-modal__hide-password js-hide-password">Hide</a>
								<span class="cd-signin-modal__error">Error message here!</span>
							</p>

							<p class="cd-signin-modal__fieldset">
								<input type="checkbox" id="accept-terms" class="cd-signin-modal__input ">
								<label for="accept-terms">I agree to the <a href="#">Terms</a></label>
							</p>

							<p class="cd-signin-modal__fieldset">
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding" type="submit" value="Create account">
							</p>
						</form>
					</div>

					<div class="cd-signin-modal__block js-signin-modal-block" data-type="reset"> <!-- reset password form -->
						<p class="cd-signin-modal__message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

						<form class="cd-signin-modal__form">
							<p class="cd-signin-modal__fieldset">
								<label class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace" for="reset-email">E-mail</label>
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="reset-email" type="email" placeholder="E-mail">
								<span class="cd-signin-modal__error">Error message here!</span>
							</p>

							<p class="cd-signin-modal__fieldset">
								<input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding" type="submit" value="Reset password">
							</p>
						</form>

						<p class="cd-signin-modal__bottom-message js-signin-modal-trigger"><a href="#" data-signin="login">Back to log-in</a></p>
					</div>
					<a href="#" class="cd-signin-modal__close js-close">Close</a>
				</div>
			</div>

		</main>
		<footer class="container-fluid">
			<div class="fixed-bottom justify-content-center">
				<p class="text-center mt-2">&copy; 2018 Korigan Design</p>
			</div>
		</footer>

		<!-- JavaScript -->

		<script src="js/placeholders.min.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>

