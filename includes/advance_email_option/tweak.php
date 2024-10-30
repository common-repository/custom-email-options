<?php

if ( ! class_exists( 'Wb_Advance_Email_Option_Tweak' ) ) {
	class Wb_advance_email_option_tweak {
		public function wbSettings() {
			$return_mail = get_option( 'admin_email' );
			?>
			   <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Not Found (error 404) page', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <select name="<?php echo $this->option; ?>[general_page404_redirect]">
					 <option value=""><?php echo esc_attr( __( 'Select page', WB_CHANGE_EMAIL_SLUG ) ); ?></option>
						<?php
						$pages  = get_pages();
						$select = '';
						foreach ( $pages as $page ) {
							$select  = ( $page->ID == $this->value['general_page404_redirect'] ) ? ' selected="selected" ' : '';
							$option  = '<option value="' . $page->ID . '" ' . $select . '>';
							$option .= $page->post_title;
							$option .= '</option>';
							echo $option;
						}
						?>
					</select><br />
					<p class="description">
						<?php echo __( 'Then WordPress does not found the page, you can use any another page to show and suggest another usable information on site. By default standard theme page shows.', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Disable "wptexturize" function for page title', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
					<?php
					$general_title_value = isset( $this->value['general_title_wptexturize_no'] ) ? $this->value['general_title_wptexturize_no'] : '';
					?>
				   <label ><input name="<?php echo $this->option; ?>[general_title_wptexturize_no]" type="radio" value="yes" <?php checked( $general_title_value, 'yes' ); ?>> <?php esc_html_e( 'Yes', 'wb-change-sender-email' ); ?></label>
				   <label ><input name="<?php echo $this->option; ?>[general_title_wptexturize_no]" type="radio" value="" <?php checked( $general_title_value, '' ); ?>> <?php esc_html_e( 'No', 'wb-change-sender-email' ); ?></label>
					<br />
					<p class="description">
						<?php echo __( 'This function applies transformations of quotes to smart quotes, apostrophes, dashes, ellipses, the trademark symbol, and the multiplication symbol.', WB_CHANGE_EMAIL_SLUG ); ?>
						<?php echo sprintf( __( 'You can read information about this function <a href="%s" target="_blank">here</a>', WB_CHANGE_EMAIL_SLUG ), 'http://codex.wordpress.org/Function_Reference/wptexturize' ); ?>
					</p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Show generation time', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
					<?php
					$general_generation_value = isset( $this->value['general_generation_time'] ) ? $this->value['general_generation_time'] : '';
					?>
				   <label ><input name="<?php echo $this->option; ?>[general_generation_time]" type="radio" value="yes" <?php checked( $general_generation_value, 'yes' ); ?>><?php esc_html_e( 'Yes', 'wb-change-sender-email' ); ?></label>
				   <label ><input name="<?php echo $this->option; ?>[general_generation_time]" type="radio" value="" <?php checked( $general_generation_value, '' ); ?>><?php esc_html_e( 'No', 'wb-change-sender-email' ); ?></label>
					<br />
					<p class="description">
						<?php echo __( 'Only admins can see this information.<br/> Number of SQL requests, generation time and memory consumption will be shown for all pages.', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Remove Settings', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
					<?php
					$general_settings_value = isset( $this->value['general_settings_remove'] ) ? $this->value['general_settings_remove'] : '';
					?>
				   <label ><input name="<?php echo $this->option; ?>[general_settings_remove]" type="radio" value="yes" <?php checked( $general_settings_value, 'yes' ); ?>><?php esc_html_e( 'Yes', 'wb-change-sender-email' ); ?></label>
				   <label ><input name="<?php echo $this->option; ?>[general_settings_remove]" type="radio" value="" <?php checked( $general_settings_value, '' ); ?>><?php esc_html_e( 'No', 'wb-change-sender-email' ); ?></label>
					<br />
					<p class="description">
						<?php echo __( 'This will remove the settings data from database and reset the plugin on deactivation of plugin.', WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			</tr>

			   <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Sender (Return-Path)', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_sender]" type="text" value="<?php echo isset( $this->value['wb_mail_sender'] ) ? $this->value['wb_mail_sender'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( "Sets the Sender email (Return-Path) of the message.  If not empty, will be sent via sendmail or as 'MAIL FROM' in smtp mode.", WB_CHANGE_EMAIL_SLUG ); ?>
					</p>
				</td>
			  </tr>
			  <tr valign="top">
				<th scope="row">
					<label for="num_elements">
						<?php echo __( 'Confirm Reading To', WB_CHANGE_EMAIL_SLUG ); ?>:
					</label>
				</th>
				<td>
				   <input name="<?php echo $this->option; ?>[wb_mail_confirm_reading_to]" type="text" value="<?php echo isset( $this->value['wb_mail_confirm_reading_to'] ) ? $this->value['wb_mail_confirm_reading_to'] : ''; ?>">
					<br />
					<p class="description">
						<?php echo __( 'Sets the email address that a reading confirmation will be sent.', WB_CHANGE_EMAIL_SLUG ); ?>
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

			add_action( 'phpmailer_init', array( $this, 'wpMailPhpmailer' ) );
			add_action( 'template_redirect', array( $this, 'wbDo' ) );
			remove_filter( 'the_title', 'wptexturize' );
			add_action( 'init', array( $this, 'wbInit' ) );
		}

		// SQL requests:62. Generation time:1.248 sec. Memory consumption:45.31 mb
		public function wbInit() {
			add_filter( 'wp_footer', array( $this, 'wbDogen' ) );
		}

		// Function to show the memory and time used
		public function wbDogen() {
			printf( __( 'SQL requests:%1$d. Generation time:%2$s sec. Memory consumption:', WB_CHANGE_EMAIL_SLUG ), get_num_queries(), timer_stop( 0, 3 ) );
			if ( function_exists( 'memory_get_usage' ) ) {
				echo round( memory_get_usage() / 1024 / 1024, 2 ) . ' mb ';
			}
		}

		public function wpMailPhpmailer( &$mailer ) {

			$phpmailer       = &$mailer;
			$wp_mail_options = $this->value;

			if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_sender'] ) ) {
				$phpmailer->Sender = $wp_mail_options['wb_mail_sender'];
			}

			if ( $this->isStrAndNotEmpty( $wp_mail_options['wb_mail_confirm_reading_to'] ) ) {
				$phpmailer->ConfirmReadingTo = $wp_mail_options['wb_mail_confirm_reading_to'];
			}
		}

		public function wbDo() {
			$wp_mail_options = $this->value;
			if ( is_404() ) {
				header( 'Status: 404 Not Found' );
				header( 'HTTP/1.0 404 Not Found' );
				define( 'DONOTCACHEPAGE', true );
				wp_redirect( get_page_link( $wp_mail_options['general_page404_redirect'] ) );
				exit;
			}
		}

	}
}
