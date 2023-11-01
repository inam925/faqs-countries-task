<?php
/**
 * Frontend functionality.
 *
 * @package FAQ_Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Fs_FAQ_Shortcode_Front' ) ) {
	/**
	 * Class responsible for handling front-end functionality of the plugin.
	 */
	class Fs_FAQ_Shortcode_Front {
		/**
		 * Hooks into necessary actions to set up frontend functionality.
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'fs_frontend_enqueue_scripts' ) );

			$faq_args = array(
				'post_type'      => 'fs_faq_cpt',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'order'          => 'ASC',
			);
			$faq_ids  = get_posts( $faq_args );
			if ( $faq_ids ) {
				foreach ( $faq_ids as $faq_id ) {
					$faq_shortcode = get_post_meta( $faq_id, 'fs_faq_shortcode', true );

					add_shortcode(
						$faq_shortcode,
						function () use ( $faq_id ) {
							ob_start();
							$this->fs_faq_shortcode( $faq_id );
							$output = ob_get_contents();
							ob_end_clean();
							return $output;
						}
					);
				}
			}
		}

		/**
		 * Enqueues the necessary CSS and JavaScript files for the Frontend.
		 */
		public function fs_frontend_enqueue_scripts() {
			wp_enqueue_style( 'fs-front-style', FS_SHORTCODE_URL . '/assets/css/fs-faq-shortcode-front.css', array(), '1.0.0' );
		}

		/**
		 * Processes each found shortcode and replaces it with its corresponding output.
		 *
		 * @param int $faq_id Id of the FAQs.
		 * @return string The content with processed shortcodes replaced.
		 */
		public function fs_faq_shortcode( $faq_id ) {
			$faq_data = get_post_meta( $faq_id, 'faq_data', true );
			if ( empty( $faq_data ) || ! is_array( $faq_data ) ) {
				return;
			}
			?>
			<div class="fs-faq-container">
			<?php

			foreach ( $faq_data as $key => $data ) {
				$question = esc_html( $data['question'] );
				$answer   = esc_html( $data['answer'] );
				?>
				<div class="fs-faq-item">
					<h3 class="fs-faq-question"><?php echo esc_html( $question ); ?></h3>
					<div class="fs-faq-answer"><?php echo esc_html( $answer ); ?></div>
				</div>
				<?php
			}
			?>
			</div>
			<?php
		}
	}
	new Fs_FAQ_Shortcode_Front();
}
