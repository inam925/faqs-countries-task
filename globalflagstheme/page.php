<?php get_header(); ?>

	<section id="main">
		<h1 id="title"><?php the_title(); ?></h1>
		<div>
		<?php 
		if ( is_page()) {
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post(); 
					?>
					<article id="content">
						<?php
						the_content();
						?>
						<h1><?php the_title(); ?></h1>
						<?php if ( get_field('gft_countries' ) ) : ?>
						<h2>
							<?php 
							echo get_field('gft_countries'); 
							?>
						</h2>
						<?php 
						endif; 
						wp_link_pages();
						?>
					</article>
					<?php 
				endwhile;
		endif; } 
		?>
		</div>
	</section>

	<aside id="meta">
		<section>
			<h4 id="date"> <?php echo get_the_date('l - F, j Y'); ?> </h4>
		</section>
	</aside>

	<hr><br>
	<a href="/">&lt;&lt; Home Page</a>

<?php get_footer(); ?>
