<?php
/* Plugin Name: Modal Dialog
Plugin URI: http://ylefebvre.ca/modal-dialog/
Description: A plugin used to display a modal dialog to visitors with text content or the contents of an external web site
Version: 3.5.5
Author: Yannick Lefebvre
Author URI: http://ylefebvre.ca
Copyright 2015  Yannick Lefebvre  (email : ylefebvre@gmail.com)

This program is free software; you can redistribute it and/or modify   
it under the terms of the GNU General Public License as published by    
the Free Software Foundation; either version 2 of the License, or    
(at your option) any later version.    

This program is distributed in the hope that it will be useful,    
but WITHOUT ANY WARRANTY; without even the implied warranty of    
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    
GNU General Public License for more details.    

You should have received a copy of the GNU General Public License    
along with this program; if not, write to the Free Software    
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA*/

define( 'MODAL_DIALOG_ADMIN_PAGE_NAME', 'modal-dialog' );

define( 'MDDIR', dirname( __FILE__ ) . '/' );

require_once( ABSPATH . '/wp-admin/includes/template.php' );
require_once plugin_dir_path( __FILE__ ) . 'modal-dialog-defaults.php';

global $accesslevelcheck;
global $my_modal_dialog_plugin_admin;
$accesslevelcheck = '';

$genoptions = get_option( 'MD_General' );
$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

if ( ! isset( $genoptions['accesslevel'] ) || empty( $genoptions['accesslevel'] ) ) {
	$genoptions['accesslevel'] = 'admin';
}

switch ( $genoptions['accesslevel'] ) {
	case 'admin':
		$accesslevelcheck = 'manage_options';
		break;

	case 'editor':
		$accesslevelcheck = 'manage_categories';
		break;

	case 'author':
		$accesslevelcheck = 'publish_posts';
		break;

	case 'contributor':
		$accesslevelcheck = 'edit_posts';
		break;

	case 'subscriber':
		$accesslevelcheck = 'read';
		break;

	default:
		$accesslevelcheck = 'manage_options';
		break;
}

//class that reperesent the complete plugin
class modal_dialog_plugin {

	//constructor of class, PHP4 compatible construction for backward compatibility
	public function __construct() {

		$genoptions = get_option( 'MD_General' );

		if ( $genoptions == false ) {
			$this->md_install();
		}

		if ( is_admin() ) {
			global $my_modal_dialog_plugin_admin;
			require plugin_dir_path( __FILE__ ) . 'modal-dialog-admin.php';
			$my_modal_dialog_plugin_admin = new modal_dialog_plugin_admin();

			add_action( 'admin_head', array( $this, 'modal_dialog_admin_header' ) );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'modal_dialog_content', 'do_shortcode', 11 );

		$genoptions = get_option( 'MD_General' );
		$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

		for ( $counter = 1; $counter <= $genoptions['numberofmodaldialogs']; $counter ++ ) {
			$optionsname = "MD_PP" . $counter;
			$options     = get_option( $optionsname );
			$options = wp_parse_args( $options, modal_dialog_default_config( $counter, 'return' ) );

			if ( $options['active'] == true ) {
				add_action( 'wp_head', array( &$this, 'modal_dialog_header' ), 1 );
				add_action( 'wp_footer', array( &$this, 'modal_dialog_footer' ), 1000 );
				break;
			}
		}

		add_action( 'comment_post_redirect', array( $this, 'comment_redirect_filter' ), 10, 2 );

		register_activation_hook( __FILE__, array( $this, 'md_install' ) );
		register_deactivation_hook( __FILE__, array( $this, 'md_uninstall' ) );

		return $this;
	}

	function modal_dialog_admin_header( $dialogname = "MD_PP1" ) {

		$genoptions = get_option( 'MD_General' );
		$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

		$options    = get_option( $dialogname );
		$options = wp_parse_args( $options, modal_dialog_default_config( 1, 'return' ) );

		if ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'fancybox' ) {
			echo "<link rel='stylesheet' type='text/css' media='screen' href='" . plugins_url( "fancybox/jquery.fancybox-1.3.4.css", __FILE__ ) . "'/>\n";
			echo "<!-- [if lt IE 7] -->\n";
			echo "<style type='text/css'>\n";

			echo "/*IE*/\n";
			echo "#fancybox-loading.fancybox-ie div	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_loading.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancybox-close		{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_close.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancybox-title-over	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_title_over.png", __FILE__ ) . ", sizingMethod='scale'); zoom: 1; }\n";
			echo ".fancybox-ie #fancybox-title-left	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_title_left.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancybox-title-main	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_title_main.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancybox-title-right	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_title_right.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancybox-left-ico		{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_nav_left.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancybox-right-ico	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_nav_right.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie .fancy-bg { background: transparent !important; }\n";

