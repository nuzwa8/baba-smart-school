<?php
/**
 * BSSMS Parent 'Fee Payments' Page
 *
 * @package BSSMS
 */

// 🟢 یہاں سے [Parent Fee Payments Class] شروع ہو رہا ہے
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * 'فیس کی ادائیگی' پیج کو رینڈر (render) کرتا ہے۔
 * سخت پابندی: اس فائل میں صرف लेआउट (layout) شامل ہے۔ کوئی AJAX یا DB کالز نہیں ہیں۔
 */
class BSSMS_Parent_Fees {

	/**
	 * صفحہ کو رینڈر کرتا ہے۔
	 */
	public static function render_page() {

		// 🟢 یہاں سے [Page Root] شروع ہو رہا ہے
		?>
		<div id="bssms-parent-fees-root" class="bssms-root" data-screen="fees">
			<p>Loading Fee Payments...</p>
		</div>
		<?php
		// 🔴 یہاں پر [Page Root] ختم ہو رہا ہے

		// 🟢 یہاں سے [Page Template] شروع ہو رہا ہے
		?>
		<template id="bssms-parent-fees-template">
			<div class="bssms-parent-fees">
				
				<div class="bssms-page-header">
					<h1><?php _e( 'Fee Payments', 'bssms' ); ?></h1>
					<div class="bssms-header-actions">
						<button class="bssms-btn bssms-btn-secondary"><?php _e( 'Export PDF', 'bssms' ); ?></button>
						<button class="bssms-btn bssms-btn-secondary"><?php _e( 'Export Excel', 'bssms' ); ?></button>
					</div>
				</div>

				<div class="bssms-breadcrumbs">
					<span><?php _e( 'Parent', 'bssms' ); ?></span> &gt; 
					<span><?php _e( 'Fee Payments', 'bssms' ); ?></span>
				</div>

				<div class="bssms-stats-grid-fees">
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Total Due', 'bssms' ); ?></span>
						<span class="card-value">PKR 15,000</span>
						<span class="card-sublabel-due"><?php _e( '40% Last Month', 'bssms' ); ?></span>
					</div>
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Due This Month', 'bssms' ); ?></span>
						<span class="card-value">PKR 500</span>
						<span class="card-sublabel-increase"><?php _e( '+58%', 'bssms' ); ?></span>
					</div>
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Paid This Month', 'bssms' ); ?></span>
						<span class="card-value">PKR 17,000</span>
					</div>
					<div class="bssms-stat-card">
						<span class="card-label"><?php _e( 'Paid This Month', 'bssms' ); ?></span>
						<span class="card-value">PKR 17,500</span>
					</div>
					<div class="bssms-stat-card-highlight">
						<span class="card-label"><?php _e( 'Next Due Date', 'bssms' ); ?></span>
						<span class="card-value-date">25 Nov</span>
					</div>
				</div>

				<div classs="bssms-toolbar">
					<div class="search-box">
						<input type="text" placeholder="<?php _e( 'Search Invoice...', 'bssms' ); ?>" />
						<span class="icon-search"></span>
					</div>
					<div class="filters">
						</div>
					<div class="bssms-actions-right">
						<label><input type="checkbox" id="pay-selected-check" /> <?php _e( 'Pay Selected', 'bssms' ); ?></label>
						<button class="bssms-btn bssms-btn-primary"><?php _e( 'Pay Selected', 'bssms' ); ?></button>
						<button class="bssms-btn bssms-btn-secondary"><?php _e( 'All Receipts (ZIP)', 'bssms' ); ?></button>
						<button class="bssms-btn icon-button" aria-label="<?php _e('Download', 'bssms'); ?>"></button>
					</div>
				</div>

				<div class="bssms-layout-grid-2col">
					
					<div class="bssms-grid-col-left">
						
						<div class="bssms-widget-card" id="widget-outstanding-invoices">
							<h3 class="widget-title"><?php _e( 'Outstanding Invoices', 'bssms' ); ?></h3>
							<table class="bssms-data-table">
								<thead>
									<tr>
										<th><input type="checkbox" /></th>
										<th><?php _e( 'Invoice #', 'bssms' ); ?></th>
										<th><?php _e( 'Child', 'bssms' ); ?></th>
										<th><?php _e( 'Class-Section', 'bssms' ); ?></th>
										<th><?php _e( 'Fine/Discount', 'bssms' ); ?></th>
										<th><?php _e( 'Due Date', 'bssms' ); ?></th>
										<th><?php _e( 'Actions', 'bssms' ); ?></th>
									</tr>
								</thead>
								<tbody>
									</tbody>
							</table>
						</div>

						<div class="bssms-widget-card" id="widget-receipts-history">
							<h3 class="widget-title"><?php _e( 'Receipts & Payment History', 'bssms' ); ?></h3>
							<table class="bssms-data-table">
								<thead>
									<tr>
										<th><?php _e( 'Receipt #', 'bssms' ); ?></th>
										<th><?php _e( 'Child', 'bssms' ); ?></th>
										<th><?php _e( 'Description', 'bssms' ); ?></th>
										<th><?php _e( 'Total Due', 'bssms' ); ?></th>
										<th><?php _e( 'Due Date', 'bssms' ); ?></th>
										<th><?php _e( 'Status', 'bssms' ); ?></th>
									</tr>
								</thead>
								<tbody>
									</tbody>
							</table>
						</div>

						<div class="bssms-widget-card" id="widget-receipts-history-bottom">
							<h3 class="widget-title"><?php _e( 'Receipts & Payment History', 'bssms' ); ?></h3>
							<table class="bssms-data-table">
								<thead>
									<tr>
										<th><?php _e( 'Payment Mode', 'bssms' ); ?></th>
										<th><?php _e( 'Receipt #', 'bssms' ); ?></th>
										<th><?php _e( 'Child', 'bssms' ); ?></th>
										<th><?php _e( 'Amount', 'bssms' ); ?></th>
										<th><?php _e( 'Status', 'bssms' ); ?></th>
										<th><?php _e( 'Action', 'bssms' ); ?></th>
									</tr>
								</thead>
								<tbody>
									</tbody>
							</table>
						</div>
					</div>

					<div class="bssms-grid-col-right">
						
						<div class="bssms-widget-card" id="widget-invoice-breakdown">
							<h3 class="widget-title"><?php _e( 'Invoice Breakdown', 'bssms' ); ?></h3>
							<div class="user-info">
								<img src="" alt="Ahmed Raza" class="avatar" />
								<span><?php _e( 'Ahmed Raza (5-A)', 'bssms' ); ?></span>
							</div>
							<div class="fee-details">
								<p><?php _e( 'Total Fee:', 'bssms' ); ?> <strong>PKR 7,000</strong></p>
								</div>
							<div class="payment-actions">
								<button class="bssms-btn bssms-btn-primary"><?php _e( 'Pay Now', 'bssms' ); ?></button>
								<button class="bssms-btn-link"><?php _e( 'Download', 'bssms' ); ?></button>
							</div>
							<div class="discount-code">
								<label><?php _e( 'Apply Discount Code', 'bssms' ); ?></label>
								<input type="text" />
								<label><?php _e( 'Add Note for Accountant', 'bssms' ); ?></label>
								<textarea></textarea>
							</div>
						</div>

						<div class="bssms-widget-card" id="widget-secure-payment">
							<h3 class="widget-title"><?php _e( 'Secure Payment', 'bssms' ); ?></h3>
							<form>
								<label><?php _e( 'Child', 'bssms' ); ?></label>
								<p><strong><?php _e( 'Aysha Khan', 'bssms' ); ?></strong></p>

								<label><?php _e( 'Amount', 'bssms' ); ?></label>
								<p><strong>PKR 8,900</strong></p>

								<button class="bssms-btn bssms-btn-primary bssms-btn-full-width"><?php _e( 'Pay Securely', 'bssms' ); ?></button>
							</form>
						</div>

						<div class="bssms-modal" id="secure-payment-modal" style="display: none; /* JS will control this */">
							<h3 class="widget-title"><?php _e( 'Secure Payment', 'bssms' ); ?></h3>
							<form>
								<label><?php _e( 'Child', 'bssms' ); ?></label>
								<p><strong><?php _e( 'Aysha Khan', 'bssms' ); ?></strong></smap>
								<div class="modal-footer">
									<button class="bssms-btn bssms-btn-secondary"><?php _e( 'Cancel', 'bssms' ); ?></button>
									<button class="bssms-btn bssms-btn-primary"><?php _e( 'Pay Securely', 'bssms' ); ?></button>
								</div>
							</form>
						</div>

					</div>
				</div>

			</div>
		</template>
		<?php
		// 🔴 یہاں پر [Page Template] ختم ہو رہا ہے
	}
}
// 🔴 یہاں پر [Parent Fee Payments Class] ختم ہو رہا ہے

// ✅ Syntax verified block end.
