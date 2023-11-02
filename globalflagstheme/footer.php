	<footer>
		<div class="gft-footer-field">
			<p class="gft-label">&copy;2023</p>
			<p class="gft-value">Made by Inam Ul Haq</p>
		</div>
		<?php
		if (in_array('advanced-custom-fields/acf.php', apply_filters('active_plugins', get_option('active_plugins')), true)) {
			?>
			<?php if (get_field('gft_address')) : ?>
				<?php
				$field = get_field_object('gft_address');
				?>
				<div class="gft-footer-field">
					<p class="gft-label"><?php echo esc_html($field['label']); ?></p>
					<p class="gft-value"><?php echo esc_html($field['value']); ?></p>
				</div>
			<?php endif; ?>
			<?php if (get_field('gft_contact')) : ?>
				<?php
				$field = get_field_object('gft_contact');
				?>
				<div class="gft-footer-field">
					<p class="gft-label"><?php echo esc_html($field['label']); ?></p>
					<p class="gft-value"><?php echo esc_html($field['value']); ?></p>
				</div>
			<?php endif; ?>
			<?php if (get_field('gft_site_logo')) : ?>
				<?php
				$field = get_field_object('gft_site_logo');
				?>
				<div class="gft-footer-field">
					<p class="gft-label"><?php echo esc_html($field['label']); ?></p>
					<img src="<?php echo esc_html($field['value']); ?>" class="gft-value">
				</div>
			<?php endif; ?>
		<?php
		} else {
			?>
			<div><?php echo esc_html__('The Advanced Custom Fields plugin is not active.', 'gft_textdomain'); ?> </div>
		<?php
		}
		?>
	</footer>
	<?php wp_footer(); ?>
	</body>

	</html>