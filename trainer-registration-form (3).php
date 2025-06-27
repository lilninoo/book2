<?php
/**
 * Template pour le formulaire d'inscription - NOUVELLE STRUCTURE STRIPE-LIKE
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/public/partials/trainer-registration-form.php
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="trpro-registration-container" id="trpro-registration-form">
    <div class="trpro-registration-header">
        <h1 class="trpro-form-title">
            Inscription Formateur IT
        </h1>
        <p class="trpro-form-subtitle">Rejoignez notre réseau d'experts et partagez votre expertise avec les meilleures entreprises</p>
    </div>

    <div class="trpro-registration-progress">
        <div class="trpro-progress-step active" data-step="1">
            <span>1</span>
            <small>Informations personnelles</small>
        </div>
        <div class="trpro-progress-step" data-step="2">
            <span>2</span>
            <small>Expérience professionnelle</small>
        </div>
        <div class="trpro-progress-step" data-step="3">
            <span>3</span>
            <small>Documents</small>
        </div>
        <div class="trpro-progress-step" data-step="4">
            <span>4</span>
            <small>Validation</small>
        </div>
    </div>

    <form id="trpro-registration-form" method="post" enctype="multipart/form-data" class="trpro-registration-form">
        
        <!-- Étape 1: Informations personnelles -->
        <div class="trpro-form-step active" data-step="1">
            <h2 class="trpro-step-title">
                Informations Personnelles
            </h2>
            
            <div class="trpro-form-row">
                <div class="trpro-form-group">
                    <label for="trpro-first-name">Prénom *</label>
                    <input type="text" id="trpro-first-name" name="first_name" required>
                    <span class="trpro-error-message"></span>
                </div>
                
                <div class="trpro-form-group">
                    <label for="trpro-last-name">Nom *</label>
                    <input type="text" id="trpro-last-name" name="last_name" required>
                    <span class="trpro-error-message"></span>
                </div>
            </div>
            
            <div class="trpro-form-row">
                <div class="trpro-form-group">
                    <label for="trpro-email">Email professionnel *</label>
                    <input type="email" id="trpro-email" name="email" required>
                    <span class="trpro-error-message"></span>
                </div>
                
                <div class="trpro-form-group">
                    <label for="trpro-phone">Téléphone *</label>
                    <input type="tel" id="trpro-phone" name="phone" required>
                    <span class="trpro-error-message"></span>
                </div>
            </div>
            
            <div class="trpro-form-group">
                <label for="trpro-company">Entreprise / Organisation</label>
                <input type="text" id="trpro-company" name="company" placeholder="Nom de votre entreprise ou freelance">
            </div>
            
            <div class="trpro-form-group">
                <label for="trpro-linkedin-url">Profil LinkedIn</label>
                <input type="url" id="trpro-linkedin-url" name="linkedin_url" placeholder="https://linkedin.com/in/votre-profil">
            </div>
        </div>

        <!-- Étape 2: Expérience professionnelle -->
        <div class="trpro-form-step" data-step="2">
            <h2 class="trpro-step-title">
                Expertise & Expérience
            </h2>
            
            <div class="trpro-form-group">
                <label>Spécialités * (sélectionnez toutes qui s'appliquent)</label>
                <div class="trpro-checkbox-grid">
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="administration-systeme">
                        <span class="trpro-checkmark"></span>
                        Administration Système
                    </label>
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="reseaux">
                        <span class="trpro-checkmark"></span>
                        Réseaux & Infrastructure
                    </label>
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="cloud">
                        <span class="trpro-checkmark"></span>
                        Cloud Computing
                    </label>
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="devops">
                        <span class="trpro-checkmark"></span>
                        DevOps & CI/CD
                    </label>
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="securite">
                        <span class="trpro-checkmark"></span>
                        Sécurité Informatique
                    </label>
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="telecoms">
                        <span class="trpro-checkmark"></span>
                        Télécommunications
                    </label>
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="developpement">
                        <span class="trpro-checkmark"></span>
                        Développement
                    </label>
                    <label class="trpro-checkbox-item">
                        <input type="checkbox" name="specialties[]" value="bases-donnees">
                        <span class="trpro-checkmark"></span>
                        Bases de Données
                    </label>
                </div>
                <span class="trpro-error-message"></span>
            </div>
            
            <div class="trpro-form-row">
                <div class="trpro-form-group">
                    <label for="trpro-availability">Disponibilité</label>
                    <select id="trpro-availability" name="availability">
                        <option value="">Sélectionnez votre disponibilité</option>
                        <option value="temps-plein">Temps plein</option>
                        <option value="temps-partiel">Temps partiel</option>
                        <option value="ponctuel">Missions ponctuelles</option>
                        <option value="weekends">Weekends uniquement</option>
                        <option value="flexible">Flexible</option>
                    </select>
                </div>
                
                <div class="trpro-form-group">
                    <label for="trpro-hourly-rate">Tarif horaire (optionnel)</label>
                    <input type="text" id="trpro-hourly-rate" name="hourly_rate" placeholder="Ex: 80€/h">
                </div>
            </div>
            
            <div class="trpro-form-group">
                <label for="trpro-experience">Expérience et compétences techniques *</label>
                <textarea id="trpro-experience" name="experience" rows="6" required 
                          placeholder="Décrivez votre expérience, vos certifications, les technologies que vous maîtrisez, vos réalisations marquantes..."></textarea>
                <span class="trpro-error-message"></span>
            </div>
            
            <div class="trpro-form-group">
                <label for="trpro-bio">Présentation professionnelle</label>
                <textarea id="trpro-bio" name="bio" rows="4" 
                          placeholder="Présentez-vous en quelques mots, votre approche pédagogique, vos motivations..."></textarea>
            </div>
        </div>

        <!-- Étape 3: Documents -->
        <div class="trpro-form-step" data-step="3">
            <h2 class="trpro-step-title">
                Documents & Pièces Jointes
            </h2>
            
            <div class="trpro-upload-section">
                <div class="trpro-form-group">
                    <label for="trpro-cv-file">CV / Portfolio * (PDF, DOC, DOCX - Max 5MB)</label>
                    <div class="trpro-file-upload-area" data-target="trpro-cv-file">
                        <div class="trpro-upload-text">
                            <div class="trpro-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p>Glissez votre CV ici ou <span class="trpro-upload-link">cliquez pour sélectionner</span></p>
                            <small>Formats acceptés: PDF, DOC, DOCX</small>
                        </div>
                        <input type="file" id="trpro-cv-file" name="cv_file" accept=".pdf,.doc,.docx" required hidden>
                    </div>
                    <div class="trpro-file-preview" id="trpro-cv-file-preview"></div>
                    <span class="trpro-error-message"></span>
                </div>
                
                <div class="trpro-form-group">
                    <label for="trpro-photo-file">Photo professionnelle (optionnel - JPG, PNG - Max 2MB)</label>
                    <div class="trpro-file-upload-area" data-target="trpro-photo-file">
                        <div class="trpro-upload-text">
                            <div class="trpro-upload-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <p>Glissez votre photo ici ou <span class="trpro-upload-link">cliquez pour sélectionner</span></p>
                            <small>Formats acceptés: JPG, PNG, GIF</small>
                        </div>
                        <input type="file" id="trpro-photo-file" name="photo_file" accept=".jpg,.jpeg,.png,.gif" hidden>
                    </div>
                    <div class="trpro-file-preview" id="trpro-photo-file-preview"></div>
                </div>
            </div>
        </div>

        <!-- Étape 4: Validation et RGPD -->
        <div class="trpro-form-step" data-step="4">
            <h2 class="trpro-step-title">
                Validation & Consentement
            </h2>
            
            <div class="trpro-summary-section">
                <h3>Récapitulatif de votre inscription</h3>
                <div id="trpro-registration-summary" class="trpro-summary-content">
                    <!-- Le résumé sera généré automatiquement -->
                </div>
            </div>
            
            <div class="trpro-rgpd-section">
                <h3>Protection des données personnelles</h3>
                
                <div class="trpro-rgpd-info">
                    <div class="trpro-info-grid">
                        <div class="trpro-info-item">
                            <strong>Responsable du traitement :</strong>
                            <span><?php echo get_option('trainer_company_name', '[Nom de votre organisation]'); ?></span>
                        </div>
                        <div class="trpro-info-item">
                            <strong>Finalité :</strong>
                            <span>Gestion des inscriptions de formateurs et mise en relation avec des recruteurs</span>
                        </div>
                        <div class="trpro-info-item">
                            <strong>Base légale :</strong>
                            <span>Consentement (Art. 6.1.a RGPD)</span>
                        </div>
                        <div class="trpro-info-item">
                            <strong>Durée de conservation :</strong>
                            <span><?php echo get_option('trainer_data_retention', 3); ?> ans à compter de votre dernière activité</span>
                        </div>
                    </div>
                </div>
                
                <div class="trpro-consent-checkboxes">
                    <label class="trpro-consent-item">
                        <input type="checkbox" name="rgpd_consent" value="1" required>
                        <span class="trpro-checkmark"></span>
                        <div class="trpro-consent-text">
                            <strong>J'accepte le traitement de mes données personnelles *</strong>
                            <p>Je consens au traitement de mes données personnelles pour la gestion de mon profil de formateur et la mise en relation avec des recruteurs potentiels.</p>
                        </div>
                    </label>
                    
                    <label class="trpro-consent-item">
                        <input type="checkbox" name="marketing_consent" value="1">
                        <span class="trpro-checkmark"></span>
                        <div class="trpro-consent-text">
                            <strong>Communications marketing (optionnel)</strong>
                            <p>J'accepte de recevoir des informations sur de nouvelles opportunités et actualités de la plateforme.</p>
                        </div>
                    </label>
                </div>
                
                <div class="trpro-rights-info">
                    <div class="trpro-info-box">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Vos droits :</strong>
                            <p>Vous disposez d'un droit d'accès, de rectification, d'effacement, de portabilité, de limitation du traitement et d'opposition. 
                            Pour exercer vos droits : <a href="mailto:<?php echo get_option('trainer_contact_email', 'dpo@votre-site.com'); ?>"><?php echo get_option('trainer_contact_email', 'dpo@votre-site.com'); ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation du formulaire -->
        <div class="trpro-form-navigation">
            <button type="button" id="trpro-prev-step" class="trpro-btn trpro-btn-secondary" style="display: none;">
                <i class="fas fa-arrow-left"></i>
                Précédent
            </button>
            
            <button type="button" id="trpro-next-step" class="trpro-btn trpro-btn-primary">
                Suivant
                <i class="fas fa-arrow-right"></i>
            </button>
            
            <button type="submit" id="trpro-submit-form" class="trpro-btn trpro-btn-success" style="display: none;">
                <i class="fas fa-paper-plane"></i>
                Envoyer ma candidature
            </button>
        </div>

        <?php wp_nonce_field('trainer_registration_nonce', 'nonce'); ?>
    </form>

    <!-- Messages de retour -->
    <div id="trpro-form-messages" class="trpro-form-messages" style="display: none;"></div>
    
    <!-- Loading overlay -->
    <div id="trpro-form-loading" class="trpro-loading-overlay" style="display: none;">
        <div class="trpro-loading-content">
            <div class="trpro-spinner"></div>
            <p>Envoi de votre candidature en cours...</p>
        </div>
    </div>
</div>

<style>
/* Styles additionnels pour le formulaire */
.trpro-upload-section {
    display: grid;
    gap: 32px;
}

