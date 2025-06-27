<?php
/**
 * Template pour afficher la liste des formateurs - NOUVELLE STRUCTURE
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/public/partials/trainer-list.php
 * Variables disponibles: $trainers, $total_trainers, $atts
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="trpro-list-container" id="trpro-trainer-list">
    <div class="trpro-list-header">
        <h2 class="trpro-section-title">
            Nos Formateurs Experts
        </h2>
        <p class="trpro-section-subtitle">Découvrez notre réseau de formateurs certifiés en informatique et télécommunications</p>
        
        <div class="trpro-list-stats">
            <div class="trpro-stat-item">
                <span class="trpro-stat-number"><?php echo $total_trainers; ?></span>
                <span class="trpro-stat-label">Formateurs Disponibles</span>
            </div>
        </div>
    </div>

    <?php if ($atts['show_search'] === 'true'): ?>
        <!-- Section de recherche -->
        <div class="trpro-search-section">
            <?php echo do_shortcode('[trainer_search]'); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($trainers)): ?>
        <!-- Filtres rapides -->
        <div class="trpro-quick-filters">
            <h3>Filtres rapides</h3>
            <div class="trpro-filter-buttons">
                <button class="trpro-filter-btn active" data-filter="all">
                    <i class="fas fa-globe"></i>
                    Tous les domaines
                </button>
                <button class="trpro-filter-btn" data-filter="administration-systeme">
                    <i class="fas fa-server"></i>
                    Administration Système
                </button>
                <button class="trpro-filter-btn" data-filter="cloud">
                    <i class="fas fa-cloud"></i>
                    Cloud Computing
                </button>
                <button class="trpro-filter-btn" data-filter="devops">
                    <i class="fas fa-infinity"></i>
                    DevOps
                </button>
                <button class="trpro-filter-btn" data-filter="securite">
                    <i class="fas fa-shield-alt"></i>
                    Sécurité IT
                </button>
                <button class="trpro-filter-btn" data-filter="reseaux">
                    <i class="fas fa-network-wired"></i>
                    Réseaux
                </button>
            </div>
        </div>

        <!-- Options d'affichage -->
        <div class="trpro-display-options">
            <div class="trpro-view-controls">
                <label>
                    <i class="fas fa-eye"></i>
                    Affichage :
                </label>
                <button class="trpro-view-btn active" data-view="grid" title="Vue grille">
                    <i class="fas fa-th"></i>
                </button>
                <button class="trpro-view-btn" data-view="list" title="Vue liste">
                    <i class="fas fa-list"></i>
                </button>
            </div>
            
            <div class="trpro-sort-controls">
                <label for="trpro-sort-select">
                    <i class="fas fa-sort"></i>
                    Trier par :
                </label>
                <select id="trpro-sort-select">
                    <option value="recent">Plus récents</option>
                    <option value="alphabetical">Ordre alphabétique</option>
                    <option value="specialties">Par spécialité</option>
                    <option value="availability">Par disponibilité</option>
                </select>
            </div>
        </div>

        <!-- Grille des formateurs -->
        <div class="trpro-trainers-container">
            <div class="trpro-trainers-grid trpro-view-grid" id="trpro-trainers-grid">
                <?php foreach ($trainers as $trainer): ?>
                    <?php include TRAINER_REGISTRATION_PLUGIN_PATH . 'public/partials/trainer-card.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php
        $total_pages = ceil($total_trainers / $atts['per_page']);
        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
        
        if ($total_pages > 1):
        ?>
            <div class="trpro-pagination-container">
                <nav class="trpro-pagination" aria-label="Navigation des formateurs">
                    <?php
                    // Lien précédent
                    if ($current_page > 1):
                        $prev_link = get_pagenum_link($current_page - 1);
                    ?>
                        <a href="<?php echo esc_url($prev_link); ?>" class="trpro-pagination-link trpro-prev">
                            <i class="fas fa-chevron-left"></i>
                            Précédent
                        </a>
                    <?php endif; ?>

                    <?php
                    // Liens des pages
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);
                    
                    // Première page
                    if ($start_page > 1):
                    ?>
                        <a href="<?php echo esc_url(get_pagenum_link(1)); ?>" class="trpro-pagination-link">1</a>
                        <?php if ($start_page > 2): ?>
                            <span class="trpro-pagination-ellipsis">...</span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <span class="trpro-pagination-link trpro-current" aria-current="page"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo esc_url(get_pagenum_link($i)); ?>" class="trpro-pagination-link"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php
                    // Dernière page
                    if ($end_page < $total_pages):
                        if ($end_page < $total_pages - 1):
                    ?>
                            <span class="trpro-pagination-ellipsis">...</span>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(get_pagenum_link($total_pages)); ?>" class="trpro-pagination-link"><?php echo $total_pages; ?></a>
                    <?php endif; ?>

                    <?php
                    // Lien suivant
                    if ($current_page < $total_pages):
                        $next_link = get_pagenum_link($current_page + 1);
                    ?>
                        <a href="<?php echo esc_url($next_link); ?>" class="trpro-pagination-link trpro-next">
                            Suivant
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </nav>
                
                <div class="trpro-pagination-info">
                    <span>
                        Page <?php echo $current_page; ?> sur <?php echo $total_pages; ?> 
                        (<?php echo $total_trainers; ?> formateur<?php echo $total_trainers > 1 ? 's' : ''; ?> au total)
                    </span>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- État vide -->
        <div class="trpro-empty-state">
            <div class="trpro-empty-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h3>Aucun formateur disponible</h3>
            <p>Nous travaillons à enrichir notre réseau de formateurs experts. Revenez bientôt pour découvrir nos nouveaux talents !</p>
            <div class="trpro-empty-actions">
                <a href="/inscription-formateur" class="trpro-btn trpro-btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Devenir formateur
                </a>
                <a href="mailto:<?php echo get_option('trainer_contact_email', get_option('admin_email')); ?>" class="trpro-btn trpro-btn-secondary">
                    <i class="fas fa-envelope"></i>
                    Nous contacter
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Section d'appel à l'action -->
    <div class="trpro-list-cta">
        <div class="trpro-cta-content">
            <div class="trpro-cta-text">
                <h3>
                    <i class="fas fa-handshake"></i>
                    Vous êtes recruteur ?
                </h3>
                <p>Contactez-nous pour accéder à des profils détaillés et organiser des entretiens avec nos formateurs experts. Service personnalisé et confidentiel.</p>
            </div>
            <div class="trpro-cta-actions">
                <a href="mailto:<?php echo get_option('trainer_contact_email', get_option('admin_email')); ?>?subject=Demande d'accès recruteur&body=Bonjour,%0D%0A%0D%0AJe souhaite obtenir un accès recruteur pour consulter les profils détaillés de vos formateurs.%0D%0A%0D%0ACordialement" 
                   class="trpro-btn trpro-btn-primary">
                    <i class="fas fa-envelope"></i>
                    Accès Recruteur
                </a>
                <?php if (get_option('trainer_contact_phone')): ?>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', get_option('trainer_contact_phone'))); ?>" 
                       class="trpro-btn trpro-btn-secondary">
                        <i class="fas fa-phone"></i>
                        <?php echo esc_html(get_option('trainer_contact_phone')); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles spécifiques pour la liste des formateurs */
