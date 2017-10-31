<?php
/*
  $Id: call_back.php,v 1.42 2003/06/11 17:35:01 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  Credits: Marg Davison, Loпc Richard, FaNaTiC, C. Bouwmeester
  Anpassungen fьr XT:Commerce 3.0.4 SP1: 2005/2006 BSB Beratung+Software Bleicher
  ASK_A_QUESTION.GIF Grafikdesign (c) 2005/2005 BSB Beratung+Software Bleicher

*/
include ('includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');

// create smarty elements
$vamTemplate = new vamTemplate;

$vamTemplate->assign('language', $_SESSION['language']);

		$spam_flag = false;

		if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
			$spam_flag = true;
			if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
				$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
			} else {
				$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
			}
		}
		if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
			$spam_flag = true;
			$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
		}
		
if (isset ($_POST['action']) && ($_POST['action'] == 'process')  && $spam_flag == false) {

include ('includes/header.php');


	$error = false;

	if (isset($_SESSION['customer_id'])) { 
		$firstname = $_SESSION['customer_first_name'];
		$phone =  vam_db_input($_POST['phone']);
		$message = vam_db_input($_POST['message_body']);
  } else {    
		$firstname = vam_db_input($_POST['firstname']);
		$phone =  vam_db_input($_POST['phone']);
		$message = vam_db_input($_POST['message_body']);
	}
	
	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;
		$messageStack->add('call_back', ENTRY_FIRST_NAME_ERROR);
	}

	if (strlen($phone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$messageStack->add('call_back', ENTRY_TELEPHONE_NUMBER_ERROR);
	}

	if ($messageStack->size('call_back') > 0) {
$vamTemplate->assign('error', $messageStack->output('call_back'));
	}

		if ($error == false) {
		$vamTemplate->assign('TEXT_MESSAGE', $_POST['message_body']);
		$vamTemplate->assign('TEXT_FIRSTNAME', $firstname);
		$vamTemplate->assign('TEXT_PHONE', $_POST['phone']);
		$vamTemplate->assign('TEXT_EMAIL_SUCCESSFUL', sprintf(TEXT_EMAIL_SUCCESSFUL_SENT_CALL));
		$vamTemplate->caching = 0;
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/call_back.html');
		$vamTemplate->caching = 0;
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/call_back.txt');
	// send mail to admin
	vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, EMAIL_SUPPORT_ADDRESS, STORE_NAME, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_ADDRESS, $to_name, '', '', NAVBAR_TITLE_CALL_BACK, $html_mail, $txt_mail);

if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/call_back_ok.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/call_back_ok.html', $cache_id);
		}
	}else{

$vamTemplate->assign('FORM_ACTION', vam_draw_form('call_back', vam_href_link(FILENAME_CALL_BACK, 'products_id='.$_GET['products_id'].'')).vam_draw_hidden_field('action', 'process').vam_draw_hidden_field('products_id', $_GET['products_id']));

        if (isset($_SESSION['customer_id'])) { 
		//-> registered user********************************************************
$vamTemplate->assign('INPUT_FIRSTNAME', $_SESSION['customer_first_name']);
        }else{
		//-> guest *********************************************************  
$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : ''))));
        }
$vamTemplate->assign('INPUT_PHONE', vam_draw_input_fieldNote(array ('name' => 'phone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : ''))));
$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('message_body', 'soft', 30, 3, stripslashes($_POST['message_body'])));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  'Перезвоните мне'));

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/call_back.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/call_back.html', $cache_id);
	}
}
}else{

include ('includes/header.php');

$breadcrumb->add(NAVBAR_TITLE_CALL_BACK, vam_href_link(FILENAME_CALL_BACK, 'products_id='.$product->data['products_id'], 'SSL'));

$vamTemplate->assign('FORM_ACTION', vam_draw_form('call_back', vam_href_link(FILENAME_CALL_BACK, 'products_id='.$_GET['products_id'].'')).vam_draw_hidden_field('action', 'process').vam_draw_hidden_field('products_id', $_GET['products_id']));
        if (isset($_SESSION['customer_id'])) { 
		//-> registered user********************************************************
$vamTemplate->assign('INPUT_FIRSTNAME', $_SESSION['customer_first_name']);
        }else{
		//-> guest *********************************************************  
$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : ''))));
        }
$vamTemplate->assign('INPUT_PHONE', vam_draw_input_fieldNote(array ('name' => 'phone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : ''))));
$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('message_body', 'soft', 30, 3, stripslashes($_POST['message_body'])));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  'Перезвоните мне'));

	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/call_back.html');
}
?>
