<?php
/**
 * Plugin Name: Trainer Registration Pro
 * Plugin URI: https://yoursite.com/trainer-registration-pro
 * Description: Plugin moderne et élégant pour gérer les inscriptions des formateurs IT avec interface Stripe-like et conformité RGPD complète
 * Version: 2.0.0
 * Author: Votre Nom
 * License: GPL v2 or later
 * Text Domain: trainer-registration-pro
 * Requires at least: 5.0
 * Tested up to: 6.3
 * Requires PHP: 7.4
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/trainer-registration.php
 */

// Sécurité - Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('TRAINER_REGISTRATION_VERSION', '2.0.0');
define('TRAINER_REGISTRATION_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TRAINER_REGISTRATION_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TRAINER_REGISTRATION_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Constantes pour les nouvelles fonctionnalités
define('TRPRO_MIN_PHP_VERSION', '7.4');
define('TRPRO_MIN_WP_VERSION', '5.0');
define('TRPRO_DB_VERSION', '2.0');

/**
 * Classe principale du plugin - Version 2.0 avec nouvelle architecture
 */
class TrainerRegistrationPlugin {

    private static $instance = null;
    private $admin = null;
    private $public = null;
    private $shortcodes = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Vérification des prérequis
        if (!$this->check_requirements()) {
            return;
        }

        // Hooks d'activation/désactivation
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Initialisation du plugin
        add_action('init', array($this, 'init'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        
        // Hooks pour les mises à jour
        add_action('admin_init', array($this, 'check_version'));
    }

    /**
     * Vérification des prérequis système
     */
    private function check_requirements() {
        $errors = array();

        // Vérification version PHP
        if (version_compare(PHP_VERSION, TRPRO_MIN_PHP_VERSION, '<')) {
            $errors[] = sprintf(
                __('Trainer Registration Pro nécessite PHP %s ou supérieur. Version actuelle : %s', 'trainer-registration-pro'),
                TRPRO_MIN_PHP_VERSION,
                PHP_VERSION
            );
        }

        // Vérification version WordPress
        if (version_compare(get_bloginfo('version'), TRPRO_MIN_WP_VERSION, '<')) {
            $errors[] = sprintf(
                __('Trainer Registration Pro nécessite WordPress %s ou supérieur. Version actuelle : %s', 'trainer-registration-pro'),
                TRPRO_MIN_WP_VERSION,
                get_bloginfo('version')
            );
        }

        if (!empty($errors)) {
            add_action('admin_notices', function() use ($errors) {
                echo '<div class="notice notice-error"><p>';
                echo '<strong>Trainer Registration Pro :</strong><br>';
                echo implode('<br>', $errors);
                echo '</p></div>';
            });
            return false;
        }

        return true;
    }

    public function init() {
        // Charger les dépendances
        $this->load_dependencies();
        
        // Initialiser les classes
        if (class_exists('TrainerRegistrationPublic')) {
            $this->public = new TrainerRegistrationPublic();
        }
        
        if (class_exists('TrainerRegistrationShortcodes')) {
            $this->shortcodes = new TrainerRegistrationShortcodes();
        }
        
        if (is_admin() && class_exists('TrainerRegistrationAdmin')) {
            $this->admin = new TrainerRegistrationAdmin();
        }
        
        // Hooks additionnels
        add_action('wp_head', array($this, 'add_plugin_meta'));
        add_filter('upload_mimes', array($this, 'add_upload_mimes'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_global_styles'));
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'trainer-registration-pro',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages/'
        );
    }

    private function load_dependencies() {
        // Classes principales - chargement sécurisé
        $required_files = array(
            'includes/class-trainer-registration-public.php',
            'includes/class-trainer-registration-admin.php',
            'includes/class-trainer-registration-shortcodes.php'
        );
        
        foreach ($required_files as $file) {
            $file_path = TRAINER_REGISTRATION_PLUGIN_PATH . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
            } else {
                error_log("Trainer Registration Pro: Fichier manquant - $file");
            }
        }
        
        // Classes utilitaires optionnelles
        $optional_files = array(
            'includes/class-trpro-database.php',
            'includes/class-trpro-email.php',
            'includes/class-trpro-security.php',
            'includes/class-trpro-gdpr.php',
            'includes/trpro-functions.php'
        );
        
        foreach ($optional_files as $file) {
            $file_path = TRAINER_REGISTRATION_PLUGIN_PATH . $file;
            if (file_exists($file_path)) {
                require_once $file_path;
            }
        }
    }

    public function activate() {
        // Créer les tables
        $this->create_tables();
        
        // Créer les dossiers d'upload
        $this->create_upload_folders();
        
        // Définir les options par défaut
        $this->set_default_options();
        
        // Enregistrer la version
        update_option('trpro_db_version', TRPRO_DB_VERSION);
        update_option('trpro_plugin_version', TRAINER_REGISTRATION_VERSION);
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Log de l'activation
        error_log('Trainer Registration Pro activated - Version ' . TRAINER_REGISTRATION_VERSION);
    }

    public function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Log de la désactivation
        error_log('Trainer Registration Pro deactivated');
    }

    private function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Table principale des inscriptions
        $table_name = $wpdb->prefix . 'trainer_registrations';
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            first_name varchar(100) NOT NULL,
            last_name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(20) NOT NULL,
            company varchar(200),
            specialties text NOT NULL,
            experience text NOT NULL,
            cv_file varchar(255) NOT NULL,
            photo_file varchar(255),
            linkedin_url varchar(255),
            bio text,
            availability varchar(50),
            hourly_rate varchar(20),
            rgpd_consent tinyint(1) NOT NULL DEFAULT 0,
            marketing_consent tinyint(1) NOT NULL DEFAULT 0,
            status varchar(20) DEFAULT 'pending',
            admin_notes text,
            last_login datetime,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY email (email),
            KEY status (status),
            KEY specialties_idx (specialties(100)),
            KEY created_at (created_at)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    private function create_upload_folders() {
        $upload_dir = wp_upload_dir();
        $folders = array(
            '/trainer-files/',
            '/trainer-files/cv/',
            '/trainer-files/photos/',
            '/trainer-files/temp/'
        );
        
        foreach ($folders as $folder) {
            $dir_path = $upload_dir['basedir'] . $folder;
            
            if (!file_exists($dir_path)) {
                wp_mkdir_p($dir_path);
                
                // Créer un fichier .htaccess pour la sécurité
                $htaccess_content = "Options -Indexes\n";
                $htaccess_content .= "deny from all\n";
                file_put_contents($dir_path . '.htaccess', $htaccess_content);
                
                // Créer un fichier index.php vide
                file_put_contents($dir_path . 'index.php', '<?php // Silence is golden');
            }
        }
    }

    private function set_default_options() {
        $defaults = array(
            'trpro_primary_color' => '#6366f1',
            'trpro_secondary_color' => '#0f172a',
            'trpro_accent_color' => '#06b6d4',
            'trainer_auto_approve' => 0,
            'trainer_require_photo' => 0,
            'trainer_max_cv_size' => 5, // MB
            'trainer_max_photo_size' => 2, // MB
            'trainer_notification_email' => get_option('admin_email'),
            'trainer_notify_new_registration' => 1,
            'trainer_notify_status_change' => 1,
            'trainer_notify_weekly_summary' => 0,
            'trainer_notify_pending_review' => 1,
            'trainer_trainers_per_page' => 12,
            'trainer_data_retention' => 3, // années
            'trainer_enable_captcha' => 0,
            'trainer_debug_mode' => 0,
            'trainer_contact_email' => get_option('admin_email'),
            'trainer_contact_phone' => '',
            'trainer_company_name' => get_bloginfo('name')
        );

        foreach ($defaults as $option => $value) {
            if (get_option($option) === false) {
                add_option($option, $value);
            }
        }
    }

    public function check_version() {
        $current_version = get_option('trpro_plugin_version', '1.0.0');
        
        if (version_compare($current_version, TRAINER_REGISTRATION_VERSION, '<')) {
            $this->upgrade();
        }
    }

    private function upgrade() {
        // Logique de mise à jour du plugin
        $current_version = get_option('trpro_plugin_version', '1.0.0');
        
        // Exemple de mise à jour de la v1 vers v2
        if (version_compare($current_version, '2.0.0', '<')) {
            // Ajouter les nouvelles colonnes à la table
            global $wpdb;
            $table_name = $wpdb->prefix . 'trainer_registrations';
            
            // Vérifier si les colonnes existent avant de les ajouter
            $columns = $wpdb->get_results("SHOW COLUMNS FROM $table_name");
            $column_names = wp_list_pluck($columns, 'Field');
            
            if (!in_array('marketing_consent', $column_names)) {
                $wpdb->query("ALTER TABLE $table_name ADD COLUMN marketing_consent tinyint(1) NOT NULL DEFAULT 0 AFTER rgpd_consent");
            }
            
            if (!in_array('admin_notes', $column_names)) {
                $wpdb->query("ALTER TABLE $table_name ADD COLUMN admin_notes text AFTER status");
            }
            
            if (!in_array('last_login', $column_names)) {
                $wpdb->query("ALTER TABLE $table_name ADD COLUMN last_login datetime AFTER admin_notes");
            }
            
            // Mettre à jour les options
            $this->set_default_options();
        }
        
        update_option('trpro_plugin_version', TRAINER_REGISTRATION_VERSION);
    }

    public function add_plugin_meta() {
        echo '<meta name="generator" content="Trainer Registration Pro ' . TRAINER_REGISTRATION_VERSION . '">' . "\n";
    }

    public function add_upload_mimes($mimes) {
        // Ajouter les types MIME pour les CV
        $mimes['doc'] = 'application/msword';
        $mimes['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        
        return $mimes;
    }

    public function enqueue_global_styles() {
        // Styles globaux pour l'intégration
        wp_add_inline_style('wp-block-library', '
            .wp-block-shortcode .trpro-container {
                max-width: none;
                margin: 0;
                padding: 0;
            }
        ');
    }
}

// Initialiser le plugin
TrainerRegistrationPlugin::get_instance();