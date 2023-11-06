<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'chld_thm_cfg_locale_css' ) ) {
	/**
	 * @param $uri
	 *
	 * @return mixed|string
	 */
	function chld_thm_cfg_locale_css( $uri ) {
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}

		return $uri;
	}
}

add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( ! function_exists( 'add_custom_product_data_tab' ) ) {

	/**
	 * @param $tabs
	 *
	 * @return mixed
	 */

	function add_custom_product_data_tab( $tabs ) {
		$tabs['custom_tab'] = array(
			'label'  => __( 'TestWork', 'storefront' ),
			'target' => 'custom_product_data',
			'class'  => array( 'show_if_simple', 'show_if_variable' ),
		);

		return $tabs;
	}
}

add_filter( 'woocommerce_product_data_tabs', 'add_custom_product_data_tab' );

if ( ! function_exists( 'custom_product_data_tab_content' ) ) {
	/**
	 * Added field image and Data and Type Product
	 */
	function custom_product_data_tab_content() {
		global $post;
		?>
		<div id="custom_product_data" class="panel woocommerce_options_panel">
			<div class="product-custom-field">
				<label for="product_custom_image"> <?php echo __( 'Картинка', 'storefront' ); ?></label>
				<?php $product_custom_image = get_post_meta( $post->ID, 'product_custom_image', true ); ?>
				<input type="hidden" id="product_custom_image" name="product_custom_image"
				       value="<?php echo esc_attr( $product_custom_image ); ?>">
				<img id="product_custom_image_preview" src="<?php echo esc_url( $product_custom_image ); ?>"
				     style="max-width: 100px;" alt="test">
				<button
					class="upload-image-button button"> <?php echo __( 'Загрузить изображение', 'storefront' ); ?></button>
				<button
					class="remove-image-button button"> <?php echo __( 'Удалить изображение', 'storefront' ); ?></button>
			</div>

			<div class="product-custom-field">
				<label for="product_custom_date"> <?php echo __( 'Дата создания', 'storefront' ); ?></label>
				<input type="date" id="product_custom_date" name="product_custom_date"
				       value="<?php echo esc_attr( get_post_meta( $post->ID, 'product_custom_date', true ) ); ?>">
			</div>

			<div class="product-custom-field">
				<label for="product_custom_type"><?php echo __( 'Тип продукта', 'storefront' ); ?></label>
				<select id="product_custom_type" name="product_custom_type">
					<?php
					$selected_type = get_post_meta( $post->ID, 'product_custom_type', true );
					$types         = array( 'rare', 'frequent', 'unusual' );
					foreach ( $types as $type ) {
						echo '<option value="' . $type . '" ' . selected( $selected_type, $type, false ) . '>' . $type . '</option>';
					} ?>
				</select>
			</div>
			<button class="clear-all-fields-button button"><?php echo __( 'Очистить все поля', 'storefront' ); ?></button>
			<button class="save-data-button button" name="save_product_data"><?php echo __('Сохранить данные', 'storefront'); ?></button>
			<button type="submit" class="button save button-primary button-large"><?php _e('Сохранить продукт', 'woocommerce'); ?></button>
			<?php wp_nonce_field( 'update_product_nonce', 'update_product' ); ?>
		</div>
		<?php
	}
}

add_action( 'woocommerce_product_data_panels', 'custom_product_data_tab_content' );

if ( ! function_exists( 'save_product_fields' ) ) {
	/**
	 * @param $post_id
	 *
	 * @return mixed|void
	 */
	function save_product_fields( $post_id ) {
		if (isset($_POST['save_product_data'])) {
			if (isset($_POST['product_custom_image'])) {
				$product_custom_image = sanitize_text_field($_POST['product_custom_image']);
				update_post_meta($post_id, 'product_custom_image', $product_custom_image);
			}
			if (isset($_POST['product_custom_date'])) {
				$product_custom_date = sanitize_text_field($_POST['product_custom_date']);
				update_post_meta($post_id, 'product_custom_date', $product_custom_date);
			}
			if (isset($_POST['product_custom_type'])) {
				$product_custom_type = sanitize_text_field($_POST['product_custom_type']);
				update_post_meta($post_id, 'product_custom_type', $product_custom_type);
			}
		}
	}

}
add_action( 'save_post', 'save_product_fields' );