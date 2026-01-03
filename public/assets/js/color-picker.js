/**
 * Color Picker Utility for Admin Panel
 * Usage: Initialize with initializeColorPicker()
 */

class ColorPickerManager {
    constructor() {
        this.pickr = null;
        this.currentColor = '#000000';
        this.isInitialized = false;
    }

    /**
     * Initialize color picker
     * @param {string} elementId - ID of input field
     * @param {string} pickerContainerId - ID of picker container
     * @param {string} defaultValue - Default color value
     */
    initialize(elementId, pickerContainerId, defaultValue = '#000000') {
        // Check if Pickr is loaded
        if (typeof Pickr === 'undefined') {
            console.error('Pickr library not loaded!');
            this.loadFallbackPicker(elementId);
            return;
        }

        // Destroy existing picker
        this.destroy();

        // Create picker
        this.pickr = Pickr.create({
            el: `#${pickerContainerId}`,
            theme: 'nano',
            default: defaultValue || '#000000',
            swatches: [
                '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#000000',
                '#FFFFFF', '#808080', '#800080', '#FFA500', '#FFC0CB',
                '#FF5733', '#33FF57', '#3357FF', '#F033FF', '#33FFF0',
                '#8B4513', '#FF69B4', '#00CED1', '#7CFC00', '#FFD700'
            ],
            components: {
                preview: true,
                opacity: false,
                hue: true,
                interaction: {
                    hex: true,
                    rgba: false,
                    hsla: false,
                    hsva: false,
                    cmyk: false,
                    input: true,
                    clear: false,
                    save: true
                }
            }
        });

        // Events
        this.pickr.on('save', (color, instance) => {
            if (color) {
                const hexColor = color.toHEXA().toString();
                this.updateInput(elementId, hexColor);
                instance.hide();
            }
        });

        this.pickr.on('change', (color, source, instance) => {
            if (color && source !== 'save') {
                const hexColor = color.toHEXA().toString();
                this.updateInput(elementId, hexColor);
            }
        });

        this.currentColor = defaultValue;
        this.isInitialized = true;

        // Add custom styles
        this.addStyles();
    }

