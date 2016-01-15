<!-- Post -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
	<figure class="post-thumbnail">
		<?php the_post_thumbnail('fullsize'); ?>
	</figure>
	<?php } ?>
	<div class="entry">
		<div class="entry-left">
			<div class="entry-date"><?php echo get_the_date('d', $post); ?><small> /<?php echo get_the_date('M', $post); ?></small></div>
			<div class="social">
				<?php m_wedding_social_shares(); ?>
			</div>
		</div>
		<div class="entry-main">
			<h3 class="title entry-title"><?php the_title(); ?></h3>
			<div class="entry-meta">
				Post by <?php the_author_posts_link(); ?> / <?php the_category(', '); ?> / <?php echo get_comments_number_text(); ?>
				<?php if ( has_tag('', get_the_ID()) ) { ?>
				<br>/ <?php the_tags(); ?>
				<?php } ?>
			</div>
			<div class="entry-content"><?php the_content(); ?></div>
			<?php 
			wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'mTheme' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'mTheme' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
			) );
			?>
		</div>
		
	</div>
</article> <!-- End Post -->