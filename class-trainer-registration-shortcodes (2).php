<?php
/**
 * Classe pour gérer les shortcodes du plugin - NOUVELLE STRUCTURE
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/includes/class-trainer-registration-shortcodes.php
 */

if (!defined('ABSPATH')) {
    exit;
}

class TrainerRegistrationShortcodes {

    public function __construct() {
        add_shortcode('trainer_home', array($this, 'display_home_page'));
        add_shortcode('trainer_registration_form', array($this, 'display_registration_form'));
        add_shortcode('trainer_list', array($this, 'display_trainer_list'));
        add_shortcode('trainer_search', array($this, 'display_trainer_search'));
    }

    /**
     * Shortcode pour la page d'accueil
     * Usage: [trainer_home]
     */
    public function display_home_page($atts) {
        $atts = shortcode_atts(array(
            'title' => 'Plateforme de Formateurs IT Excellence',
            'subtitle' => 'Connectons les talents IT avec les entreprises d\'exception',
            'description' => 'Découvrez notre réseau exclusif de formateurs experts en informatique, administration système, cloud, DevOps, sécurité et télécommunications. Une plateforme moderne et sécurisée pour connecter l\'excellence.'
        ), $atts);

        // Enqueue les styles et scripts spécifiques si nécessaire
        wp_enqueue_style('trpro-home-style');
        wp_enqueue_script('trpro-home-script');

        ob_start();
        include TRAINER_REGISTRATION_PLUGIN_PATH . 'public/partials/trainer-home.php';
        return ob_get_clean();
    }

    /**
     * Shortcode pour le formulaire d'inscription
     * Usage: [trainer_registration_form]
     */
    public function display_registration_form($atts) {
        $atts = shortcode_atts(array(
            'show_header' => 'true',
            'redirect_success' => '',
            'form_id' => 'trpro-registration-form'
        ), $atts);

        // Enqueue les styles et scripts pour le formulaire
        wp_enqueue_style('trpro-form-style');
        wp_enqueue_script('trpro-form-script');

        ob_start();
        include TRAINER_REGISTRATION_PLUGIN_PATH . 'public/partials/trainer-registration-form.php';
        return ob_get_clean();
    }

    /**
     * Shortcode pour la liste des formateurs
     * Usage: [trainer_list per_page="12" show_search="true"]
     */
    public function display_trainer_list($atts) {
        global $wpdb;
        
        $atts = shortcode_atts(array(
            'per_page' => 12,
            'show_search' => 'true',
            'show_filters' => 'true',
            'view_mode' => 'grid',
            'show_pagination' => 'true'
        ), $atts);

        $table_name = $wpdb->prefix . 'trainer_registrations';
        
        // Gestion de la pagination
        $page = get_query_var('paged') ? get_query_var('paged') : 1;
        $offset = ($page - 1) * $atts['per_page'];
        
        // Gestion des filtres
        $where_conditions = array("status = 'approved'");
        $params = array();
        
        // Filtre par spécialité si fourni dans l'URL
        if (isset($_GET['specialty']) && !empty($_GET['specialty'])) {
            $specialty = sanitize_text_field($_GET['specialty']);
            $where_conditions[] = 'specialties LIKE %s';
            $params[] = '%' . $specialty . '%';
        }
        
        // Filtre de recherche si fourni dans l'URL
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = sanitize_text_field($_GET['search']);
            $where_conditions[] = '(specialties LIKE %s OR bio LIKE %s OR experience LIKE %s)';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }
        
        $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
        
        // Récupérer le nombre total de formateurs
        $count_query = "SELECT COUNT(*) FROM $table_name $where_clause";
        if (!empty($params)) {
            $count_query = $wpdb->prepare($count_query, $params);
        }
        $total_trainers = $wpdb->get_var($count_query);
        
        // Récupérer les formateurs pour la page actuelle
        $trainers_query = "SELECT * FROM $table_name $where_clause ORDER BY created_at DESC LIMIT %d OFFSET %d";
        $final_params = array_merge($params, array($atts['per_page'], $offset));
        $trainers_query = $wpdb->prepare($trainers_query, $final_params);
        $trainers = $wpdb->get_results($trainers_query);

