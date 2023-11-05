<?php
/*
Template Name: Create Product
*/

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<h1><?php echo __( 'Add Product', 'storefront' ); ?></h1>
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="product_title"><?php echo __( 'Product Title:', 'storefront' ); ?></label>
				<input type="text" class="form-control" name="product_title" id="product_title" required>
			</div>

			<div class="form-group">
				<label for="product_price"><?php echo __( 'Product Price:', 'storefront' ); ?></label>
				<input type="number" class="form-control" name="product_price" id="product_price" required>
			</div>

			<div class="form-group">
				<label for="product_sku"><?php echo __( 'Product SKU:', 'storefront' ); ?></label>
				<input type="number" class="form-control" name="product_sku" id="product_sku" required>
			</div>

			<div class="form-group">
				<label for="product_custom_image"><?php echo __( 'Product Custom Image:', 'storefront' ); ?></label>
				<input type="file" class="form-control-file" name="product_custom_image" id="product_custom_image" required>
			</div>

			<div class="form-group">
				<label for="product_custom_date"><?php echo __( 'Product Custom Date:', 'storefront' ); ?></label>
				<input type="date" class="form-control" name="product_custom_date" id="product_custom_date" required>
			</div>

			<div class="form-group">
				<label for="product_custom_type"><?php echo __( 'Product Custom Type:', 'storefront' ); ?></label>
				<select class="form-control" name="product_custom_type" id="product_custom_type">
					<option value="rare">Rare</option>
					<option value="frequent">Frequent</option>
					<option value="unusual">Unusual</option>
				</select>
			</div>

			<button type="submit" class="btn btn-primary"
			        name="submit_product"><?php echo __( 'Add Product', 'storefront' ); ?></button>
		</form>

		<?php
		if ( isset( $_POST['submit_product'] ) ) {
			$product_title        = sanitize_text_field( $_POST['product_title'] );
			$product_price        = sanitize_text_field( $_POST['product_price'] );
			$product_custom_image = sanitize_text_field( $_POST['product_custom_image'] );
			$product_custom_date  = sanitize_text_field( $_POST['product_custom_date'] );
			$product_custom_type  = sanitize_text_field( $_POST['product_custom_type'] );
			$product_sku          = sanitize_text_field( $_POST['product_sku'] );

			$post_data = array(
				'post_title'   => $product_title,
				'post_content' => '',
				'post_status'  => 'publish',
				'post_type'    => 'product',
				'post_author'  => 1,
			);

			$product_id = wp_insert_post( $post_data );

			if ( $product_id ) {
				update_post_meta( $product_id, '_price', $product_price );
				update_post_meta( $product_id, 'product_custom_image', $product_custom_image );
				update_post_meta( $product_id, 'product_custom_date', $product_custom_date );
				update_post_meta( $product_id, 'product_custom_type', $product_custom_type );
				update_post_meta( $product_id, '_sku', $product_sku );
			}
			if ( ! empty( $_FILES['product_custom_image']['name'] ) ) {
				$upload_dir = wp_upload_dir();
				$image_data = $_FILES['product_custom_image'];

				$file_name = $image_data['name'];
				$file_path = $upload_dir['path'] . '/' . $file_name;
				move_uploaded_file( $image_data['tmp_name'], $file_path );
				$file_type = wp_check_filetype( $file_name, null );


				$attachment = array(
					'post_mime_type' => $file_type['type'],
					'post_title'     => sanitize_file_name( $file_name ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				$attachment_id = wp_insert_attachment( $attachment, $file_path );
				update_post_meta( $product_id, '_thumbnail_id', $attachment_id );
				update_post_meta( $product_id, 'product_custom_image', $upload_dir['url'] . '/' . $file_name );
			}
		}
		?>

	</main>
</div>

<?php
get_footer();
?>
