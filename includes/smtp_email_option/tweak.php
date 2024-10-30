<?php


if ( ! class_exists( 'Wb_Smtp_Email_Option_Tweak' ) ) {
	class Wb_smtp_email_option_tweak {

		private $wb_general_tweak;

		public function wbSettings() {
			?>
			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Send Email using SMTP', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
					<?php	$general_email_value = isset( $this->value['general_email_send_from'] ) ? $this->value['general_email_send_from'] : ''; ?>
				   <label ><input name="<?php echo $this->option; ?>[general_email_send_from]" type="radio" value="yes" <?php checked( $general_email_value, 'yes' ); ?>><?php esc_html_e( 'Yes', 'wb-change-sender-email' ); ?></label>
				   <label ><input name="<?php echo $this->option; ?>[general_email_send_from]" type="radio" value="" <?php checked( $general_email_value, '' ); ?>> <?php esc_html_e( 'No', 'wb-change-sender-email' ); ?></label>
					<br />
					<p class="description">
						<?php echo __( 'If you checked this option the smtp section will be added to send email through smtp', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			</tr>
			 <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'From Email Address', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_from_email]" type="text" value="<?php echo isset( $this->value['wb_mail_from_email'] ) ? $this->value['wb_mail_from_email'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( 'This email address will be used in the "From" field.', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'From Name', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_from_name]" type="text" value="<?php echo isset( $this->value['wb_mail_from_name'] ) ? $this->value['wb_mail_from_name'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( 'This text will be used in the "FROM" field', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'SMTP Host', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_smtp_host]" type="text" value="<?php echo isset( $this->value['wb_mail_smtp_host'] ) ? $this->value['wb_mail_smtp_host'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( 'Your mail server', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Type of Encription', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
					<?php $wb_mail_value = isset( $this->value['wb_mail_encription'] ) ? $this->value['wb_mail_encription'] : ''; ?>
				   <label ><input name="<?php echo $this->option; ?>[wb_mail_encription]" type="radio" value="" <?php checked( $wb_mail_value, '' ); ?>><?php esc_html_e( 'None', 'wb-change-sender-email' ); ?></label>
				   <label ><input name="<?php echo $this->option; ?>[wb_mail_encription]" type="radio" value="ssl" <?php checked( $wb_mail_value, 'ssl' ); ?>><?php esc_html_e( 'SSL', 'wb-change-sender-email' ); ?></label>
				   <label ><input name="<?php echo $this->option; ?>[wb_mail_encription]" type="radio" value="tls" <?php checked( $wb_mail_value, 'tls' ); ?>><?php esc_html_e( 'TLS', 'wb-change-sender-email' ); ?></label>
					<br />
					<p class="description">
						<?php echo __( 'For most servers SSL is the recommended option', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'SMTP Port', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_port]" type="text" value="<?php echo isset( $this->value['wb_mail_port'] ) ? $this->value['wb_mail_port'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( 'The port to your mail server', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'SMTP Authentication', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
					<?php $wb_mail_auth_value = isset( $this->value['wb_mail_auth'] ) ? $this->value['wb_mail_auth'] : ''; ?>
				   <label ><input name="<?php echo $this->option; ?>[wb_mail_auth]" type="radio" value="yes" <?php checked( $wb_mail_auth_value, 'yes' ); ?>><?php esc_html_e( 'Yes', 'wb-change-sender-email' ); ?></label>
				   <label ><input name="<?php echo $this->option; ?>[wb_mail_auth]" type="radio" value="" <?php checked( $wb_mail_auth_value, '' ); ?>><?php esc_html_e( 'No', 'wb-change-sender-email' ); ?></label>
					<br />
					<p class="description">
						<?php echo __( "This options should always be checked 'Yes'", WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'SMTP username', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_username]" type="text" value="<?php echo isset( $this->value['wb_mail_username'] ) ? $this->value['wb_mail_username'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( 'The username to login to your mail server', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'SMTP Password', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_password]" type="password" value="<?php echo isset( $this->value['wb_mail_password'] ) ? $this->value['wb_mail_password'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( 'The password to login to your mail server', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			<?php
		}

		public function isStrAndNotEmpty( $var ) {
			if ( ! is_string( $var ) ) {
				return false;
			}

			if ( empty( $var ) ) {
				return false;
			}

			if ( $var == '' ) {
				return false;
			}

			return true;
		}

		public function wbTweak() {
			// general tweak was used
			if ( isset( $this->value['general_email_send_from'] ) && $this->value['general_email_send_from'] == 'yes' ) {
				add_action( 'phpmailer_init', array( $this, 'wpMailPhpmailer' ) );
				// add_action( 'admin_init', array( $this, 'wpMailPhpmailer' ) );
			}
		}

		public function wpMailPhpmailer( &$phpmailer ) {
			$wp_mail_options = $this->value;
			$phpmailer->IsSMTP();
			if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_from_email'] ) ) {
				$phpmailer->From = $wp_mail_options['wb_mail_from_email'];
			}

			if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_from_name'] ) ) {
				$phpmailer->FromName = $wp_mail_options['wb_mail_from_name'];
			}

			/* Set the SMTPSecure value */
			if ( $wp_mail_options['wb_mail_encription'] !== '' ) {
				$phpmailer->SMTPSecure = $wp_mail_options['wb_mail_encription'];
			}

			if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_smtp_host'] ) ) {
				$phpmailer->Host = $wp_mail_options['wb_mail_smtp_host'];
			}

			if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_port'] ) ) {
				$phpmailer->Port = $wp_mail_options['wb_mail_port'];
			}

			if ( 'yes' == $wp_mail_options['wb_mail_auth'] ) :
				if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_auth'] ) ) {
					$phpmailer->SMTPAuth = true;
				}

				/**
			* Sets the Body of the message.  This can be either an HTML or text body.
			* If HTML then run IsHTML(true).
			 *
			* @var string
			*/
				if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_username'] ) ) {
					$phpmailer->Username = $wp_mail_options['wb_mail_username'];
				}

				/**
				* Sets the text-only body of the message.  This automatically sets the
				* email to multipart/alternative.  This body can be read by mail
				* clients that do not have HTML email capability such as mutt. Clients
				* that can read HTML will view the normal Body.
				 *
				* @var string
				*/
				if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_password'] ) ) {
					$phpmailer->Password = $wp_mail_options['wb_mail_password'];
				}

			endif;
		}
	}
}
