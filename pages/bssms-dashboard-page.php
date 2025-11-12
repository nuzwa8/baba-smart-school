<?php
/**
 * BSSMS_Dashboard_Page کلاس
 * اکیڈمی ڈیش بورڈ کے صفحہ کی (PHP) لاجک اور ٹیمپلیٹ کو سنبھالتی ہے۔
 * قاعدہ 30 کے تحت یہ ایک سرشار (Dedicated) فائل ہے۔
 */
class BSSMS_Dashboard_Page {

	/**
	 * ڈیش بورڈ کے صفحہ کو رینڈر کریں۔
	 */
	public static function render_page() {
		// کم از کم داخلہ بنانے کی صلاحیت ہونی چاہیے
		if ( ! current_user_can( 'bssms_create_admission' ) ) {
			wp_die( esc_html__( 'آپ کے پاس اس صفحہ تک رسائی کی اجازت نہیں ہے۔', 'bssms' ) );
		}
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'اکیڈمی ڈیش بورڈ', 'bssms' ); ?> <span style="font-size:14px; color:#999; margin-left:10px;">(Live overview of admissions, payments & system status)</span></h2>
			<div class="bssms-message-container"></div>
			<div id="bssms-dashboard-root">
				<?php 
				self::render_dashboard_template();
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * ڈیش بورڈ کے لیے (PHP) ٹیمپلیٹ بلاک کو رینڈر کریں۔
	 * قاعدہ 4: مکمل <template> blocks
	 */
	private static function render_dashboard_template() {
		$settings = BSSMS_DB::get_settings_bulk(['academy_name', 'logo_url']);
		?>
		<template id="bssms-dashboard-template">
			<div class="bssms-dashboard-grid">
				
				<div class="bssms-dashboard-header bssms-col-span-full">
					<div class="header-branding">
						<?php if (!empty($settings['logo_url'])): ?>
							<img src="<?php echo esc_url($settings['logo_url']); ?>" alt="لوگو" class="bssms-header-logo">
						<?php endif; ?>
						<h3><?php echo esc_html($settings['academy_name']); ?></h3>
					</div>
					<div class="header-actions">
						<button class="bssms-btn bssms-btn-secondary" onclick="window.location.href='admin.php?page=<?php echo esc_attr(BSSMS_Core::get_instance()->pages['settings']); ?>'">⚙️ ترتیبات</button>
					</div>
				</div>
				
				<div class="bssms-kpi-section bssms-col-span-full">
					<div class="bssms-kpi-card kpi-students">
						<div class="kpi-value" id="kpi-students-value">...</div>
						<div class="kpi-title">Total Students Enrolled</div>
						<div class="kpi-change" id="kpi-students-change">...</div>
					</div>
					<div class="bssms-kpi-card kpi-collected">
						<div class="kpi-value" id="kpi-collected-value">...</div>
						<div class="kpi-title">Total Fee Collected</div>
						<div class="kpi-change" id="kpi-collected-change">...</div>
					</div>
					<div class="bssms-kpi-card kpi-dues">
						<div class="kpi-value" id="kpi-dues-value">...</div>
						<div class="kpi-title">Fee Dues Pending</div>
						<div class="kpi-change" id="kpi-dues-change">...</div>
					</div>
					<div class="bssms-kpi-card kpi-courses">
						<div class="kpi-value" id="kpi-courses-value">...</div>
						<div class="kpi-title">Active Courses</div>
						<div class="kpi-change" id="kpi-courses-change">...</div>
					</div>
				</div>
				
				<div class="bssms-chart-card bssms-card admissions-chart-area">
					<h4 class="section-title">📈 داخلہ کی تاریخ (Admissions Over Time)</h4>
					<canvas id="admissions-chart"></canvas>
					<div class="chart-controls">
						<button class="bssms-btn bssms-btn-chart active" data-period="30days">Last 30 Days</button>
						<button class="bssms-btn bssms-btn-chart" data-period="6months">6 Months</button>
					</div>
				</div>
				
				<div class="bssms-payment-breakdown-card bssms-card">
					<h4 class="section-title">💰 ادائیگی کا بریک ڈاؤن (Payment Breakdown)</h4>
					<canvas id="payment-breakdown-chart"></canvas>
					<div id="payment-legend" class="bssms-legend"></div>
				</div>

				<div class="bssms-recent-admissions-card bssms-card">
					<h4 class="section-title">🆕 حالیہ داخلہ جات (Recent Admissions)</h4>
					<table class="bssms-table">
						<thead>
							<tr>
								<th>Student Name</th>
								<th>Course</th>
								<th>Date</th>
								<th>Details</th>
							</tr>
						</thead>
						<tbody id="recent-admissions-tbody">
							<tr><td colspan="4" class="bssms-loading">...</td></tr>
						</tbody>
					</table>
				</div>

				<div class="bssms-quick-actions-card bssms-card">
					<h4 class="section-title">🚀 فوری کارروائیاں (Quick Actions)</h4>
					<div class="action-buttons-grid">
						<button class="bssms-btn bssms-btn-action" data-action="admission">
							<span class="dashicons dashicons-welcome-write-blog"></span> New Admission
						</button>
						<button class="bssms-btn bssms-btn-action" data-action="list">
							<span class="dashicons dashicons-list-view"></span> Students List
						</button>
						<button class="bssms-btn bssms-btn-action" data-action="courses">
							<span class="dashicons dashicons-welcome-learn-more"></span> Manage Courses
						</button>
						<button class="bssms-btn bssms-btn-action" data-action="settings">
							<span class="dashicons dashicons-admin-settings"></span> Settings
						</button>
					</div>
				</div>
				
				<div class="bssms-dashboard-footer bssms-col-span-full">
					<p>Plugin Version <?php echo esc_html(BSSMS_VERSION); ?> | Last updated: <span id="last-updated-time">...</span></p>
					<p>&copy; <?php echo date('Y'); ?> <?php echo esc_html($settings['academy_name']); ?></p>
				</div>
			</div>
		</template>
		<?php
	}
}

// ✅ Syntax verified block end
