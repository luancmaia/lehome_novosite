<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class modal_dialog_plugin_admin {

	function __construct() {
		//add filter for WordPress 2.8 changed backend box system !
		add_filter( 'screen_layout_columns', array( $this, 'on_screen_layout_columns' ), 10, 2 );
		//register callback for admin menu  setup
		add_action( 'admin_menu', array( $this, 'on_admin_menu' ) );
		//register the callback been used if options of page been submitted and needs to be processed
		add_action( 'admin_post_save_modal_dialog_general', array( $this, 'on_save_changes_general' ) );
		add_action( 'admin_post_save_modal_dialog_configurations', array( $this, 'on_save_changes_configurations' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_post_meta_boxes' ) );

		add_action( 'edit_post', array( $this, 'md_editsave_post_field' ) );
		add_action( 'save_post', array( $this, 'md_editsave_post_field' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	//for WordPress 2.8 we have to tell, that we support 2 columns !
	function on_screen_layout_columns( $columns, $screen ) {
		if ( $screen == $this->pagehooktop ) {
			$columns[ $this->pagehooktop ] = 1;
		} elseif ( $screen == $this->pagehooksettings ) {
			$columns[ $this->pagehooksettings ] = 1;
		}

		return $columns;
	}

	function add_post_meta_boxes() {
		// Add addition section to Post/Page Edition page
		add_meta_box( 'modaldialog_meta_box', __( 'Modal Dialog', 'modal-dialog' ), array(
			$this,
			'md_post_edit_extra'
		), 'post', 'normal', 'high' );
		add_meta_box( 'modaldialog_meta_box', __( 'Modal Dialog', 'modal-dialog' ), array(
			$this,
			'md_post_edit_extra'
		), 'page', 'normal', 'high' );
	}

	function remove_querystring_var( $url, $key ) {
		$keypos = strpos( $url, $key );
		if ( $keypos ) {
			$ampersandpos = strpos( $url, '&', $keypos );
			$newurl       = substr( $url, 0, $keypos - 1 );

			if ( $ampersandpos ) {
				$newurl .= substr( $url, $ampersandpos );
			}
		} else {
			$newurl = $url;
		}

		return $newurl;
	}

	//extend the admin menu
	function on_admin_menu() {
		//add our own option page, you can also add it to different sections or use your own one
		global $accesslevelcheck;
		$this->pagehooktop      = add_menu_page( __( 'Modal Dialog General Options', 'modal-dialog' ), "Modal Dialog", $accesslevelcheck, MODAL_DIALOG_ADMIN_PAGE_NAME, array(
			$this,
			'on_show_page'
		), plugins_url( 'icons/ModalDialog16.png', __FILE__ ) );
		$this->pagehooksettings = add_submenu_page( MODAL_DIALOG_ADMIN_PAGE_NAME, __( 'Modal Dialog - Configurations', 'modal-dialog' ), __( 'Configurations', 'modal-dialog' ), $accesslevelcheck, 'modal-dialog-configurations', array(
			$this,
			'on_show_page'
		) );
		$this->pagehookfaq      = add_submenu_page( MODAL_DIALOG_ADMIN_PAGE_NAME, __( 'Modal Dialog - FAQ', 'modal-dialog' ), __( 'FAQ', 'modal-dialog' ), $accesslevelcheck, 'modal-dialog-faq', array(
			$this,
			'on_show_page'
		) );

		//register  callback gets call prior your own page gets rendered
		add_action( 'load-' . $this->pagehooktop, array( &$this, 'on_load_page' ) );
		add_action( 'load-' . $this->pagehooksettings, array( &$this, 'on_load_page' ) );
		add_action( 'load-' . $this->pagehookfaq, array( &$this, 'on_load_page' ) );
	}

	//will be executed if wordpress core detects this page has to be rendered
	function on_load_page() {
		//ensure, that the needed javascripts been loaded to allow drag/drop, expand/collapse and hide/show of boxes
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );

		//add several metaboxes now, all metaboxes registered during load page can be switched off/on at "Screen Options" automatically, nothing special to do therefore
		add_meta_box( 'modaldialog_general_meta_box', __( 'General Configuration', 'modal-dialog' ), array(
			$this,
			'general_config_meta_box'
		), $this->pagehooktop, 'normal', 'high' );
		add_meta_box( 'modaldialog_general_save_meta_box', __( 'Save General Configuration', 'modal-dialog' ), array(
			$this,
			'general_save_meta_box'
		), $this->pagehooktop, 'normal', 'high' );

		add_meta_box( 'modaldialog_dialog_config_selection_meta_box', __( 'Modal Dialog Selection', 'modal-dialog' ), array(
			$this,
			'dialog_config_selection_meta_box'
		), $this->pagehooksettings, 'normal', 'high' );

		add_meta_box( 'modaldialog_dialog_config_meta_box', __( 'General Configuration', 'modal-dialog' ), array(
			$this,
			'dialog_config_meta_box'
		), $this->pagehooksettings, 'normal', 'high' );

		add_meta_box( 'modaldialog_dialog_visibility_meta_box', __( 'Visibility', 'modal-dialog' ), array(
			$this,
			'dialog_config_visibility_meta_box'
		), $this->pagehooksettings, 'normal', 'high' );

		add_meta_box( 'modaldialog_dialog_config_cookie_meta_box', __( 'Cookie Settings', 'modal-dialog' ), array(
			$this,
			'dialog_config_cookie_meta_box'
		), $this->pagehooksettings, 'normal', 'high' );

		add_meta_box( 'modaldialog_dialog_config_layout_meta_box', __( 'Layout', 'modal-dialog' ), array(
			$this,
			'dialog_config_layout_meta_box'
		), $this->pagehooksettings, 'normal', 'high' );

		add_meta_box( 'modaldialog_dialog_config_save_meta_box', __( 'Preview / Save', 'modal-dialog' ), array(
			$this,
			'dialog_config_save_meta_box'
		), $this->pagehooksettings, 'normal', 'high' );

		add_meta_box( 'modaldialog_dialog_faq_meta_box', __( 'Frequently Asked Questions', 'modal-dialog' ), array(
			$this,
			'dialog_config_faq_meta_box'
		), $this->pagehookfaq, 'normal', 'high' );

	}

	//executed to show the plugins complete admin page
	function on_show_page() {
		//we need the global screen column value to beable to have a sidebar in WordPress 2.8
		global $screen_layout_columns;
		global $wpdb;

		$genoptions = get_option( 'MD_General' );

		$config = '';

		if ( isset( $_GET['config'] ) && $config == '' ) {
			$config = $_GET['config'];

			if ( $config > $genoptions['numberofmodaldialogs'] ) {
				$config = 1;
			}
		} else {
			$config = 1;
		}

		if ( $_GET['page'] == 'modal-dialog' ) {
			$pagetitle = __( 'Modal Dialog General Settings', 'modal-dialog' );
			$formvalue = 'save_modal_dialog_general';

			if ( isset( $_GET['message'] ) && $_GET['message'] == '1' ) {
				echo '<div id="message" class="updated fade"><p><strong>' . __( 'Modal Dialog General Settings Updated', 'modal-dialog' ) . '</strong></div>';
			}
		} elseif ( $_GET['page'] == 'modal-dialog-configurations' ) {
			$pagetitle = __( 'Modal Dialog Configurations', 'modal-dialog' );
			$formvalue = 'save_modal_dialog_configurations';

			if ( isset( $_GET['message'] ) && $_GET['message'] == '1' ) {
				echo '<div id="message" class="updated fade"><p><strong>' . __( 'Modal Dialog Configuration Updated', 'modal-dialog' ) . ' (#' . $config . ')</strong></div>';
			}
		} elseif ( $_GET['page'] == 'modal-dialog-faq' ) {
			$pagetitle = __( 'Modal Dialog FAQ', 'modal-dialog' );
			$formvalue = 'save_modal_dialog_faq';
		}

		$configname = 'MD_PP' . $config;
		$options    = get_option( $configname );

		if ( $options == false ) {
			modal_dialog_default_config( $config );
			$options = get_option( $configname );
		}

		$options = wp_parse_args( $options, modal_dialog_default_config( 1, 'return' ) );

		//define some data can be given to each metabox during rendering
		$data['options']    = $options;
		$data['config']     = $config;
		$data['genoptions'] = $genoptions;
		?>
		<div id="modal-dialog-general" class="wrap">
			<div class='icon32'><img src="<?php echo plugins_url( '/icons/ModalDialog32.png', __FILE__ ); ?>" /></div>
			<h2><?php echo $pagetitle; ?>
				<span style='padding-left: 50px'><a href="http://ylefebvre.ca/wordpress-plugins/modal-dialog/" target="modaldialog"><img src="<?php echo plugins_url( "/icons/btn_donate_LG.gif", __FILE__ ); ?>" /></a></span>
			</h2>

			<form action="admin-post.php" method="post" id='mdform' enctype='multipart/form-data'>
				<?php wp_nonce_field( 'modal-dialog-general' ); ?>
				<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
				<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
				<input type="hidden" name="action" value="<?php echo $formvalue; ?>" />

				<div id="poststuff" class="metabox-holder">
					<div id="post-body" class="has-sidebar">
						<div id="post-body-content" class="has-sidebar-content">
							<?php
							if ( $_GET['page'] == 'modal-dialog' ) {
								do_meta_boxes( $this->pagehooktop, 'normal', $data );
							} elseif ( $_GET['page'] == 'modal-dialog-configurations' ) {
								do_meta_boxes( $this->pagehooksettings, 'normal', $data );
							} elseif ( $_GET['page'] == 'modal-dialog-faq' ) {
								do_meta_boxes( $this->pagehookfaq, 'normal', $data );
							}

							?>
						</div>
					</div>
					<br class="clear" />

				</div>
			</form>
		</div>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function ($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
			});
			//]]>
		</script>

	<?php
	}

	//executed if the post arrives initiated by pressing the submit button of form
	function on_save_changes_general() {
		//user permission check
		global $accesslevelcheck;
		if ( ! current_user_can( $accesslevelcheck ) ) {
			wp_die( __( 'Cheatin&#8217; uh?' ) );
		}
		//cross check the given referer
		check_admin_referer( 'modal-dialog-general' );

		$options = get_option( 'MD_General' );

		foreach ( array( 'numberofmodaldialogs', 'primarydialog', 'popupscript', 'accesslevel' ) as $option_name ) {
			if ( isset( $_POST[ $option_name ] ) ) {
				$options[ $option_name ] = $_POST[ $option_name ];
			}
		}

		foreach ( array( 'disableonmobilebrowsers' ) as $option_name ) {
			if ( isset( $_POST[ $option_name ] ) ) {
				$options[ $option_name ] = true;
			} else {
				$options[ $option_name ] = false;
			}
		}

		update_option( 'MD_General', $options );

		//lets redirect the post request into get request (you may add additional params at the url, if you need to show save results
		wp_redirect( $this->remove_querystring_var( $_POST['_wp_http_referer'], 'message' ) . "&message=1" );
	}

	//executed if the post arrives initiated by pressing the submit button of form
	function on_save_changes_configurations() {
		//user permission check
		global $accesslevelcheck;
		if ( ! current_user_can( $accesslevelcheck ) ) {
			wp_die( __( 'Cheatin&#8217; uh?' ) );
		}
		//cross check the given referer
		check_admin_referer( 'modal-dialog-general' );

		if ( isset( $_POST['configid'] ) ) {
			$configid = $_POST['configid'];
		} else {
			$configid = 1;
		}

		$configname = 'MD_PP' . $configid;
		$options    = get_option( $configname );

		foreach (
			array(
				'dialogtext',
				'contentlocation',
				'cookieduration',
				'contenturl',
				'pages',
				'overlaycolor',
				'textcolor',
				'backgroundcolor',
				'delay',
				'dialogwidth',
				'dialogheight',
				'cookiename',
				'numberoftimes',
				'exitmethod',
				'sessioncookiename',
				'overlayopacity',
				'autoclosetime',
				'dialogname',
				'displayfrequency',
				'dialogclosingcallback',
				'excludepages',
				'countermode',
				'dialogposition',
				'topposition',
				'leftposition',
				'rightposition',
				'bottomposition',
				'transitionmode',
				'excludeurlstrings',
				'codecondition'
			) as $option_name
		) {
			if ( isset( $_POST[ $option_name ] ) ) {
				$options[ $option_name ] = $_POST[ $option_name ];
			}
		}

		foreach ( array( 'active' ) as $option_name ) {
			if ( isset( $_POST[ $option_name ] ) && $_POST[ $option_name ] == "True" ) {
				$options[ $option_name ] = true;
			} elseif ( isset( $_POST[ $option_name ] ) && $_POST[ $option_name ] == "False" ) {
				$options[ $option_name ] = false;
			}
		}

		foreach (
			array(
				'autosize',
				'showfrontpage',
				'forcepagelist',
				'oncepersession',
				'hideclosebutton',
				'centeronscroll',
				'manualcookiecreation',
				'autoclose',
				'checklogin',
				'showaftercommentposted',
				'hidescrollbars',
				'ignoreesckey',
				'showregisterpage'
			) as $option_name
		) {
			if ( isset( $_POST[ $option_name ] ) ) {
				$options[ $option_name ] = true;
			} else {
				$options[ $option_name ] = false;
			}
		}

		update_option( $configname, $options );

		//lets redirect the post request into get request (you may add additional params at the url, if you need to show save results
		wp_redirect( $this->remove_querystring_var( $_POST['_wp_http_referer'], 'message' ) . "&message=1&config=" . $configid );
	}

	function general_config_meta_box( $data ) {
		$genoptions = $data['genoptions'];
		?>

		<table>
			<tr>
				<td style="width: 200px">Number of Modal Dialogs</td>
				<td>
					<input type="text" id="numberofmodaldialogs" name="numberofmodaldialogs" size="5" value="<?php echo $genoptions['numberofmodaldialogs']; ?>" />
				</td>
			</tr>
			<?php if (current_user_can( 'manage_options' )) { ?>
			<tr>
				<td style='width:200px'>Access level required</td>
				<td>
					<?php } ?>
					<select <?php if ( ! current_user_can( 'manage_options' ) ) {
						echo 'style="display: none"';
					} ?> id="accesslevel" name="accesslevel">
						<?php $levels = array(
							'admin'       => 'Administrator',
							'editor'      => 'Editor',
							'author'      => 'Author',
							'contributor' => 'Contributor',
							'subscriber'  => 'Subscriber'
						);
						if ( ! isset( $genoptions['accesslevel'] ) || empty( $genoptions['accesslevel'] ) ) {
							$genoptions['accesslevel'] = 'admin';
						}

						foreach ( $levels as $key => $level ) {
							echo '<option value="' . $key . '" ' . selected( $genoptions['accesslevel'], $key, false ) . '>' . $level . '</option>';
						} ?>
					</select>
					<?php if (current_user_can( 'manage_options' )) { ?>
				</td>
			</tr>
		<?php } ?>
			<tr>
				<td>Disable on mobile browsers</td>
				<td>
					<input type="checkbox" id="disableonmobilebrowsers" name="disableonmobilebrowsers" <?php if ( $genoptions['disableonmobilebrowsers'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
			</tr>
			<tr>
				<td>Pop-Up Dialog Script</td>
				<td>
					<select name="popupscript" id="popupscript" style="width:250px;">
						<option value="colorbox"<?php if ( ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) || ! isset( $genoptions['popupscript'] ) ) {
							echo ' selected="selected"';
						} ?>>Colorbox
						</option>
						<option value="fancybox"<?php if ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'fancybox' ) {
							echo ' selected="selected"';
						} ?>>Fancybox (legacy)
						</option>
					</select>
				</td>
			</tr>
		</table>

	<?php
	}

	function general_save_meta_box( $data ) {
		?>
		<div class="submitbox">
			<input type="submit" name="submit" class="button-primary" value="<?php _e( 'Save Settings', 'modal-dialog' ); ?>" />
		</div>

	<?php
	}

	function dialog_config_selection_meta_box( $data ) {
		$genoptions = $data['genoptions'];
		$config     = $data['config'];
		?>

		<?php _e( 'Select Current Dialog Configuration', 'modal-dialog' ); ?> :
		<SELECT id="configlist" name="configlist" style='width: 300px'>
			<?php if ( $genoptions['numberofmodaldialogs'] == '' ) {
				$numberofdialogs = 1;
			} else {
				$numberofdialogs = $genoptions['numberofmodaldialogs'];
			}
			for ( $counter = 1; $counter <= $numberofdialogs; $counter ++ ): ?>
				<?php $tempoptionname = "MD_PP" . $counter;
				$tempoptions          = get_option( $tempoptionname ); ?>
				<option value="<?php echo $counter ?>" <?php if ( $config == $counter ) {
					echo 'SELECTED';
				} ?>><?php if ( $counter == 1 ) {
						_e( 'Primary ', 'modal-dialog' );
					} ?><?php _e( 'Dialog', 'modal-dialog' ); ?> <?php echo $counter ?><?php if ( $tempoptions != "" ) {
						echo " (" . $tempoptions['dialogname'] . ")";
					} ?></option>
			<?php endfor; ?>
		</SELECT>
		<INPUT type="button" name="go" value="<?php _e( 'Make Current', 'modal-dialog' ); ?>!" onClick="window.location= 'admin.php?page=modal-dialog-configurations&amp;config=' + jQuery('#configlist').val()">

	<?php
	}

	function dialog_config_meta_box( $data ) {
		$options    = $data['options'];
		$config     = $data['config'];
		$genoptions = $data['genoptions'];
		?>
		<input type='hidden' value='<?php echo $config; ?>' name='configid' id='configid' />
		<table>
			<tr>
				<td style="width:250px">Dialog Name</td>
				<td>
					<input type="text" id="dialogname" name="dialogname" size="40" value="<?php echo $options['dialogname']; ?>" />
				</td>
			</tr>
			<tr>
				<td>Activate</td>
				<td>
					<select name="active" id="active" style="width:250px;">
						<option value="True"<?php if ( $options['active'] == true ) {
							echo ' selected="selected"';
						} ?>>Yes
						</option>
						<option value="False"<?php if ( $options['active'] == false ) {
							echo ' selected="selected"';
						} ?>>No
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Content Source</td>
				<td>
					<select name="contentlocation" id="contentlocation" style="width:250px;">
						<option value="URL"<?php if ( $options['contentlocation'] == 'URL' ) {
							echo ' selected="selected"';
						} ?>>Web Site Address
						</option>
						<option value="Inline"<?php if ( $options['contentlocation'] == 'Inline' ) {
							echo ' selected="selected"';
						} ?>>Specify Below in Dialog Contents
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Appearance Delay (in milliseconds)</td>
				<td><input type="text" id="delay" name="delay" size="5" value="<?php echo $options['delay']; ?>" /></td>
			</tr>
			<tr>
				<td>Web Site Address</td>
				<td colspan=3>
					<input type="text" id="contenturl" name="contenturl" size="40" value="<?php echo $options['contenturl']; ?>" />
				</td>
			</tr>
			<tr>
				<td>Dialog Contents</td>
				<td>
					<TEXTAREA id="dialogtext" NAME="dialogtext" COLS=80 ROWS=10><?php echo esc_html( stripslashes( $options['dialogtext'] ) ); ?></TEXTAREA>
				</td>
			</tr>
		</table>
	<?php
	}

	function dialog_config_visibility_meta_box( $data ) {
		$options    = $data['options'];
		$config     = $data['config'];
		$genoptions = $data['genoptions'];
		?>
		<table>
			<tr>
				<td>Display on front page</td>
				<td>
					<input type="checkbox" id="showfrontpage" name="showfrontpage" <?php if ( $options['showfrontpage'] == true ) {
						echo ' checked="checked" ';
					} ?>/></td>
			</tr>
			<tr>
				<td>Do not show if user logged in</td>
				<td><input type="checkbox" id="checklogin" name="checklogin" <?php if ( $options['checklogin'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
				<td>Display after new comment posted</td>
				<td>
					<input type="checkbox" id="showaftercommentposted" name="showaftercommentposted" <?php checked( $options['showaftercommentposted'] ); ?>/></td>
			</tr>
			<tr>
				<td>Auto-Close Dialog</td>
				<td><input type="checkbox" id="autoclose" name="autoclose" <?php checked( $options['autoclose'] ); ?>/>
				</td>
				<td>Auto-Close Time (in ms)</td>
				<td>
					<input type="text" id="autoclosetime" name="autoclosetime" size="8" value="<?php echo $options['autoclosetime']; ?>" />
				</td>
			</tr>
			<tr>
				<td style="width: 250px">Only show on specific pages and single posts</td>
				<td><input type="checkbox" <?php if ( $config > 1 ) {
						checked(1); disabled(1);
					} ?> id="forcepagelist" name="forcepagelist" <?php if ( $options['forcepagelist'] == true ) {
						echo ' checked="checked" ';
					} ?>/></td>
				<td>Show on registration page</td>
				<td><input type="checkbox" id="showregisterpage" name="showregisterpage" <?php checked( $options['showregisterpage'] ); ?>/></td>
			</tr>
			<tr>
				<td>Pages and posts to display Modal Dialog (empty for all, comma-separated IDs)</td>
				<td colspan="3"><input type="text" id="pages" name="pages" style="width: 100%" value="<?php echo $options['pages']; ?>" />
				</td>
			</tr>
			<tr>
				<td>Pages and posts not to display dialog on (comma-separated IDs)</td>
				<td colspan="3">
					<input type="text" id="excludepages" name="excludepages" style="width: 100%" value="<?php echo $options['excludepages']; ?>" />
				</td>
			</tr>
			<tr>
				<td>URLs not to display display on (comma-separated URL strings)</td>
				<td colspan="3">
					<input type="text" id="excludeurlstrings" name="excludeurlstrings" style="width: 100%" value="<?php echo $options['excludeurlstrings']; ?>" />
				</td>
			</tr>
			<tr>
				<td>PHP Condition string ( E.g. in_category(3) || is_archive(3) )</td>
				<td colspan="3">
					<input type="text" id="codecondition" name="codecondition" style="width: 100%" value="<?php echo stripslashes( $options['codecondition'] ); ?>" />
				</td>
			</tr>
			<tr>
				<td>Javascript Dialog Closure Callback</td>
				<td>
					<input type="text" id="dialogclosingcallback" name="dialogclosingcallback" size="30" value="<?php echo $options['dialogclosingcallback']; ?>" />
				</td>
			</tr>

		</table>

	<?php }

	function dialog_config_cookie_meta_box( $data ) {
		$options    = $data['options'];
		$config     = $data['config'];
		$genoptions = $data['genoptions'];
		?>

		<table>
			<tr>
				<td style="width: 250px">Number of days until cookie expiration</td>
				<td>
					<input type="text" id="cookieduration" name="cookieduration" size="4" value="<?php echo $options['cookieduration']; ?>" />
				</td>
				<td>Number of times to display / before displaying modal dialog</td>
				<td>
					<input type="text" id="numberoftimes" name="numberoftimes" size="4" value="<?php echo $options['numberoftimes']; ?>" />
				</td>
			</tr>
			<tr>
				<td>Counter Mode</td>
				<td>
					<select name="countermode" id="countermode" style="width:200px;">
						<option value="timestodisplay" <?php selected( $options['countermode'] == 'timestodisplay' ); ?>>Display x Times</option>
						<option value="timesbeforedisplay" <?php selected( $options['countermode'] == 'timesbeforedisplay' ) ?>>Display after x Views</option>
					</select>
				</td>
				<td>Period to display dialog (every # page loads)</td>
				<td>
					<input type="text" id="displayfrequency" name="displayfrequency" size="4" value="<?php echo( $options['displayfrequency'] == '' ? '1' : $options['displayfrequency'] ); ?>" />
				</td>
				</td>
			</tr>
			<tr>
				<td>Cookie Name</td>
				<td>
					<input type="text" id="cookiename" name="cookiename" size="30" value="<?php echo $options['cookiename']; ?>" />
				</td>
				<td>Show once per session</td>
				<td>
					<input type="checkbox" id="oncepersession" name="oncepersession" <?php if ( $options['oncepersession'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
			</tr>
			<tr>
				<td>Session Cookie Name</td>
				<td>
					<input type="text" id="sessioncookiename" name="sessioncookiename" size="30" value="<?php if ( $options['sessioncookiename'] != '' ) {
						echo $options['sessioncookiename'];
					} else {
						echo 'modal-dialog-session';
					} ?>" /></td>
				<td>Set display cookies manually</td>
				<td>
					<input type="checkbox" id="manualcookiecreation" name="manualcookiecreation" <?php if ( $options['manualcookiecreation'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="button" id="deletecookies" name="deletecookies" value="Delete All Cookies" /></td>
			</tr>
		</table>

		<script type="text/javascript">
			jQuery(document).ready(function () {
				jQuery("#deletecookies").click(function () {
					jQuery.cookie(jQuery("#cookiename").val(), null, {path: '/'});
					jQuery.cookie(jQuery("#sessioncookiename").val(), null, {path: '/'});
					alert("Deleted all cookies");
				});
			});
		</script>

	<?php }

	function dialog_config_layout_meta_box( $data ) {
		$options    = $data['options'];
		$config     = $data['config'];
		$genoptions = $data['genoptions'];
		?>
		<table>
			<tr>
				<td style="width:250px">Hide Close Button</td>
				<td>
					<input type="checkbox" id="hideclosebutton" name="hideclosebutton" <?php if ( $options['hideclosebutton'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
				<td>Ignore Escape Key</td>
				<td>
					<input type="checkbox" id="ignoreesckey" name="ignoreesckey" <?php if ( isset( $options['ignoreesckey'] ) && $options['ignoreesckey'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
			</tr>
			<tr>
				<td>Center on scroll</td>
				<td>
					<input type="checkbox" id="centeronscroll" name="centeronscroll" <?php if ( $options['centeronscroll'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
				<td>Auto-Size Dialog</td>
				<td><input type="checkbox" id="autosize" name="autosize" <?php if ( $options['autosize'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
			</tr>
			<tr>
				<td>Hide Scroll Bars</td>
				<td>
					<input type="checkbox" id="hidescrollbars" name="hidescrollbars" <?php if ( $options['hidescrollbars'] ) {
						echo ' checked="checked" ';
					} ?>/></td>
				<td>Transition</td>
				<td>
					<select name="transitionmode" id="transitionmode" style="width:200px;">
						<option value="fade" <?php selected( $options['transitionmode'] == 'Fade' ); ?>>Fade</option>
						<option value="elastic" <?php selected( $options['transitionmode'] == 'elastic' ) ?>>Elastic</option>
						<option value="none" <?php selected( $options['transitionmode'] == 'none' ) ?>>None</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Dialog Width</td>
				<td>
					<input type="text" id="dialogwidth" name="dialogwidth" size="4" value="<?php echo $options['dialogwidth']; ?>" />
				</td>
				<td>Dialog Height</td>
				<td>
					<input type="text" id="dialogheight" name="dialogheight" size="4" value="<?php echo $options['dialogheight']; ?>" />
				</td>
			</tr>
			<tr <?php if ( $genoptions['popupscript'] != 'colorbox' ) {
				echo 'style="display:none;';
			} ?>>
				<td>Dialog Position</td>
				<td>
					<select name="dialogposition" id="dialogposition" style="width:100px;">
						<option value="center"<?php selected( $options['dialogposition'] == 'center' ) ?>>Center</option>
						<option value="userposition"<?php selected( $options['dialogposition'] == 'userposition' ); ?>>User-Defined Position</option>
					</select>
				</td>
				<td>Dialog Exit Method</td>
				<td>
					<select name="exitmethod" id="exitmethod" style="width:100px;">
						<option value="onlyexitbutton"<?php selected( $options['exitmethod'] == 'onlyexitbutton' ); ?>>Only Close Button</option>
						<option value="anywhere"<?php selected( $options['exitmethod'] == 'anywhere' ); ?>>Anywhere</option>
					</select>
				</td>
			</tr>
			<tr class="userpositionsettings" <?php if ( $genoptions['popupscript'] != 'colorbox' || ( $genoptions['popupscript'] == 'colorbox' && $options['dialogposition'] == 'center' ) ) {
				echo 'style="display:none;"';
			} ?>>
				<td>(only specify required fields, in pixels or percentage)</td>
				<td colspan="3">Top<input type="text" id="topposition" name="topposition" size="6" value="<?php echo $options['topposition']; ?>" />
					Left<input type="text" id="leftposition" name="leftposition" size="6" value="<?php echo $options['leftposition']; ?>" />
					Right<input type="text" id="rightposition" name="rightposition" size="6" value="<?php echo $options['rightposition']; ?>" />
					Bottom<input type="text" id="bottomposition" name="bottomposition" size="6" value="<?php echo $options['bottomposition']; ?>" />
				</td>
			</tr>
			<tr>
				<td>Overlay Color</td>
				<td>
					<input type="text" id="overlaycolor" name="overlaycolor" size="8" value="<?php echo $options['overlaycolor']; ?>" />
				</td>
				<td>Overlay Opacity (0 to 1)</td>
				<td>
					<input type="text" id="overlayopacity" name="overlayopacity" size="8" value="<?php if ( $options['overlayopacity'] == '' ) {
						echo '0.3';
					} else {
						echo $options['overlayopacity'];
					} ?>" /></td>
			</tr>
			<tr>
				<td>Text Color (not used with web site address)</td>
				<td>
					<input type="text" id="textcolor" name="textcolor" size="8" value="<?php echo $options['textcolor']; ?>" />
				</td>
				<td>Background Color</td>
				<td>
					<input type="text" id="backgroundcolor" name="backgroundcolor" size="8" value="<?php echo $options['backgroundcolor']; ?>" />
				</td>

			</tr>

		</table>

		<script type="text/javascript">
			jQuery(document).ready(function () {
				jQuery("#dialogposition").change(function () {
					jQuery(".userpositionsettings").toggle();
				});
			});
		</script>

	<?php }

	function dialog_config_save_meta_box( $data ) {
		$options = $data['options'];
		?>
		<!-- <span>
			<input type="button" class="button" id="previewdialog" name="previewdialog" value="Preview Modal Dialog" />
		</span> -->
		<span class="submitbox">
			<input type="submit" name="submit" class="button-primary" value="<?php _e( 'Save Settings', 'modal-dialog' ); ?>" />
		</span>

		<!--
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#previewdialog").click(function() {
					alert("Test");
				});
			});
		</script>
		-->

	<?php
	}

	function md_post_edit_extra( $post ) {
		global $wpdb;

		$genoptions = get_option( 'MD_General' );

		if ( $post->ID != '' ) {
			$dialogid = get_post_meta( $post->ID, "modal-dialog-id", true );
			if ( $dialogid == "" ) {
				$dialogid = 0;
			}
		} else {
			$dialogid = 0;
		}
		?>
		<table>
			<tr>
				<td colspan="2">Setting a dialog here will take priority over any other dialog specified under the Modal Dialog Settings page.</td>
			</tr>
			<tr>
				<td style='width: 200px'><?php _e( 'Modal Display to Display', 'modal-dialog' ); ?></td>
				<td>
					<SELECT id="dialogid" name="dialogid" style='width: 300px'>
						<option value="0">None</option>
						<?php if ( $genoptions['numberofmodaldialogs'] == '' ) {
							$numberofdialogs = 1;
						} else {
							$numberofdialogs = $genoptions['numberofmodaldialogs'];
						}
						for ( $counter = 1; $counter <= $numberofdialogs; $counter ++ ): ?>
							<?php $tempoptionname = "MD_PP" . $counter;
							$tempoptions          = get_option( $tempoptionname ); ?>
							<option value="<?php echo $counter ?>" <?php if ( $dialogid == $counter ) {
								echo 'SELECTED';
							} ?>><?php _e( 'Dialog', 'modal-dialog' ); ?> <?php echo $counter ?><?php if ( $tempoptions != "" ) {
									echo " (" . $tempoptions['dialogname'] . ")";
								} ?></option>
						<?php endfor; ?>
					</SELECT>
				</td>
			</tr>
		</table>
	<?php
	}

	function md_editsave_post_field( $post_id ) {
		if ( isset( $_POST['dialogid'] ) ) {
			update_post_meta( $post_id, "modal-dialog-id", $_POST['dialogid'] );
		}
	}

	function dialog_config_faq_meta_box() {
		?>

		<h2>Why is Modal Dialog not showing up on my web site?</h2>

		<p>There are typically two main reasons why Modal Dialog does not show up correctly on web pages:</p>

		<ol>
			<li>You have another plugin installed which uses jQuery on your site that has its own version of jQuery instead of using the default version that is part of the Wordpress install. To see if this is the case, go to your site and look at the page source, then search for jQuery. If you see some versions of jQuery that get loaded from plugin directories, then this is most likely the source of the problem as they would conflict with the copy of jQuery that is delivered with Wordpress.</li>

			<li>The other thing to check is to see if your theme has the wp_head and wp_footer functions in the theme's header. If these functions are not present, then the plugin will not work as expected.</li>

			<li>The last potential issue is a javascript conflict on your site. Install a browser plugin such as Firebug and look at the console to see if any javascript errors are display. Then look at the problematic plugin and try to fix the problem. A single javascript error will prevent all remaining javascript from executing.</li>
		</ol>

		<p>You can send me a link to your web site if these solutions don't help you so that I can see what is happening myself and try to provide a solution.</p>

		<h2>How can I make Modal Dialog open when I click on a button or a link?</h2>

		<p>Add the onclick property to your link or button code and call the <code>modal_dialog_open()</code> function.
		</p>

		<p>
			<code>&lt;a href=&quot;#&quot; onclick=&quot;modal_dialog_open();&quot; title=&quot;Learn More&quot;&gt;Learn More&lt;/a&gt;</code>
		</p>

		<p><code>&lt;button onclick=&quot;modal_dialog_open();&quot;&gt;Open Modal&lt;/button&gt;</code></p>

		<h2>How can I close the Modal Dialog Window Manually?</h2>

		<p>You can create a button or other control that calls the <code>modal_dialog_close()</code> function:</p>

		<p>
			<code>&lt;a href=&quot;#&quot; onclick=&quot;modal_dialog_close();&quot; title=&quot;Close dialog&quot;&gt;Learn More&lt;/a&gt;</code>
		</p>

		<p><code>&lt;button onclick=&quot;modal_dialog_close();&quot;&gt;Close Modal&lt;/button&gt;</code></p>

		<h2>How can I manually set the cookie if I ask Modal Dialog to let me do it manually?</h2>

		<p>Call the following javascript / jQuery function, setting the cookie-name to match the name entered in the Modal Dialog settings, the cookievalue and the duration to any duration that you deem acceptable.</p>

		<p>jQuery.cookie('cookie-name', cookievalue, { expires: 365 });</p>


	<?php
	}

	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'jquerycookies', plugins_url( "cookie.js", __FILE__ ), "", "1.0" );
	}
}