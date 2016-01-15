<?php 

global $post;
?>
<!-- Post -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
	<figure class="post-thumbnail">
		<a href="<?php echo get_permalink(get_the_ID()); ?>">
			<?php the_post_thumbnail('thumbnail'); ?>
		</a>
	</figure>
	<?php } ?>
	<h4 class="entry-title"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h4>
	<div class="entry-meta">
		<?php echo get_the_date(); ?> - <?php the_author_posts_link(); ?> - <?php comments_number(); ?>
	</div>
	<div class="entry-content"><?php the_excerpt(); ?></div>
	<div class="buttons">
		<a class="button" href="<?php echo get_permalink(get_the_ID()); ?>">Read more</a>
	</div>
</article>
<!-- End Post -->