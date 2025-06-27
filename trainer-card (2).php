<?php
/**
 * Template pour afficher une carte de formateur - NOUVELLE STRUCTURE
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/public/partials/trainer-card.php
 * Variable disponible: $trainer (objet avec les données du formateur)
 */

if (!defined('ABSPATH')) {
    exit;
}

// Récupérer les paramètres de contact depuis les options
$contact_email = get_option('trainer_contact_email', get_option('admin_email'));
$contact_phone = get_option('trainer_contact_phone', '');
?>

<div class="trpro-trainer-card" data-trainer-id="<?php echo esc_attr($trainer->id); ?>">
    <div class="trpro-trainer-photo">
        <?php if (!empty($trainer->photo_file)): ?>
            <?php 
            $upload_dir = wp_upload_dir();
            $photo_url = $upload_dir['baseurl'] . '/' . $trainer->photo_file;
            ?>
            <img src="<?php echo esc_url($photo_url); ?>" 
                 alt="Photo de profil" 
                 loading="lazy">
        <?php else: ?>
            <i class="fas fa-user-circle"></i>
        <?php endif; ?>
        
        <!-- Badges overlay sur la photo -->
        <div class="trpro-trainer-badges-overlay">
            <div class="trpro-badge trpro-verified" title="Profil vérifié">
                <i class="fas fa-shield-check"></i>
            </div>
            
            <?php if (!empty($trainer->cv_file)): ?>
                <div class="trpro-badge trpro-cv-available" title="CV disponible">
                    <i class="fas fa-file-pdf"></i>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="trpro-trainer-info">
        <div class="trpro-trainer-header">
            <h3 class="trpro-trainer-name">
                Formateur Expert
                <span class="trpro-trainer-id">#<?php echo str_pad($trainer->id, 4, '0', STR_PAD_LEFT); ?></span>
            </h3>
            
            <?php if (!empty($trainer->company)): ?>
                <div class="trpro-trainer-company">
                    <i class="fas fa-building"></i>
                    <?php echo esc_html($trainer->company); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="trpro-trainer-specialties">
            <div class="trpro-specialty-tags">
                <?php 
                $specialties = explode(', ', $trainer->specialties);
                $displayed_count = 0;
                $max_display = 3;
                
                foreach ($specialties as $specialty): 
                    $specialty = trim($specialty);
                    if (!empty($specialty) && $displayed_count < $max_display):
                        $displayed_count++;
                ?>
                    <span class="trpro-specialty-tag">
                        <?php echo esc_html(ucfirst(str_replace('-', ' ', $specialty))); ?>
                    </span>
                <?php 
                    endif;
                endforeach;
                
                // Afficher un badge "+X" s'il y a plus de spécialités
                $remaining = count($specialties) - $max_display;
                if ($remaining > 0):
                ?>
                    <span class="trpro-specialty-tag trpro-more">
                        +<?php echo $remaining; ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (!empty($trainer->bio)): ?>
            <div class="trpro-trainer-bio">
                <?php echo esc_html(wp_trim_words($trainer->bio, 20, '...')); ?>
            </div>
        <?php endif; ?>
        
        <div class="trpro-trainer-meta">
            <?php if (!empty($trainer->availability)): ?>
                <div class="trpro-meta-item">
                    <i class="fas fa-calendar-check"></i>
                    <span><?php echo esc_html(ucfirst(str_replace('-', ' ', $trainer->availability))); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($trainer->hourly_rate)): ?>
                <div class="trpro-meta-item">
                    <i class="fas fa-euro-sign"></i>
                    <span><?php echo esc_html($trainer->hourly_rate); ?></span>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="trpro-trainer-experience-preview">
            <div class="trpro-experience-snippet">
                <i class="fas fa-star"></i>
                <span><?php echo esc_html(wp_trim_words($trainer->experience, 15, '...')); ?></span>
            </div>
        </div>
        
        <div class="trpro-trainer-actions">
            <?php if (!empty($contact_email)): ?>
                <a href="mailto:<?php echo esc_attr($contact_email); ?>?subject=Contact formateur %23<?php echo str_pad($trainer->id, 4, '0', STR_PAD_LEFT); ?>&body=Bonjour,%0D%0A%0D%0AJe souhaite entrer en contact avec le formateur %23<?php echo str_pad($trainer->id, 4, '0', STR_PAD_LEFT); ?> pour discuter d'une collaboration.%0D%0A%0D%0ACordialement" 
                   class="trpro-contact-btn trpro-contact-email"
                   title="Contacter par email">
                    <i class="fas fa-envelope"></i>
                    Contacter
                </a>
            <?php endif; ?>
            
            <button class="trpro-btn-info" data-trainer-id="<?php echo esc_attr($trainer->id); ?>" title="Voir plus d'informations">
                <i class="fas fa-info-circle"></i>
                Détails
            </button>
        </div>
        
        <div class="trpro-trainer-footer">
            <div class="trpro-registration-date">
                <i class="fas fa-calendar-plus"></i>
                <span>Inscrit le <?php echo date_i18n('d/m/Y', strtotime($trainer->created_at)); ?></span>
            </div>
            
            <?php if (!empty($trainer->linkedin_url)): ?>
                <div class="trpro-trainer-linkedin">
                    <a href="<?php echo esc_url($trainer->linkedin_url); ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       title="Voir le profil LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Badges de statut -->
        <div class="trpro-status-badges">
            <?php 
            // Badge basé sur l'ancienneté
            $registration_date = new DateTime($trainer->created_at);
            $now = new DateTime();
            $interval = $registration_date->diff($now);
            
            if ($interval->days > 365): 
            ?>
                <div class="trpro-badge trpro-experienced" title="Membre depuis plus d'un an">
                    <i class="fas fa-medal"></i>
                    <span>Expérimenté</span>
                </div>
            <?php elseif ($interval->days > 30): ?>
                <div class="trpro-badge trpro-active" title="Membre actif">
                    <i class="fas fa-star"></i>
                    <span>Actif</span>
                </div>
            <?php else: ?>
                <div class="trpro-badge trpro-new" title="Nouveau membre">
                    <i class="fas fa-sparkles"></i>
                    <span>Nouveau</span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($contact_phone)): ?>
                <div class="trpro-badge trpro-phone-available" title="Contact téléphonique disponible">
                    <i class="fas fa-phone"></i>
                    <span>Tel</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Modal d'informations détaillées -->
    <div class="trpro-trainer-modal" id="trpro-modal-<?php echo esc_attr($trainer->id); ?>" style="display: none;">
        <div class="trpro-modal-backdrop"></div>
        <div class="trpro-modal-content">
            <div class="trpro-modal-header">
                <h4>Formateur Expert #<?php echo str_pad($trainer->id, 4, '0', STR_PAD_LEFT); ?></h4>
                <button class="trpro-modal-close" data-trainer-id="<?php echo esc_attr($trainer->id); ?>">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="trpro-modal-body">
                <div class="trpro-modal-specialties">
                    <h5><i class="fas fa-cogs"></i> Compétences détaillées</h5>
                    <div class="trpro-detailed-specialties">
                        <?php 
                        $specialties = explode(', ', $trainer->specialties);
                        foreach ($specialties as $specialty): 
                            $specialty = trim($specialty);
                            if (!empty($specialty)):
                                // Mapping des spécialités vers des icônes
                                $specialty_icons = [
                                    'administration-systeme' => 'fas fa-server',
                                    'reseaux' => 'fas fa-network-wired',
                                    'cloud' => 'fas fa-cloud',
                                    'devops' => 'fas fa-infinity',
                                    'securite' => 'fas fa-shield-alt',
                                    'telecoms' => 'fas fa-satellite-dish',
                                    'developpement' => 'fas fa-code',
                                    'bases-donnees' => 'fas fa-database'
                                ];
                                
                                $icon = isset($specialty_icons[$specialty]) ? $specialty_icons[$specialty] : 'fas fa-cog';
                        ?>
                            <div class="trpro-detailed-specialty">
                                <i class="<?php echo esc_attr($icon); ?>"></i>
                                <span><?php echo esc_html(ucfirst(str_replace('-', ' ', $specialty))); ?></span>
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
                
                <?php if (!empty($trainer->experience)): ?>
                    <div class="trpro-modal-experience">
                        <h5><i class="fas fa-briefcase"></i> Expérience professionnelle</h5>
                        <p><?php echo esc_html($trainer->experience); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($trainer->bio)): ?>
                    <div class="trpro-modal-bio">
                        <h5><i class="fas fa-user"></i> Présentation</h5>
                        <p><?php echo esc_html($trainer->bio); ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="trpro-modal-actions">
                    <?php if (!empty($contact_email)): ?>
                        <a href="mailto:<?php echo esc_attr($contact_email); ?>?subject=Contact formateur %23<?php echo str_pad($trainer->id, 4, '0', STR_PAD_LEFT); ?>" 
                           class="trpro-btn trpro-btn-primary">
                            <i class="fas fa-envelope"></i>
                            Contacter par Email
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($contact_phone)): ?>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)); ?>" 
                           class="trpro-btn trpro-btn-success">
                            <i class="fas fa-phone"></i>
                            <?php echo esc_html($contact_phone); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles spécifiques pour les cartes de formateurs */
