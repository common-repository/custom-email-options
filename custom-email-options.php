<?php
/**
 * Plugin Name: Custom Email Options
 * Plugin URI: https://wbcomdesigns.com/plugins/custom-email-options/
 * Description: Sender Email/Name Change and General Tweaks Options
 * Version: 1.2.0
 * Text Domain: wb-change-sender-email
 * Author: Wbcom Designs<admin@wbcomdesigns.com>
 * Author URI: http://www.wbcomdesigns.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package custom-email-options
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( 'No Direct Access Allowed' );
}

	define( 'WB_CHANGE_EMAIL_NAME', 'Custom Email Options' );
	define( 'WB_CHANGE_EMAIL_VERSION', '1.2.0' );
	define( 'WB_CHANGE_EMAIL_SLUG', 'wb-change-sender-email' );
	define( 'WB_CHANGE_EMAIL_OPTION', 'wb-change-sender-email' );
	define( 'WB_ADVANCE_EMAIL_OPTION', 'wb-change-advance-email' );
	define( 'WB_SMTP_EMAIL_OPTION', 'wb-change-smtp-email' );
	define( 'WB_CHANGE_EMAIL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	define( 'WB_CHANGE_EMAIL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'WB_CHANGE_EMAIL_UPDATER_ID', 200 );

if ( ! class_exists( 'Wb_Sender_Email_Tweaker_Plugin_File' ) ) {

	/**
	 * Class to display html and add hooks, main class of the plugin.
	 *
	 * @package custom-email-Options
	 * @since   1.0.0
	 */
	class Wb_Sender_Email_Tweaker_Plugin_File {

		/**
		 * General tweak option.
		 *
		 * @since   1.0.0
		 * @var     $wb_general_tweak contain gereral tweak option.
		 */
		private $wb_general_tweak;

		/**
		 * General tweak option.
		 *
		 * @since   1.0.0
		 * @var     $wb_advance_tweak contain gereral tweak option.
		 */
		private $wb_advance_tweak;

		/**
		 * General tweak option.
		 *
		 * @since   1.0.0
		 * @var     $wb_smtp_tweak contain gereral tweak option.
		 */
		private $wb_smtp_tweak;

			private $test_email_msg;
			private $general;

			// calls the default hooks on plugin activation and get values of the setting saved in the option table
		public function __construct() {

			/* Include wbcom plugin folder file. */
			require_once WB_CHANGE_EMAIL_PLUGIN_PATH . 'includes/wbcom/wbcom-admin-settings.php';

			$this->wb_general_tweak = get_option( WB_CHANGE_EMAIL_OPTION );
			$this->wb_advance_tweak = get_option( WB_ADVANCE_EMAIL_OPTION );
			$this->wb_smtp_tweak    = get_option( WB_SMTP_EMAIL_OPTION );
			if ( is_multisite() ) {
				add_action( 'network_admin_menu', array( $this, 'registerAdminMenuPage' ) );
			} else {
				add_action( 'admin_menu', array( $this, 'registerAdminMenuPage' ) );
			}
			add_action( 'admin_init', array( $this, 'saveWbGeneralDataPages' ) );
			add_action( 'admin_init', array( $this, 'saveWbAdvanceDataPages' ) );
			add_action( 'admin_init', array( $this, 'saveWbSmtpDataPages' ) );
			add_action( 'init', array( $this, 'wbLoadTweak' ), 99 );
			add_action( 'init', array( $this, 'wbSentTestEmail' ), 10 );
			add_action( 'init', array( $this, 'wb_redirect_404_to_homepage_or_custom_page' ), 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			if ( isset( $this->wb_general_tweak['general_email_from'] ) && $this->wb_general_tweak['general_email_from'] != '' ) {
				add_filter( 'wp_mail_from', array( $this, 'custom_wp_mail_from' ), 10 );
			}

			if ( isset( $this->wb_general_tweak['general_email_from_name'] ) && $this->wb_general_tweak['general_email_from_name'] != '' ) {
				add_filter( 'wp_mail_from_name', array( $this, 'custom_wp_mail_from_name' ), 10 );
			}

			$this->test_email_msg = '';
			$this->general        = array( // array of the tab based template section to be called in particular tab
				'General Settings' => array(
					'general_email_from',
					'general_email_from_name',
				),
				'Extra Settings'   => array( 'advance_email_option' ),
				'Smtp Settings'    => array( 'smtp_email_option' ),
				'Test Email'       => array( 'general_send_email_test' ),
			);
		}

			/**
			 * Register the stylesheets for the admin area.
			 *
			 * @since    1.0.0
			 */
		public function enqueue_styles() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in User_Profile_Pro_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The User_Profile_Pro_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_style( 'custom-email-options-admin', plugin_dir_url( __FILE__ ) . 'assets/css/admin-ui.css', array() );

		}
		function wb_redirect_404_to_homepage_or_custom_page() {

			if ( is_404() ) {
				$redirect_settings = get_option( 'wb-change-advance-email' );
				if ( array_key_exists( 'general_page404_redirect', $redirect_settings ) ) {
					$redirect_page_id = $redirect_settings['general_page404_redirect'];
					if ( ! empty( $redirect_page_id ) && is_page( $redirect_page_id ) && get_post_status( $redirect_page_id ) == 'publish' ) {
						$link = get_page_link( $redirect_page_id );
						wp_redirect( home_url( $link ), 301 );
					} else {
						wp_redirect( home_url(), 301 );
					}
				} else {
					wp_redirect( home_url(), 301 );
				}

				die();
			}
		}




		public function custom_wp_mail_from_name() {
			return $this->wb_general_tweak['general_email_from_name'];
		}

		public function custom_wp_mail_from() {
			return $this->wb_general_tweak['general_email_from'];
		}

			// Add the menu to the menu bar
		public function registerAdminMenuPage() {
			// add_menu_page('Email Options', 'Email Options', 'manage_options', 'custom_email_options', array($this, 'wbGeneralMenuPage'), 'dashicons-email-alt', 81);

			if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) ) {
				add_menu_page( esc_html__( 'WB Plugins', 'custom-email-options' ), esc_html__( 'WB Plugins', 'custom-email-options' ), 'manage_options', 'wbcomplugins', array( $this, 'wbGeneralMenuPage' ), 'dashicons-lightbulb', 59 );
				add_submenu_page( 'wbcomplugins', esc_html__( 'General', 'custom-email-options' ), esc_html__( 'General', 'custom-email-options' ), 'manage_options', 'wbcomplugins' );
			}
			add_submenu_page( 'wbcomplugins', esc_html__( 'Custom Email Options Settings Page', 'custom-email-options' ), esc_html__( 'Email Options', 'custom-email-options' ), 'manage_options', 'custom-email-options', array( $this, 'wbGeneralMenuPage' ) );
		}


		public function saveWbGeneralDataPages() {
			// general tweak was used
			$nonce = str_replace( ' ', '_', 'General Settings' );
			if ( isset( $_POST['save_wb_general_data_nonce'] ) && wp_verify_nonce( $_POST['save_wb_general_data_nonce'], $nonce ) ) {
				 $this->wb_general_tweak = $_POST['wb_general_tweak'];
				 update_option( WB_CHANGE_EMAIL_OPTION, $this->wb_general_tweak );
			}
		}

		public function saveWbAdvanceDataPages() {
			// Advance tweak was used
			$nonce = str_replace( ' ', '_', 'Extra Settings' );

			if ( isset( $_POST['save_wb_general_data_nonce'] ) && wp_verify_nonce( $_POST['save_wb_general_data_nonce'], $nonce ) ) {
				$this->wb_advance_tweak = $_POST['advance_email_option'];
				update_option( WB_ADVANCE_EMAIL_OPTION, $this->wb_advance_tweak );
			}
		}

		public function saveWbSmtpDataPages() {
			 // smtp tweak was used
			$nonce = str_replace( ' ', '_', 'Smtp Settings' );

			if ( isset( $_POST['save_wb_general_data_nonce'] ) && wp_verify_nonce( $_POST['save_wb_general_data_nonce'], $nonce ) ) {
				$this->wb_smtp_tweak = $_POST['smtp_email_option'];
				update_option( WB_SMTP_EMAIL_OPTION, $this->wb_smtp_tweak );
			}
		}

			// Function to sent the testing email
		public function wbSentTestEmail() {
			 $nonce = str_replace( ' ', '_', 'Test Email' );
			if ( isset( $_POST['save_wb_general_data_nonce'] ) && wp_verify_nonce(
				$_POST['save_wb_general_data_nonce'],
				$nonce
			) ) {
				// general as well as smtp tweak was used
				$swpsmtp_options = $this->wb_smtp_tweak;
				if ( $swpsmtp_options['general_email_send_from'] == 'yes' ) :
					$errors          = '';
					$swpsmtp_options = $this->wb_smtp_tweak;
					$swpsmtp_options = filter_var_array( $swpsmtp_options, FILTER_SANITIZE_STRING );
					require_once ABSPATH . WPINC . '/class-phpmailer.php';
					$mail = new PHPMailer();

					$from_name  = utf8_decode( $swpsmtp_options['wb_mail_from_name'] );
					$from_email = $swpsmtp_options['wb_mail_from_email'];

					// $mail->IsSMTP();

					/* If using smtp auth, set the username & password */
					if ( 'yes' == $swpsmtp_options['wb_mail_auth'] ) {
						$mail->SMTPAuth = true;
						$mail->Username = $swpsmtp_options['wb_mail_username'];
						$mail->Password = $swpsmtp_options['wb_mail_password'];
					}

					/* Set the SMTPSecure value, if set to none, leave this blank */
					if ( $swpsmtp_options['wb_mail_encription'] !== '' ) {
						$mail->SMTPSecure = $swpsmtp_options['wb_mail_encription'];
					}

					/* Set the other options */
					$mail->Host = $swpsmtp_options['wb_mail_smtp_host'];
					$mail->Port = $swpsmtp_options['wb_mail_port'];
					$mail->SetFrom( $from_email, $from_name );
					$mail->isHTML( true );
					$mail->Subject = utf8_decode( $_POST['mail_subject'] );
					$mail->MsgHTML( $_POST['mail_message'] );
					$mail->AddAddress( $_POST['mail_to'] );
					$mail->SMTPDebug = 0;
					/* Send mail and return result */
					if ( ! $mail->Send() ) {
						$errors = $mail->ErrorInfo;
					}

					$mail->ClearAddresses();
					$mail->ClearAllRecipients();

					if ( ! empty( $errors ) ) {
						$this->test_email_msg = $errors;
					} else {
						$this->test_email_msg = 'Test is successful';
					}
					else :
						if ( wp_mail( $_POST['mail_to'], $_POST['mail_subject'], $_POST['mail_message'] ) ) {
							$this->test_email_msg = 'Test is successful';
						} else {
							$this->test_email_msg = 'Test failed';
						}
					endif;
			}
		}

			// function to apply the settings done by the user
		public function wbLoadTweak() {
			 // general,advance and smtp tweak was used

			foreach ( $this->general as $tab => $tweakval ) {
				if ( ! empty( $tweakval ) ) :
					$nonce = str_replace( ' ', '_', $tab );
					foreach ( $tweakval as $tweak_ID ) {
						require_once WB_CHANGE_EMAIL_PLUGIN_PATH . "includes/{$tweak_ID}/tweak.php";

						$tweakCls      = "Wb_{$tweak_ID}_tweak";
						$tweak         = new $tweakCls();
						$tweak->option = $tweak_ID;

						if ( $nonce == 'General_Settings' ) {
							$tweak->value = isset( $this->wb_general_tweak[ $tweak_ID ] ) ? $this->wb_general_tweak[ $tweak_ID ] : '';
							if ( isset( $this->wb_general_tweak[ $tweak_ID ] ) && $this->wb_general_tweak[ $tweak_ID ] != '' ) {
								$tweak->wbTweak();
							}
						} elseif ( $nonce == 'Smtp_Settings' ) {
							$tweak->value = $this->wb_smtp_tweak;

							if ( isset( $this->wb_smtp_tweak ) && ! empty( $this->wb_smtp_tweak ) ) {
								$tweak->wbTweak();
							}
						} else {
							$tweak->value = $this->wb_advance_tweak;
							if ( isset( $this->wb_advance_tweak ) && ! empty( $this->wb_advance_tweak ) ) {
								$tweak->wbTweak();
							}
						}
					}
					endif;
			}
		}

			// Function to generate the tab based html view of the page
		function wbGeneralMenuPage() {
			// general,advance and smtp tweak was used
			?>
				<div class="wrap">
					<div class="blpro-header">
					<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
						<h1 class="wbcom-plugin-heading">
						<?php esc_html_e( 'Custom Email Options Settings', 'custom-email-options' ); ?>
						</h1>
					</div>
					<div class="wbcom-admin-settings-page">
				<?php
				if ( ! empty( $this->test_email_msg ) ) {
					if ( $this->test_email_msg == 'Test failed' ) {
						$notice_cls = 'error';
					} else {
						$notice_cls = 'updated';
					}
					?>
						<div id="setting-error-settings_updated" class="settings-error notice <?php echo $notice_cls; ?> is-dismissible">
							<p><strong><?php echo $this->test_email_msg; ?></strong></p>
							<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e( 'Dismiss this notice.', WB_CHANGE_EMAIL_SLUG ); ?></span></button>
						</div>
					<?php } ?>
					<div class="wbcom-tabs-section">
						<h2 class="nav-tab-wrapper">
						<?php
						$cur_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';
						foreach ( $this->general as $tab => $val ) {
							$current = ( $cur_tab == str_replace( ' ', '_', $tab ) || ( $tab == 'General Settings' && $cur_tab == '' ) ) ? 'nav-tab-active' : '';
							if ( is_multisite() ) {
								$admin_url = ( $tab == 'General Settings' ) ? network_admin_url( 'admin.php?page=custom-email-options' ) : network_admin_url( 'admin.php?page=custom-email-options&tab=' . str_replace( ' ', '_', $tab ) );
							} else {
								$admin_url = ( $tab == 'General Settings' ) ? admin_url( 'admin.php?page=custom-email-options' ) : admin_url( 'admin.php?page=custom-email-options&tab=' . str_replace( ' ', '_', $tab ) );
							}
							echo '<a href="' . $admin_url . '" class="nav-tab ' . $current . '">' . $tab . '</a>';
						}
						?>
						</h2>
					</div>
					<?php
					foreach ( $this->general as $tab => $tweakval ) {
						if ( ! empty( $tweakval ) && $cur_tab == str_replace( ' ', '_', $tab ) || ( $tab == 'General Settings' && $cur_tab == '' ) ) :
							$nonce = str_replace( ' ', '_', $tab );
							?>
						<div class="wbcom-tab-content">
						<form method="POST" action="">
							<table class="form-table">
								<?php
								foreach ( $tweakval as $tweak_ID ) {
									require_once WB_CHANGE_EMAIL_PLUGIN_PATH . "includes/{$tweak_ID}/tweak.php";
									$tweakCls      = "Wb_{$tweak_ID}_tweak";
									$tweak         = new $tweakCls();
									$tweak->option = $tweak_ID;
									if ( $nonce == 'General_Settings' ) {
										$tweak->value = isset( $this->wb_general_tweak[ $tweak_ID ] ) ? $this->wb_general_tweak[ $tweak_ID ] : '';
									} elseif ( $nonce == 'Test_Email' ) {
										$tweak->value = $this->test_email_msg;
									} elseif ( $nonce == 'Smtp_Settings' ) {
										$tweak->value = $this->wb_smtp_tweak;
									} else {
										$tweak->value = $this->wb_advance_tweak;
									}
									$tweak->wbSettings();
								}
								?>
								<tr valign="top">
									<td colspan="2">
										<?php wp_nonce_field( $nonce, 'save_wb_general_data_nonce' ); ?>
										<input type="submit" name="save-wb-general-data" value="SUBMIT" class="button button-primary" />
									</td>
								</tr>
							</table>
						</form>
						</div>
							<?php
					endif;
					}
					?>
					</div>
				</div>
				<?php
		}
	}
		new Wb_Sender_Email_Tweaker_Plugin_File();
}

	// Activation Hook to add default option values
function wb_sender_email_activate() {
	update_option( 'wb-sender-email-version', WB_CHANGE_EMAIL_VERSION );
	update_option( 'wb-sender-email-updater-id', WB_CHANGE_EMAIL_UPDATER_ID );
}

	register_activation_hook( __FILE__, 'wb_sender_email_activate' );

		/**
		 * Deactivation Hook to remove default option values if user has marked to delete them.
		 *
		 * @author wbcomdesigns
		 * @since  1.0.0
		 */
function wb_sender_email_deactivate() {
	$wb_general_tweak = get_option( WB_ADVANCE_EMAIL_OPTION );
	if ( $wb_general_tweak['general_settings_remove'] == 'yes' ) {
		delete_option( WB_CHANGE_EMAIL_OPTION );
		delete_option( WB_ADVANCE_EMAIL_OPTION );
		delete_option( WB_SMTP_EMAIL_OPTION );
		delete_option( 'wb-sender-email-version' );
		delete_option( 'wb-sender-email-updater-id' );
	}
}
	register_deactivation_hook( __FILE__, 'wb_sender_email_deactivate' );
?>
