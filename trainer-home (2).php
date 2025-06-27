<?php
/**
 * Template pour la page d'accueil du plugin - NOUVELLE STRUCTURE
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/public/partials/trainer-home.php
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="trpro-container" id="trpro-home">
    <!-- Hero Section avec titre dégradé -->
    <section class="trpro-hero-section">
        <div class="trpro-wrapper">
            <div class="trpro-hero-content">
                <div class="trpro-hero-text">
                    <h1 class="trpro-hero-title">
                        <?php echo esc_html($atts['title']); ?>
                    </h1>
                    <p class="trpro-hero-subtitle"><?php echo esc_html($atts['subtitle']); ?></p>
                    <p class="trpro-hero-description"><?php echo esc_html($atts['description']); ?></p>
                    
                    <div class="trpro-hero-actions">
                        <a href="/inscription-formateur" class="trpro-btn trpro-btn-primary trpro-btn-large">
                            <i class="fas fa-user-plus"></i>
                            Devenir Formateur
                        </a>
                        <a href="/trouver-formateur" class="trpro-btn trpro-btn-secondary trpro-btn-large">
                            <i class="fas fa-search"></i>
                            Trouver un Formateur
                        </a>
                    </div>
                </div>
                
                <div class="trpro-hero-illustration">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Specialties Section -->
    <section class="trpro-section" id="trpro-specialties">
        <div class="trpro-wrapper">
            <h2 class="trpro-section-title">Nos Domaines d'Expertise</h2>
            <p class="trpro-section-subtitle">
                Des formateurs experts dans tous les domaines de l'informatique et des télécommunications
            </p>
            
            <div class="trpro-grid trpro-grid-3">
                <div class="trpro-specialty-card">
                    <div class="trpro-specialty-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3>Administration Système</h3>
                    <p>Linux, Windows Server, virtualisation, monitoring et automatisation des infrastructures</p>
                </div>
                
                <div class="trpro-specialty-card">
                    <div class="trpro-specialty-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Réseaux & Infrastructure</h3>
                    <p>Cisco, configuration réseau, sécurité réseau, protocoles TCP/IP et architectures complexes</p>
                </div>
                
                <div class="trpro-specialty-card">
                    <div class="trpro-specialty-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3>Cloud Computing</h3>
                    <p>AWS, Azure, Google Cloud, architecture cloud native, migration et optimisation</p>
                </div>
                
                <div class="trpro-specialty-card">
                    <div class="trpro-specialty-icon">
                        <i class="fas fa-infinity"></i>
                    </div>
                    <h3>DevOps & CI/CD</h3>
                    <p>Docker, Kubernetes, Jenkins, GitLab, automatisation des déploiements et monitoring</p>
                </div>
                
                <div class="trpro-specialty-card">
                    <div class="trpro-specialty-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Sécurité Informatique</h3>
                    <p>Cybersécurité, tests de pénétration, conformité RGPD, audit sécurité et forensic</p>
                </div>
                
                <div class="trpro-specialty-card">
                    <div class="trpro-specialty-icon">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <h3>Télécommunications</h3>
                    <p>VoIP, réseaux télécoms, fibre optique, technologies 5G et solutions IoT</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="trpro-section" id="trpro-features" style="background: var(--trpro-bg-secondary);">
        <div class="trpro-wrapper">
            <div class="trpro-grid trpro-grid-2">
                <div class="trpro-card trpro-feature-trainer">
                    <div class="trpro-card-header">
                        <div class="trpro-specialty-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="trpro-card-title">Pour les Formateurs</h3>
                    </div>
                    <div class="trpro-card-content">
                        <ul class="trpro-feature-list">
                            <li><i class="fas fa-check"></i> Inscription gratuite et simple</li>
                            <li><i class="fas fa-check"></i> Profil professionnel détaillé</li>
                            <li><i class="fas fa-check"></i> Visibilité auprès des recruteurs</li>
                            <li><i class="fas fa-check"></i> Gestion sécurisée des données RGPD</li>
                            <li><i class="fas fa-check"></i> Support dédié 24/7</li>
                        </ul>
                        <a href="/inscription-formateur" class="trpro-btn trpro-btn-primary">
                            <i class="fas fa-arrow-right"></i>
                            S'inscrire maintenant
                        </a>
                    </div>
                </div>
                
                <div class="trpro-card trpro-feature-recruiter">
                    <div class="trpro-card-header">
                        <div class="trpro-specialty-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="trpro-card-title">Pour les Recruteurs</h3>
                    </div>
                    <div class="trpro-card-content">
                        <ul class="trpro-feature-list">
                            <li><i class="fas fa-check"></i> Base de données qualifiée</li>
                            <li><i class="fas fa-check"></i> Recherche par compétences avancée</li>
                            <li><i class="fas fa-check"></i> Profils vérifiés et certifiés</li>
                            <li><i class="fas fa-check"></i> Contact direct et sécurisé</li>
                            <li><i class="fas fa-check"></i> Accès prioritaire aux talents</li>
                        </ul>
                        <a href="/catalogue-formateurs" class="trpro-btn trpro-btn-outline">
                            <i class="fas fa-arrow-right"></i>
                            Chercher des formateurs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="trpro-stats-section" id="trpro-stats">
        <div class="trpro-wrapper">
            <div class="trpro-stats-grid">
                <?php
                global $wpdb;
                $table_name = $wpdb->prefix . 'trainer_registrations';
                $total_trainers = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'approved'");
                ?>
                
                <div class="trpro-stat-item">
                    <div class="trpro-stat-number"><?php echo $total_trainers ?: '50+'; ?></div>
                    <div class="trpro-stat-label">Formateurs Certifiés</div>
                </div>
                
                <div class="trpro-stat-item">
                    <div class="trpro-stat-number">6+</div>
                    <div class="trpro-stat-label">Domaines d'Expertise</div>
                </div>
                
                <div class="trpro-stat-item">
                    <div class="trpro-stat-number">100%</div>
                    <div class="trpro-stat-label">Profils Vérifiés</div>
                </div>
                
                <div class="trpro-stat-item">
                    <div class="trpro-stat-number">24h</div>
                    <div class="trpro-stat-label">Temps de Réponse</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="trpro-cta-section" id="trpro-cta">
        <div class="trpro-wrapper">
            <div class="trpro-cta-content">
                <h2>Prêt à rejoindre notre réseau d'excellence ?</h2>
                <p>Que vous soyez formateur expert ou recruteur à la recherche de talents, notre plateforme vous connecte avec les bons profils en toute sécurité.</p>
                
                <div class="trpro-cta-buttons">
                    <a href="/inscription-formateur" class="trpro-btn trpro-btn-primary trpro-btn-large">
                        <i class="fas fa-user-plus"></i>
                        Inscription Formateur
                    </a>
                    <a href="/contact-recruteur" class="trpro-btn trpro-btn-secondary trpro-btn-large">
                        <i class="fas fa-handshake"></i>
                        Accès Recruteur
                    </a>
                </div>
                
                <div class="trpro-contact-info">
                    <?php
                    $contact_email = get_option('trainer_contact_email', get_option('admin_email'));
                    $contact_phone = get_option('trainer_contact_phone', '');
                    ?>
                    <?php if ($contact_email): ?>
                        <div class="trpro-contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ($contact_phone): ?>
                        <div class="trpro-contact-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="trpro-trust-section" id="trpro-trust">
        <div class="trpro-wrapper">
            <div class="trpro-trust-badges">
                <div class="trpro-trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Données Sécurisées</span>
                </div>
                <div class="trpro-trust-item">
                    <i class="fas fa-user-check"></i>
                    <span>Conforme RGPD</span>
                </div>
                <div class="trpro-trust-item">
                    <i class="fas fa-certificate"></i>
                    <span>Profils Certifiés</span>
                </div>
                <div class="trpro-trust-item">
                    <i class="fas fa-headset"></i>
                    <span>Support 24/7</span>
                </div>
                <div class="trpro-trust-item">
                    <i class="fas fa-award"></i>
                    <span>Qualité Garantie</span>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Styles spécifiques pour la page d'accueil */
