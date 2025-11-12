/**
 * bssms-settings.js
 * سسٹم ترتیبات (System Settings) کی کلائنٹ سائیڈ لاجک کو سنبھالتا ہے۔
 * ترتیبات کو لوڈ، نیویگیٹ، اور محفوظ کرنا شامل ہے۔
 */

(function ($) {
    // 🟢 یہاں سے Settings JS Logic شروع ہو رہا ہے
    
    const settingsConfig = {
        root: '#bssms-settings-root',
        templateId: 'bssms-settings-form-template',
        formId: '#bssms-settings-form',
        data: bssms_data.settings || {}, // PHP سے لوکلائزڈ ترتیبات
    };

    /**
     * ترتیبات کے صفحہ کو شروع کریں۔
     */
    function initSettingsPage() {
        if (BSSMS_UI.mountTemplate(settingsConfig.root, settingsConfig.templateId)) {
            loadInitialSettings();
            bindEvents();
            showSection('general'); // ڈیفالٹ کے طور پر جنرل سیکشن دکھائیں
        }
    }

    /**
     * PHP سے موصول ہونے والی ترتیبات سے فارم کو پُر کریں۔
     */
    function loadInitialSettings() {
        const settings = settingsConfig.data;
        
        // 1. جنرل ترتیبات
        $('#academy_name').val(settings.academy_name || '');
        $('#admin_email').val(settings.admin_email || '');
        $('#default_currency').val(settings.default_currency || 'PKR');
        $('#date_format').val(settings.date_format || 'd-m-Y');
        
        // لوگو مینجمنٹ
        $('#logo_url_hidden').val(settings.logo_url || '');
        if (settings.logo_url) {
            $('#current-logo-img').attr('src', settings.logo_url).show();
            $('#btn-remove-logo').show();
        }

        // 2. تھیم اور برانڈنگ
        // Theme Mode Toggle
        const isDark = settings.theme_mode === 'dark';
        $('#theme_mode_toggle').prop('checked', isDark);
        $('#current-theme-mode').text(isDark ? 'Dark' : 'Light');
        
        // Primary Color
        $('#primary_color').val(settings.primary_color || '#0073aa');
        $('#color-hex-display').text(settings.primary_color || '#0073aa');
        
        // 3. زبان کی ترتیبات
        $('#enable_bilingual_labels').prop('checked', settings.enable_bilingual_labels === 'on');
        $('#enable_auto_urdu_translation').prop('checked', settings.enable_auto_urdu_translation === 'on');
        
        // لائیو تھیم اپ ڈیٹ
        updateLiveTheme(settings.theme_mode, settings.primary_color);
    }
    
    /**
     * تھیم اور رنگ کو DOM پر لاگو کریں (Live Update)
     */
    function updateLiveTheme(mode, color) {
        $('body').removeClass('bssms-light-mode bssms-dark-mode').addClass(`bssms-${mode}-mode`);
        // CSS ویری ایبل کو اپ ڈیٹ کریں
        document.documentElement.style.setProperty('--bssms-color-primary', color);
    }

    /**
     * سائیڈ بار نیویگیشن کو ہینڈل کریں۔
     */
    function showSection(sectionId) {
        // تمام بٹنوں سے ایکٹو کلاس ہٹائیں
        $('.bssms-nav-item').removeClass('active');
        // تمام سیکشنز کو چھپائیں
        $('.bssms-setting-section').hide();

        // منتخب سیکشن کو دکھائیں اور نیویگیشن بٹن کو ایکٹو کریں
        $(`.bssms-nav-item[data-section="${sectionId}"]`).addClass('active');
        $(`#settings-${sectionId}`).show();
    }

    /**
     * فارم کو جمع کرانے کا AJAX ہینڈلر
     */
    function handleFormSubmit(e) {
        e.preventDefault();
        
        const $form = $(settingsConfig.formId);
        
        // فارم ڈیٹا کو FormData میں شامل کریں (تاکہ فائل اپ لوڈ ہو سکے)
        const formData = new FormData($form[0]);
        
        // غیر فعال ٹوگلز کی ویلیو کو 'off' کے طور پر بھیجیں
        if (!$('#theme_mode_toggle').is(':checked')) {
            formData.append('theme_mode', 'light'); // Dark موڈ نہیں ہے تو Light بھیجیں
        }
        if (!$('#enable_bilingual_labels').is(':checked')) {
            formData.append('enable_bilingual_labels', 'off');
        }
        if (!$('#enable_auto_urdu_translation').is(':checked')) {
            formData.append('enable_auto_urdu_translation', 'off');
        }

        // بٹن کو غیر فعال کریں اور لوڈنگ دکھائیں
        $('#btn-save-settings, #btn-save-exit').prop('disabled', true).text('محفوظ کیا جا رہا ہے...');
        BSSMS_UI.displayMessage('Processing', bssms_data.messages.saving, 'info');

        // (AJAX) کال
        BSSMS_UI.wpAjax('save_settings', formData)
            .then(response => {
                BSSMS_UI.displayMessage('Success', response.message_ur, 'success');
                
                // تھیم اور زبان کی ترتیبات کو اپ ڈیٹ کریں
                const newMode = response.new_theme_mode || 'light';
                const newColor = $('#primary_color').val();
                
                updateLiveTheme(newMode, newColor);
                $('#current-theme-mode').text(newMode === 'dark' ? 'Dark' : 'Light');

                // اگر 'Save & Exit' بٹن دبایا گیا تو باہر نکلیں
                if (e.target.id === 'btn-save-exit') {
                    window.location.href = `admin.php?page=${bssms_data.pages['students-list']}`;
                }
            })
            .catch(error => {
                console.error('Settings Save Failed:', error);
            })
            .finally(() => {
                $('#btn-save-settings, #btn-save-exit').prop('disabled', false).text('💾 Save Changes (محفوظ کریں)');
            });
    }

    /**
     * تمام ترتیبات کو ڈیفالٹ پر ری سیٹ کریں۔
     */
    function handleResetDefaults() {
        if (!confirm(bssms_data.messages.reset_confirm)) {
            return;
        }

        $('#btn-restore-defaults').prop('disabled', true).text('ری سیٹ ہو رہا ہے...');

        BSSMS_UI.wpAjax('reset_defaults', {})
            .then(response => {
                BSSMS_UI.displayMessage('Success', response.message_ur, 'success');
                window.location.reload(); // صفحہ ری لوڈ کریں تاکہ نئی ترتیبات لوڈ ہوں۔
            })
            .catch(error => {
                console.error('Reset Failed:', error);
            })
            .finally(() => {
                $('#btn-restore-defaults').prop('disabled', false).text('⚠️ Restore Defaults');
            });
    }
    
    /**
     * تمام (DOM) ایونٹس کو باندھیں۔
     */
    function bindEvents() {
        // سائیڈ بار نیویگیشن
        $('.bssms-nav-item').on('click', function() {
            showSection($(this).data('section'));
        });
        
        // فارم جمع کرانا
        $(settingsConfig.formId).on('submit', handleFormSubmit);

        // تمام ترتیبات کو ری سیٹ کریں (Input values only)
        $('#btn-reset-all').on('click', loadInitialSettings);
        
        // فیکٹری ڈیفالٹس کو ری سیٹ کریں (DB reset)
        $('#btn-restore-defaults').on('click', handleResetDefaults);

        // Theme Mode لائیو اپ ڈیٹ
        $('#theme_mode_toggle').on('change', function() {
            const mode = $(this).is(':checked') ? 'dark' : 'light';
            $('#current-theme-mode').text(mode === 'dark' ? 'Dark' : 'Light');
            updateLiveTheme(mode, $('#primary_color').val());
        });

        // Primary Color لائیو اپ ڈیٹ
        $('#primary_color').on('input', function() {
            const color = $(this).val();
            $('#color-hex-display').text(color);
            const mode = $('#theme_mode_toggle').is(':checked') ? 'dark' : 'light';
            updateLiveTheme(mode, color);
        });
        
        // پرائمری کلر کو ڈیفالٹ پر ری سیٹ کریں
        $('#btn-reset-color').on('click', function() {
            const defaultColor = '#0073aa';
            $('#primary_color').val(defaultColor).trigger('input');
        });

        // لوگو ہٹائیں
        $('#btn-remove-logo').on('click', function() {
            if (confirm('کیا آپ واقعی لوگو ہٹانا چاہتے ہیں؟')) {
                $('#logo_url_hidden').val(''); // URL کو خالی کریں
                $('#current-logo-img').attr('src', '').hide();
                $('#logo_file').val(''); // فائل ان پٹ بھی خالی کریں
                $(this).hide();
                BSSMS_UI.displayMessage('Info', 'لوگو ہٹا دیا گیا ہے، محفوظ کرنے کے لیے "Save Changes" پر کلک کریں۔', 'info');
            }
        });
        
        // لوگو فائل کا لائیو پریویو
        $('#logo_file').on('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#current-logo-img').attr('src', e.target.result).show();
                    $('#btn-remove-logo').show();
                };
                reader.readAsDataURL(this.files[0]);
                // hidden URL کو خالی رکھیں تاکہ فائل اپ لوڈ کا فنکشن چلے
                $('#logo_url_hidden').val('');
            }
        });
    }

    // جب DOM تیار ہو جائے تو صفحہ شروع کریں
    $(document).ready(function () {
        if ($(settingsConfig.root).length) {
            initSettingsPage();
        }
    });

    // 🔴 یہاں پر Settings JS Logic ختم ہو رہا ہے
})(jQuery);

// ✅ Syntax verified block end
