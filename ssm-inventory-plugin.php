<?php
/**
 * Plugin Name:       SSM Core Inventory
 * Plugin URI:        https://your-plugin-uri.com
 * Description:       Manages core inventory (Units, Types, Rates) and settings for hotel/rental properties.
 * Version:           1.0.0
 * Author:            Your Name
 * Author URI:        https://your-author-uri.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ssm-inventory
 * Domain Path:       /languages
 */

// 🟢 یہاں سے [Plugin Security & Foundation] شروع ہو رہا ہے

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin class
 */
final class SSM_Inventory_Plugin {

    /**
     * Plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Constructor.
     */
    public function __construct() {
        $this->define_constants();
        add_action( 'admin_menu', array( $this, 'register_admin_menus' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }

    /**
     * Define plugin constants.
     */
    private function define_constants() {
        define( 'SSM_PLUGIN_FILE', __FILE__ );
        define( 'SSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'SSM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Register all admin menus for the plugin.
     */
    public function register_admin_menus() {
        // Main Menu Page (Core Inventory)
        add_menu_page(
            __( 'Core Inventory', 'ssm-inventory' ),
            __( 'Core Inventory', 'ssm-inventory' ),
            'manage_options',
            'ssm-settings', // Main menu slug points to General Settings
            array( $this, 'render_admin_page_settings' ),
            'dashicons-building',
            25
        );

        // 1. General Settings (This is also the main page)
        add_submenu_page(
            'ssm-settings',
            __( 'General Settings', 'ssm-inventory' ),
            __( 'General Settings', 'ssm-inventory' ),
            'manage_options',
            'ssm-settings', // Slug
            array( $this, 'render_admin_page_settings' ) // Callback
        );

        // 2. Unit Types
        add_submenu_page(
            'ssm-settings',
            __( 'Unit Types', 'ssm-inventory' ),
            __( 'Unit Types', 'ssm-inventory' ),
            'manage_options',
            'ssm-unit-types', // Slug
            array( $this, 'render_admin_page_unit_types' ) // Callback
        );

        // 3. Units
        add_submenu_page(
            'ssm-settings',
            __( 'Units', 'ssm-inventory' ),
            __( 'Units', 'ssm-inventory' ),
            'manage_options',
            'ssm-units', // Slug
            array( $this, 'render_admin_page_units' ) // Callback
        );

        // 4. Rate Plans
        add_submenu_page(
            'ssm-settings',
            __( 'Rate Plans', 'ssm-inventory' ),
            __( 'Rate Plans', 'ssm-inventory' ),
            'manage_options',
            'ssm-rate-plans', // Slug
            array( $this, 'render_admin_page_rate_plans' ) // Callback
        );
    }

    /**
     * Enqueue admin scripts and styles.
     */
    public function enqueue_admin_assets( $hook_suffix ) {
        // List of our plugin's admin pages
        $plugin_pages = array(
            'toplevel_page_ssm-settings',
            'core-inventory_page_ssm-unit-types',
            'core-inventory_page_ssm-units',
            'core-inventory_page_ssm-rate-plans',
        );

        // Load assets only on our plugin pages
        if ( in_array( $hook_suffix, $plugin_pages ) ) {
            
            // Enqueue Style
            wp_enqueue_style(
                'ssm-inventory-style',
                SSM_PLUGIN_URL . 'ssm-inventory-plugin.css',
                array(),
                self::VERSION
            );

            // Enqueue Script
            wp_enqueue_script(
                'ssm-inventory-script',
                SSM_PLUGIN_URL . 'ssm-inventory-plugin.js',
                array( 'jquery', 'wp-element' ), // wp-element for React/Vue, or just jquery
                self::VERSION,
                true // Load in footer
            );

            // Localize script data (Rule 6)
            wp_localize_script(
                'ssm-inventory-script',
                'ssm_data',
                array(
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'nonce'    => wp_create_nonce( 'ssm_ajax_nonce' ), // Security Nonce (Rule 6)
                )
            );
        }
    }

    // 🔴 یہاں پر [Plugin Security & Foundation] ختم ہو رہا ہے

    // 🟢 یہاں سے [Admin Page Render Functions] شروع ہو رہا ہے

    /**
     * Renders the General Settings page.
     * (Rule 6: Must have root div and template)
     */
    public function render_admin_page_settings() {
        // Root div for JS app
        echo '<div id="ssm-settings-root" class="ssm-root" data-screen="settings"></div>';
        
        // Full page template (Rule 6)
        echo '<template id="ssm-settings-template">';
        echo '<div>Loading Settings Page...</div>'; // Placeholder
        echo '</template>';
    }

    /**
     * Renders the Unit Types page.
     * (Rule 6: Must have root div and template)
     */
    public function render_admin_page_unit_types() {
        // Root div for JS app
        echo '<div id="ssm-unit-types-root" class="ssm-root" data-screen="unit-types"></div>';

        // Full page template (Rule 6)
        echo '<template id="ssm-unit-types-template">';
        echo '<div>Loading Unit Types Page...</div>'; // Placeholder
        echo '</template>';
    }

    /**
     * Renders the Units page.
     * (Rule 6: Must have root div and template)
     */
    public function render_admin_page_units() {
        // Root div for JS app
        echo '<div id="ssm-units-root" class="ssm-root" data-screen="units"></div>';

        // Full page template (Rule 6)
        echo '<template id="ssm-units-template">';
        echo '<div>Loading Units Page...</div>'; // Placeholder
        echo '</template>';
    }

    /**
     * Renders the Rate Plans page.
     * (Rule 6: Must have root div and template)
     */
    public function render_admin_page_rate_plans() {
        // Root div for JS app
        echo '<div id="ssm-rate-plans-root" class="ssm-root" data-screen="rate-plans"></div>';

        // Full page template (Rule 6)
        echo '<template id="ssm-rate-plans-template">';
        echo '<div>Loading Rate Plans Page...</div>'; // Placeholder
        echo '</template>';
    }

    // 🔴 یہاں پر [Admin Page Render Functions] ختم ہو رہا ہے

}

/**
 * Initialize the plugin.
 */
function ssm_run_inventory_plugin() {
    new SSM_Inventory_Plugin();
}
add_action( 'plugins_loaded', 'ssm_run_inventory_plugin' );
