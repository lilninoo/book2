<?php
/**
 * Template pour la recherche de formateurs - NOUVELLE STRUCTURE
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/public/partials/trainer-search.php
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="trpro-search-container" id="trpro-trainer-search">
    <div class="trpro-search-header">
        <h3>Rechercher un Formateur</h3>
        <p>Trouvez le formateur expert qui correspond à vos besoins</p>
    </div>
    
    <div class="trpro-search-form">
        <div class="trpro-search-filters">
            <div class="trpro-search-field">
                <input type="text" 
                       id="trpro-trainer-search-input" 
                       placeholder="Rechercher par compétence, technologie, certification..."
                       autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
            
            <div class="trpro-filter-field">
                <select id="trpro-specialty-filter">
                    <option value="all">Toutes les spécialités</option>
                    <option value="administration-systeme">Administration Système</option>
                    <option value="reseaux">Réseaux & Infrastructure</option>
                    <option value="cloud">Cloud Computing</option>
                    <option value="devops">DevOps & CI/CD</option>
                    <option value="securite">Sécurité Informatique</option>
                    <option value="telecoms">Télécommunications</option>
                    <option value="developpement">Développement</option>
                    <option value="bases-donnees">Bases de Données</option>
                </select>
            </div>
            
            <button type="button" id="trpro-search-trainers-btn" class="trpro-btn trpro-btn-primary">
                <i class="fas fa-search"></i>
                Rechercher
            </button>
        </div>
    </div>
    
    <div class="trpro-search-results-container">
        <div id="trpro-search-results" class="trpro-search-results">
            <!-- Les résultats seront chargés ici via AJAX -->
            <div class="trpro-search-placeholder">
                <div class="trpro-placeholder-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4>Commencez votre recherche</h4>
                <p>Utilisez les filtres ci-dessus pour trouver des formateurs experts dans votre domaine</p>
            </div>
        </div>
        
        <div id="trpro-search-loading" class="trpro-loading-spinner" style="display: none;">
            <div class="trpro-spinner"></div>
            <span>Recherche en cours...</span>
        </div>
    </div>
    
    <!-- Suggestions de recherche populaires -->
    <div class="trpro-search-suggestions">
        <h4>Recherches populaires</h4>
        <div class="trpro-suggestion-tags">
            <button class="trpro-suggestion-tag" data-search="kubernetes">
                <i class="fas fa-cube"></i>
                Kubernetes
            </button>
            <button class="trpro-suggestion-tag" data-search="aws">
                <i class="fab fa-aws"></i>
                AWS
            </button>
            <button class="trpro-suggestion-tag" data-search="docker">
                <i class="fab fa-docker"></i>
                Docker
            </button>
            <button class="trpro-suggestion-tag" data-search="linux">
                <i class="fab fa-linux"></i>
                Linux
            </button>
            <button class="trpro-suggestion-tag" data-search="cisco">
                <i class="fas fa-network-wired"></i>
                Cisco
            </button>
            <button class="trpro-suggestion-tag" data-search="cybersécurité">
                <i class="fas fa-shield-alt"></i>
                Cybersécurité
            </button>
            <button class="trpro-suggestion-tag" data-search="python">
                <i class="fab fa-python"></i>
                Python
            </button>
            <button class="trpro-suggestion-tag" data-search="azure">
                <i class="fas fa-cloud"></i>
                Azure
            </button>
        </div>
    </div>
</div>

<style>
/* Styles spécifiques pour la recherche de formateurs */
.trpro-search-container {
    max-width: 800px;
    margin: 0 auto;
}

.trpro-search-header {
    text-align: center;
    margin-bottom: 32px;
}

.trpro-search-header h3 {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--trpro-text-primary);
    margin-bottom: 8px;
}

.trpro-search-header p {
    color: var(--trpro-text-secondary);
    font-size: 1.1rem;
}

.trpro-search-form {
    margin-bottom: 40px;
}

.trpro-search-filters {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 16px;
    align-items: end;
}

.trpro-search-field {
    position: relative;
}

.trpro-search-field input {
    width: 100%;
    padding: 16px 50px 16px 20px;
    border: 2px solid var(--trpro-border);
    border-radius: var(--trpro-radius-xl);
    font-size: 16px;
    font-family: var(--trpro-font-family);
    transition: var(--trpro-transition);
    background: white;
}

.trpro-search-field input:focus {
    outline: none;
    border-color: var(--trpro-primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}

.trpro-search-field i {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--trpro-text-tertiary);
    pointer-events: none;
}

.trpro-filter-field select {
    padding: 16px 20px;
    border: 2px solid var(--trpro-border);
    border-radius: var(--trpro-radius-xl);
    background: white;
    font-size: 16px;
    font-family: var(--trpro-font-family);
    min-width: 200px;
    transition: var(--trpro-transition);
}

