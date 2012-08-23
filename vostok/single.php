<?php get_header(); ?>
	<div id="content">
		<div id="main-content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<? $postData = get_post_custom($post->ID); ?>
			<article id="single-post-<? the_ID(); ?>" <? post_class(); ?>>
				<header>
					<h2><? the_title(); ?></h2>
					<span class="date"><?php the_time(__('m/j/Y','vostok')) ?></span>
				</header>
				<section class="entry">
					<iframe src="http://player.vimeo.com/video/<? echo $postData['custom_video'][0]; ?>"  width="530" height="298" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					
					<ul class="film_details">
						<li><strong>Genre:</strong> </li>
						<li><strong>Directed:</strong> <? echo $postData['custom_director'][0]; ?></li>
						<li><strong>Written:</strong> <? echo $postData['custom_writer'][0]; ?></li>
						<li><strong>Produced:</strong> <? echo $postData['custom_producer'][0]; ?></li>
						<li><strong>Website:</strong> <a target="_blank" href="<? echo $postData['custom_website'][0]; ?>">Link</a></li>
						<li><strong>Cast:</strong> <? echo $postData['custom_cast'][0]; ?></li>
					</ul>
					<p><strong>Synopsis:</strong><br/>
					<? echo $postData['custom_synopsis'][0]; ?></p>
				</section>
				<footer>
					<span class="report"><a href="#">Report Issue</a></span>
				</footer>
			</article>
		<?php endwhile; else: ?>
			<p class="string"><?php _e('Sorry, there are no articles under this criterion.','vostok'); ?></p>
	<?php endif; ?>
		</div><!-- close:main-content -->
		<?php get_sidebar(); ?>
	</div><!-- close:content -->
<?php get_footer(); ?>