.trpro-list-header {
    text-align: center;
    margin-bottom: 64px;
    padding: 48px 0;
    background: var(--trpro-gradient-secondary);
    border-radius: var(--trpro-radius);
    border: 1px solid var(--trpro-border);
}

.trpro-list-stats {
    display: flex;
    justify-content: center;
    margin-top: 32px;
}

.trpro-list-stats .trpro-stat-item {
    text-align: center;
    padding: 24px 48px;
    background: white;
    border-radius: var(--trpro-radius);
    box-shadow: var(--trpro-shadow-md);
    border: 1px solid var(--trpro-border);
}

.trpro-list-stats .trpro-stat-number {
    display: block;
    font-size: 3rem;
    font-weight: 800;
    background: var(--trpro-gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
}

.trpro-list-stats .trpro-stat-label {
    color: var(--trpro-text-secondary);
    font-weight: 600;
    font-size: 1.1rem;
}

.trpro-search-section {
    margin-bottom: 48px;
}

.trpro-quick-filters {
    background: white;
    padding: 32px;
    border-radius: var(--trpro-radius);
    box-shadow: var(--trpro-shadow);
    margin-bottom: 32px;
    border: 1px solid var(--trpro-border);
}

.trpro-quick-filters h3 {
    font-size: 1.5rem;
    color: var(--trpro-text-primary);
    margin-bottom: 24px;
    font-weight: 600;
}

.trpro-filter-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.trpro-filter-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 24px;
    border: 2px solid var(--trpro-border);
    background: white;
    border-radius: var(--trpro-radius-xl);
    cursor: pointer;
    transition: var(--trpro-transition);
    font-weight: 600;
    color: var(--trpro-text-secondary);
    text-decoration: none;
}

.trpro-filter-btn:hover,
.trpro-filter-btn.active {
    border-color: var(--trpro-primary);
    background: var(--trpro-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--trpro-shadow-md);
}

.trpro-filter-btn i {
    font-size: 1.1rem;
}

.trpro-display-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    padding: 24px;
    background: var(--trpro-bg-secondary);
    border-radius: var(--trpro-radius);
    border: 1px solid var(--trpro-border);
}

.trpro-view-controls,
.trpro-sort-controls {
    display: flex;
    align-items: center;
    gap: 16px;
}

