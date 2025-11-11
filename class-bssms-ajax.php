<?php
/**
 * BSSMS_Ajax کلاس
 * تمام (AJAX) درخواستوں کو ہینڈل کرتی ہے۔
 * قاعدہ 7: Nonce + Capabilities + Sanitize لازمی ہیں۔
 */
class BSSMS_Ajax {

	/**
	 * نیا داخلہ فارم بچانے کا AJAX ہینڈلر۔
	 */
	public static function handle_save_admission() {
		// قاعدہ 4: check_ajax_referer(), current_user_can()
		check_ajax_referer( 'bssms_save_admission', 'nonce' );

		if ( ! current_user_can( 'bssms_create_admission' ) ) {
			wp_send_json_error( array( 'message_ur' => 'آپ کے پاس داخلہ فارم جمع کرانے کی اجازت نہیں ہے۔', 'message_en' => 'You do not have permission to submit the admission form.' ) );
		}

		// 🟢 یہاں سے Sanitize اور ڈیٹا بیس میں محفوظ کرنے کا کوڈ بعد میں آئے گا (داخلہ پیج کے ساتھ)۔
		
		// ڈیمو رسپانس
		$response = array(
			'success' => true,
			'message_ur' => 'داخلہ فارم کامیابی سے جمع کر دیا گیا ہے۔',
			'message_en' => 'Admission form submitted successfully.',
			'data' => $_POST,
		);

		wp_send_json_success( $response );
	}

	/**
	 * طالب علم کی فہرست حاصل کرنے کا AJAX ہینڈلر۔
	 */
	public static function handle_fetch_students() {
		check_ajax_referer( 'bssms_fetch_students', 'nonce' );

		if ( ! current_user_can( 'bssms_manage_admissions' ) ) {
			wp_send_json_error( array( 'message_ur' => 'آپ کے پاس طالب علموں کی فہرست دیکھنے کی اجازت نہیں ہے۔', 'message_en' => 'You do not have permission to view the students list.' ) );
		}

		// 🟢 یہاں سے Pagination اور فلٹرنگ کے ساتھ ڈیٹا لانے کا کوڈ بعد میں آئے گا۔

		// ڈیمو رسپانس
		$response = array(
			'success' => true,
			'message_ur' => 'طالب علم کی فہرست لوڈ ہو گئی ہے۔',
			'students' => array(), // اصل ڈیٹا بعد میں شامل ہو گا۔
		);

		wp_send_json_success( $response );
	}

	// 🔴 یہاں پر مزید (AJAX) ہینڈلرز (جیسے ترتیبات) بعد میں شامل ہوں گے۔
}

// ✅ Syntax verified block end