.trpro-upload-icon {
    font-size: 3rem;
    color: var(--trpro-primary);
    margin-bottom: 16px;
}

.trpro-file-preview {
    margin-top: 16px;
    padding: 16px;
    background: var(--trpro-bg-secondary);
    border-radius: var(--trpro-radius-sm);
    border: 1px solid var(--trpro-border);
    display: none;
}

.trpro-file-preview.active {
    display: block;
}

.trpro-file-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.trpro-file-info i {
    font-size: 1.5rem;
    color: var(--trpro-primary);
}

.trpro-file-details {
    flex: 1;
}

.trpro-file-name {
    font-weight: 600;
    color: var(--trpro-text-primary);
    margin-bottom: 4px;
}

.trpro-file-size {
    color: var(--trpro-text-secondary);
    font-size: 0.9rem;
}

.trpro-file-remove {
    background: var(--trpro-error);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--trpro-transition);
}

.trpro-file-remove:hover {
    background: #dc2626;
}

.trpro-summary-section,
.trpro-rgpd-section {
    background: var(--trpro-bg-secondary);
    padding: 32px;
    border-radius: var(--trpro-radius);
    margin-bottom: 32px;
    border: 1px solid var(--trpro-border);
}

.trpro-summary-section h3,
.trpro-rgpd-section h3 {
    color: var(--trpro-text-primary);
    margin-bottom: 20px;
    font-size: 1.25rem;
    font-weight: 600;
}

