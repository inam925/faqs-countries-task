<?php get_header(); ?>

	<section id="main">
		<?php if ( have_posts() ) : ?>
		<div>
			<?php the_archive_title( '<h1 id="title">', '</h1>' ); ?>
			<ul>
				<?php 
				while ( have_posts() ) :
			the_post(); 
					?>
					<li>
					<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
					<span style="color:grey;"> -  <?php echo get_the_date(); ?></span>
					</li>
				<?php 
				endwhile;
else :
		get_template_part('content', 'none'); 
	?>
			</ul>
		</div>
		<?php endif; ?>
	</section>

<?php get_footer(); ?>
