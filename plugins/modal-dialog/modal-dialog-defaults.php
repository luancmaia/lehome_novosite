<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function modal_dialog_default_config( $confignumber, $setoptions = 'return' ) {
	$options['dialogname']      = 'Default';
	$options['contentlocation'] = 'URL';
	$options['dialogtext']      = 'Example Dialog Text';

	if ( is_multisite() ) {
		$options['active'] = false;
	} else if ( ! is_multisite() ) {
		$options['active'] = true;
	}
	$options['cookieduration']  = 365;
	$options['contenturl']      = 'http://ici.radio-canada.ca/';
	$options['pages']           = '';
	$options['overlaycolor']    = '#00CC00';
	$options['textcolor']       = '#000000';
	$options['backgroundcolor'] = '#FFFFFF';
	$options['delay']           = 2000;
	$options['dialogwidth']     = 900;
	$options['dialogheight']    = 700;
	$options['cookiename']      = 'modal-dialog';
	$options['numberoftimes']   = 10;
	$options['countermode']     = 'timestodisplay';
	$options['exitmethod']      = 'onlyexitbutton';
	$options['autosize']        = false;
	$options['showfrontpage']   = true;

	if ( $confignumber == 1 ) {
		$options['forcepagelist'] = false;
	} elseif ( $confignumber > 1 ) {
		$options['forcepagelist'] = true;
	}

	$options['sessioncookiename']      = 'modal-dialog-session';
	$options['oncepersession']         = false;
	$options['hideclosebutton']        = false;
	$options['ignoreesckey']           = false;
	$options['centeronscroll']         = false;
	$options['manualcookiecreation']   = false;
	$options['overlayopacity']         = '0.3';
	$options['autoclose']              = false;
	$options['autoclosetime']          = 5000;
	$options['checklogin']             = false;
	$options['displayfrequency']       = 1;
	$options['showaftercommentposted'] = false;
	$options['dialogclosingcallback']  = '';
	$options['hidescrollbars']         = false;
	$options['excludepages']           = '';
	$options['dialogposition']         = 'center';
	$options['topposition']            = '';
	$options['leftposition']           = '';
	$options['rightposition']          = '';
	$options['bottomposition']         = '';
	$options['transitionmode']         = 'fade';
	$options['excludeurlstrings']      = '';
	$options['showregisterpage']       = false;
	$options['codecondition']          = '';

	if ( 'return_and_set' == $setoptions ) {
		$configname = "MD_PP" . $confignumber;
		update_option( $configname, $options );
	}

	return $options;
}

function modal_dialog_general_default_config( $setoptions = 'return' ) {
	$genoptions['numberofmodaldialogs']    = 1;
	$genoptions['primarydialog']           = 1;
	$genoptions['disableonmobilebrowsers'] = false;
	$genoptions['accesslevel']             = 'admin';
	$genoptions['popupscript']             = 'colorbox';

	if ( 'return_and_set' == $setoptions ) {
		update_option( 'MD_General', $genoptions );
	}

	return $genoptions;
}