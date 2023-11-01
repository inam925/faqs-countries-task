<?php get_header(); ?>
	<main>
		<div class="gft-landing-page">
			<div class="">
				<h1>Hello, I'm Inam Ul Haq</h1>
				<h2>A web developer currently specializing in the WordPress ecosystem, with expertise in crafting custom plugins and themes.</h2>
				<h2>
					<a target="_blank" href='https://github.com/inam925'>Github </a>/
					<a target="_blank" href='https://www.linkedin.com/in/inam-ul-haq-a69200272/'>LinkedIn </a>/
					<a target="_blank" href="mailto:inam925@gmail.com"> Email </a>
				</h2>
			</div>
			<div class="is-gravatar">
				<?php 
				$admin_email = get_option('admin_email');
				echo get_avatar( $admin_email, 100 ); 
				?>
			</div>
		</div>
		<br><hr>
		<div class="gft-columns">
			<div class="gft-blog">
				<h3> Blog</h3>
				<ul>
				<?php 
				if ( is_home() || is_archive() ) {
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post(); 
							?>
					<li>
						<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
						<span style="color:grey;"> -  <?php echo get_the_date(); ?></span>
					</li>
					<?php 
						endwhile;
				endif; } 
				?>
				</ul>
			</div>

			<?php if ( is_active_sidebar( 'gft-global-sidebar' ) ) : ?>
			<div id="secondary" class="gft-widget" role="complementary">
				<?php dynamic_sidebar( 'gft-global-sidebar' ); ?>
			</div>
			<?php endif; ?>
		</div>

		<br><hr>
		<?php if ( is_active_sidebar( 'gft-global-footer' ) ) : ?>
		<div id="secondary" class="gft-footer-links" role="complementary">
			<?php dynamic_sidebar( 'gft-global-footer' ); ?>
		</div>
		<?php endif; ?>
	</main>
<?php get_footer(); ?>