			echo ".fancybox-ie #fancy-bg-n	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_n.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancy-bg-ne	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_ne.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancy-bg-e	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_e.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancy-bg-se	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_se.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancy-bg-s	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_s.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancy-bg-sw	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_sw.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancy-bg-w	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_w.png", __FILE__ ) . ", sizingMethod='scale'); }\n";
			echo ".fancybox-ie #fancy-bg-nw	{ filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . plugins_url( "fancybox/fancy_shadow_nw.png", __FILE__ ) . ", sizingMethod='scale'); }\n";

			echo "</style>";
			echo "<!-- [endif] -->\n";
		} else if ( ! isset( $genoptions['popupscript'] ) || ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) ) {

			if ( empty ( $options['overlaycolor'] ) ) {
				$options['overlaycolor'] = "rgba(200, 200, 200, " . ( empty( $options['overlayopacity'] ) ? '0.3' : $options['overlayopacity'] ) . ")";
			} else {
				$colorarray = $this->hex2rgb( $options['overlaycolor'] );

				$options['overlaycolor'] = "rgba(" . $colorarray . ", " . ( empty( $options['overlayopacity'] ) ? '0.3' : $options['overlayopacity'] ) . ")";
			}
			?>
			<style type="text/css">
				#cboxOverlay {
					background: repeat 0 0 <?php echo $options['overlaycolor']; ?>;
				}
			</style>
		<?php
		}
	}

	function comment_redirect_filter( $location, $comment ) {
		$genoptions = get_option( 'MD_General' );
		$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

		for ( $counter = 1; $counter <= $genoptions['numberofmodaldialogs']; $counter ++ ) {
			$optionsname = "MD_PP" . $counter;
			$options     = get_option( $optionsname );
			$options = wp_parse_args( $options, modal_dialog_default_config( $counter, 'return' ) );

			if ( $options['showaftercommentposted'] == true ) {
				$commentanchorpos = strpos( $location, '#comment' );
				$getpresence      = strpos( $location, '?' );
				if ( $commentanchorpos != false ) {
					if ( $getpresence == false ) {
						$showdialogstring = '?showmodaldialog=' . $counter;
					} else {
						$showdialogstring = '&showmodaldialog=' . $counter;
					}
					$location = substr_replace( $location, $showdialogstring, $commentanchorpos, 0 );
				}
				break;
			}

		}

		return $location;
	}

	function md_install() {
		$options = get_option( 'MD_PP1' );

		if ( $options == false ) {
			$oldoptions = get_option( 'MD_PP' );

			if ( $oldoptions != false ) {
				$oldoptions['dialogname'] = 'Default';
				update_option( 'MD_PP1', $oldoptions );
			} else {
				modal_dialog_default_config( 1, 'return_and_set' );
			}
		}

		$genoptions = get_option( 'MD_General' );

		if ( $genoptions == false ) {
			modal_dialog_general_default_config( 'return_and_set' );
		}
	}

	function md_uninstall() {
	}

	function modal_dialog_header( $manualdisplay = false ) {
		global $post;
		if ( isset( $post ) ) {
			$thePostID  = $post->ID;
		}

		$display    = false;
		$dialogname = '';

		if ( isset( $_GET['showmodaldialog'] ) ) {
			$display    = true;
			$dialogname = "MD_PP" . $_GET['showmodaldialog'];
		} elseif ( ! empty( $thePostID ) ) {
			$dialogid = get_post_meta( $post->ID, "modal-dialog-id", true );
			if ( ! empty( $dialogid ) && $dialogid != 0 ) {
				$display = true;
			}
			$dialogname = "MD_PP" . $dialogid;
		}

		if ( $display == false ) {
			$genoptions = get_option( 'MD_General' );
			$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

			for ( $counter = 1; $counter <= $genoptions['numberofmodaldialogs']; $counter ++ ) {
				$dialogid    = $counter;
				$optionsname = "MD_PP" . $counter;
				$options     = get_option( $optionsname );
				$options = wp_parse_args( $options, modal_dialog_default_config( $counter, 'return' ) );

				if ( $options['checklogin'] == false || $options['checklogin'] == '' || ( $options['checklogin'] == true && ! is_user_logged_in() ) ) {
					if ( ( $options['active'] || $manualdisplay ) && ! is_admin() ) {
						if ( in_array( $GLOBALS['pagenow'], array(
								'wp-register.php',
								'wp-signup.php'
							) ) && ! $options['showregisterpage']
						) {
							$display    = false;
							$dialogname = $optionsname;
							break;
						} elseif ( in_array( $GLOBALS['pagenow'], array(
								'wp-register.php',
								'wp-signup.php'
							) ) && $options['showregisterpage']
						) {
							$display    = true;
							$dialogname = $optionsname;
							break;
						} elseif ( $options['showfrontpage'] && is_front_page() ) {
							$display    = true;
							$dialogname = $optionsname;
							break;
						} elseif ( !empty( $options['codecondition'] ) && eval( 'return ' . stripslashes($options['codecondition']) . ';' ) ) {
							$display = true;
							$dialogname = $optionsname;
							break;
					    } elseif ( $options['showfrontpage'] == false && is_front_page() ) {
							$display = false;
						} elseif ( $options['forcepagelist'] == true ) {
							if ( $options['pages'] != '' ) {
								$pagelist = explode( ',', $options['pages'] );

								if ( $pagelist ) {
									foreach ( $pagelist as $pageid ) {
										if ( is_page( intval( $pageid ) ) || is_single( $pageid ) ) {
											$display    = true;
											$dialogname = $optionsname;
											break 2;
										} else {
											$display = false;
										}
									}
								}
							}
						} elseif ( $options['forcepagelist'] == false && ! is_front_page() ) {
							$display    = true;
							$dialogname = $optionsname;
						} elseif ( $manualdisplay == true ) {
							$display    = true;
							$dialogname = $optionsname;
						}

						if ( ! empty( $options['excludepages'] ) ) {
							$exclude_page_list = explode( ',', $options['excludepages'] );

							if ( $exclude_page_list ) {
								foreach ( $exclude_page_list as $excluded_page_id ) {
									if ( is_page( intval( $excluded_page_id ) ) || is_single( $excluded_page_id ) ) {
										$display = false;
										break;
									}
								}
							}
						}

						if ( ! empty( $options['excludeurlstrings'] ) ) {
							$exclude_url_list = explode( ',', $options['excludeurlstrings'] );
							global $post;

							if ( $exclude_url_list ) {
								foreach ( $exclude_url_list as $excluded_string ) {
									$page_address = get_permalink( $post->ID );
									if ( false !== strpos ( $page_address, $excluded_string ) ) {
										$display = false;
									}
								}
							}
						}
					}
				} else {
					$display = false;
				}
			}
		}

		if ( $display == true ) {
			$this->modal_dialog_admin_header( $dialogname );
		}
	}

	function hex2rgb( $hex ) {
		$hex = str_replace( "#", "", $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array( $r, $g, $b );

		return implode( ",", $rgb ); // returns the rgb values separated by commas
	}

	function modal_dialog_footer( $manualdisplay = false ) {
		global $post;
		$thePostID = $post->ID;
		$display   = false;

		wp_reset_query();

		if ( isset( $_GET['showmodaldialog'] ) ) {
			$display  = true;
			$dialogid = $_GET['showmodaldialog'];
		} elseif ( ! empty( $thePostID ) ) {
			$dialogid = get_post_meta( $post->ID, "modal-dialog-id", true );
			if ( ! empty( $dialogid ) && $dialogid != 0 ) {
				$display = true;
			} else {
				$dialogid = 1;
			}
		}

		if ( $display == false ) {
			$genoptions = get_option( 'MD_General' );
			$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

			for ( $counter = 1; $counter <= $genoptions['numberofmodaldialogs']; $counter ++ ) {
				$dialogid    = $counter;
				$optionsname = "MD_PP" . $counter;
				$options     = get_option( $optionsname );
				$options = wp_parse_args( $options, modal_dialog_default_config( $counter, 'return' ) );

				if ( ! empty( $options['excludeurlstrings'] ) ) {
					$exclude_url_list = explode( ',', $options['excludeurlstrings'] );
					global $post;

					if ( $exclude_url_list ) {
						foreach ( $exclude_url_list as $excluded_string ) {
							$page_address = get_permalink( $post->ID );
							if ( false !== strpos ( $page_address, $excluded_string ) ) {
								$display = false;
								break 2;
							}
						}
					}
				}

				if ( ! empty( $options['excludepages'] ) ) {
					$exclude_page_list = explode( ',', $options['excludepages'] );

					if ( $exclude_page_list ) {
						foreach ( $exclude_page_list as $excluded_page_id ) {
							if ( is_page( intval( $excluded_page_id ) ) || is_single( $excluded_page_id ) ) {
								$display = false;
								break 2;
							}
						}
					}
				}

				if ( $options['checklogin'] == false || $options['checklogin'] == '' || ( $options['checklogin'] == true && ! is_user_logged_in() ) ) {
					if ( ( $options['active'] || $manualdisplay ) && ! is_admin() ) {
						if ( in_array( $GLOBALS['pagenow'], array( 'wp-register.php', 'wp-signup.php' ) ) && !$options['showregisterpage'] ) {
							$display = false;
							break;
						} elseif ( in_array( $GLOBALS['pagenow'], array( 'wp-register.php', 'wp-signup.php' ) ) && $options['showregisterpage'] ) {
							$display = true;
							break;
						} elseif ( $options['showfrontpage'] && is_front_page() ) {
							$display = true;
							break;
						} elseif ( !empty( $options['codecondition'] ) && eval( 'return ' . stripslashes( $options['codecondition'] ) . ';' ) ) {
							$display = true;
							break;
						} elseif ( $options['showfrontpage'] == false && is_front_page() ) {
							$display = false;
						} elseif ( $options['forcepagelist'] == true ) {
							if ( $options['pages'] != '' ) {
								$pagelist = explode( ',', $options['pages'] );

								if ( $pagelist ) {
									foreach ( $pagelist as $pageid ) {
										if ( is_page( intval( $pageid ) ) || is_single( $pageid ) ) {
											$display = true;
											break 2;
										} else {
											$display = false;
										}
									}
								}
							}
						} elseif ( 1 == $counter && $options['forcepagelist'] == false && ! is_front_page() ) {
							$display = true;
							break;
						} elseif ( $manualdisplay == true ) {
							$display = true;
							break;
						}
					}
				} else {
					$display = false;
				}
			}
		}

		if ( $display == true && $dialogid != 0 ) {
			global $wpdb;

			$optionsname = "MD_PP" . $dialogid;
			$options     = get_option( $optionsname );
			$options = wp_parse_args( $options, modal_dialog_default_config( $dialogid, 'return' ) );

			$genoptions  = get_option( 'MD_General' );
			$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

			$output = "<!-- Modal Dialog Output -->\n";

			if ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'fancybox' ) {

				if ( $options['contentlocation'] == 'Inline' ) {

					$output .= "<a id=\"inline\" href=\"#data\"></a>\n";
					$output .= "<div style=\"display:none\"><div id=\"data\" style=\"color:" . $options['textcolor'] . ";background-color:" . $options['backgroundcolor'] . ";width:100%;height:100%\">";
					$output .= apply_filters( 'modal_dialog_content', stripslashes( $options['dialogtext'] ) );

					$output .= "</div></div>\n";

				} elseif ( $options['contentlocation'] == "URL" ) {
					$output .= "<a href='" . $options['contenturl'] . "' class='iframe'></a>\n";
				}

			} else if ( ! isset( $genoptions['popupscript'] ) || ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) ) {

				if ( $options['contentlocation'] == 'Inline' ) {

					$output .= "<a class='inline' href='#inline_content'></a>\n";
					$output .= "<div style='display:none'>";
					$output .= "<div id='inline_content' style='padding:10px;color:" . $options['textcolor'] . ";background-color:" . $options['backgroundcolor'] . "'>";
					$output .= "<div id='inline_replaceable_content'>";
					$output .= apply_filters( 'modal_dialog_content', stripslashes( $options['dialogtext'] ) );
					$output .= "</div>";

					$output .= "</div></div>\n";

				} elseif ( $options['contentlocation'] == "URL" ) {
					$output .= "<a href='" . $options['contenturl'] . "' class='iframe'></a>\n";
				}

			}

			if ( $options['sessioncookiename'] != '' ) {
				$sessioncookiename = $options['sessioncookiename'];
			} else {
				$sessioncookiename = 'modaldialogsession';
			}

			$output .= "<div id='md-content'>\n";

			$output .= "<script type=\"text/javascript\">\n";

			$output .= "function modal_dialog_open() {\n";

			if ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'fancybox' ) {
				if ( $options['contentlocation'] == 'Inline' || empty( $options['contentlocation'] ) ) {
					$output .= "\tjQuery(\"a#inline\").trigger('click')\n";
				} elseif ( $options['contentlocation'] == 'URL' ) {
					$output .= "\tjQuery(\"a.iframe\").trigger('click')\n";
				}
			} else if ( ! isset( $genoptions['popupscript'] ) || ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) ) {
				if ( $options['contentlocation'] == 'Inline' || empty( $options['contentlocation'] ) ) {
					$output .= "\tjQuery(\"a.inline\").trigger('click')\n";
				} elseif ( $options['contentlocation'] == 'URL' ) {
					$output .= "\tjQuery(\"a.iframe\").trigger('click')\n";
				}
			}

			if ( $options['manualcookiecreation'] == false ) {
				$output .= "\tcookievalue++;\n";
				$output .= "\tjQuery.cookie('" . $options['cookiename'] . "', cookievalue";

				if ( $options['cookieduration'] > 0 ) {
					$output .= ", { expires: " . $options['cookieduration'] . ", path: '/'}";
				} else {
					$output .= ", { path: '/' }";
				}

				$output .= ");\n";
			}

			if ( $options['oncepersession'] == true ) {
				if ( $options['manualcookiecreation'] == false ) {
					$output .= "\tjQuery.cookie('" . $sessioncookiename . "', 0, { path: '/' });\n";
				}
			}

			$output .= "}\n";

			if ( ! isset( $genoptions['popupscript'] ) || ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) ) {
				$output .= "function set_modal_dialog_content( newContent ) {\n";
				$output .= "\tjQuery('#inline_replaceable_content').replaceWith( \"<div id='inline_replaceable_content'>\" + newContent + \"</div>\");\n";
				$output .= "};\n";

				$output .= "function set_modal_dialog_web_site_address( newAddress ) {\n";
				$output .= "\tjQuery('a.iframe').attr( 'href', newAddress );\n";
				$output .= "};\n";
			}

			$output .= "function modal_dialog_close() {\n";

			if ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'fancybox' ) {
				$output .= "\tparent.jQuery.fancybox.close();\n";
			} else if ( ! isset( $genoptions['popupscript'] ) || ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) ) {
				$output .= "\tjQuery.colorbox.close();\n";
			}

			$output .= "}\n\n";

			$output .= "var cookievalue = jQuery.cookie('" . $options['cookiename'] . "');\n";
			$output .= "if (cookievalue == null) cookievalue = 0;\n";

			if ( $options['oncepersession'] == true ) {
				$output .= "var sessioncookie = jQuery.cookie('" . $sessioncookiename . "');\n\n";
			}

			$output .= "jQuery(document).ready(function() {\n";

			if ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'fancybox' ) {
				if ( $options['contentlocation'] == 'Inline' || empty( $options['contentlocation'] ) ) {
					$output .= "jQuery(\"a#inline\").fancybox({\n";
				} elseif ( $options['contentlocation'] == 'URL' ) {
					$output .= "jQuery(\"a.iframe\").fancybox({\n";
				}

				if ( $options['exitmethod'] == 'onlyexitbutton' ) {
					$output .= "'hideOnOverlayClick': false,\n";
					$output .= "'hideOnContentClick': false,\n";
				} elseif ( $options['exitmethod'] == 'anywhere' ) {
					$output .= "'hideOnOverlayClick': true,\n";
					$output .= "'hideOnContentClick': false,\n";
				}

				if ( true == $options['hideclosebutton'] ) {
					$output .= "'enableEscapeButton': false,\n";
				} else {
					$output .= "'enableEscapeButton': true,\n";
				}

				if ( isset( $options['ignoreesckey'] ) && true == $options['ignoreesckey'] ) {
					$output .= "'showCloseButton': false,\n";
				} else {
					$output .= "'showCloseButton': true,\n";
				}

				if ( $options['centeronscroll'] == true ) {
					$output .= "'centerOnScroll': true,\n";
				}

				if ( $options['hidescrollbars'] == true ) {
					$output .= "'scrolling': 'no',\n";
				}

				if ( $options['dialogclosingcallback'] != '' ) {
					$output .= "'onClosed': function() {" . $options['dialogclosingcallback'] . "},\n";
				}

				if ( $options['autosize'] == true || empty( $options['autosize'] ) ) {
					$output .= "'autoDimensions': true,\n";
				} elseif ( $options['autosize'] == false ) {
					$output .= "'autoDimensions': false,\n";
				}

				$output .= "'overlayColor': '" . $options['overlaycolor'] . "',\n";
				$output .= "'width': '" . $options['dialogwidth'] . "',\n";
				$output .= "'height': '" . $options['dialogheight'] . "',\n";

				if ( $options['overlayopacity'] == '' ) {
					$options['overlayopacity'] = '0.3';
				}

				if ( !empty( $options['transitionmode'] ) ) {
					$output .= "\t\ttransitionIn: \"" . $options['transitionmode'] . "\",\n";
					$output .= "\t\ttransitionOut: \"" . $options['transitionmode'] . "\",\n";
				}

				$output .= "'overlayOpacity': " . $options['overlayopacity'] . "\n";
				$output .= "});\n";
			} else if ( ! isset( $genoptions['popupscript'] ) || ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) ) {

				if ( $options['contentlocation'] == 'Inline' || empty( $options['contentlocation'] ) ) {
					$output .= "\tjQuery(\"a.inline\").colorbox({\n";
					$output .= "\t\tinline: true,\n";
					$output .= "\t\treturnFocus: false,\n";
				} elseif ( $options['contentlocation'] == 'URL' ) {
					$output .= "\tjQuery(\"a.iframe\").colorbox({\n";
					$output .= "\t\tiframe: true,\n";
					$output .= "\t\treturnFocus: false,\n";
				}

				if ( $options['exitmethod'] == 'onlyexitbutton' ) {
					$output .= "\t\toverlayClose: false,\n";
				} elseif ( $options['exitmethod'] == 'anywhere' ) {
					$output .= "\t\toverlayClose: true,\n";
				}

				if ( $options['hideclosebutton'] == true ) {
					$output .= "\t\tcloseButton: false,\n";
				} else {
					$output .= "\t\tcloseButton: true,\n";
				}

				if ( isset( $options['ignoreesckey'] ) && true == $options['ignoreesckey'] ) {
					$output .= "\t\tescKey: false,\n";
				} else {
					$output .= "\t\tescKey: true,\n";
				}

				if ( $options['centeronscroll'] == true ) {
					$output .= "\t\tfixed: true,\n";
				}

				if ( $options['hidescrollbars'] == true ) {
					$output .= "\t\tscrolling: 'false',\n";
				}

				if ( $options['dialogclosingcallback'] != '' ) {
					$output .= "\t\tonClosed: function() {" . $options['dialogclosingcallback'] . "},\n";
				}

				if ( $options['autosize'] == true ) {
					$output .= "\t\twidth: '80%',\n";
					$output .= "\t\theight: '80%',\n";
				} else {
					$output .= "\t\twidth: '" . $options['dialogwidth'] . "',\n";
					$output .= "\t\theight: '" . $options['dialogheight'] . "',\n";
				}

				if ( $options['sessioncookiename'] != '' ) {
					$sessioncookiename = $options['sessioncookiename'];
				} else {
					$sessioncookiename = 'modaldialogsession';
				}

				if ( $options['overlayopacity'] == '' ) {
					$options['overlayopacity'] = '0.3';
				}

				if ( $options['dialogposition'] == 'userposition' ) {
					if ( !empty( $options['topposition'] ) ) {
						$output .= "\t\ttop: \"" . $options['topposition'] . "\",\n";
					}
					if ( !empty( $options['leftposition'] ) ) {
						$output .= "\t\tleft: \"" . $options['leftposition'] . "\",\n";
					}
					if ( !empty( $options['rightposition'] ) ) {
						$output .= "\t\tright: \"" . $options['rightposition'] . "\",\n";
					}
					if ( !empty( $options['bottomposition'] ) ) {
						$output .= "\t\tbottom: \"" . $options['bottomposition'] . "\",\n";
					}
				}

				if ( !empty( $options['transitionmode'] ) ) {
					$output .= "\t\ttransition: \"" . $options['transitionmode'] . "\",\n";
				}

				$output .= "\t\toverlayOpacity: " . $options['overlayopacity'] . "\n";

				$output .= "\t});\n\n";
			}

			if ( $options['oncepersession'] == true ) {
				$output .= "\tif (sessioncookie == null)\n";
				$output .= "\t{\n";
			}

			if ( $options['displayfrequency'] != 1 && $options['displayfrequency'] != '' && $options['showaftercommentposted'] == false ) {
				$output .= "\tvar cookiechecksvalue = jQuery.cookie('" . $options['cookiename'] . "_checks');\n";
				$output .= "\tif (cookiechecksvalue == null) cookiechecksvalue = 0;\n";
			}

			$output .= "\tif (cookievalue ";

			if ( empty( $options['countermode'] ) ) {
				$options['countermode'] = 'timestodisplay';
			}

			if ( $options['countermode'] == 'timestodisplay' ) {
				$output .= ' < ';
			} elseif ( $options['countermode'] == 'timesbeforedisplay' ) {
				$output .= ' > ';
			}

			$output .= $options['numberoftimes'];
			
			if ( $genoptions['disableonmobilebrowsers'] ) {
				$output .= " && jQuery.browser.mobile == false";
			}
			
			$output .= ")\n";

			$output .= "\t{\n";

			if ( $options['displayfrequency'] != 1 && $options['displayfrequency'] != '' && $options['showaftercommentposted'] == false ) {
				$output .= "\t\tcookiechecksvalue++;\n";
				$output .= "\t\tjQuery.cookie('" . $options['cookiename'] . "_checks', cookiechecksvalue";

				if ( $options['cookieduration'] > 0 ) {
					$output .= ", { expires: " . $options['cookieduration'] . ", path: '/'}";
				} else {
					$output .= ", { path: '/' }";
				}

				$output .= ");\n";

				$output .= "\t\tif (cookiechecksvalue % " . $options['displayfrequency'] . " == 0) {\n";
			}

			$output .= "\t\tsetTimeout(\n";
			$output .= "\t\t\tfunction(){\n";

			$output .= "\t\t\t\tmodal_dialog_open();\n";

			if ( empty( $options['delay'] ) || !is_numeric( $options['delay'] ) ) {
				$options['delay'] = 2000;
			}

			$output .= "\t\t\t}, " . $options['delay'] . ");\n";
			$output .= "\t};\n";

			if ( $options['displayfrequency'] != 1 && $options['displayfrequency'] != '' && $options['showaftercommentposted'] == false ) {
				$output .= '}';
			}

			if ( $options['oncepersession'] == true ) {
				$output .= "\t}\n";
			}

			$output .= "});\n";
			if ( $options['autoclose'] == true && $options['autoclosetime'] != 0 ) {
				$output .= "setTimeout('modal_dialog_close();'," . $options['autoclosetime'] . ");\n";
			}
			$output .= "</script>\n";

			$output .= "</div>\n";

			$output .= "<!-- End of Modal Dialog Output -->\n";

			echo $output;
		}
	}

	function enqueue_scripts() {
		$genoptions = get_option( 'MD_General' );
		$genoptions = wp_parse_args( $genoptions, modal_dialog_general_default_config( 'return' ) );

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'jquerycookies', plugins_url( 'cookie.js', __FILE__ ), 'jquery', '1.0' );
		
		if ( $genoptions['disableonmobilebrowsers'] ) {
			wp_enqueue_script( 'jqueryDetectMobile', plugins_url( 'detectmobilebrowser.js', __FILE__ ), 'jquery', '1.0' );
		}

		if ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'fancybox' ) {
			wp_enqueue_script( 'fancyboxpack', plugins_url( 'fancybox/jquery.fancybox-1.3.4.pack.js', __FILE__ ), 'jquery', '1.3.4' );
		} else if ( ! isset( $genoptions['popupscript'] ) || ( isset( $genoptions['popupscript'] ) && $genoptions['popupscript'] == 'colorbox' ) ) {
			wp_enqueue_script( 'colorboxpack', plugins_url( 'colorbox/jquery.colorbox-min.js', __FILE__ ), 'jquery', '1.5.6' );
			wp_enqueue_style( 'colorboxstyle', plugins_url( 'colorbox/colorbox.css', __FILE__ ), '', '1.5.6' );
		}
	}
}

global $my_modal_dialog_plugin;
$my_modal_dialog_plugin = new modal_dialog_plugin();

?>