.trpro-view-controls label,
.trpro-sort-controls label {
    font-weight: 600;
    color: var(--trpro-text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}

.trpro-view-btn {
    padding: 10px 14px;
    border: 2px solid var(--trpro-border);
    background: white;
    border-radius: var(--trpro-radius-sm);
    cursor: pointer;
    transition: var(--trpro-transition);
    color: var(--trpro-text-secondary);
}

.trpro-view-btn:hover,
.trpro-view-btn.active {
    border-color: var(--trpro-primary);
    background: var(--trpro-primary);
    color: white;
}

#trpro-sort-select {
    padding: 10px 16px;
    border: 2px solid var(--trpro-border);
    border-radius: var(--trpro-radius-sm);
    background: white;
    font-size: 1rem;
    font-weight: 500;
}

.trpro-trainers-container {
    margin-bottom: 64px;
}

.trpro-view-list .trpro-trainers-grid {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.trpro-view-list .trpro-trainer-card {
    display: flex;
    flex-direction: row;
    max-width: none;
    height: auto;
}

.trpro-view-list .trpro-trainer-photo {
    width: 180px;
    height: 180px;
    flex-shrink: 0;
}

.trpro-view-list .trpro-trainer-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.trpro-pagination-container {
    text-align: center;
    margin: 64px 0;
}

.trpro-pagination {
    display: inline-flex;
    gap: 8px;
    align-items: center;
    margin-bottom: 24px;
}

.trpro-pagination-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    border: 2px solid var(--trpro-border);
    border-radius: var(--trpro-radius-sm);
    text-decoration: none;
    color: var(--trpro-text-secondary);
    font-weight: 600;
    transition: var(--trpro-transition);
    min-width: 48px;
    justify-content: center;
    background: white;
}

.trpro-pagination-link:hover {
    background: var(--trpro-primary);
    color: white;
    border-color: var(--trpro-primary);
    transform: translateY(-1px);
    text-decoration: none;
    box-shadow: var(--trpro-shadow);
}

.trpro-pagination-link.trpro-current {
    background: var(--trpro-primary);
    color: white;
    border-color: var(--trpro-primary);
}

.trpro-pagination-ellipsis {
    padding: 12px 8px;
    color: var(--trpro-text-light);
}

.trpro-pagination-info {
    color: var(--trpro-text-secondary);
    font-size: 0.95rem;
    font-weight: 500;
}

.trpro-empty-state {
    text-align: center;
    padding: 80px 24px;
    background: var(--trpro-bg-secondary);
    border-radius: var(--trpro-radius);
    margin: 48px 0;
    border: 1px solid var(--trpro-border);
}

.trpro-empty-icon {
    font-size: 5rem;
    color: var(--trpro-text-light);
    margin-bottom: 32px;
}

.trpro-empty-state h3 {
    font-size: 2rem;
    color: var(--trpro-text-primary);
    margin-bottom: 16px;
    font-weight: 600;
}

.trpro-empty-state p {
    font-size: 1.125rem;
    color: var(--trpro-text-secondary);
    margin-bottom: 32px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.trpro-empty-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
}

.trpro-list-cta {
    background: var(--trpro-gradient-primary);
    color: white;
    padding: 64px;
    border-radius: var(--trpro-radius);
    margin-top: 80px;
    box-shadow: var(--trpro-shadow-lg);
}

.trpro-cta-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 48px;
    max-width: 1000px;
    margin: 0 auto;
}

.trpro-cta-text h3 {
    font-size: 2rem;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 16px;
    font-weight: 700;
}

.trpro-cta-text p {
    font-size: 1.125rem;
    opacity: 0.95;
    line-height: 1.7;
}

.trpro-cta-actions {
    display: flex;
    gap: 16px;
    flex-shrink: 0;
    flex-direction: column;
}

.trpro-cta-actions .trpro-btn {
    padding: 16px 32px;
    font-size: 1.1rem;
    font-weight: 600;
    white-space: nowrap;
}

.trpro-cta-actions .trpro-btn-secondary {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.25);
    color: white;
}

.trpro-cta-actions .trpro-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
}

/* Responsive */
@media (max-width: 1024px) {
    .trpro-display-options {
        flex-direction: column;
        gap: 20px;
    }
    
    .trpro-view-controls,
    .trpro-sort-controls {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .trpro-list-header {
        padding: 32px 16px;
    }
    
    .trpro-filter-buttons {
        justify-content: center;
    }
    
    .trpro-filter-btn {
        padding: 12px 20px;
    }
    
    .trpro-cta-content {
        flex-direction: column;
        text-align: center;
        gap: 32px;
    }
    
    .trpro-cta-actions {
        flex-direction: row;
        justify-content: center;
        width: 100%;
    }
    
    .trpro-view-list .trpro-trainer-card {
        flex-direction: column;
    }
    
    .trpro-view-list .trpro-trainer-photo {
        width: 100%;
        height: 200px;
    }
    
    .trpro-pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .trpro-list-cta {
        padding: 48px 24px;
    }
}

@media (max-width: 480px) {
    .trpro-filter-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .trpro-filter-btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
    
    .trpro-cta-actions {
        flex-direction: column;
    }
    
    .trpro-empty-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>