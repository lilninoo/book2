<?php
/**
 * Classe pour la partie publique du plugin - NOUVELLE STRUCTURE
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/includes/class-trainer-registration-public.php
 */

if (!defined('ABSPATH')) {
    exit;
}

class TrainerRegistrationPublic {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_submit_trainer_registration', array($this, 'handle_registration'));
        add_action('wp_ajax_nopriv_submit_trainer_registration', array($this, 'handle_registration'));
        add_action('wp_ajax_search_trainers', array($this, 'handle_trainer_search'));
        add_action('wp_ajax_nopriv_search_trainers', array($this, 'handle_trainer_search'));
        add_action('wp_ajax_contact_trainer', array($this, 'handle_trainer_contact'));
        add_action('wp_ajax_nopriv_contact_trainer', array($this, 'handle_trainer_contact'));
        
        // Hooks pour améliorer l'intégration
        add_action('wp_head', array($this, 'add_custom_css_variables'));
        add_filter('body_class', array($this, 'add_body_classes'));
    }

    public function enqueue_styles() {
        // CSS principal avec nouvelles classes
        wp_register_style(
            'trpro-public-style',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/css/public-style.css',
            array(),
            TRAINER_REGISTRATION_VERSION,
            'all'
        );
        
        // FontAwesome pour les icônes
        wp_register_style(
            'trpro-fontawesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
            array(),
            '6.4.0'
        );
        
        // CSS spécifiques pour différentes pages
        wp_register_style(
            'trpro-home-style',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/css/home-style.css',
            array('trpro-public-style'),
            TRAINER_REGISTRATION_VERSION
        );
        
        wp_register_style(
            'trpro-form-style',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/css/form-style.css',
            array('trpro-public-style'),
            TRAINER_REGISTRATION_VERSION
        );
        
        wp_register_style(
            'trpro-list-style',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/css/list-style.css',
            array('trpro-public-style'),
            TRAINER_REGISTRATION_VERSION
        );
        
        wp_register_style(
            'trpro-search-style',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/css/search-style.css',
            array('trpro-public-style'),
            TRAINER_REGISTRATION_VERSION
        );
        
        // Enqueue automatiquement le style principal et FontAwesome
        wp_enqueue_style('trpro-public-style');
        wp_enqueue_style('trpro-fontawesome');
        
        // Enqueue conditionnel basé sur le contenu de la page
        global $post;
        if ($post && has_shortcode($post->post_content, 'trainer_home')) {
            wp_enqueue_style('trpro-home-style');
        }
        if ($post && has_shortcode($post->post_content, 'trainer_registration_form')) {
            wp_enqueue_style('trpro-form-style');
        }
        if ($post && (has_shortcode($post->post_content, 'trainer_list') || has_shortcode($post->post_content, 'trainer_search'))) {
            wp_enqueue_style('trpro-list-style');
            wp_enqueue_style('trpro-search-style');
        }
    }

    public function enqueue_scripts() {
        // JavaScript principal
        wp_register_script(
            'trpro-public-script',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/js/public-script.js',
            array('jquery'),
            TRAINER_REGISTRATION_VERSION,
            true
        );
        
        // Scripts spécifiques
        wp_register_script(
            'trpro-home-script',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/js/home-script.js',
            array('trpro-public-script'),
            TRAINER_REGISTRATION_VERSION,
            true
        );
        
        wp_register_script(
            'trpro-form-script',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/js/form-script.js',
            array('trpro-public-script'),
            TRAINER_REGISTRATION_VERSION,
            true
        );
        
        wp_register_script(
            'trpro-list-script',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/js/list-script.js',
            array('trpro-public-script'),
            TRAINER_REGISTRATION_VERSION,
            true
        );
        
        wp_register_script(
            'trpro-search-script',
            TRAINER_REGISTRATION_PLUGIN_URL . 'public/js/search-script.js',
            array('trpro-public-script'),
            TRAINER_REGISTRATION_VERSION,
            true
        );
        
        // Enqueue le script principal
        wp_enqueue_script('trpro-public-script');
        
        // Configuration AJAX et localisation
        wp_localize_script('trpro-public-script', 'trainer_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('trainer_registration_nonce'),
            'messages' => array(
                'success' => __('Inscription réussie ! Nous vous contacterons bientôt.', 'trainer-registration'),
                'error' => __('Erreur lors de l\'inscription. Veuillez réessayer.', 'trainer-registration'),
                'required' => __('Ce champ est obligatoire.', 'trainer-registration'),
                'loading' => __('Chargement en cours...', 'trainer-registration'),
                'search_no_results' => __('Aucun formateur trouvé pour cette recherche.', 'trainer-registration'),
                'contact_success' => __('Message envoyé avec succès !', 'trainer-registration'),
                'contact_error' => __('Erreur lors de l\'envoi du message.', 'trainer-registration')
            ),
            'settings' => array(
                'max_file_size' => 5 * 1024 * 1024, // 5MB
                'allowed_file_types' => array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif'),
                'search_delay' => 300, // Délai en ms avant recherche automatique
                'animation_duration' => 300
            )
        ));
        
        // Enqueue conditionnel des scripts spécifiques
        global $post;
        if ($post && has_shortcode($post->post_content, 'trainer_home')) {
            wp_enqueue_script('trpro-home-script');
        }
        if ($post && has_shortcode($post->post_content, 'trainer_registration_form')) {
            wp_enqueue_script('trpro-form-script');
        }
        if ($post && (has_shortcode($post->post_content, 'trainer_list') || has_shortcode($post->post_content, 'trainer_search'))) {
            wp_enqueue_script('trpro-list-script');
            wp_enqueue_script('trpro-search-script');
        }
    }
    
    public function add_custom_css_variables() {
        $primary_color = get_option('trpro_primary_color', '#6366f1');
        $secondary_color = get_option('trpro_secondary_color', '#0f172a');
        $accent_color = get_option('trpro_accent_color', '#06b6d4');
        
        echo "<style>
        :root {
            --trpro-primary-custom: {$primary_color};
            --trpro-secondary-custom: {$secondary_color};
            --trpro-accent-custom: {$accent_color};
        }
        </style>";
    }
    
    public function add_body_classes($classes) {
        global $post;
        
        if ($post) {
            if (has_shortcode($post->post_content, 'trainer_home')) {
                $classes[] = 'trpro-page-home';
            }
            if (has_shortcode($post->post_content, 'trainer_registration_form')) {
                $classes[] = 'trpro-page-registration';
            }
            if (has_shortcode($post->post_content, 'trainer_list')) {
                $classes[] = 'trpro-page-list';
            }
            if (has_shortcode($post->post_content, 'trainer_search')) {
                $classes[] = 'trpro-page-search';
            }
        }
        
        return $classes;
    }

    public function handle_registration() {
        // Vérification du nonce avec nouveau nom
        if (!wp_verify_nonce($_POST['nonce'], 'trainer_registration_nonce')) {
            wp_send_json_error(array('message' => 'Security check failed'));
        }

        global $wpdb;
        
        // Validation des données avec messages améliorés
        $errors = array();
        
        // Validation des champs obligatoires
        $required_fields = array(
            'first_name' => 'Le prénom est obligatoire',
            'last_name' => 'Le nom est obligatoire',
            'email' => 'L\'email est obligatoire',
            'phone' => 'Le téléphone est obligatoire',
            'specialties' => 'Au moins une spécialité est requise',
            'experience' => 'La description de l\'expérience est obligatoire',
            'rgpd_consent' => 'Le consentement RGPD est obligatoire'
        );
        
        foreach ($required_fields as $field => $message) {
            if (empty($_POST[$field])) {
                $errors[] = $message;
            }
        }
        
        // Validation email
        if (!empty($_POST['email']) && !is_email($_POST['email'])) {
            $errors[] = 'Format d\'email invalide';
        }
        
        // Validation expérience (minimum 50 caractères)
        if (!empty($_POST['experience']) && strlen($_POST['experience']) < 50) {
            $errors[] = 'La description de l\'expérience doit contenir au moins 50 caractères';
        }
        
        // Vérification de l'unicité de l'email
        if (!empty($_POST['email'])) {
            $table_name = $wpdb->prefix . 'trainer_registrations';
            $existing_email = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $table_name WHERE email = %s",
                sanitize_email($_POST['email'])
            ));
            
            if ($existing_email) {
                $errors[] = 'Cet email est déjà enregistré';
            }
        }
        
        // Vérification du CV
        if (empty($_FILES['cv_file']['name'])) {
            $errors[] = 'Le CV est obligatoire';
        }
        
        if (!empty($errors)) {
            wp_send_json_error(array('errors' => $errors));
        }
        
        // Gestion de l'upload des fichiers avec validation améliorée
        $cv_file = $this->handle_file_upload($_FILES['cv_file'], 'cv');
        $photo_file = '';
        
        if (!empty($_FILES['photo_file']['name'])) {
            $photo_file = $this->handle_file_upload($_FILES['photo_file'], 'photo');
            if (!$photo_file) {
                wp_send_json_error(array('message' => 'Erreur lors du téléchargement de la photo'));
            }
        }
        
        if (!$cv_file) {
            wp_send_json_error(array('message' => 'Erreur lors du téléchargement du CV'));
        }
        
        // Préparation des spécialités
        $specialties = '';
        if (is_array($_POST['specialties'])) {
            $specialties = implode(', ', array_map('sanitize_text_field', $_POST['specialties']));
        }
        
        // Insertion en base de données avec gestion d'erreur améliorée
        $table_name = $wpdb->prefix . 'trainer_registrations';
        
        $result = $wpdb->insert(
            $table_name,
            array(
                'first_name' => sanitize_text_field($_POST['first_name']),
                'last_name' => sanitize_text_field($_POST['last_name']),
                'email' => sanitize_email($_POST['email']),
                'phone' => sanitize_text_field($_POST['phone']),
                'company' => sanitize_text_field($_POST['company']),
                'specialties' => $specialties,
                'experience' => sanitize_textarea_field($_POST['experience']),
                'cv_file' => $cv_file,
                'photo_file' => $photo_file,
                'linkedin_url' => esc_url_raw($_POST['linkedin_url']),
                'bio' => sanitize_textarea_field($_POST['bio']),
                'availability' => sanitize_text_field($_POST['availability']),
                'hourly_rate' => sanitize_text_field($_POST['hourly_rate']),
                'rgpd_consent' => 1,
                'marketing_consent' => isset($_POST['marketing_consent']) ? 1 : 0,
                'status' => get_option('trainer_auto_approve', 0) ? 'approved' : 'pending'
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s')
        );
        
        if ($result) {
            $trainer_id = $wpdb->insert_id;
            
            // Envoi d'email de notification à l'admin
            $this->send_admin_notification($_POST, $trainer_id);
            
            // Envoi d'email de confirmation au formateur
            $this->send_trainer_confirmation($_POST);
            
            // Log de l'inscription pour audit
            $this->log_registration($trainer_id, $_POST);
            
            wp_send_json_success(array(
                'message' => 'Inscription réussie ! Nous examinerons votre candidature et vous contacterons sous 48h.',
                'trainer_id' => $trainer_id
            ));
        } else {
            // Log de l'erreur
            error_log('Erreur insertion trainer registration: ' . $wpdb->last_error);
            wp_send_json_error(array('message' => 'Erreur lors de l\'enregistrement. Veuillez réessayer.'));
        }
    }

    private function handle_file_upload($file, $type) {
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        
        // Configuration d'upload plus stricte
        $upload_overrides = array(
            'test_form' => false,
            'mimes' => array()
        );
        
        // Définir les types de fichiers autorisés avec MIME types
        if ($type === 'cv') {
            $allowed_types = array('pdf', 'doc', 'docx');
            $upload_overrides['mimes'] = array(
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            );
            $max_size = 5 * 1024 * 1024; // 5MB
        } else {
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $upload_overrides['mimes'] = array(
                'jpg|jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif'
            );
            $max_size = 2 * 1024 * 1024; // 2MB
        }
        
        // Vérification de la taille
        if ($file['size'] > $max_size) {
            return false;
        }
        
        // Vérification de l'extension
        $file_info = pathinfo($file['name']);
        if (!in_array(strtolower($file_info['extension']), $allowed_types)) {
            return false;
        }
        
        // Générer un nom de fichier sécurisé et unique
        $timestamp = time();
        $random = wp_generate_password(8, false);
        $file['name'] = $type . '_' . $timestamp . '_' . $random . '.' . $file_info['extension'];
        
        $movefile = wp_handle_upload($file, $upload_overrides);
        
        if ($movefile && !isset($movefile['error'])) {
            return 'trainer-files/' . basename($movefile['file']);
        }
        
        return false;
    }

    private function send_admin_notification($data, $trainer_id) {
        $admin_email = get_option('trainer_notification_email', get_option('admin_email'));
        $subject = 'Nouvelle inscription formateur - ' . $data['first_name'] . ' ' . $data['last_name'];
        
        $specialties = is_array($data['specialties']) ? implode(', ', $data['specialties']) : $data['specialties'];
        
        $message = "Nouvelle inscription de formateur :\n\n";
        $message .= "ID: #" . str_pad($trainer_id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "Nom : " . $data['first_name'] . " " . $data['last_name'] . "\n";
        $message .= "Email : " . $data['email'] . "\n";
        $message .= "Téléphone : " . $data['phone'] . "\n";
        $message .= "Entreprise : " . (!empty($data['company']) ? $data['company'] : 'Non renseignée') . "\n";
        $message .= "Spécialités : " . $specialties . "\n";
        $message .= "Disponibilité : " . (!empty($data['availability']) ? $data['availability'] : 'Non renseignée') . "\n\n";
        $message .= "Connectez-vous à l'administration pour voir les détails complets et approuver cette inscription.\n";
        $message .= admin_url('admin.php?page=trainer-registration&action=view&trainer_id=' . $trainer_id);
        
        wp_mail($admin_email, $subject, $message);
    }
    
    private function send_trainer_confirmation($data) {
        $subject = 'Confirmation de votre inscription - Plateforme Formateurs IT';
        
        $message = "Bonjour " . $data['first_name'] . ",\n\n";
        $message .= "Nous avons bien reçu votre inscription sur notre plateforme de formateurs IT.\n\n";
        $message .= "Votre candidature est actuellement en cours d'examen par notre équipe.\n";
        $message .= "Nous vous contacterons sous 48h pour vous informer de la suite.\n\n";
        $message .= "En attendant, vous pouvez nous contacter si vous avez des questions :\n";
        $message .= "Email : " . get_option('trainer_contact_email', get_option('admin_email')) . "\n";
        
        if (get_option('trainer_contact_phone')) {
            $message .= "Téléphone : " . get_option('trainer_contact_phone') . "\n";
        }
        
        $message .= "\nCordialement,\nL'équipe Formateurs IT";
        
        wp_mail($data['email'], $subject, $message);
    }
    
    private function log_registration($trainer_id, $data) {
        // Log simple pour audit
        $log_entry = array(
            'timestamp' => current_time('mysql'),
            'trainer_id' => $trainer_id,
            'email' => $data['email'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        );
        
        update_option('trpro_last_registration_log', $log_entry);
    }

    public function handle_trainer_search() {
        if (!wp_verify_nonce($_POST['nonce'], 'trainer_registration_nonce')) {
            wp_send_json_error(array('message' => 'Security check failed'));
        }
        
        global $wpdb;
        
        $search_term = sanitize_text_field($_POST['search_term']);
        $specialty_filter = sanitize_text_field($_POST['specialty_filter']);
        
        $table_name = $wpdb->prefix . 'trainer_registrations';
        
        $where_clause = "WHERE status = 'approved'";
        $params = array();
        
        if (!empty($search_term)) {
            $where_clause .= " AND (specialties LIKE %s OR bio LIKE %s OR experience LIKE %s OR company LIKE %s)";
            $search_param = '%' . $search_term . '%';
            $params[] = $search_param;
            $params[] = $search_param;
            $params[] = $search_param;
            $params[] = $search_param;
        }
        
        if (!empty($specialty_filter) && $specialty_filter !== 'all') {
            $where_clause .= " AND specialties LIKE %s";
            $params[] = '%' . $specialty_filter . '%';
        }
        
        $query = "SELECT * FROM $table_name $where_clause ORDER BY created_at DESC LIMIT 20";
        
        if (!empty($params)) {
            $query = $wpdb->prepare($query, $params);
        }
        
        $trainers = $wpdb->get_results($query);
        
        ob_start();
        if (!empty($trainers)) {
            echo '<div class="trpro-trainers-grid">';
            foreach ($trainers as $trainer) {
                include TRAINER_REGISTRATION_PLUGIN_PATH . 'public/partials/trainer-card.php';
            }
            echo '</div>';
        }
        $html = ob_get_clean();
        
        wp_send_json_success(array(
            'html' => $html,
            'count' => count($trainers),
            'search_term' => $search_term,
            'specialty_filter' => $specialty_filter
        ));
    }
    
    public function handle_trainer_contact() {
        if (!wp_verify_nonce($_POST['contact_nonce'], 'trainer_contact_nonce')) {
            wp_send_json_error(array('message' => 'Security check failed'));
        }
        
        // Validation des données
        $errors = array();
        
        if (empty($_POST['contact_name'])) $errors[] = 'Le nom est obligatoire';
        if (empty($_POST['contact_email']) || !is_email($_POST['contact_email'])) $errors[] = 'Email valide requis';
        if (empty($_POST['contact_message'])) $errors[] = 'Le message est obligatoire';
        if (empty($_POST['trainer_id'])) $errors[] = 'ID formateur manquant';
        
        if (!empty($errors)) {
            wp_send_json_error(array('errors' => $errors));
        }
        
        // Récupérer les infos du formateur
        global $wpdb;
        $table_name = $wpdb->prefix . 'trainer_registrations';
        $trainer = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d AND status = 'approved'",
            intval($_POST['trainer_id'])
        ));
        
        if (!$trainer) {
            wp_send_json_error(array('message' => 'Formateur non trouvé'));
        }
        
        // Envoyer l'email de contact
        $contact_email = get_option('trainer_contact_email', get_option('admin_email'));
        $subject = 'Demande de contact pour le formateur #' . str_pad($trainer->id, 4, '0', STR_PAD_LEFT);
        
        $message = "Nouvelle demande de contact :\n\n";
        $message .= "Formateur concerné : #" . str_pad($trainer->id, 4, '0', STR_PAD_LEFT) . "\n";
        $message .= "Spécialités : " . $trainer->specialties . "\n\n";
        $message .= "--- Demandeur ---\n";
        $message .= "Nom : " . sanitize_text_field($_POST['contact_name']) . "\n";
        $message .= "Email : " . sanitize_email($_POST['contact_email']) . "\n";
        $message .= "Entreprise : " . sanitize_text_field($_POST['contact_company']) . "\n\n";
        $message .= "--- Message ---\n";
        $message .= sanitize_textarea_field($_POST['contact_message']) . "\n\n";
        $message .= "Répondez directement à cet email pour mettre en relation.";
        
        $headers = array(
            'Reply-To: ' . sanitize_email($_POST['contact_email'])
        );
        
        if (wp_mail($contact_email, $subject, $message, $headers)) {
            wp_send_json_success(array('message' => 'Votre message a été envoyé avec succès !'));
        } else {
            wp_send_json_error(array('message' => 'Erreur lors de l\'envoi du message'));
        }
    }
}