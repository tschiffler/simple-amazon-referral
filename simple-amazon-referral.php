<?php
/*
Plugin Name: Simple Amazon Referral
Description: Ein einfaches WordPress-Plugin zur Verwaltung und Anzeige von Amazon-Produktdaten. Sämtliche Daten werden über eine lokale Tabelle gehalten ohne Abhängigkeiten zu irgend einer API.
Version: 1.0
Author: Thomas Schiffler
Author URI: https://www.schiffler.eu
*/

// Sicherheit: Direktzugriff verhindern
if (!defined('ABSPATH')) {
    exit;
}

class SimpleAmazonReferral {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'simple_amazon_referral';

        register_activation_hook(__FILE__, [$this, 'install_table']);
        register_uninstall_hook(__FILE__, ['SimpleAmazonReferral', 'uninstall_table']);
        add_action('admin_menu', [$this, 'create_admin_menu']);
        add_shortcode('AMAZON_REF', [$this, 'render_shortcode']);
		add_shortcode('AMAZON_TXT', [$this, 'render_text_shortcode']);
    }

    // Tabelle erstellen
    public function install_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            product_id VARCHAR(255) NOT NULL,
            image_url TEXT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            product_url TEXT NOT NULL
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Tabelle löschen
    public static function uninstall_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'simple_amazon_referral';
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    // Admin-Menü erstellen
    public function create_admin_menu() {
        add_menu_page(
            'Simple Amazon Referral',
            'Amazon Referral',
            'manage_options',
            'simple-amazon-referral',
            [$this, 'admin_page'],
            'dashicons-cart'
        );
    }

    // Admin-Seite rendern
    public function admin_page() {
        global $wpdb;

        // Daten verarbeiten (Hinzufügen / Bearbeiten)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $product_id = sanitize_text_field($_POST['product_id']);
            $image_url = esc_url_raw($_POST['image_url']);
            $title = sanitize_text_field($_POST['title']);
            $description = sanitize_textarea_field($_POST['description']);
            $product_url = esc_url_raw($_POST['product_url']);

            if ($_POST['action'] === 'add') {
                $wpdb->insert($this->table_name, [
                    'product_id' => $product_id,
                    'image_url' => $image_url,
                    'title' => $title,
                    'description' => $description,
                    'product_url' => $product_url
                ]);
            } elseif ($_POST['action'] === 'edit' && isset($_POST['id'])) {
                $id = (int) $_POST['id'];
                $wpdb->update($this->table_name, [
                    'product_id' => $product_id,
                    'image_url' => $image_url,
                    'title' => $title,
                    'description' => $description,
                    'product_url' => $product_url
                ], ['id' => $id]);
            }
        }

        // Daten löschen
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
            $id = (int) $_GET['id'];
            $wpdb->delete($this->table_name, ['id' => $id]);
        }

        // Daten abrufen
        $products = $wpdb->get_results("SELECT * FROM $this->table_name");

        include 'admin-page-template.php';
    }
	
	// Produkt laden (nach Produkt-ID oder technischer ID)
    private function get_product($identifier) {
        global $wpdb;

        if (is_numeric($identifier)) {
            return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $identifier));
        } else {
            return $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE product_id = %s", $identifier));
        }
    }

    // Shortcode für Produktanzeige rendern
    public function render_shortcode($atts, $content = null) {
        global $wpdb;

        $atts = shortcode_atts([
            'template' => 'default',
        ], $atts);

        $identifier = sanitize_text_field($content);

        if (empty($identifier)) {
            return '<p>Keine Produkt-ID oder technische ID angegeben.</p>';
        }

        $product = $this->get_product($identifier);

        if (!$product) {
            return '<p>Produkt nicht gefunden.</p>';
        }

        $template_file = plugin_dir_path(__FILE__) . 'templates/' . $atts['template'] . '-template.php';

        if (!file_exists($template_file)) {
            $template_file = plugin_dir_path(__FILE__) . 'templates/default-template.php';
        }

        if (!file_exists($template_file)) {
            return '<p>Template-Datei nicht gefunden.</p>';
        }

        ob_start();
        include $template_file;
        return ob_get_clean();
    }

    // Shortcode für Textlink rendern
    public function render_text_shortcode($atts, $content = null) {
        global $wpdb;

        $atts = shortcode_atts([
            'title' => 'Produkt ansehen',
        ], $atts);

        $identifier = sanitize_text_field($content);

        if (empty($identifier)) {
            return '<p>Keine Produkt-ID oder technische ID angegeben.</p>';
        }

        $product = $this->get_product($identifier);

        if (!$product) {
            return '<p>Produkt nicht gefunden.</p>';
        }

        return sprintf(
            '<a href="%s" target="_blank" title="%s" alt="%s">%s*</a>',
            esc_url($product->product_url),
            esc_attr($product->title),
            esc_attr($product->title),
            esc_html($atts['title'])
        );
    }
}

new SimpleAmazonReferral();

