<?php
/**
 * Admin functionality.
 *
 * @package FAQ_Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Fs_FAQ_Shortcode_Admin' ) ) {
	/**
	 * Class responsible for administration interface.
	 */
	class Fs_FAQ_Shortcode_Admin {
		/**
		 * Hooks into necessary actions to set up admin functionality.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'fs_enqueue_custom_admin_scripts' ) );
			add_action( 'add_meta_boxes_fs_faq_cpt', array( $this, 'fs_faq_shortcode_meta_fields' ) );
			add_action( 'save_post_fs_faq_cpt', array( $this, 'save_faq_fields' ) );

			add_filter( 'manage_edit-fs_faq_cpt_columns', array( $this, 'fs_faq_cpt_modify_columns' ) );
			add_action( 'manage_fs_faq_cpt_posts_custom_column', array( $this, 'fs_faq_cpt_display_shortcode_column' ), 10, 2 );
		}

		/**
		 * Enqueues admin styles and scripts.
		 */
		public function fs_enqueue_custom_admin_scripts() {
			global $current_screen;
			if ( ( 'post' === $current_screen->base && 'fs_faq_cpt' === $current_screen->post_type ) ||
				( 'post' === $current_screen->base && 'fs_faq_cpt' === $current_screen->post_type && 'add' === $current_screen->action )
			) {
				wp_enqueue_style( 'fs-admin-style', FS_SHORTCODE_URL . '/assets/css/fs-faq-shortcode-admin.css', array(), '1.0.0' );
				wp_enqueue_script( 'fs-admin-script', FS_SHORTCODE_URL . '/assets/js/fs-faq-shortcode-admin.js', array( 'jquery' ), '1.0', true );
			}
		}

		/**
		 * Modify the columns in the admin panel.
		 *
		 * @param array $columns An array of existing columns.
		 * @return array Modified array of columns.
		 */
		public function fs_faq_cpt_modify_columns( $columns ) {
			// Add Shortcode column.
			$columns['faq_shortcode'] = 'Shortcode';

			$new_column_order = array(
				'cb'            => $columns['cb'], // Checkbox column.
				'title'         => $columns['title'], // Title column.
				'faq_shortcode' => $columns['faq_shortcode'], // Shortcode column.
				'date'          => $columns['date'], // Date column.
			);
			return $new_column_order;
		}

		/**
		 * Displays the shortcode value in the custom column.
		 *
		 * @param string $column The column being displayed.
		 * @param int    $post_id The current post ID.
		 */
		public function fs_faq_cpt_display_shortcode_column( $column, $post_id ) {
			if ( 'faq_shortcode' === $column ) {
				$shortcode = '[' . get_post_meta( $post_id, 'fs_faq_shortcode', true ) . ']';
				echo esc_html( $shortcode );
			}
		}

		/**
		 * Adds meta boxes.
		 */
		public function fs_faq_shortcode_meta_fields() {
			add_meta_box(
				'faq_fields',
				'FAQ Fields',
				array( $this, 'fs_render_faq_fields' ),
				'fs_faq_cpt'
			);
		}

		public function fs_render_faq_fields( $post ) {
			$faq_fields = get_post_meta( $post->ID, 'faq_data', true );
			wp_nonce_field( 'fs_nonce_value', 'fs_nonce_value_field' );

			// Initialize an empty array if no data is found
			if ( empty( $faq_fields ) || ! is_array( $faq_fields ) ) {
				$faq_fields = array(
					array(
						'question' => '',
						'answer'   => '',
					),
				);
			}
			?>
			<div class="fs-faq-fields">
				<?php
				foreach ( $faq_fields as $key => $data ) {
					?>
					<div class="fs-faq-field">
						<label class="fs-faq-label" for="faq_question_<?php echo esc_attr( $key ); ?>"><?php echo esc_html__( 'Question:', 'faq_textdomain' ); ?></label>
						<input class="fs-faq-input" type="text" id="fs-faq_question_<?php echo esc_attr( $key ); ?>" name="faq_data[<?php echo esc_attr( $key ); ?>][question]" value="<?php echo esc_attr( $data['question'] ); ?>" required>
						<br><br>
						<label class="fs-faq-label" for="faq_answer_<?php echo esc_attr( $key ); ?>"><?php echo esc_html__( 'Answer:', 'faq_textdomain' ); ?></label>
						<textarea class="fs-faq-textarea" id="fs-faq_answer_<?php echo esc_attr( $key ); ?>" name="faq_data[<?php echo esc_attr( $key ); ?>][answer]" required><?php echo esc_textarea( $data['answer'] ); ?></textarea>
						<a class="fs-remove-faq-field" href="#"><?php echo esc_html__( 'Remove', 'faq_textdomain' ); ?></a>
					</div>
					<?php
				}
				?>
			</div>
			<button class="button fs-add-faq-field"><?php echo esc_html__( 'Add New Field', 'faq_textdomain' ); ?></button>
			<?php
		}

		public function save_faq_fields( $post_id ) {
			// For custom post type.
			$exclude_statuses = array(
				'auto-draft',
				'trash',
			);
			$action           = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';

			if ( in_array( get_post_status( $post_id ), $exclude_statuses, true ) || 'untrash' === $action || ( ! current_user_can( 'edit_post', $post_id ) ) ) {
				return;
			}
			$nonce = isset( $_POST['fs_nonce_value_field'] ) ? sanitize_text_field( wp_unslash( $_POST['fs_nonce_value_field'] ) ) : 0;
			if ( ! wp_verify_nonce( $nonce, 'fs_nonce_value' ) ) {
				wp_die( esc_html__( 'Security Violated.', 'faq_textdomain' ) );
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			if ( $_POST && isset( $_POST['faq_data'] ) ) {
				$faq_fields = sanitize_post( $_POST['faq_data'] );

				// Remove empty fields
				$faq_fields = array_filter(
					$faq_fields,
					function ( $item ) {
						return ! empty( $item['question'] ) || ! empty( $item['answer'] );
					}
				);

				// Update post meta
				update_post_meta( $post_id, 'faq_data', $faq_fields );
				$shortcode = 'faq_shortcode_id_' . $post_id . '';
				update_post_meta( $post_id, 'fs_faq_shortcode', $shortcode );
			}
		}
	}
	new Fs_FAQ_Shortcode_Admin();
}
