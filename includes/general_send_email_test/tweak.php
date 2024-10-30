<?php
// Display form to send test email main class
if ( ! class_exists( 'Wb_General_Send_Email_Test_Tweak' ) ) {
	class Wb_general_send_email_test_tweak {
		// generate form field to send email
		public function wbSettings() {
			$sitename = get_option( 'blogname' );
			?>
			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'To', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input type="email" value="<?php echo esc_attr__( get_option( 'admin_email' ), WB_CHANGE_EMAIL_SLUG ); ?>" name="mail_to" class="regular-text" required="required" />
				 </td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Subject', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input type="text" value="<?php echo esc_attr__( get_option( 'blogname' ) . ' - ' . 'Email Testing', WB_CHANGE_EMAIL_SLUG ); ?>" name="mail_subject" class="regular-text" required="required" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Message', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <textarea name="mail_message" id="textarea-message" class="regular-text" required="required">
						 <?php echo sprintf( __( 'This is test email from %s.' ), $sitename ); ?>
					 </textarea>
				 </td>
			</tr>
			<script type="text/javascript">
					jQuery('textarea#textarea-message').html(jQuery('textarea#textarea-message').html().trim());
			</script>
			<?php
		}

		public function wbTweak() {
			// function with no action
		}
	}
}
