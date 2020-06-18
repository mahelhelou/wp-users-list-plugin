<?php
/**
 * The UI (User Interface) for the plugin
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div class="wrap">

	<div class="header">
		<h1 class="table__title"><?php esc_html_e( 'All Current Users List', 'wp-users-list' ); ?></h1>
		<span class="table__description"><?php esc_html_e( 'Information about all current users in this website.', 'wp-users-list' ); ?></span>
	</div>

	<?php
	/**
	 * Get all users from DB
	 */

	function get_all_users() {
    $db_record = array();
    $i = 0;
		$users = get_users( array( 'fields' => array( 'ID' ) ) );

		foreach( $users as $user ) {
			$db_record[$i] = get_user_meta ( $user->ID);
			$i++;
		}

		return $db_record;
	}
?>

	<table id="table_id" class="display">
    <thead>
        <tr>
            <th><?php esc_html_e( 'User Role', 'wp-users-list' ); ?></th>
            <th><?php esc_html_e( 'User Displayed Name', 'wp-users-list' ); ?></th>
            <th><?php esc_html_e( 'User Username', 'wp-users-list' ); ?></th>
        </tr>
    </thead>
    <tbody>
			<?php
				$users = get_all_users();
				// print_r( $users );
			?>

			<?php foreach ( $users as $user ) { ?>
        <tr>
					<td>
					<?php
						$user_role = array();
						preg_match( '/\"(.*?)\"/', $user['wp_capabilities'][0], $user_role);
						esc_html_e( $user_role[1] );
					?>
				</td>
          <td><?php esc_html_e( $user['first_name'][0]); ?></td>
          <td><?php esc_html_e( $user['nickname'][0]); ?></td>
				</tr>
			<?php } ?>
    </tbody>
</table>

</div>
