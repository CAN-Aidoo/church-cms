import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

// Make Alpine available globally
window.Alpine = Alpine;
window.Chart = Chart;

// Alpine.js Components
Alpine.data('modal', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
}));

Alpine.data('dropdown', () => ({
    open: false,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
}));

Alpine.data('sidebar', () => ({
    open: true,
    toggle() {
        this.open = !this.open;
    }
}));

Alpine.data('tabs', (initialTab = 0) => ({
    activeTab: initialTab,
    setTab(index) {
        this.activeTab = index;
    }
}));

Alpine.data('toast', () => ({
    visible: false,
    message: '',
    type: 'success',
    show(message, type = 'success') {
        this.message = message;
        this.type = type;
        this.visible = true;
        setTimeout(() => this.hide(), 3000);
    },
    hide() {
        this.visible = false;
    }
}));

// Start Alpine
Alpine.start();

// Utility Functions
window.formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-GH', {
        style: 'currency',
        currency: 'GHS'
    }).format(amount);
};

window.formatDate = (date) => {
    return new Intl.DateFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }).format(new Date(date));
};

window.formatDateTime = (datetime) => {
    return new Intl.DateFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(new Date(datetime));
};

// Toast Notification System
window.showToast = (message, type = 'success') => {
    const toast = document.getElementById('toast-notification');
    if (toast) {
        const event = new CustomEvent('show-toast', {
            detail: { message, type }
        });
        toast.dispatchEvent(event);
    }
};

// Confirmation Dialog
window.confirmAction = (message) => {
    return new Promise((resolve) => {
        if (confirm(message)) {
            resolve(true);
        } else {
            resolve(false);
        }
    });
};

// Auto-dismiss alerts
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('[data-auto-dismiss]');
    alerts.forEach(alert => {
        const timeout = parseInt(alert.dataset.autoDismiss) || 5000;
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, timeout);
    });
});

// Handle AJAX form submissions
document.addEventListener('submit', async (e) => {
    const form = e.target;
    if (form.dataset.ajax === 'true') {
        e.preventDefault();

        const formData = new FormData(form);
        const submitButton = form.querySelector('[type="submit"]');
        const originalText = submitButton?.textContent;

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner"></span> Processing...';
        }

        try {
            const response = await fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (data.status === 'success') {
                showToast(data.message || 'Operation successful', 'success');
                if (data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 1000);
                }
            } else {
                showToast(data.message || 'Operation failed', 'error');

                // Display field errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'form-error';
                            errorDiv.textContent = data.errors[field][0];
                            input.parentNode.appendChild(errorDiv);
                        }
                    });
                }
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
            console.error('Form submission error:', error);
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        }
    }
});

// Initialize charts if Chart.js data exists
document.addEventListener('DOMContentLoaded', () => {
    const chartElements = document.querySelectorAll('[data-chart]');
    chartElements.forEach(element => {
        const chartData = JSON.parse(element.dataset.chart);
        const ctx = element.getContext('2d');
        new Chart(ctx, chartData);
    });
});

// Print functionality
window.printElement = (elementId) => {
    const element = document.getElementById(elementId);
    if (element) {
        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<link rel="stylesheet" href="/css/app.css">');
        printWindow.document.write('</head><body>');
        printWindow.document.write(element.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
};

// Export to CSV
window.exportTableToCSV = (tableId, filename = 'export.csv') => {
    const table = document.getElementById(tableId);
    if (!table) return;

    const rows = Array.from(table.querySelectorAll('tr'));
    const csv = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('th, td'));
        return cells.map(cell => `"${cell.textContent.trim()}"`).join(',');
    }).join('\n');

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
};