.trpro-summary-content {
    display: grid;
    gap: 16px;
}

.trpro-summary-item {
    display: grid;
    grid-template-columns: 150px 1fr;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid var(--trpro-border-light);
}

.trpro-summary-label {
    font-weight: 600;
    color: var(--trpro-text-primary);
}

.trpro-summary-value {
    color: var(--trpro-text-secondary);
}

.trpro-rgpd-info {
    background: white;
    padding: 24px;
    border-radius: var(--trpro-radius-sm);
    margin-bottom: 24px;
    border: 1px solid var(--trpro-border);
}

.trpro-info-grid {
    display: grid;
    gap: 16px;
}

.trpro-info-item {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 12px;
    padding: 8px 0;
}

.trpro-info-item strong {
    color: var(--trpro-text-primary);
    font-size: 0.9rem;
}

.trpro-info-item span {
    color: var(--trpro-text-secondary);
    font-size: 0.9rem;
}

.trpro-consent-checkboxes {
    display: grid;
    gap: 20px;
    margin-bottom: 24px;
}

.trpro-consent-item {
    display: flex;
    gap: 16px;
    padding: 24px;
    background: white;
    border-radius: var(--trpro-radius-sm);
    cursor: pointer;
    transition: var(--trpro-transition);
    border: 2px solid var(--trpro-border);
}

