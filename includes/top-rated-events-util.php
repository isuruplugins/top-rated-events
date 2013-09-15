<?php
		// Read top rated posts from db
 		function top_star_ratings_events_get($tr_events){
			global $wpdb;
			$table = $wpdb->prefix . 'postmeta';
			    $tr_rated_events = $wpdb->get_results("SELECT a.ID, a.post_title, b.meta_value AS 'ratings' FROM " . $wpdb->posts . " a, $table b, $table c WHERE a.post_status='publish' AND a.post_type='event' AND a.ID=b.post_id AND a.ID=c.post_id AND b.meta_key='_kksr_avg' AND c.meta_key='_kksr_casts' ORDER BY b.meta_value DESC, c.meta_value DESC LIMIT $tr_events");
			return $tr_rated_events;
		}
		// Custom event excerpt	
 		function top_star_ratings_events_excerpt_get($EM_Highest_Rated_Event){
			$tr_events_excerpt = $EM_Highest_Rated_Event->output("#_EVENTEXCERPT"); 
									  $tr_events_excerpt = preg_replace('/<[^>]+./','', $tr_events_excerpt);
										if ( strlen($tr_events_excerpt) > 120 ) {
											  $length = 120; 
											  $tr_events_excerpt = substr($tr_events_excerpt,0,$length);
											}

											$tr_events_excerpt = $tr_events_excerpt . '... ';
			return $tr_events_excerpt;								
		}
		
		function top_star_ratings_events_stars_get($post_id){
			if(function_exists("kk_star_ratings")) { $outcome_star = kk_star_ratings($post_id); }
		return $outcome_star;
		}
		
		function top_star_ratings_events_shares_get($tr_social_sharing_toolkit,$post){
			if($tr_social_sharing_toolkit!=null){ $outcome_share = $tr_social_sharing_toolkit->create_bookmarks(esc_url(get_permalink( $post->ID)), $post->post_title);}
		return $outcome_share;
		}
	

		