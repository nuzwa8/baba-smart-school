<?php
/**
 * BSSMS Parent 'Attendance Tracker' Page
 *
 * @package BSSMS
 */

// 🟢 یہاں سے [Parent Attendance Tracker Class] شروع ہو رہا ہے
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * 'حاضری ٹریکر' پیج کو رینڈر (render) کرتا ہے۔
 * سخت پابندی: اس فائل میں صرف लेआउट (layout) شامل ہے۔ کوئی AJAX یا DB کالز نہیں ہیں۔
 */
class BSSMS_Parent_Attendance {

	/**
	 * صفحہ کو رینڈر کرتا ہے۔
	 */
	public static function render_page() {

		// 🟢 یہاں سے [Page Root] شروع ہو رہا ہے
		?>
		<div id="bssms-parent-attendance-root" class="bssms-root" data-screen="attendance">
			<p>Loading Attendance Tracker...</p>
		</div>
		<?php
		// 🔴 یہاں پر [Page Root] ختم ہو رہا ہے

		// 🟢 یہاں سے [Page Template] شروع ہو رہا ہے
		?>
		<template id="bssms-parent-attendance-template">
			<div class="bssms-parent-attendance">
				
				<div class="bssms-page-header">
					<h1><?php _e( 'Attendance Tracker', 'bssms' ); ?></h1>
					<div class="bssms-header-actions">
						<button class="bssms-btn bssms-btn-secondary"><?php _e( 'Export PDF', 'bssms' ); ?></button>
						<button class="bssms-btn bssms-btn-secondary"><?php _e( 'Export Excel', 'bssms' ); ?></button>
					</div>
				</div>

				<div class="bssms-stats-grid-attendance">
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Overall Attendance %', 'bssms' ); ?></span>
						<span class="card-value">94%</span>
					</div>
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Days Present', 'bssms' ); ?></span>
						<span class="card-value">24</span>
					</div>
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Days Absent', 'bssms' ); ?></span>
						<span class="card-value">2</span>
					</div>
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Late Arrivals', 'bssms' ); ?></span>
						<span class="card-value">1</span>
					</div>
				</div>

				<div class="bssms-layout-grid-2col-attendance">
					
					<div class="bssms-grid-col-left">
						
						<div class="bssms-widget-card" id="widget-attendance-calendar">
							<div class="widget-header">
								<h3 class="widget-title"><?php _e( 'Attendance Calendar', 'bssms' ); ?></h3>
								<div class="widget-filters">
									<label><?php _e( 'Filter', 'bssms' ); ?></label>
									<button class="bssms-btn-link"><?php _e( 'Print Report', 'bssms' ); ?></button>
								</div>
							</div>
							<div class="widget-toolbar">
								<input type="date" />
								<select>
									<option><?php _e( 'This Month', 'bssms' ); ?></option>
								</select>
								<button class="bssms-btn bssms-btn-primary"><?php _e( 'Apply Filter', 'bssms' ); ?></button>
							</div>
							<div class="calendar-placeholder">
								[<?php _e( 'Monthly Calendar Grid', 'bssms' ); ?>]
							</div>
							<div class="calendar-legend">
								<span class="legend-item present"><?php _e( 'Present', 'bssms' ); ?></span>
								<span class="legend-item absent"><?php _e( 'Absent', 'bssms' ); ?></span>
								<span class="legend-item late"><?php _e( 'Late', 'bssms' ); ?></span>
								<span class="legend-item holiday"><?php _e( 'Holiday', 'bssms' ); ?></span>
							</div>
						</div>

						<div class="bssms-widget-card" id="widget-attendance-trend">
							<h3 class="widget-title"><?php _e( 'Monthly Attendance Trend', 'bssms' ); ?></h3>
							<div class="chart-placeholder-line">
								[<?php _e( 'Line Chart', 'bssms' ); ?>]
							</div>
						</div>

						<div class="bssms-widget-card" id="widget-absence-breakdown">
							<h3 class="widget-title"><?php _e( 'Absence Breakdown', 'bssms' ); ?></h3>
							<div class="chart-placeholder-pie">
								[<?php _e( 'Pie Chart', 'bssms' ); ?>]
							</div>
						</div>

					</div>

					<div class="bssms-grid-col-right">
						
						<div class="bssms-widget-card" id="widget-child-info">
							<div class="user-info">
								<img src="" alt="Aysha Khan" class="avatar" />
								<div class="info-text">
									<h4><?php _e( 'Aysha Khan', 'bssms' ); ?></h4>
									<span><?php _e( 'Class: 7-B', 'bssms' ); ?></span>
									<span><?php _e( 'Roll No: 23', 'bssms' ); ?></span>
								</div>
							</div>
							<div class="widget-actions">
								<button class="bssms-btn-link"><?php _e( 'View Homework', 'bssms' ); ?></button>
								<button class="bssms-btn-link"><?php _e( 'View Results', 'bssms' ); ?></button>
							</div>
						</div>

						<div class="bssms-widget-card" id="widget-monthly-trend-sidebar">
							<h3 class="widget-title"><?php _e( 'Monthly Attendance Trend', 'bssms' ); ?></h3>
							<div class="trend-details">
								<p><?php _e( 'Data: 05 Nov 2025', 'bssms' ); ?></p>
								<p><?php _e( 'Status: Absent', 'bssms' ); ?></p>
								</div>
						</div>

						<div class="bssms-widget-card" id="widget-child-details-sidebar">
							<h3 class="widget-title"><?php _e( 'Child Details', 'bssms' ); ?></h3>
							</div>

						<div class="bssms-widget-card" id="widget-absence-alerts">
							<h3 class="widget-title"><?php _e( 'Absence Alerts', 'bssms' ); ?></h3>
							<ul class="alert-list">
								<li>
									<span><?php _e( 'Date', 'bssms' ); ?></span>
									<span><?php _e( 'Reason', 'bssms' ); ?></span>
									<button class="bssms-btn-link"><?php _e( 'Aert Parent', 'bssms' ); ?></button>
								</li>
							</ul>
						</div>

						<div class="bssms-widget-card" id="widget-ai-predictor">
							<h3 class="widget-title"><?php _e( 'AI Attendance Predictor', 'bssms' ); ?></h3>
							<p><?php _e( 'Ahmed\'s attendance dropped by 8% month. Possible absentsie risk next week.', 'bssms' ); ?></p>
							<div class="chart-placeholder-line-small">
								[<?php _e( 'Small Trend Chart', 'bssms' ); ?>]
							</div>
						</div>

					</div>
				</div>

			</div>
		</template>
		<?php
		// 🔴 یہاں پر [Page Template] ختم ہو رہا ہے
	}
}
// 🔴 یہاں پر [Parent Attendance Tracker Class] ختم ہو رہا ہے

// ✅ Syntax verified block end.