    /**
     * Update input field with color value
     */
    updateInput(elementId, hexColor) {
        const input = document.getElementById(elementId);
        if (input) {
            // Remove # for storage
            const cleanColor = hexColor.replace('#', '');
            input.value = cleanColor;

            // Update preview if exists
            this.updatePreview(cleanColor);

            // Trigger change event
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    /**
     * Update color preview
     */
    updatePreview(color) {
        const preview = document.querySelector('.color-preview-active');
        if (preview) {
            preview.style.backgroundColor = `#${color}`;
        }
    }

    /**
     * Destroy picker instance
     */
    destroy() {
        if (this.pickr) {
            this.pickr.destroyAndRemove();
            this.pickr = null;
        }
        this.isInitialized = false;
    }

    /**
     * Get current color
     */
    getCurrentColor() {
        return this.currentColor;
    }

    /**
     * Set color value
     */
    setColor(color) {
        if (this.pickr && color) {
            const hexColor = color.startsWith('#') ? color : `#${color}`;
            this.pickr.setColor(hexColor);
            this.currentColor = hexColor;
        }
    }

    /**
     * Load fallback picker (input type color)
     */
    loadFallbackPicker(elementId) {
        const input = document.getElementById(elementId);
        if (input) {
            const container = input.closest('.color-input-container') || input.parentElement;

            // Create color input
            const colorInput = document.createElement('input');
            colorInput.type = 'color';
            colorInput.className = 'form-control color-input-fallback mt-2';
            colorInput.value = input.value ? `#${input.value}` : '#000000';

            // Update on change
            colorInput.addEventListener('change', function () {
                input.value = this.value.replace('#', '');
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });

            container.appendChild(colorInput);

            console.warn('Using fallback color picker');
        }
    }

    /**
     * Add custom styles
     */
    addStyles() {
        if (!document.getElementById('color-picker-styles')) {
            const style = document.createElement('style');
            style.id = 'color-picker-styles';
            style.textContent = `
                .pcr-app {
                    z-index: 99999 !important;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                    border-radius: 8px;
                }
                .pcr-button {
                    width: 100% !important;
                    height: 40px !important;
                    border-radius: 6px !important;
                    border: 1px solid #dee2e6 !important;
                }
                .color-preview-active {
                    width: 40px;
                    height: 40px;
                    border-radius: 6px;
                    border: 2px solid #fff;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                    cursor: pointer;
                    transition: transform 0.2s;
                }
                .color-preview-active:hover {
                    transform: scale(1.05);
                }
                .color-input-fallback {
                    height: 40px;
                    padding: 0;
                    cursor: pointer;
                }
                .color-input-container {
                    position: relative;
                }
                .color-picker-trigger {
                    position: absolute;
                    right: 10px;
                    top: 50%;
                    transform: translateY(-50%);
                    background: #f8f9fa;
                    border: 1px solid #dee2e6;
                    border-radius: 4px;
                    padding: 5px 10px;
                    cursor: pointer;
                    font-size: 12px;
                }
                .color-picker-trigger:hover {
                    background: #e9ecef;
                }
            `;
            document.head.appendChild(style);
        }
    }
}

// Global instance
const colorPicker = new ColorPickerManager();

/**
 * Initialize color picker for attribute forms
 */
function initializeAttributeColorPicker() {
    // Check if we're on attributes page
    if (!document.getElementById('colorHex')) return;

    // Create picker container if not exists
    let pickerContainer = document.getElementById('colorPickerContainer');
    if (!pickerContainer) {
        const inputGroup = document.getElementById('colorHex').closest('.input-group');
        if (inputGroup) {
            pickerContainer = document.createElement('div');
            pickerContainer.id = 'colorPickerContainer';
            pickerContainer.className = 'mt-3';
            inputGroup.parentNode.insertBefore(pickerContainer, inputGroup.nextSibling);
        }
    }

    // Get current value
    const currentValue = document.getElementById('colorHex').value;
    const defaultValue = currentValue ? `#${currentValue}` : '#000000';

    // Initialize picker
    colorPicker.initialize('colorHex', 'colorPickerContainer', defaultValue);
}

/**
 * Create color preview for table rows
 */
function initializeColorPreviews() {
    document.querySelectorAll('.color-preview').forEach(preview => {
        preview.classList.add('color-preview-active');

        // Add click to copy functionality
        preview.addEventListener('click', function () {
            const color = this.style.backgroundColor || '#000000';
            const hexColor = rgbToHex(color);

            // Copy to clipboard
            navigator.clipboard.writeText(hexColor).then(() => {
                showToast('success', `Color ${hexColor} copied to clipboard!`);
            });
        });
    });
}

/**
 * Convert RGB to Hex
 */
function rgbToHex(rgb) {
    if (rgb.startsWith('#')) return rgb;

    const result = rgb.match(/\d+/g);
    if (!result) return '#000000';

    const r = parseInt(result[0]);
    const g = parseInt(result[1]);
    const b = parseInt(result[2]);

    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
}

/**
 * Reset color picker when modal is opened
 */
function resetColorPicker() {
    if (colorPicker.isInitialized) {
        colorPicker.setColor('#000000');
    }

    // Re-initialize on modal show
    $('#colorModal').on('shown.bs.modal', function () {
        setTimeout(() => {
            initializeAttributeColorPicker();
        }, 300);
    });
}

/**
 * Load Pickr library dynamically
 */
function loadColorPickerLibrary(callback) {
    if (typeof Pickr !== 'undefined') {
        if (callback) callback();
        return;
    }

    // Load CSS
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css';
    document.head.appendChild(link);

    // Load JS
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js';
    script.onload = function () {
        if (callback) callback();
    };
    script.onerror = function () {
        console.error('Failed to load Pickr library');
    };
    document.head.appendChild(script);
}

/**
 * Initialize all color picker functionality
 */
function initColorPicker() {
    loadColorPickerLibrary(function () {
        // Initialize for attribute form
        initializeAttributeColorPicker();

        // Initialize previews in table
        initializeColorPreviews();

        // Setup reset on form reset
        resetColorPicker();
    });
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', function () {
    // Check if we're on attributes page
    if (document.querySelector('[data-page="attributes"]') ||
        window.location.pathname.includes('attributes')) {
        initColorPicker();
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ColorPickerManager,
        initializeAttributeColorPicker,
        initColorPicker,
        colorPicker
    };
}