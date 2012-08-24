<?php get_header(); ?>
	<div id="content">
		<div id="main-content">
	<?php if (have_posts()) : ?>
		<p class="string"><?php _e('You searched for the following','vostok'); ?>: "<strong><?php echo wp_specialchars($s); ?></strong>"</p>
		<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
		<h2 class="error"><?php _e('Search results','vostok'); ?></h2>
		<?php while (have_posts()) : the_post(); ?>
		<? $postData = get_post_custom($post->ID); ?>
				<article class="post" id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<span class="date"><?php the_time(__('m/j/Y','vostok')) ?></span>
					<section class="entry">
						<a href="<? the_permalink(); ?>"><img height="298" width="530" class="thumbnail_image" src="<? echo $postData['custom_thumb'][0]; ?>" /></a>
					</section>
					
					<!--footer>
						<span class="report"><a href="#">Report Issue</a></span>
					</footer-->
				</article><!-- close:post -->
			<?php endwhile; 
				wp_reset_postdata();
			?>
			<div class="pagination clearfix">
				<div class="prev"><?php next_posts_link(__('Older Films','vostok'), $query->max_num_pages) ?></div>
				<div class="next"><?php previous_posts_link(__('Newer Films','vostok'), $query->max_num_pages) ?></div>
			</div>
	<?php else : ?>
		<p class="string"><?php _e('You searched for the following','vostok') ?>: "<strong><?php echo wp_specialchars($s); ?></strong>"</p>
		<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
		<h2 class="error"><?php _e('We didn\'t find anything. Try a different search or look in the categories below.','vostok'); ?></h2>
	<?php endif; ?>
		</div>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>