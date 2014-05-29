<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ).'&type=alphabetical') ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php do_action( 'bp_before_directory_members_list' ); ?>

<!--	<ul id="members-list" class="item-list" role="main">
-->
<?php if(current_user_on_level(1) && !current_user_on_level(4)) { ?>

	<table border="1" id="dglcc_directory"><thead>
		<tr class="mem-header">
			<th>Contact</th>
			<th>Industry</th>
			<th>Business Name</th>
			<th>Membership Level</th>
		</tr>
	</thead>
	<tbody>
	<?php while ( bp_members() ) : bp_the_member(); ?>
	
	<?php
		$member_id = bp_get_member_user_id();
		$user_object = new M_Membership( $member_id );
		$subs = $user_object->get_subscription_ids();
		if(!empty($subs)) {
			$names = array();
			$mem_id = array();
			foreach((array) $subs as $key) {
				$sub = new M_Subscription ( $key );
				if(!empty($sub)) {
					$names[] = $sub->sub_name();
					$mem_id[] = $sub->sub_id();
				}
			}
			$sub_names = implode(", ", $names);
			$sub_ids = implode(", ", $mem_id);
		}
		
	//	print_r($user_object);
		$active_member = $user_object->active_member();
	//	$sub_ids = $user_object->get_subscription_ids();
	
		$has_cap = $user_object->has_cap('membershipadmin');
		$level_id = $user_object->get_level_ids();
		$levels = $user_object->get_level_ids();
		if(!empty($levels)) {
			$rows = array();
			foreach((array) $levels as $key => $value) {
				$level = new M_Level ( $value->level_id );
				if(!empty($level)) {
					if((int) $value->sub_id != 0) {
						$rows[] = $level->level_title();
					} else {
						$rows[] = $level->level_title();
					}
				}
			}
			$level_id = implode(", ", $rows);
		}
		
		
		
		$relationship = $user_object->get_relationships();
		$biz_ind_clean = str_replace('/', '-', $biz_industry);
		$biz_ind_clean = str_replace('&', 'and', $biz_industry);
		
	?>

<!--		<li>
-->			
		<tr class="<?php echo 'mem-'.$sub_ids; echo ' '.$biz_ind_clean; ?>">
			<td>
			<div class="item-avatar">
				<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
			</div>

			<div class="item">
				<div class="item-title">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); echo $user_id2; ?></a>
				</div>

				<?php do_action( 'bp_directory_members_item' ); ?>

				<?php
				 /***
				  * If you want to show specific profile fields here you can,
				  * but it'll add an extra query for each member in the loop
				  * (only one regardless of the number of fields you show):
				  *
				  * bp_member_profile_data( 'field=the field name' );
				  */
				?>
			</div>
			</td>
			<td>
				<?php echo bp_member_profile_data('field=Industry'); ?>
			</td>
			<td>
				<?php echo bp_member_profile_data('field=Business Name'); ?>
				<?php //echo xprofile_get_field_id_from_name( 'Business Name' ) ;?>
			</td>
			<td>
				<?php echo $sub_names; ?>
			</td>
		</tr>
		
<!--			<div class="action">

				<?php do_action( 'bp_directory_members_actions' ); ?>

			</div>

			<div class="clear"></div>
		</li>
-->
	<?php endwhile; ?>

<!--	</ul>
-->
		</tbody>
	</table>

	
<?php } else { ?>

	<table border="1" id="dglcc_directory"><thead>
		<tr class="mem-header">
			<th>Company</th>
			<th>Phone Number</th>
			<th>Business Address</th>
		</tr>
	</thead>
	<tbody>
	<?php while ( bp_members() ) : bp_the_member();  
	//include_by_meta('Vivace Buddy', 'Business Name'), 'type' => 'newest'
	?>
	
	
	<?php
		$biz_array = array();
		$member_id = bp_get_member_user_id();
		$user_object = new M_Membership( $member_id );
		$subs = $user_object->get_subscription_ids();
		if(!empty($subs)) {
			$names = array();
			$mem_id = array();
			foreach((array) $subs as $key) {
				$sub = new M_Subscription ( $key );
				if(!empty($sub)) {
					$names[] = $sub->sub_name();
					$mem_id[] = $sub->sub_id();
				}
			}
			$sub_names = implode(", ", $names);
			$sub_ids = implode(", ", $mem_id);
		}
		
	//	print_r($user_object);
		$active_member = $user_object->active_member();
	//	$sub_ids = $user_object->get_subscription_ids();
	
		$has_cap = $user_object->has_cap('membershipadmin');
		$level_id = $user_object->get_level_ids();
		$levels = $user_object->get_level_ids();
		if(!empty($levels)) {
			$rows = array();
			foreach((array) $levels as $key => $value) {
				$level = new M_Level ( $value->level_id );
				if(!empty($level)) {
					if((int) $value->sub_id != 0) {
						$rows[] = $level->level_title();
					} else {
						$rows[] = $level->level_title();
					}
				}
			}
			$level_id = implode(", ", $rows);
		}
		
		
		
		$relationship = $user_object->get_relationships();
		$biz_ind_clean = str_replace('/', '-', $biz_industry);
		$biz_ind_clean = str_replace('&', 'and', $biz_industry);
		
/*	if(!empty($level_id)) {
		$biz_name = bp_get_member_profile_data( 'field=Business Name', bp_get_member_user_id() );
		if ($biz_name != '' && !in_array($biz_name, $biz_array)) {
			array_push($biz_array, $biz_name);
*/	?>
	
		<tr class="<?php echo 'mem-'.$sub_ids; echo ' '.$biz_ind_clean; ?>">
			<td>
				<div class="item-avatar">
					<?php bp_member_avatar(); ?>
				</div>
				<?php echo bp_member_profile_data('field=Business Name'); ?>
			</td>
			<td>
				<?php echo bp_member_profile_data('field=Business Phone Number'); ?>
			</td>
			<td>
				
				<?php echo bp_member_profile_data('field=Street Address').'<br />';
				echo bp_member_profile_data('field=City').', ';
				echo bp_member_profile_data('field=State').' ';
				echo bp_member_profile_data('field=Zip Code');
				?>
				
				
			</td>
		</tr>
	
	<?php
//	}
//	}
	//}
	?>
	
	<?php endwhile; ?>

	</tbody>
	</table>

<?php
}




 ?>
 
 

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>
