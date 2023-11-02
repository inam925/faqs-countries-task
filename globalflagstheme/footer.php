	<footer>
		<div class="gft-footer-field">
		<p class="gft-label">&copy;2023</p>
		<p class="gft-value">Made by Inam Ul Haq</p>
		</div>
		<?php if (get_field('gft_address')) : ?>
			<?php
			$field = get_field_object('gft_address');
			?>
			<div class="gft-footer-field">
				<p class="gft-label"><?php echo $field['label']; ?></p>
				<p class="gft-value"><?php echo $field['value']; ?></p>
			</div>
		<?php endif; ?>
		<?php if (get_field('gft_contact')) : ?>
			<?php
			$field = get_field_object('gft_contact');
			?>
			<div class="gft-footer-field">
				<p class="gft-label"><?php echo $field['label']; ?></p>
				<p class="gft-value"><?php echo $field['value']; ?></p>
			</div>
		<?php endif; ?>
		<?php if (get_field('gft_site_logo')) : ?>
			<?php
			$field = get_field_object('gft_site_logo');
			?>
			<div class="gft-footer-field">
				<p class="gft-label"><?php echo $field['label']; ?></p>
				<img src="<?php echo $field['value']; ?>" class="gft-value">
			</div>
		<?php endif; ?>
	</footer>
	<?php wp_footer(); ?>
	</body>

	</html>