.trpro-filter-field select:focus {
    outline: none;
    border-color: var(--trpro-primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}

.trpro-search-results-container {
    position: relative;
    min-height: 200px;
}

.trpro-search-results {
    margin-bottom: 40px;
}

.trpro-search-placeholder {
    text-align: center;
    padding: 60px 20px;
    background: var(--trpro-bg-secondary);
    border-radius: var(--trpro-radius);
    border: 2px dashed var(--trpro-border);
}

.trpro-placeholder-icon {
    font-size: 3rem;
    color: var(--trpro-text-light);
    margin-bottom: 20px;
}

.trpro-search-placeholder h4 {
    font-size: 1.5rem;
    color: var(--trpro-text-primary);
    margin-bottom: 10px;
    font-weight: 600;
}

.trpro-search-placeholder p {
    color: var(--trpro-text-secondary);
    font-size: 1.1rem;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.6;
}

.trpro-loading-spinner {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: var(--trpro-radius);
    backdrop-filter: blur(4px);
}

.trpro-loading-spinner .trpro-spinner {
    margin-bottom: 16px;
}

.trpro-loading-spinner span {
    color: var(--trpro-text-secondary);
    font-weight: 500;
}

.trpro-search-suggestions {
    background: var(--trpro-bg-secondary);
    padding: 32px;
    border-radius: var(--trpro-radius);
    border: 1px solid var(--trpro-border);
}

.trpro-search-suggestions h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--trpro-text-primary);
    margin-bottom: 20px;
    text-align: center;
}

.trpro-suggestion-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
}

.trpro-suggestion-tag {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: white;
    border: 2px solid var(--trpro-border);
    border-radius: var(--trpro-radius-xl);
    color: var(--trpro-text-secondary);
    font-weight: 500;
    cursor: pointer;
    transition: var(--trpro-transition);
    text-decoration: none;
}

.trpro-suggestion-tag:hover {
    border-color: var(--trpro-primary);
    background: var(--trpro-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--trpro-shadow);
}

.trpro-suggestion-tag i {
    font-size: 0.9rem;
}

/* Résultats de recherche sous forme de grille */
.trpro-search-results .trpro-trainers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

/* Message d'absence de résultats */
.trpro-no-results {
    text-align: center;
    padding: 60px 20px;
    background: var(--trpro-bg-secondary);
    border-radius: var(--trpro-radius);
    border: 1px solid var(--trpro-border);
}

.trpro-no-results .trpro-empty-icon {
    font-size: 3rem;
    color: var(--trpro-text-light);
    margin-bottom: 20px;
}

.trpro-no-results h3 {
    font-size: 1.5rem;
    color: var(--trpro-text-primary);
    margin-bottom: 10px;
    font-weight: 600;
}

.trpro-no-results p {
    color: var(--trpro-text-secondary);
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .trpro-search-filters {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .trpro-filter-field select {
        min-width: 100%;
    }
    
    .trpro-suggestion-tags {
        justify-content: flex-start;
    }
    
    .trpro-suggestion-tag {
        flex: 1;
        min-width: calc(50% - 6px);
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .trpro-search-container {
        padding: 0 16px;
    }
    
    .trpro-suggestion-tag {
        min-width: 100%;
    }
    
    .trpro-search-results .trpro-trainers-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des suggestions de recherche
    const suggestionTags = document.querySelectorAll('.trpro-suggestion-tag');
    const searchInput = document.getElementById('trpro-trainer-search-input');
    const searchBtn = document.getElementById('trpro-search-trainers-btn');
    
    suggestionTags.forEach(tag => {
        tag.addEventListener('click', function() {
            const searchTerm = this.dataset.search;
            searchInput.value = searchTerm;
            
            // Déclencher automatiquement la recherche
            if (searchBtn) {
                searchBtn.click();
            }
            
            // Effet visuel
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
    
    // Auto-complete simple basé sur les suggestions
    if (searchInput) {
        const suggestions = Array.from(suggestionTags).map(tag => tag.dataset.search);
        
        searchInput.addEventListener('input', function() {
            const value = this.value.toLowerCase();
            
            if (value.length >= 2) {
                const matches = suggestions.filter(suggestion => 
                    suggestion.toLowerCase().includes(value)
                );
                
                // Vous pouvez implémenter ici un dropdown d'auto-complétion
                // Pour l'instant, on se contente de la fonctionnalité de base
            }
        });
    }
    
    // Animation d'entrée pour les suggestions
    setTimeout(() => {
        suggestionTags.forEach((tag, index) => {
            setTimeout(() => {
                tag.style.opacity = '0';
                tag.style.transform = 'translateY(20px)';
                tag.style.transition = 'all 0.3s ease';
                
                requestAnimationFrame(() => {
                    tag.style.opacity = '1';
                    tag.style.transform = 'translateY(0)';
                });
            }, index * 50);
        });
    }, 100);
});
</script>