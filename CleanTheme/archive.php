<?php get_header();?>
	<h1 class="page-title"><?php single_cat_title(); ?></h1>
	<?php while (have_posts()) : the_post(); ?>
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><h2><?php the_title(); ?></h2></a>
		<?php the_time('j F, Y') ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
	<?php echo paginate_links();?>
<?php get_footer();?>