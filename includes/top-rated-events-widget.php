<?php
/**
 * Top_Rated_Events_Widget Widget Class
 */
class Top_Rated_Events_Widget extends WP_Widget {
    /** constructor */
    function Top_Rated_Events_Widget() {
        parent::WP_Widget(false, $name = 'Top Rated Events Widget');	
    }

	
    /** WP_Widget::widget*/
    function widget($args, $instance) {	
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $tr_events 	= $instance['tr_events'];
		$tr_show_event_image = $instance['tr_show_event_image'];
		$tr_show_event_excerpt	= $instance['tr_show_event_excerpt'];
		$tr_show_event_rating = $instance['tr_show_event_rating'];
		$tr_show_event_sharing = $instance['tr_show_event_sharing'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
						
			  <?php 
			  if (class_exists('EM_Events')) {
			  
				  if (class_exists('MR_Social_Sharing_Toolkit')) {
						$tr_social_sharing_toolkit = new MR_Social_Sharing_Toolkit();
				  }
			  
					  if(function_exists("kk_star_ratings_get")) 
					  { 
						$highest_rated_events = top_star_ratings_events_get($tr_events); 
						
						?>
						<ul>
						<?php 	
						foreach($highest_rated_events as $post)
						{
							$EM_Highest_Rated_Event = em_get_event($post->ID, 'post_id');
								if($EM_Highest_Rated_Event != null){
								if($tr_show_event_image == true && $EM_Highest_Rated_Event->output('#_EVENTIMAGE')){ ?>
								<li><img src="<?php echo $EM_Highest_Rated_Event->output('#_EVENTIMAGEURL'); ?>"  width="100%" height="100%" border="0"></li>
								<?php } ?> 
								<li><b><?php echo $EM_Highest_Rated_Event->output('#_EVENTNAME'); ?></b></li>
								<?php 
								$location_name = $EM_Highest_Rated_Event->output('#_LOCATIONNAME');						
								if($location_name!=null){
								?>
								<li><?php echo $location_name .'  '.$EM_Highest_Rated_Event->output('#_LOCATIONTOWN'); ?></li>
								<?php } ?>								
								<li><?php echo 'Dates : ' . $EM_Highest_Rated_Event->output('#_EVENTDATES'); ?></li>
								<li><?php echo 'Time : ' . $EM_Highest_Rated_Event->output('#_EVENTTIMES'); ?></li>								
								<?php if($tr_show_event_excerpt == true){ ?>
								<li><?php echo top_star_ratings_events_excerpt_get($EM_Highest_Rated_Event); ?></li>
								<?php } if($tr_show_event_rating == true){ ?>
								<li><?php echo top_star_ratings_events_stars_get($post->ID); ?></li>
								<li><hr style="border-color:#fff;border: 0;color:#fff;background-color:#fff;"></li>
								<?php } if(class_exists('MR_Social_Sharing_Toolkit')&& $tr_show_event_sharing == true){ ?>
								<li><?php echo top_star_ratings_events_shares_get($tr_social_sharing_toolkit , $post); ?></li>
								<?php  } }?>
								<li><hr></li>
								<?php $EM_Highest_Rated_Event = null;
								}
						} else{
								   echo 'kk Star Rating plugin is not installed.';
						} ?>
						</ul>
					  <?php } else{
					               echo 'Events Manager plugin is not installed.';
					  } ?>		

              <?php echo $after_widget; ?>
        <?php
    }
 
    /** WP_Widget::update */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['tr_events'] = strip_tags($new_instance['tr_events']);
		$instance['tr_show_event_image'] = strip_tags($new_instance['tr_show_event_image']);
		$instance['tr_show_event_excerpt'] = strip_tags($new_instance['tr_show_event_excerpt']);
		$instance['tr_show_event_rating'] = strip_tags($new_instance['tr_show_event_rating']);
		$instance['tr_show_event_sharing'] = strip_tags($new_instance['tr_show_event_sharing']);
        return $instance;
    }
 
    /** WP_Widget::form */
    function form($instance) {	
 
        $title 	= esc_attr($instance['title']);
        $tr_events	= esc_attr($instance['tr_events']);
		$tr_show_event_image = esc_attr($instance['tr_show_event_image']);
		$tr_show_event_excerpt = esc_attr($instance['tr_show_event_excerpt']);
		$tr_show_event_rating = esc_attr($instance['tr_show_event_rating']);
		$tr_show_event_sharing = esc_attr($instance['tr_show_event_sharing']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('tr_events'); ?>"><?php _e('No of events to show'); ?></label> 
          <input style="width:50px;" id="<?php echo $this->get_field_id('tr_events'); ?>" name="<?php echo $this->get_field_name('tr_events'); ?>" type="text" value="<?php echo $tr_events; ?>" />
        </p>
		<p>
		<label for="<?php echo $this->get_field_id('tr_show_event_image'); ?>"><?php _e('Show Event Image'); ?></label>
		<input  id="<?php echo $this->get_field_id('tr_show_event_image'); ?>" name="<?php echo $this->get_field_name('tr_show_event_image'); ?>" type="checkbox" value="1" <?php checked('1',$tr_show_event_image); ?>/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('tr_show_event_excerpt'); ?>"><?php _e('Show Event Excerpt'); ?></label>
		<input  id="<?php echo $this->get_field_id('tr_show_event_excerpt'); ?>" name="<?php echo $this->get_field_name('tr_show_event_excerpt'); ?>" type="checkbox" value="1" <?php checked('1',$tr_show_event_excerpt); ?>/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('tr_show_event_rating'); ?>"><?php _e('Show Event Ratings'); ?></label>
		<input  id="<?php echo $this->get_field_id('tr_show_event_rating'); ?>" name="<?php echo $this->get_field_name('tr_show_event_rating'); ?>" type="checkbox" value="1" <?php checked('1',$tr_show_event_rating); ?>/>
		</p>
		<?php if (class_exists('MR_Social_Sharing_Toolkit')) { ?>
		<p>
		<label for="<?php echo $this->get_field_id('tr_show_event_sharing'); ?>"><?php _e('Show social share icons'); ?></label>
		<input  id="<?php echo $this->get_field_id('tr_show_event_sharing'); ?>" name="<?php echo $this->get_field_name('tr_show_event_sharing'); ?>" type="checkbox" value="1" <?php checked('1',$tr_show_event_sharing); ?>/>
		</p>
		
        <?php }
    }
 
 
} // end class Top_Rated_Events_Widget
add_action('widgets_init', create_function('', 'return register_widget("Top_Rated_Events_Widget");'));

?>