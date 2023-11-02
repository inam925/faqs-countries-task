<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />
	<meta name="google-site-verification" content="fN9pYp6C0mSy-0ChKXnAmCiGYu9tPKpfNUpaUdmPXYo" />
	<title>
		<?php
		if (is_home()) :
			bloginfo('name');
			?>
			|
		<?php
			echo bloginfo('description');
		endif;
		?>
		<?php wp_title('', true); ?>
	</title>
	<?php wp_head(); ?>
</head>

<body>
	<header>
		<nav class="gft-nav-container">
			<div>
			<?php
			wp_nav_menu(array(
				'theme_location' => 'gft-global-nav', // Use the registered menu location
				'container'      => false, // Remove the default container
				'menu_class'     => 'gft-nav-menu', // Add a CSS class for the menu
			));
			?>
			</div>
			<div id="gft-select-theme">
			<div onclick="setDarkMode(true)" id="gft-dark-button" class=""> 🌚 <span>Dark</span></div>
			<div onclick="setDarkMode(false)" id="gft-light-button" class="gft-is-hidden"> 🌝 <span>Light</span> </div>
			</div>
		</nav>
	</header>