.trpro-trainer-card {
    position: relative;
    overflow: hidden;
    background: white;
    border: 1px solid var(--trpro-border);
    border-radius: var(--trpro-radius);
    transition: var(--trpro-transition);
    box-shadow: var(--trpro-shadow-sm);
}

.trpro-trainer-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--trpro-shadow-lg);
    border-color: var(--trpro-primary);
}

.trpro-trainer-photo {
    width: 100%;
    height: 200px;
    background: var(--trpro-bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--trpro-text-tertiary);
    font-size: 3rem;
    position: relative;
    overflow: hidden;
}

.trpro-trainer-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--trpro-transition-slow);
}

.trpro-trainer-card:hover .trpro-trainer-photo img {
    transform: scale(1.05);
}

.trpro-trainer-badges-overlay {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.trpro-trainer-info {
    padding: 24px;
}

.trpro-trainer-header {
    margin-bottom: 16px;
}

.trpro-trainer-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--trpro-text-primary);
    text-align: center;
    margin-bottom: 8px;
    line-height: 1.3;
}

.trpro-trainer-id {
    font-size: 0.8rem;
    color: var(--trpro-text-light);
    font-weight: 400;
    display: block;
    margin-top: 4px;
}

.trpro-trainer-company {
    text-align: center;
    color: var(--trpro-text-secondary);
    margin-bottom: 16px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.trpro-trainer-company i {
    color: var(--trpro-primary);
}

.trpro-trainer-specialties {
    margin-bottom: 16px;
}

.trpro-specialty-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
}