.trpro-feature-list {
    list-style: none;
    margin: 0 0 32px 0;
    padding: 0;
}

.trpro-feature-list li {
    padding: 12px 0;
    color: var(--trpro-text-secondary);
    position: relative;
    padding-left: 32px;
    display: flex;
    align-items: center;
    font-weight: 500;
}

.trpro-feature-list li i {
    position: absolute;
    left: 0;
    color: var(--trpro-success);
    font-weight: 600;
    width: 20px;
    height: 20px;
    background: rgba(16, 185, 129, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.trpro-contact-info {
    display: flex;
    justify-content: center;
    gap: 32px;
    flex-wrap: wrap;
    margin-top: 40px;
}

.trpro-contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    background: white;
    padding: 16px 24px;
    border-radius: var(--trpro-radius-xl);
    border: 1px solid var(--trpro-border);
    box-shadow: var(--trpro-shadow-sm);
    transition: var(--trpro-transition);
}

.trpro-contact-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--trpro-shadow);
}

.trpro-contact-item i {
    color: var(--trpro-primary);
    font-size: 1.1rem;
}

.trpro-contact-item a {
    color: var(--trpro-text-secondary);
    text-decoration: none;
    font-weight: 500;
}

.trpro-contact-item a:hover {
    color: var(--trpro-primary);
}

.trpro-trust-section {
    padding: 60px 0;
    background: white;
    border-top: 1px solid var(--trpro-border-light);
}

.trpro-trust-badges {
    display: flex;
    justify-content: center;
    gap: 48px;
    flex-wrap: wrap;
}

.trpro-trust-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--trpro-text-tertiary);
    font-weight: 600;
    transition: var(--trpro-transition);
}

.trpro-trust-item:hover {
    color: var(--trpro-primary);
    transform: translateY(-2px);
}

.trpro-trust-item i {
    font-size: 1.2rem;
    color: var(--trpro-success);
    width: 32px;
    height: 32px;
    background: rgba(16, 185, 129, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.trpro-feature-trainer:hover {
    border-color: var(--trpro-success);
}

.trpro-feature-recruiter:hover {
    border-color: var(--trpro-accent);
}

@media (max-width: 768px) {
    .trpro-contact-info {
        flex-direction: column;
        gap: 16px;
        align-items: center;
    }
    
    .trpro-trust-badges {
        gap: 24px;
        flex-direction: column;
        align-items: center;
    }
}
</style>