        // Enqueue les styles et scripts pour la liste
        wp_enqueue_style('trpro-list-style');
        wp_enqueue_script('trpro-list-script');

        ob_start();
        include TRAINER_REGISTRATION_PLUGIN_PATH . 'public/partials/trainer-list.php';
        return ob_get_clean();
    }

    /**
     * Shortcode pour la recherche de formateurs
     * Usage: [trainer_search]
     */
    public function display_trainer_search($atts) {
        $atts = shortcode_atts(array(
            'show_suggestions' => 'true',
            'max_results' => 20,
            'show_filters' => 'true',
            'placeholder' => 'Rechercher par compétence, technologie, certification...'
        ), $atts);

        // Enqueue les styles et scripts pour la recherche
        wp_enqueue_style('trpro-search-style');
        wp_enqueue_script('trpro-search-script');

        ob_start();
        include TRAINER_REGISTRATION_PLUGIN_PATH . 'public/partials/trainer-search.php';
        return ob_get_clean();
    }

    /**
     * Shortcode pour afficher un formateur spécifique
     * Usage: [trainer_profile id="123"]
     */
    public function display_trainer_profile($atts) {
        global $wpdb;
        
        $atts = shortcode_atts(array(
            'id' => 0,
            'show_contact' => 'true',
            'show_bio' => 'true',
            'show_experience' => 'true'
        ), $atts);

        if (empty($atts['id'])) {
            return '<div class="trpro-error">ID de formateur requis</div>';
        }

        $table_name = $wpdb->prefix . 'trainer_registrations';
        $trainer = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d AND status = 'approved'",
            $atts['id']
        ));

        if (!$trainer) {
            return '<div class="trpro-error">Formateur non trouvé ou non approuvé</div>';
        }

        ob_start();
        include TRAINER_REGISTRATION_PLUGIN_PATH . 'public/partials/trainer-profile.php';
        return ob_get_clean();
    }

    /**
     * Shortcode pour afficher les statistiques
     * Usage: [trainer_stats]
     */
    public function display_trainer_stats($atts) {
        global $wpdb;
        
        $atts = shortcode_atts(array(
            'show_total' => 'true',
            'show_specialties' => 'true',
            'show_chart' => 'false',
            'style' => 'cards'
        ), $atts);

        $table_name = $wpdb->prefix . 'trainer_registrations';
        
        // Récupérer les statistiques
        $stats = array(
            'total' => $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'approved'"),
            'pending' => $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'pending'"),
            'specialties' => $wpdb->get_var("SELECT COUNT(DISTINCT specialties) FROM $table_name WHERE status = 'approved'"),
            'this_month' => $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'approved' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())")
        );

        ob_start();
        ?>
        <div class="trpro-stats-container">
            <?php if ($atts['style'] === 'cards'): ?>
                <div class="trpro-stats-grid">
                    <?php if ($atts['show_total'] === 'true'): ?>
                        <div class="trpro-stat-card">
                            <div class="trpro-stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="trpro-stat-content">
                                <div class="trpro-stat-number"><?php echo $stats['total']; ?></div>
                                <div class="trpro-stat-label">Formateurs Actifs</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($atts['show_specialties'] === 'true'): ?>
                        <div class="trpro-stat-card">
                            <div class="trpro-stat-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="trpro-stat-content">
                                <div class="trpro-stat-number"><?php echo $stats['specialties']; ?></div>
                                <div class="trpro-stat-label">Spécialités Couvertes</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="trpro-stat-card">
                        <div class="trpro-stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="trpro-stat-content">
                            <div class="trpro-stat-number"><?php echo $stats['this_month']; ?></div>
                            <div class="trpro-stat-label">Nouveaux ce Mois</div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Style ligne -->
                <div class="trpro-stats-inline">
                    <span class="trpro-stat-item">
                        <strong><?php echo $stats['total']; ?></strong> formateurs actifs
                    </span>
                    <span class="trpro-stat-separator">•</span>
                    <span class="trpro-stat-item">
                        <strong><?php echo $stats['specialties']; ?></strong> spécialités
                    </span>
                    <span class="trpro-stat-separator">•</span>
                    <span class="trpro-stat-item">
                        <strong><?php echo $stats['this_month']; ?></strong> nouveaux ce mois
                    </span>
                </div>
            <?php endif; ?>
        </div>
        
        <style>
        .trpro-stats-container {
            margin: 20px 0;
        }
        
        .trpro-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .trpro-stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px;
            background: white;
            border: 1px solid var(--trpro-border);
            border-radius: var(--trpro-radius);
            box-shadow: var(--trpro-shadow-sm);
            transition: var(--trpro-transition);
        }
        
        .trpro-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--trpro-shadow);
        }
        
        .trpro-stat-icon {
            width: 50px;
            height: 50px;
            background: var(--trpro-gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .trpro-stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--trpro-text-primary);
            line-height: 1;
        }
        
        .trpro-stat-label {
            color: var(--trpro-text-secondary);
            font-weight: 500;
            margin-top: 4px;
        }
        
        .trpro-stats-inline {
            display: flex;
            align-items: center;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            padding: 20px;
            background: var(--trpro-bg-secondary);
            border-radius: var(--trpro-radius);
            border: 1px solid var(--trpro-border);
        }
        
        .trpro-stat-item {
            color: var(--trpro-text-secondary);
        }
        
        .trpro-stat-item strong {
            color: var(--trpro-primary);
            font-size: 1.2rem;
        }
        
        .trpro-stat-separator {
            color: var(--trpro-text-light);
        }
        
        @media (max-width: 768px) {
            .trpro-stats-grid {
                grid-template-columns: 1fr;
            }
            
            .trpro-stats-inline {
                flex-direction: column;
                gap: 8px;
            }
            
            .trpro-stat-separator {
                display: none;
            }
        }
        </style>
        <?php
        return ob_get_clean();
    }

    /**
     * Shortcode pour le formulaire de contact rapide
     * Usage: [trainer_contact_form trainer_id="123"]
     */
    public function display_contact_form($atts) {
        $atts = shortcode_atts(array(
            'trainer_id' => 0,
            'show_trainer_info' => 'true',
            'redirect_success' => ''
        ), $atts);

        if (empty($atts['trainer_id'])) {
            return '<div class="trpro-error">ID de formateur requis</div>';
        }

        ob_start();
        ?>
        <div class="trpro-contact-form-container">
            <form id="trpro-contact-form" class="trpro-contact-form" data-trainer-id="<?php echo esc_attr($atts['trainer_id']); ?>">
                <h3>Contacter ce formateur</h3>
                
                <div class="trpro-form-group">
                    <label for="contact-name">Votre nom *</label>
                    <input type="text" id="contact-name" name="contact_name" required>
                </div>
                
                <div class="trpro-form-group">
                    <label for="contact-email">Votre email *</label>
                    <input type="email" id="contact-email" name="contact_email" required>
                </div>
                
                <div class="trpro-form-group">
                    <label for="contact-company">Entreprise</label>
                    <input type="text" id="contact-company" name="contact_company">
                </div>
                
                <div class="trpro-form-group">
                    <label for="contact-message">Message *</label>
                    <textarea id="contact-message" name="contact_message" rows="5" required placeholder="Décrivez votre projet de formation, vos besoins, dates souhaitées..."></textarea>
                </div>
                
                <button type="submit" class="trpro-btn trpro-btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer le message
                </button>
                
                <?php wp_nonce_field('trainer_contact_nonce', 'contact_nonce'); ?>
            </form>
        </div>
        
        <style>
        .trpro-contact-form-container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .trpro-contact-form {
            background: white;
            padding: 32px;
            border-radius: var(--trpro-radius);
            border: 1px solid var(--trpro-border);
            box-shadow: var(--trpro-shadow);
        }
        
        .trpro-contact-form h3 {
            color: var(--trpro-text-primary);
            margin-bottom: 24px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
        }
        </style>
        <?php
        return ob_get_clean();
    }
}