.trpro-specialty-tag {
    background: var(--trpro-bg-secondary);
    color: var(--trpro-primary);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1px solid var(--trpro-border);
    transition: var(--trpro-transition);
}

.trpro-specialty-tag:hover {
    background: var(--trpro-primary);
    color: white;
    transform: scale(1.05);
}

.trpro-specialty-tag.trpro-more {
    background: var(--trpro-accent);
    color: white;
    border-color: var(--trpro-accent);
}

.trpro-trainer-bio {
    color: var(--trpro-text-secondary);
    line-height: 1.6;
    margin-bottom: 16px;
    font-size: 0.9rem;
    text-align: center;
    min-height: 44px;
}

.trpro-trainer-meta {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.trpro-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--trpro-text-secondary);
    font-size: 0.85rem;
    font-weight: 500;
}

.trpro-meta-item i {
    color: var(--trpro-primary);
}

.trpro-trainer-experience-preview {
    margin-bottom: 20px;
}

.trpro-experience-snippet {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 0.85rem;
    color: var(--trpro-text-secondary);
    line-height: 1.5;
}

.trpro-experience-snippet i {
    color: var(--trpro-accent);
    margin-top: 2px;
    flex-shrink: 0;
}

.trpro-trainer-actions {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
}

.trpro-contact-btn,
.trpro-btn-info {
    flex: 1;
    padding: 12px 16px;
    border: none;
    border-radius: 24px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: var(--trpro-transition);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
}

.trpro-contact-btn {
    background: var(--trpro-primary);
    color: white;
}

