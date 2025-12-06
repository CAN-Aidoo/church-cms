/**
 * Advanced Report Builder
 *
 * Interactive report builder with real-time preview,
 * drag-and-drop columns, and dynamic filtering.
 */

class ReportBuilder {
    constructor(options = {}) {
        this.reportType = options.reportType || 'membership';
        this.selectedColumns = options.selectedColumns || [];
        this.filters = options.filters || [];
        this.groupBy = options.groupBy || null;
        this.calculations = options.calculations || [];
        this.previewData = null;
        this.availableFields = {};
        this.filterOperators = {};

        // API endpoints
        this.previewEndpoint = options.previewEndpoint || '/api/v1/reports/preview';
        this.fieldsEndpoint = options.fieldsEndpoint || '/api/v1/reports/fields';
        this.operatorsEndpoint = options.operatorsEndpoint || '/api/v1/reports/operators';
        this.validateEndpoint = options.validateEndpoint || '/api/v1/reports/validate';

        // CSRF token
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Headers
        this.headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };

        if (this.csrfToken) {
            this.headers['X-CSRF-TOKEN'] = this.csrfToken;
        }

        this.init();
    }

    /**
     * Initialize the report builder
     */
    async init() {
        await this.loadAvailableFields();
        await this.loadFilterOperators();
        this.setupEventListeners();
        this.renderFieldsList();
        this.renderSelectedColumns();
    }

    /**
     * Load available fields for the selected report type
     */
    async loadAvailableFields() {
        try {
            const response = await fetch(`${this.fieldsEndpoint}?type=${this.reportType}`, {
                method: 'GET',
                headers: this.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.availableFields = data.fields;
        } catch (error) {
            console.error('Error loading available fields:', error);
            this.showError('Failed to load available fields');
        }
    }

    /**
     * Load filter operators
     */
    async loadFilterOperators() {
        try {
            const response = await fetch(this.operatorsEndpoint, {
                method: 'GET',
                headers: this.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.filterOperators = data.operators;
        } catch (error) {
            console.error('Error loading filter operators:', error);
        }
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Report type change
        const reportTypeSelect = document.getElementById('report-type');
        if (reportTypeSelect) {
            reportTypeSelect.addEventListener('change', (e) => {
                this.changeReportType(e.target.value);
            });
        }

        // Preview button
        const previewBtn = document.getElementById('preview-report');
        if (previewBtn) {
            previewBtn.addEventListener('click', () => {
                this.previewReport();
            });
        }

        // Add filter button
        const addFilterBtn = document.getElementById('add-filter');
        if (addFilterBtn) {
            addFilterBtn.addEventListener('click', () => {
                this.addFilter();
            });
        }

        // Add calculation button
        const addCalcBtn = document.getElementById('add-calculation');
        if (addCalcBtn) {
            addCalcBtn.addEventListener('click', () => {
                this.addCalculation();
            });
        }

        // Save report button
        const saveBtn = document.getElementById('save-report');
        if (saveBtn) {
            saveBtn.addEventListener('click', () => {
                this.saveReport();
            });
        }
    }

    /**
     * Change report type
     */
    async changeReportType(newType) {
        this.reportType = newType;
        this.selectedColumns = [];
        this.filters = [];
        this.groupBy = null;
        this.calculations = [];

        await this.loadAvailableFields();
        this.renderFieldsList();
        this.renderSelectedColumns();
        this.renderFilters();
    }

    /**
     * Render available fields list
     */
    renderFieldsList() {
        const container = document.getElementById('available-fields');
        if (!container) return;

        if (Object.keys(this.availableFields).length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500 p-4">No fields available</p>';
            return;
        }

        const html = Object.entries(this.availableFields).map(([key, field]) => {
            const isSelected = this.selectedColumns.includes(key);
            return `
                <div class="field-item p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors ${isSelected ? 'bg-primary-50 border-primary-300' : ''}"
                     data-field="${key}"
                     draggable="true">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">${field.label}</p>
                                <p class="text-xs text-gray-500">${field.type}</p>
                            </div>
                        </div>
                        ${isSelected ? '<svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>' : ''}
                    </div>
                </div>
            `;
        }).join('');

        container.innerHTML = html;

        // Add drag and click event listeners
        container.querySelectorAll('.field-item').forEach(item => {
            item.addEventListener('click', (e) => {
                const field = e.currentTarget.dataset.field;
                this.toggleColumn(field);
            });

            item.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('field', e.currentTarget.dataset.field);
                e.currentTarget.classList.add('opacity-50');
            });

            item.addEventListener('dragend', (e) => {
                e.currentTarget.classList.remove('opacity-50');
            });
        });
    }

    /**
     * Render selected columns
     */
    renderSelectedColumns() {
        const container = document.getElementById('selected-columns');
        if (!container) return;

        if (this.selectedColumns.length === 0) {
            container.innerHTML = `
                <div class="p-8 text-center text-gray-400 border-2 border-dashed border-gray-200 rounded-lg">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <p class="text-sm">Click or drag fields here</p>
                </div>
            `;
            return;
        }

        const html = this.selectedColumns.map((columnKey, index) => {
            const field = this.availableFields[columnKey];
            if (!field) return '';

            return `
                <div class="selected-column-item p-3 bg-white border border-gray-200 rounded-lg flex items-center justify-between group hover:border-primary-300 transition-colors"
                     data-field="${columnKey}"
                     draggable="true">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400 cursor-move" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">${field.label}</span>
                        <span class="text-xs text-gray-400">(${field.type})</span>
                    </div>
                    <button class="remove-column text-gray-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity"
                            data-field="${columnKey}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;
        }).join('');

        container.innerHTML = html;

        // Add event listeners
        container.querySelectorAll('.remove-column').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const field = e.currentTarget.dataset.field;
                this.removeColumn(field);
            });
        });

        // Setup drop zone
        container.addEventListener('dragover', (e) => {
            e.preventDefault();
            container.classList.add('bg-primary-50', 'border-primary-300');
        });

        container.addEventListener('dragleave', () => {
            container.classList.remove('bg-primary-50', 'border-primary-300');
        });

        container.addEventListener('drop', (e) => {
            e.preventDefault();
            container.classList.remove('bg-primary-50', 'border-primary-300');

            const field = e.dataTransfer.getData('field');
            if (field && !this.selectedColumns.includes(field)) {
                this.addColumn(field);
            }
        });
    }

    /**
     * Toggle column selection
     */
    toggleColumn(field) {
        if (this.selectedColumns.includes(field)) {
            this.removeColumn(field);
        } else {
            this.addColumn(field);
        }
    }

    /**
     * Add column
     */
    addColumn(field) {
        if (!this.selectedColumns.includes(field)) {
            this.selectedColumns.push(field);
            this.renderFieldsList();
            this.renderSelectedColumns();
        }
    }

    /**
     * Remove column
     */
    removeColumn(field) {
        this.selectedColumns = this.selectedColumns.filter(col => col !== field);
        this.renderFieldsList();
        this.renderSelectedColumns();
    }

    /**
     * Add filter
     */
    addFilter() {
        const filter = {
            field: '',
            operator: 'equals',
            value: ''
        };

        this.filters.push(filter);
        this.renderFilters();
    }

    /**
     * Render filters
     */
    renderFilters() {
        const container = document.getElementById('filters-container');
        if (!container) return;

        if (this.filters.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500 p-4">No filters added</p>';
            return;
        }

        const html = this.filters.map((filter, index) => {
            return this.renderFilterRow(filter, index);
        }).join('');

        container.innerHTML = html;

        // Add event listeners for filter removal
        container.querySelectorAll('.remove-filter').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                this.removeFilter(index);
            });
        });
    }

    /**
     * Render single filter row
     */
    renderFilterRow(filter, index) {
        const fieldsOptions = Object.entries(this.availableFields).map(([key, field]) => {
            return `<option value="${key}" ${filter.field === key ? 'selected' : ''}>${field.label}</option>`;
        }).join('');

        const operatorsOptions = Object.entries(this.filterOperators).map(([key, label]) => {
            return `<option value="${key}" ${filter.operator === key ? 'selected' : ''}>${label}</option>`;
        }).join('');

        return `
            <div class="filter-row flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <select class="filter-field flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        data-index="${index}">
                    <option value="">Select field...</option>
                    ${fieldsOptions}
                </select>
                <select class="filter-operator px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        data-index="${index}">
                    ${operatorsOptions}
                </select>
                <input type="text"
                       class="filter-value flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Value..."
                       value="${filter.value}"
                       data-index="${index}">
                <button class="remove-filter p-2 text-gray-400 hover:text-red-600 transition-colors"
                        data-index="${index}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        `;
    }

    /**
     * Remove filter
     */
    removeFilter(index) {
        this.filters.splice(index, 1);
        this.renderFilters();
    }

    /**
     * Add calculation
     */
    addCalculation() {
        const calculation = {
            field: '',
            type: 'sum',
            label: ''
        };

        this.calculations.push(calculation);
        this.renderCalculations();
    }

    /**
     * Render calculations
     */
    renderCalculations() {
        const container = document.getElementById('calculations-container');
        if (!container) return;

        if (this.calculations.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500 p-4">No calculations added</p>';
            return;
        }

        // Implementation for calculations rendering
        // Similar to filters rendering
    }

    /**
     * Preview report
     */
    async previewReport() {
        if (this.selectedColumns.length === 0) {
            this.showError('Please select at least one column');
            return;
        }

        this.showLoading();

        try {
            const response = await fetch(this.previewEndpoint, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({
                    type: this.reportType,
                    columns: this.selectedColumns,
                    filters: this.filters,
                    group_by: this.groupBy,
                    calculations: this.calculations,
                    limit: 50
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.previewData = data;
            this.renderPreview(data);
            this.hideLoading();
        } catch (error) {
            console.error('Error previewing report:', error);
            this.showError('Failed to preview report');
            this.hideLoading();
        }
    }

    /**
     * Render preview
     */
    renderPreview(data) {
        const container = document.getElementById('preview-container');
        if (!container) return;

        if (!data.data || data.data.length === 0) {
            container.innerHTML = '<p class="text-center text-gray-500 p-8">No data to display</p>';
            return;
        }

        // Build table
        const headers = data.columns.map(col => {
            const field = this.availableFields[col];
            return `<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">${field?.label || col}</th>`;
        }).join('');

        const rows = data.data.map(row => {
            const cells = data.columns.map(col => {
                const value = row[col] !== null && row[col] !== undefined ? row[col] : '-';
                return `<td class="px-4 py-3 text-sm text-gray-900">${value}</td>`;
            }).join('');
            return `<tr class="border-b border-gray-100 hover:bg-gray-50">${cells}</tr>`;
        }).join('');

        const html = `
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-gray-900">Preview (${data.total} total rows, showing ${data.data.length})</h3>
                    ${data.statistics ? this.renderStatistics(data.statistics) : ''}
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>${headers}</tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            ${rows}
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        container.innerHTML = html;
    }

    /**
     * Render statistics
     */
    renderStatistics(statistics) {
        const stats = Object.entries(statistics).map(([key, value]) => {
            return `<span class="text-sm text-gray-600"><strong>${key}:</strong> ${value}</span>`;
        }).join(' | ');

        return `<div class="text-sm text-gray-600">${stats}</div>`;
    }

    /**
     * Save report
     */
    async saveReport() {
        // Validate configuration
        const validation = await this.validateConfig();
        if (!validation.valid) {
            this.showValidationErrors(validation.errors);
            return;
        }

        // Implement save logic
        console.log('Saving report with config:', {
            type: this.reportType,
            columns: this.selectedColumns,
            filters: this.filters,
            group_by: this.groupBy,
            calculations: this.calculations
        });
    }

    /**
     * Validate configuration
     */
    async validateConfig() {
        try {
            const response = await fetch(this.validateEndpoint, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({
                    type: this.reportType,
                    columns: this.selectedColumns,
                    filters: this.filters
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Error validating config:', error);
            return { valid: false, errors: ['Validation failed'] };
        }
    }

    /**
     * Show loading state
     */
    showLoading() {
        const previewBtn = document.getElementById('preview-report');
        if (previewBtn) {
            previewBtn.disabled = true;
            previewBtn.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-white inline-block" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
            `;
        }
    }

    /**
     * Hide loading state
     */
    hideLoading() {
        const previewBtn = document.getElementById('preview-report');
        if (previewBtn) {
            previewBtn.disabled = false;
            previewBtn.innerHTML = 'Preview Report';
        }
    }

    /**
     * Show error message
     */
    showError(message) {
        // Implement toast notification or alert
        alert(message);
    }

    /**
     * Show validation errors
     */
    showValidationErrors(errors) {
        const errorHtml = errors.map(err => `<li>${err}</li>`).join('');
        const message = `<ul class="list-disc pl-4">${errorHtml}</ul>`;

        // Show in a modal or alert
        alert('Validation errors:\n' + errors.join('\n'));
    }
}

// Auto-initialize
document.addEventListener('DOMContentLoaded', function() {
    const builderElement = document.getElementById('report-builder');
    if (builderElement) {
        const reportType = builderElement.dataset.reportType || 'membership';
        window.reportBuilder = new ReportBuilder({
            reportType: reportType
        });
    }
});
