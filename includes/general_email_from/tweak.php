<?php
// change from email address class
if ( ! class_exists( 'Wb_General_Email_From_Tweak' ) ) {
	class Wb_general_email_from_tweak {
		// generate email setting form field
		public function wbSettings() {

			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}

			$from_email  = 'wordpress@' . $sitename;
			$admin_email = get_option( 'admin_email' );

			?>
			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Change from email address', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input class="regular-text" name="wb_general_tweak[<?php echo $this->option; ?>]" type="email" value="<?php echo ! empty( $this->value ) ? $this->value : $admin_email; ?>">
					<br />
					<p class="description">
						<?php echo __( 'You can define any email address, address will be used for all sent emails.<br/> Default email is ' . $from_email, WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			</tr>
			<?php
		}
		// function to apply filter to change the email address
		public function wbTweak() {

		}
	}
}
