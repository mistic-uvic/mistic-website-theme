<?php
/**
 * Page Template
 *
 * This is the default page template.  It is used when a more specific template can't be found to display
 * singular views of pages.
 *
 * @package Oxygen
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

  <div class="aside">

    <?php get_template_part( 'menu', 'secondary' ); // Loads the menu-secondary.php template.  ?>

    <?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

  </div>

  <?php do_atomic( 'before_content' ); // oxygen_before_content ?>

  <div class="content-wrap">

    <div id="content">

      <?php do_atomic( 'open_content' ); // oxygen_open_content ?>

      <div class="hfeed">

        <?php if ( have_posts() ) : ?>

          <?php while ( have_posts() ) : the_post(); ?>

            <?php do_atomic( 'before_entry' ); // oxygen_before_entry ?>

            <div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

              <?php do_atomic( 'open_entry' ); // oxygen_open_entry ?>

              <?php echo apply_atomic_shortcode( 'entry_title', '[entry-title permalink="0"]' ); ?>

              <div class="entry-content">

                <img
                  <?php
                    $image = get_field('picture');
                    $image_sized = $image['sizes']['medium'];
                  ?>
                  id="person-picture"
                  src="<?php echo $image_sized; ?>"
                />

                <div id='person-summary'>
                <ul>
                <li><?php echo get_field('role') . ', ' . get_field('departments')?></li>
                <li><b>Research areas:</b> <?php echo get_field('research_areas')?></li>
                </ul>
                </div>

                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'oxygen' ) ); ?>

                <?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'oxygen' ), 'after' => '</p>' ) ); ?>

                <h3>Recent posts:</h3>
                <p>In future, this will display links to recent posts related to this person.</p>

                <h3>Participating in Projects:</h3>

                <?php
                $projects = get_field('projects');
                foreach($projects as $project){
                  $post = get_post($project); setup_postdata($post);
                  get_template_part('summary',null);
                }
                wp_reset_postdata();
                ?>

                <h3>Publications:</h3>
                <div id="related-publications">
                <?php
                $all_pubs = get_posts(array(
                    'post_type' => 'publication',
                    'post_parent' => 0,
                ));
                foreach($all_pubs as $pub)
                {
                  $authors = get_field('authors', $pub);
                  if (in_array(get_the_ID(), $authors))
                  {
                      $post = get_post($pub); setup_postdata($post);
                      get_template_part('publication',null);
                  }
                  wp_reset_postdata();
                }
                ?>
                </div>

              </div><!-- .entry-content -->

              <?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">[entry-edit-link]</div>' ); ?>

              <?php do_atomic( 'close_entry' ); // oxygen_close_entry ?>

            </div><!-- .hentry -->

            <?php do_atomic( 'after_entry' ); // oxygen_after_entry ?>

            <?php do_atomic( 'after_singular' ); // oxygen_after_singular ?>

            <?php comments_template( '/comments.php', true ); // Loads the comments.php template. ?>

          <?php endwhile; ?>

        <?php endif; ?>

      </div><!-- .hfeed -->

      <?php do_atomic( 'close_content' ); // oxygen_close_content ?>

    </div><!-- #content -->

    <?php do_atomic( 'after_content' ); // oxygen_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>