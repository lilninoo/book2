/**
 * JavaScript pour la partie publique du plugin - NOUVELLE STRUCTURE
 * Préfixe: trpro- pour éviter les conflits
 * 
 * Fichier: /wp-content/plugins/trainer-registration-plugin/public/js/public-script.js
 */

jQuery(document).ready(function($) {
    'use strict';

    // ===== VARIABLES GLOBALES =====
    
    let currentStep = 1;
    const totalSteps = 4;
    let formSubmitting = false;
    
    // ===== NAVIGATION DU FORMULAIRE MULTI-ÉTAPES =====
    
    function updateProgressBar() {
        $('.trpro-progress-step').removeClass('active');
        for (let i = 1; i <= currentStep; i++) {
            $(`.trpro-progress-step[data-step="${i}"]`).addClass('active');
        }
    }
    
    function showStep(step) {
        $('.trpro-form-step').removeClass('active');
        $(`.trpro-form-step[data-step="${step}"]`).addClass('active');
        
        // Gestion des boutons
        if (step === 1) {
            $('#trpro-prev-step').hide();
        } else {
            $('#trpro-prev-step').show();
        }
        
        if (step === totalSteps) {
            $('#trpro-next-step').hide();
            $('#trpro-submit-form').show();
            generateSummary();
        } else {
            $('#trpro-next-step').show();
            $('#trpro-submit-form').hide();
        }
        
        updateProgressBar();
        
        // Scroll vers le haut du formulaire
        $('html, body').animate({
            scrollTop: $('.trpro-registration-container').offset().top - 50
        }, 300);
    }
    
    $('#trpro-next-step').on('click', function() {
        if (validateCurrentStep()) {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }
    });
    
    $('#trpro-prev-step').on('click', function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // ===== VALIDATION DU FORMULAIRE =====
    
    function validateCurrentStep() {
        let isValid = true;
        const currentStepDiv = $(`.trpro-form-step[data-step="${currentStep}"]`);
        
        // Nettoyer les erreurs précédentes
        currentStepDiv.find('.trpro-error-message').text('');
        currentStepDiv.find('.trpro-form-group').removeClass('error');
        
        switch (currentStep) {
            case 1:
                isValid = validateStep1(currentStepDiv);
                break;
            case 2:
                isValid = validateStep2(currentStepDiv);
                break;
            case 3:
                isValid = validateStep3(currentStepDiv);
                break;
            case 4:
                isValid = validateStep4(currentStepDiv);
                break;
        }
        
        return isValid;
    }
    
    function validateStep1(stepDiv) {
        let isValid = true;
        
        // Prénom
        const firstName = stepDiv.find('#trpro-first-name').val().trim();
        if (!firstName) {
            showFieldError('#trpro-first-name', 'Le prénom est obligatoire');
            isValid = false;
        }
        
        // Nom
        const lastName = stepDiv.find('#trpro-last-name').val().trim();
        if (!lastName) {
            showFieldError('#trpro-last-name', 'Le nom est obligatoire');
            isValid = false;
        }
        
        // Email
        const email = stepDiv.find('#trpro-email').val().trim();
        if (!email) {
            showFieldError('#trpro-email', 'L\'email est obligatoire');
            isValid = false;
        } else if (!isValidEmail(email)) {
            showFieldError('#trpro-email', 'Veuillez saisir un email valide');
            isValid = false;
        }
        
        // Téléphone
        const phone = stepDiv.find('#trpro-phone').val().trim();
        if (!phone) {
            showFieldError('#trpro-phone', 'Le téléphone est obligatoire');
            isValid = false;
        }
        
        return isValid;
    }
    
    function validateStep2(stepDiv) {
        let isValid = true;
        
        // Spécialités
        const specialties = stepDiv.find('input[name="specialties[]"]:checked');
        if (specialties.length === 0) {
            stepDiv.find('.trpro-checkbox-grid').after('<span class="trpro-error-message">Veuillez sélectionner au moins une spécialité</span>');
            isValid = false;
        }
        
        // Expérience
        const experience = stepDiv.find('#trpro-experience').val().trim();
        if (!experience) {
            showFieldError('#trpro-experience', 'Veuillez décrire votre expérience');
            isValid = false;
        } else if (experience.length < 50) {
            showFieldError('#trpro-experience', 'Veuillez fournir une description plus détaillée (minimum 50 caractères)');
            isValid = false;
        }
        
        return isValid;
    }
    
    function validateStep3(stepDiv) {
        let isValid = true;
        
        // CV obligatoire
        const cvFile = stepDiv.find('#trpro-cv-file')[0].files[0];
        if (!cvFile) {
            showFieldError('#trpro-cv-file', 'Le CV est obligatoire');
            isValid = false;
        } else {
            // Vérifier la taille (5MB max)
            if (cvFile.size > 5 * 1024 * 1024) {
                showFieldError('#trpro-cv-file', 'Le fichier CV ne doit pas dépasser 5MB');
                isValid = false;
            }
            
            // Vérifier le type
            const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!allowedTypes.includes(cvFile.type)) {
                showFieldError('#trpro-cv-file', 'Format de fichier non supporté. Utilisez PDF, DOC ou DOCX');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    function validateStep4(stepDiv) {
        let isValid = true;
        
        // Consentement RGPD obligatoire
        const rgpdConsent = stepDiv.find('input[name="rgpd_consent"]:checked');
        if (rgpdConsent.length === 0) {
            stepDiv.find('.trpro-consent-checkboxes').after('<span class="trpro-error-message">Le consentement RGPD est obligatoire</span>');
            isValid = false;
        }
        
        return isValid;
    }
    
    function showFieldError(fieldId, message) {
        const field = $(fieldId);
        field.closest('.trpro-form-group').addClass('error');
        field.siblings('.trpro-error-message').text(message);
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // ===== GESTION DES FICHIERS =====
    
    // Drag & Drop pour les fichiers
    $('.trpro-file-upload-area').on('click', function() {
        const targetInput = $(this).data('target');
        $(`#${targetInput}`).click();
    });
    
    $('.trpro-file-upload-area').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });
    
    $('.trpro-file-upload-area').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });
    
    $('.trpro-file-upload-area').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        
        const files = e.originalEvent.dataTransfer.files;
        const targetInput = $(this).data('target');
        
        if (files.length > 0) {
            $(`#${targetInput}`)[0].files = files;
            $(`#${targetInput}`).trigger('change');
        }
    });
    
    // Aperçu des fichiers
    $('input[type="file"]').on('change', function() {
        const file = this.files[0];
        const fileId = $(this).attr('id');
        const previewDiv = $(`#${fileId}-preview`);
        
        if (file) {
            let fileIcon = 'fas fa-file';
            if (file.type.includes('pdf')) fileIcon = 'fas fa-file-pdf';
            else if (file.type.includes('image')) fileIcon = 'fas fa-file-image';
            else if (file.type.includes('word')) fileIcon = 'fas fa-file-word';
            
            const fileSize = formatFileSize(file.size);
            
            const previewHtml = `
                <div class="trpro-file-info">
                    <i class="${fileIcon}"></i>
                    <div class="trpro-file-details">
                        <div class="trpro-file-name">${file.name}</div>
                        <div class="trpro-file-size">${fileSize}</div>
                    </div>
                    <button type="button" class="trpro-file-remove" data-target="${fileId}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            previewDiv.html(previewHtml).addClass('active');
        } else {
            previewDiv.removeClass('active').empty();
        }
    });
    
    // Supprimer un fichier
    $(document).on('click', '.trpro-file-remove', function() {
        const targetId = $(this).data('target');
        $(`#${targetId}`).val('');
        $(`#${targetId}-preview`).removeClass('active').empty();
    });
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // ===== GÉNÉRATION DU RÉSUMÉ =====
    
    function generateSummary() {
        const summary = $('#trpro-registration-summary');
        summary.empty();
        
        // Informations personnelles
        const firstName = $('#trpro-first-name').val();
        const lastName = $('#trpro-last-name').val();
        const email = $('#trpro-email').val();
        const phone = $('#trpro-phone').val();
        const company = $('#trpro-company').val();
        
        summary.append(createSummaryItem('Nom complet', `${firstName} ${lastName}`));
        summary.append(createSummaryItem('Email', email));
        summary.append(createSummaryItem('Téléphone', phone));
        if (company) {
            summary.append(createSummaryItem('Entreprise', company));
        }
        
        // Spécialités
        const specialties = [];
        $('input[name="specialties[]"]:checked').each(function() {
            const label = $(this).closest('.trpro-checkbox-item').text().trim();
            specialties.push(label);
        });
        summary.append(createSummaryItem('Spécialités', specialties.join(', ')));
        
        // Disponibilité
        const availability = $('#trpro-availability').val();
        if (availability) {
            summary.append(createSummaryItem('Disponibilité', availability));
        }
        
        // Fichiers
        const cvFile = $('#trpro-cv-file')[0].files[0];
        if (cvFile) {
            summary.append(createSummaryItem('CV', cvFile.name));
        }
        
        const photoFile = $('#trpro-photo-file')[0].files[0];
        if (photoFile) {
            summary.append(createSummaryItem('Photo', photoFile.name));
        }
    }
    
    function createSummaryItem(label, value) {
        return `
            <div class="trpro-summary-item">
                <div class="trpro-summary-label">${label}</div>
                <div class="trpro-summary-value">${value}</div>
            </div>
        `;
    }

    // ===== SOUMISSION DU FORMULAIRE =====
    
    $('#trpro-registration-form').on('submit', function(e) {
        e.preventDefault();
        
        if (formSubmitting) {
            return false;
        }
        
        if (!validateCurrentStep()) {
            return false;
        }
        
        formSubmitting = true;
        
        // Afficher le loading
        $('#trpro-form-loading').show();
        
        // Préparer les données avec FormData pour les fichiers
        const formData = new FormData(this);
        formData.append('action', 'submit_trainer_registration');
        formData.append('nonce', trainer_ajax.nonce);
        
        $.ajax({
            url: trainer_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#trpro-form-loading').hide();
                formSubmitting = false;
                
                if (response.success) {
                    showMessage('success', response.data.message || trainer_ajax.messages.success);
                    $('#trpro-registration-form')[0].reset();
                    $('.trpro-file-preview').removeClass('active').empty();
                    currentStep = 1;
                    showStep(currentStep);
                    
                    // Scroll vers le message
                    $('html, body').animate({
                        scrollTop: $('#trpro-form-messages').offset().top - 50
                    }, 300);
                } else {
                    showMessage('error', response.data.message || trainer_ajax.messages.error);
                    
                    // Afficher les erreurs spécifiques
                    if (response.data.errors) {
                        response.data.errors.forEach(function(error) {
                            console.error('Erreur de validation:', error);
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                $('#trpro-form-loading').hide();
                formSubmitting = false;
                console.error('Erreur AJAX:', error);
                showMessage('error', 'Erreur de connexion. Veuillez réessayer.');
            }
        });
    });
    
    function showMessage(type, message) {
        const messageDiv = $('#trpro-form-messages');
        messageDiv.removeClass('success error').addClass(type);
        messageDiv.html(`<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`);
        messageDiv.show();
        
        // Masquer automatiquement après 5 secondes pour les succès
        if (type === 'success') {
            setTimeout(function() {
                messageDiv.fadeOut();
            }, 5000);
        }
    }

    // ===== RECHERCHE DE FORMATEURS =====
    
    $('#trpro-search-trainers-btn').on('click', function() {
        performTrainerSearch();
    });
    
    $('#trpro-trainer-search-input').on('keypress', function(e) {
        if (e.which === 13) {
            performTrainerSearch();
        }
    });
    
    $('#trpro-specialty-filter').on('change', function() {
        performTrainerSearch();
    });
    
    function performTrainerSearch() {
        const searchTerm = $('#trpro-trainer-search-input').val().trim();
        const specialtyFilter = $('#trpro-specialty-filter').val();
        
        // Afficher le loading
        $('#trpro-search-loading').show();
        $('#trpro-search-results').empty();
        
        $.ajax({
            url: trainer_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'search_trainers',
                search_term: searchTerm,
                specialty_filter: specialtyFilter,
                nonce: trainer_ajax.nonce
            },
            success: function(response) {
                $('#trpro-search-loading').hide();
                
                if (response.success) {
                    if (response.data.html.trim()) {
                        $('#trpro-search-results').html(response.data.html);
                        initTrainerCardEvents();
                    } else {
                        $('#trpro-search-results').html(getNoResultsHtml());
                    }
                } else {
                    $('#trpro-search-results').html('<div class="trpro-error-message">Erreur lors de la recherche</div>');
                }
            },
            error: function() {
                $('#trpro-search-loading').hide();
                $('#trpro-search-results').html('<div class="trpro-error-message">Erreur de connexion</div>');
            }
        });
    }
    
    function getNoResultsHtml() {
        return `
            <div class="trpro-no-results">
                <div class="trpro-empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Aucun formateur trouvé</h3>
                <p>Essayez avec d'autres mots-clés ou filtres.</p>
            </div>
        `;
    }

    // ===== FILTRES ET VUES =====
    
    // Filtrage rapide
    $(document).on('click', '.trpro-filter-btn', function() {
        $('.trpro-filter-btn').removeClass('active');
        $(this).addClass('active');
        
        const filter = $(this).data('filter');
        filterTrainerCards(filter);
    });
    
    function filterTrainerCards(filter) {
        $('.trpro-trainer-card').each(function() {
            const card = $(this);
            const specialties = card.find('.trpro-specialty-tags').text().toLowerCase();
            
            if (filter === 'all' || specialties.includes(filter.replace('-', ' '))) {
                card.show();
            } else {
                card.hide();
            }
        });
    }
    
    // Changement de vue
    $(document).on('click', '.trpro-view-btn', function() {
        $('.trpro-view-btn').removeClass('active');
        $(this).addClass('active');
        
        const view = $(this).data('view');
        $('#trpro-trainers-grid').removeClass('trpro-view-grid trpro-view-list').addClass(`trpro-view-${view}`);
    });
    
    // Tri
    $('#trpro-sort-select').on('change', function() {
        const sortBy = $(this).val();
        const cardsArray = Array.from($('.trpro-trainer-card'));
        
        cardsArray.sort((a, b) => {
            switch (sortBy) {
                case 'alphabetical':
                    const nameA = $(a).find('.trpro-trainer-name').text().toLowerCase();
                    const nameB = $(b).find('.trpro-trainer-name').text().toLowerCase();
                    return nameA.localeCompare(nameB);
                case 'recent':
                    // Par défaut, ordre inverse (plus récents en premier)
                    return 0;
                default:
                    return 0;
            }
        });
        
        const container = $('#trpro-trainers-grid');
        cardsArray.forEach(card => container.append(card));
    });

    // ===== MODALES DES FORMATEURS =====
    
    function initTrainerCardEvents() {
        // Ouvrir la modale
        $('.trpro-btn-info').off('click').on('click', function() {
            const trainerId = $(this).data('trainer-id');
            $(`#trpro-modal-${trainerId}`).show();
            $('body').addClass('trpro-modal-open');
        });
        
        // Fermer la modale
        $('.trpro-modal-close, .trpro-modal-backdrop').off('click').on('click', function() {
            const trainerId = $(this).data('trainer-id') || $(this).closest('.trpro-trainer-modal').attr('id').replace('trpro-modal-', '');
            $(`#trpro-modal-${trainerId}`).hide();
            $('body').removeClass('trpro-modal-open');
        });
        
        // Fermer avec Escape
        $(document).off('keydown.modal').on('keydown.modal', function(e) {
            if (e.key === 'Escape') {
                $('.trpro-trainer-modal:visible').hide();
                $('body').removeClass('trpro-modal-open');
            }
        });
    }
    
    // Initialiser les événements des cartes au chargement
    initTrainerCardEvents();

    // ===== ANIMATIONS DES STATISTIQUES =====
    
    function animateStats() {
        $('.trpro-stat-number').each(function() {
            const $this = $(this);
            const originalText = $this.text();
            
            // Extraire le nombre du texte
            const matches = originalText.match(/(\d+)/);
            if (!matches) return;
            
            const finalNumber = parseInt(matches[1]);
            const suffix = originalText.replace(/\d+/, ''); // Récupérer le suffixe (%, +, etc.)
            const duration = 2000;
            const steps = 60;
            const increment = finalNumber / steps;
            let current = 0;
            let stepCount = 0;
            
            const timer = setInterval(function() {
                current += increment;
                stepCount++;
                
                if (stepCount >= steps || current >= finalNumber) {
                    current = finalNumber;
                    clearInterval(timer);
                }
                
                $this.text(Math.floor(current) + suffix);
            }, duration / steps);
        });
    }
    
    // ===== ANIMATIONS AU SCROLL =====
    
    function animateOnScroll() {
        $('.trpro-specialty-card, .trpro-trainer-card, .trpro-card').each(function() {
            if (isElementInViewport($(this))) {
                $(this).addClass('trpro-visible');
            }
        });
    }
    
    function isElementInViewport($element) {
        if ($element.length === 0) return false;
        
        const elementTop = $element.offset().top;
        const elementBottom = elementTop + $element.outerHeight();
        const viewportTop = $(window).scrollTop();
        const viewportBottom = viewportTop + $(window).height();
        
        return elementBottom > viewportTop && elementTop < viewportBottom;
    }
    
    // Déclencher les animations au scroll
    $(window).on('scroll', animateOnScroll);
    animateOnScroll(); // Exécuter une fois au chargement
    
    // Animation des stats quand elles deviennent visibles
    let statsAnimated = false;
    $(window).on('scroll', function() {
        if (!statsAnimated && $('.trpro-stats-section').length) {
            if (isElementInViewport($('.trpro-stats-section'))) {
                animateStats();
                statsAnimated = true;
            }
        }
    });

    // ===== SCROLL FLUIDE POUR LES ANCRES =====
    
    $(document).on('click', 'a[href^="#trpro"]', function(e) {
        const href = $(this).attr('href');
        
        // Vérifier que c'est un lien ancre valide
        if (href === '#' || href.length === 1) {
            return;
        }
        
        const target = $(href);
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 600);
        }
    });

    // ===== AMÉLIORATIONS UX =====
    
    // Améliorer les interactions des checkbox
    $('.trpro-checkbox-item').on('click', function() {
        const checkbox = $(this).find('input[type="checkbox"]');
        checkbox.prop('checked', !checkbox.prop('checked'));
        $(this).toggleClass('checked', checkbox.prop('checked'));
    });
    
    // Améliorer les interactions des boutons
    $('.trpro-btn, .trpro-filter-btn, .trpro-view-btn').on('mouseenter', function() {
        $(this).addClass('hover');
    }).on('mouseleave', function() {
        $(this).removeClass('hover');
    });
    
    // Validation en temps réel
    $('input, textarea').on('blur', function() {
        const $this = $(this);
        const value = $this.val().trim();
        const required = $this.prop('required');
        
        if (required && !value) {
            $this.closest('.trpro-form-group').addClass('error');
            $this.siblings('.trpro-error-message').text('Ce champ est obligatoire');
        } else {
            $this.closest('.trpro-form-group').removeClass('error');
            $this.siblings('.trpro-error-message').text('');
        }
    });
    
    // Style CSS additionnel pour les interactions
    $('<style>')
        .prop("type", "text/css")
        .html(`
            .trpro-modal-open { overflow: hidden; }
            .trpro-checkbox-item.checked { 
                border-color: var(--trpro-primary); 
                background: rgba(99, 102, 241, 0.05); 
            }
            .trpro-form-group.error input,
            .trpro-form-group.error select,
            .trpro-form-group.error textarea {
                border-color: var(--trpro-error);
            }
            .trpro-no-results {
                text-align: center;
                padding: 60px 20px;
                color: var(--trpro-text-secondary);
            }
            .trpro-no-results .trpro-empty-icon {
                font-size: 3rem;
                margin-bottom: 20px;
                color: var(--trpro-text-light);
            }
        `)
        .appendTo("head");
    
    console.log('Trainer Registration Pro: JavaScript loaded successfully with new structure');
});