.trpro-contact-btn:hover {
    background: var(--trpro-primary-dark);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.trpro-btn-info {
    background: var(--trpro-bg-secondary);
    color: var(--trpro-text-secondary);
    border: 1px solid var(--trpro-border);
}

.trpro-btn-info:hover {
    background: var(--trpro-accent);
    color: white;
    border-color: var(--trpro-accent);
}

.trpro-trainer-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--trpro-border-light);
    font-size: 0.8rem;
    color: var(--trpro-text-secondary);
}

.trpro-registration-date {
    display: flex;
    align-items: center;
    gap: 6px;
}

.trpro-registration-date i {
    color: var(--trpro-primary);
}

.trpro-trainer-linkedin a {
    color: #0077b5;
    text-decoration: none;
    font-size: 1.2rem;
    transition: var(--trpro-transition);
}

.trpro-trainer-linkedin a:hover {
    transform: scale(1.2);
}

.trpro-status-badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.trpro-badge {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.trpro-badge.trpro-verified {
    background: rgba(16, 185, 129, 0.1);
    color: var(--trpro-success);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.trpro-badge.trpro-cv-available {
    background: rgba(99, 102, 241, 0.1);
    color: var(--trpro-primary);
    border: 1px solid rgba(99, 102, 241, 0.2);
}

.trpro-badge.trpro-experienced {
    background: rgba(245, 158, 11, 0.1);
    color: var(--trpro-warning);
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.trpro-badge.trpro-active {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
    border: 1px solid rgba(139, 92, 246, 0.2);
}

.trpro-badge.trpro-new {
    background: rgba(236, 72, 153, 0.1);
    color: #ec4899;
    border: 1px solid rgba(236, 72, 153, 0.2);
}

.trpro-badge.trpro-phone-available {
    background: rgba(16, 185, 129, 0.1);
    color: var(--trpro-success);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

/* Modal styles */
.trpro-trainer-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.trpro-modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
}

.trpro-modal-content {
    background: white;
    border-radius: var(--trpro-radius);
    box-shadow: var(--trpro-shadow-xl);
    min-width: 500px;
    max-width: 90vw;
    max-height: 90vh;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

.trpro-modal-header {
    padding: 24px;
    border-bottom: 1px solid var(--trpro-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--trpro-bg-secondary);
}

.trpro-modal-header h4 {
    margin: 0;
    color: var(--trpro-text-primary);
    font-size: 1.25rem;
    font-weight: 600;
}

.trpro-modal-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: var(--trpro-text-light);
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: var(--trpro-transition);
}

.trpro-modal-close:hover {
    background: var(--trpro-bg-tertiary);
    color: var(--trpro-text-primary);
}

.trpro-modal-body {
    padding: 24px;
    max-height: 60vh;
    overflow-y: auto;
}

.trpro-modal-specialties,
.trpro-modal-experience,
.trpro-modal-bio {
    margin-bottom: 24px;
}

.trpro-modal-body h5 {
    color: var(--trpro-text-primary);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1.1rem;
    font-weight: 600;
}

.trpro-modal-body h5 i {
    color: var(--trpro-primary);
}

.trpro-detailed-specialties {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.trpro-detailed-specialty {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: var(--trpro-bg-secondary);
    border-radius: var(--trpro-radius-sm);
    border: 1px solid var(--trpro-border);
}

.trpro-detailed-specialty i {
    color: var(--trpro-primary);
    font-size: 1.1rem;
}

.trpro-modal-experience p,
.trpro-modal-bio p {
    color: var(--trpro-text-secondary);
    line-height: 1.6;
    margin: 0;
}

.trpro-modal-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px solid var(--trpro-border);
}

/* Responsive */
@media (max-width: 768px) {
    .trpro-trainer-footer {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
    }
    
    .trpro-status-badges {
        justify-content: flex-start;
    }
    
    .trpro-modal-content {
        min-width: 0;
        margin: 10px;
    }
    
    .trpro-modal-actions {
        flex-direction: column;
    }
    
    .trpro-detailed-specialties {
        grid-template-columns: 1fr;
    }
}
</style>