/**
 * BSSMS Parent Dashboard
 * * سخت پابندی: یہ فائل صرف UI کو ماؤنٹ کرتی ہے اور AJAX پلیس ہولڈرز پر مشتمل ہے۔
 */

// 🟢 یہاں سے [Parent Dashboard JS] شروع ہو رہا ہے
(function () {
	'use strict';

	// ضروری یوٹیلیٹیز (Utilities) کے لیے پلیس ہولڈرز
	// (یہ فرض کیا جاتا ہے کہ BSSMS_Utils 'bssms-common.js' میں موجود ہے)
	const BSSMS_Utils = window.BSSMS_Utils || {
		mountTemplate: (rootId, templateId) => {
			console.log(`Mounting ${templateId} into ${rootId}`);
			const root = document.getElementById(rootId);
			const template = document.getElementById(templateId);
			if (root && template) {
				root.innerHTML = template.innerHTML;
			} else {
				console.error(`Root (${rootId}) or Template (${templateId}) not found.`);
			}
		},
		wpAjax: (options) => {
			console.log('AJAX call placeholder:', options.data.action);
			// کامیابی (Success) کا جھوٹا (fake) جواب
			if (options.success) {
				options.success({ success: true, data: {} });
			}
		}
	};

	/**
	 * ڈیش بورڈ شروع کریں
	 */
	function initParentDashboard() {
		const rootElement = document.getElementById('bssms-parent-dashboard-root');
		if (!rootElement) {
			console.log('Parent Dashboard root not found. JS exiting.');
			return;
		}

		console.log('Initializing Parent Dashboard...');

		// 1. ٹیمپلیٹ ماؤنٹ کریں
		BSSMS_Utils.mountTemplate('bssms-parent-dashboard-root', 'bssms-parent-dashboard-template');

		// 2. ڈیٹا لوڈ کرنے کے لیے پلیس ہولڈرز
		loadMessageList();
		loadFeeOverview();
	}

	/**
	 * حالیہ پیغامات (Recent Messages) لوڈ کرنے کا پلیس ہولڈر
	 */
	function loadMessageList() {
		const messageList = document.querySelector('#widget-messages .message-list');
		if (!messageList) return;

		console.log('AJAX call placeholder: bssms_parent_get_recent_messages');
		// BSSMS_Utils.wpAjax({ ... });

		// فرضی (mock) ڈیٹا
		messageList.innerHTML = `
			<li class="message-item">
				<img src="" alt="avatar" class="avatar-placeholder" />
				<div class="message-content">
					<p><strong>Teacher Ali (Math)</strong>: Homework for Class 7-B...</p>
					<span class="timestamp">2 hours ago</span>
				</div>
				<span class="status-tag teacher">Teacher</span>
			</li>
			<li class="message-item">
				<img src="" alt="avatar" class="avatar-placeholder" />
				<div class="message-content">
					<p><strong>Principal Zara</strong>: PTM Schedule announced...</p>
					<span class="timestamp">1 day ago</span>
				</div>
				<span class="status-tag principal">Principal</span>
			</li>
		`;
	}

	/**
	 * فیس کا خلاصہ (Fee Overview) لوڈ کرنے کا پلیس ہولڈر
	 */
	function loadFeeOverview() {
		const feeTableBody = document.querySelector('#widget-fee-overview tbody');
		if (!feeTableBody) return;

		console.log('AJAX call placeholder: bssms_parent_get_fee_overview');
		// BSSMS_Utils.wpAjax({ ... });

		// فرضی (mock) ڈیٹا
		feeTableBody.innerHTML = `
			<tr>
				<td>Ali Khan</td>
				<td>$150</td>
				<td><span class="status-due">Due</span></td>
				<td><button class="bssms-btn-link">View Receipt</button></td>
			</tr>
			<tr>
				<td>Fatima Khan</td>
				<td>$0</td>
				<td><span class="status-paid">Paid</span></td>
				<td><button class="bssms-btn-link">View Receipt</button></td>
			</tr>
		`;
	}

	// DOM تیار ہونے پر شروع کریں
	document.addEventListener('DOMContentLoaded', initParentDashboard);

})();
// 🔴 یہاں پر [Parent Dashboard JS] ختم ہو رہا ہے

// ✅ Syntax verified block end.
