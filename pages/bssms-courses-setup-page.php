<?php
/**
 * BSSMS_Courses_Setup_Page کلاس
 * کورسز سیٹ اپ اور مینجمنٹ کے صفحہ کی (PHP) لاجک اور ٹیمپلیٹ کو سنبھالتی ہے۔
 * قاعدہ 30 کے تحت یہ ایک سرشار (Dedicated) فائل ہے۔
 */
class BSSMS_Courses_Setup_Page {

	/**
	 * کورسز سیٹ اپ کے صفحہ کو رینڈر کریں۔
	 */
	public static function render_page() {
		// صرف ایڈمن کو رسائی (ہم نے پہلے ہی مینو میں manage_options سیٹ کر دیا ہے، یہ ایک اضافی سیکیورٹی چیک ہے)
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'آپ کے پاس اس صفحہ تک رسائی کی اجازت نہیں ہے۔', 'bssms' ) );
		}
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'کورسز سیٹ اپ', 'bssms' ); ?> <span style="font-size:14px; color:#999; margin-left:10px;">(Manage Academy Courses & Fees)</span></h2>
			<div class="bssms-message-container"></div>
			<div id="bssms-courses-setup-root">
				<?php 
				self::render_courses_template();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * کورسز سیٹ اپ کے لیے (PHP) ٹیمپلیٹ بلاک کو رینڈر کریں۔
	 * قاعدہ 4: مکمل <template> blocks
	 */
	private static function render_courses_template() {
		?>
		<template id="bssms-courses-setup-template">
			<div class="bssms-course-manager-grid">
				
				<div class="bssms-list-view bssms-card">
					<h4 class="section-title">📚 دستیاب کورسز (Available Courses)</h4>
					
					<div class="bssms-list-toolbar">
						<input type="text" id="course-search-input" class="bssms-input" placeholder="🔍 کورس نام یا ID سے تلاش کریں...">
						<select id="course-status-filter" class="bssms-select">
							<option value="">تمام حیثیتیں</option>
							<option value="active">🟢 فعال (Active)</option>
							<option value="inactive">🔴 غیر فعال (Inactive)</option>
						</select>
					</div>
					
					<div class="bssms-table-container">
						<table class="bssms-table" id="bssms-courses-table">
							<thead>
								<tr>
									<th>ID #</th>
									<th>Course Name (انگلش/اردو)</th>
									<th>Fee (Rs.)</th>
									<th>Status (حیثیت)</th>
									<th>Actions (ایکشنز)</th>
								</tr>
							</thead>
							<tbody id="bssms-courses-tbody">
								<tr><td colspan="5" class="bssms-loading">🔄 لوڈ ہو رہا ہے...</td></tr>
							</tbody>
						</table>
					</div>

					<div class="bssms-table-footer-actions">
						<div class="bssms-footer-summary">
							<span id="total-courses-summary">Total Courses: 0</span> | 
							<span id="active-courses-summary">Active: 0</span>
						</div>
						<div class="bssms-global-actions">
							<button class="bssms-btn bssms-btn-secondary" id="btn-print-courses">🖨️ Print</button>
							<button class="bssms-btn bssms-btn-secondary" id="btn-export-courses-excel">📊 Export (Excel)</button>
						</div>
					</div>
				</div>
				
				<div class="bssms-side-form bssms-card">
					<h4 class="section-title" id="course-form-title">➕ نیا کورس شامل کریں (Add New Course)</h4>
					
					<form id="bssms-course-form">
						<input type="hidden" name="course_id" id="course_id" value="0">
						
						<div class="bssms-form-group">
							<label for="course_name_en" class="bssms-label">Course Name (English) <span class="required">*</span></label>
							<input type="text" id="course_name_en" name="course_name_en" class="bssms-input" required placeholder="مثلاً: AI Master">
						</div>

						<div class="bssms-form-group">
							<label for="course_name_ur" class="bssms-label">کورس کا نام (اردو) <small>(اختیاری)</small></label>
							<input type="text" id="course_name_ur" name="course_name_ur" class="bssms-input bssms-input-ur" placeholder="مثلاً: اے آئی ماسٹر">
						</div>
						
						<div class="bssms-form-group">
							<label for="course_fee" class="bssms-label">Course Fee (فیس روپے) <span class="required">*</span></label>
							<input type="number" id="course_fee" name="course_fee" class="bssms-input" required min="100" placeholder="مثلاً: 50000">
							<p class="bssms-fee-words" id="course_fee_words">رقم الفاظ میں</p>
						</div>

						<div class="bssms-form-group bssms-toggle-group">
							<label for="is_active" class="bssms-label">Status: Active (فعال)</label>
							<input type="checkbox" id="is_active" name="is_active" checked>
						</div>

						<div class="bssms-form-actions">
							<button type="submit" class="bssms-btn bssms-btn-primary" id="btn-save-course">💾 Save (محفوظ کریں)</button>
							<button type="button" class="bssms-btn bssms-btn-secondary" id="btn-reset-course">Reset (خالی کریں)</button>
						</div>
					</form>
				</div>
			</div>
			
			<button class="bssms-btn bssms-btn-fab" id="btn-open-add-new">➕ Add Course</button>
		</template>
		<?php
	}
}

// ✅ Syntax verified block end
