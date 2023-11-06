<?php
/*
Template Name: All Products
*/

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<h1><?php echo __( 'All Products', 'storefront' ); ?></h1>

		<div class="products-list">
			<?php
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => - 1,
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) :
				$count = 0;
				while ( $query->have_posts() ) : $query->the_post();
					$product_title = get_the_title();
					$product_price = get_post_meta( get_the_ID(), '_price', true );
					$product_sku   = get_post_meta( get_the_ID(), '_sku', true );
					$product_image = get_post_meta( get_the_ID(), 'product_custom_image', true );
					$product_date  = get_post_meta( get_the_ID(), 'product_custom_date', true );
					$product_type  = get_post_meta( get_the_ID(), 'product_custom_type', true );

					if ( empty( $product_image ) ) {
						$product_image = get_the_post_thumbnail_url();
					}
					?>

					<?php if ( $count % 4 === 0 ) : ?>
						<div class="row">
					<?php endif; ?>

					<div class="col-md-3 product">
						<img src="<?php echo $product_image; ?>" alt="<?php echo $product_title; ?>">
						<h2><?php echo $product_title; ?></h2>
						<p><?php echo __( 'Price:', 'storefront' ) . ' ' . $product_price; ?></p>
						<p><?php echo __( 'Sku:', 'storefront' ) . ' ' . $product_sku; ?></p>
						<p><?php echo __( 'Type:', 'storefront' ) . ' ' . $product_type; ?></p>
						<p><?php echo __( 'Date:', 'storefront' ) . ' ' . $product_date; ?></p>
					</div>

					<?php if ( $count % 4 === 3 ) : ?>
						</div>
					<?php endif; ?>

					<?php $count ++; ?>

				<?php endwhile;

				if ( $count % 4 !== 0 ) {
					echo '</div>';
				}

				wp_reset_postdata();
			else :
				echo __( 'No products found', 'storefront' );
			endif;
			?>
		</div>

	</main>
</div>
<?php get_template_part( 'templates/create-product' ); ?>
<?php
get_footer();
?>
