<?php get_header();?>
	<?php while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php the_time('j F, Y') ?>
		<b>Рубрика:</b> <?php the_category(', ') ?>  
		<?php the_content(); ?>
		<?php the_tags('<p><b>Метки:</b> ', ', ', '</p>'); ?>
	<?php endwhile; ?>
<?php get_footer();?>