.trpro-consent-item:hover {
    box-shadow: var(--trpro-shadow);
    border-color: var(--trpro-primary);
}

.trpro-consent-text strong {
    color: var(--trpro-text-primary);
    display: block;
    margin-bottom: 8px;
    font-size: 1rem;
}

.trpro-consent-text p {
    color: var(--trpro-text-secondary);
    font-size: 0.9rem;
    margin: 0;
    line-height: 1.5;
}

.trpro-rights-info {
    margin-top: 24px;
}

.trpro-info-box {
    display: flex;
    gap: 16px;
    padding: 20px;
    background: rgba(99, 102, 241, 0.05);
    border-radius: var(--trpro-radius-sm);
    border: 1px solid rgba(99, 102, 241, 0.2);
}

.trpro-info-box i {
    color: var(--trpro-primary);
    font-size: 1.2rem;
    margin-top: 2px;
    flex-shrink: 0;
}

.trpro-info-box strong {
    color: var(--trpro-text-primary);
    display: block;
    margin-bottom: 8px;
}

.trpro-info-box p {
    color: var(--trpro-text-secondary);
    margin: 0;
    line-height: 1.5;
    font-size: 0.9rem;
}

.trpro-info-box a {
    color: var(--trpro-primary);
    text-decoration: none;
}

.trpro-info-box a:hover {
    text-decoration: underline;
}

.trpro-form-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 48px;
    padding-top: 32px;
    border-top: 2px solid var(--trpro-border-light);
}

@media (max-width: 768px) {
    .trpro-registration-form {
        padding: 32px 24px;
    }
    
    .trpro-form-navigation {
        flex-direction: column;
        gap: 16px;
    }
    
    .trpro-btn {
        width: 100%;
        max-width: 300px;
    }
    
    .trpro-summary-item,
    .trpro-info-item {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    
    .trpro-consent-item {
        flex-direction: column;
        gap: 12px;
    }
}
</style>