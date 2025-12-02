# Church Management System - Frontend Architecture

## 🎨 Frontend Overview

**Technology Stack**: HTML5 + Tailwind CSS + JavaScript
**Framework**: Vanilla JS / Alpine.js for reactivity
**Build Tools**: Vite / Laravel Mix
**Component Architecture**: Modular, reusable components
**Template Engine**: Laravel Blade

---

## 📁 Project Structure

```
church-management-system/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php          # Main layout
│   │   │   ├── auth.blade.php         # Auth layout
│   │   │   └── guest.blade.php        # Guest layout
│   │   ├── components/
│   │   │   ├── navbar.blade.php       # Navigation component
│   │   │   ├── sidebar.blade.php      # Sidebar component
│   │   │   ├── footer.blade.php       # Footer component
│   │   │   ├── modal.blade.php        # Modal component
│   │   │   └── card.blade.php         # Card component
│   │   ├── dashboard/
│   │   │   └── index.blade.php        # Dashboard view
│   │   ├── members/
│   │   │   ├── index.blade.php        # Members list
│   │   │   ├── create.blade.php       # Create member
│   │   │   ├── edit.blade.php         # Edit member
│   │   │   └── show.blade.php         # Member details
│   │   ├── auth/
│   │   │   ├── login.blade.php        # Login page
│   │   │   ├── register.blade.php     # Registration page
│   │   │   └── forgot-password.blade.php
│   │   └── errors/
│   │       ├── 404.blade.php          # 404 error page
│   │       └── 500.blade.php          # 500 error page
│   ├── css/
│   │   ├── app.css                    # Main stylesheet
│   │   └── tailwind.css               # Tailwind imports
│   └── js/
│       ├── app.js                     # Main JavaScript
│       ├── components/
│       │   ├── chart.js                # Chart component
│       │   ├── datatable.js            # DataTable component
│       │   ├── form-validation.js      # Form validation
│       │   └── modal.js                # Modal handler
│       ├── services/
│       │   ├── api.js                  # API service
│       │   ├── auth.js                 # Auth service
│       │   └── utils.js                # Utility functions
│       └── pages/
│           ├── dashboard.js            # Dashboard logic
│           ├── members.js              # Members logic
│           └── finance.js              # Finance logic
├── public/
│   ├── css/                           # Compiled CSS
│   ├── js/                            # Compiled JavaScript
│   ├── images/                        # Static images
│   └── build/                         # Build assets
└── package.json                        # NPM dependencies
```

---

## 🎨 Component Architecture

### Base Layout Template
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Church Management System')</title>
    
    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')
    
    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')
        
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Navbar --}}
            @include('components.navbar')
            
            {{-- Main Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    {{-- Scripts --}}
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
```

### Reusable Component Example
```blade
{{-- resources/views/components/member-card.blade.php --}}
<div class="bg-white rounded-lg shadow-md p-6" 
     x-data="{ showDetails: false }">
    <div class="flex items-center">
        <img src="{{ $member->photo_url ?? '/images/default-avatar.png' }}" 
             alt="{{ $member->full_name }}"
             class="w-16 h-16 rounded-full object-cover">
        <div class="ml-4">
            <h3 class="text-lg font-semibold text-gray-900">
                {{ $member->full_name }}
            </h3>
            <p class="text-gray-600">{{ $member->email }}</p>
            <p class="text-sm text-gray-500">{{ $member->phone }}</p>
        </div>
    </div>
    
    <div class="mt-4 flex space-x-2">
        <button @click="showDetails = !showDetails"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            <span x-text="showDetails ? 'Hide' : 'View'"></span> Details
        </button>
        <a href="{{ route('members.edit', $member->id) }}"
           class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            Edit
        </a>
    </div>
    
    <div x-show="showDetails" 
         x-transition
         class="mt-4 p-4 bg-gray-50 rounded-md">
        <dl class="grid grid-cols-2 gap-2 text-sm">
            <dt class="font-semibold">Join Date:</dt>
            <dd>{{ $member->join_date->format('M d, Y') }}</dd>
            <dt class="font-semibold">Status:</dt>
            <dd>
                <span class="px-2 py-1 text-xs rounded-full 
                     {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($member->status) }}
                </span>
            </dd>
        </dl>
    </div>
</div>
```

---

## 🎨 Tailwind CSS Configuration

```javascript
// tailwind.config.js
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
        },
        secondary: {
          500: '#8b5cf6',
          600: '#7c3aed',
        }
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in',
        'slide-in': 'slideIn 0.3s ease-out',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
```

---

## 📝 JavaScript Architecture

### API Service Layer
```javascript
// resources/js/services/api.js
class ApiService {
    constructor() {
        this.baseURL = '/api/v1';
        this.token = localStorage.getItem('auth_token');
        this.headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        };
        
        if (this.token) {
            this.headers['Authorization'] = `Bearer ${this.token}`;
        }
    }
    
    async request(method, endpoint, data = null) {
        const config = {
            method: method,
            headers: this.headers
        };
        
        if (data && method !== 'GET') {
            config.body = JSON.stringify(data);
        }
        
        try {
            const response = await fetch(`${this.baseURL}${endpoint}`, config);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }
    
    get(endpoint) {
        return this.request('GET', endpoint);
    }
    
    post(endpoint, data) {
        return this.request('POST', endpoint, data);
    }
    
    put(endpoint, data) {
        return this.request('PUT', endpoint, data);
    }
    
    delete(endpoint) {
        return this.request('DELETE', endpoint);
    }
}

export default new ApiService();
```

### Alpine.js Component Example
```javascript
// resources/js/components/memberForm.js
document.addEventListener('alpine:init', () => {
    Alpine.data('memberForm', () => ({
        formData: {
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            date_of_birth: '',
            gender: '',
            member_status: 'active'
        },
        errors: {},
        loading: false,
        
        async submitForm() {
            this.loading = true;
            this.errors = {};
            
            try {
                const response = await api.post('/members', this.formData);
                
                if (response.status === 'success') {
                    window.location.href = '/members';
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    alert('An error occurred. Please try again.');
                }
            } finally {
                this.loading = false;
            }
        },
        
        clearErrors(field) {
            delete this.errors[field];
        }
    }));
});
```

### DataTable Component
```javascript
// resources/js/components/datatable.js
class DataTable {
    constructor(element, options = {}) {
        this.element = element;
        this.options = {
            searchable: true,
            sortable: true,
            paginate: true,
            perPage: 20,
            ...options
        };
        
        this.currentPage = 1;
        this.searchTerm = '';
        this.sortColumn = null;
        this.sortDirection = 'asc';
        
        this.init();
    }
    
    init() {
        this.renderControls();
        this.attachEventListeners();
        this.loadData();
    }
    
    renderControls() {
        const controls = document.createElement('div');
        controls.className = 'flex justify-between items-center mb-4';
        
        if (this.options.searchable) {
            controls.innerHTML += `
                <input type="text" 
                       placeholder="Search..." 
                       class="search-input px-4 py-2 border rounded-md">
            `;
        }
        
        if (this.options.paginate) {
            controls.innerHTML += `
                <div class="pagination flex space-x-2"></div>
            `;
        }
        
        this.element.parentNode.insertBefore(controls, this.element);
    }
    
    attachEventListeners() {
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', debounce((e) => {
                this.searchTerm = e.target.value;
                this.loadData();
            }, 300));
        }
        
        // Sort functionality
        this.element.querySelectorAll('th[data-sortable]').forEach(th => {
            th.classList.add('cursor-pointer', 'hover:bg-gray-100');
            th.addEventListener('click', () => {
                this.sort(th.dataset.column);
            });
        });
    }
    
    async loadData() {
        const params = new URLSearchParams({
            page: this.currentPage,
            per_page: this.options.perPage,
            search: this.searchTerm,
            sort_by: this.sortColumn,
            sort_order: this.sortDirection
        });
        
        try {
            const response = await fetch(`${this.options.endpoint}?${params}`);
            const data = await response.json();
            
            this.renderTable(data.data);
            this.renderPagination(data.pagination);
        } catch (error) {
            console.error('Error loading data:', error);
        }
    }
    
    renderTable(data) {
        const tbody = this.element.querySelector('tbody');
        tbody.innerHTML = data.map(row => this.options.rowTemplate(row)).join('');
    }
    
    renderPagination(pagination) {
        const container = document.querySelector('.pagination');
        if (!container) return;
        
        container.innerHTML = `
            <button class="px-3 py-1 border rounded" 
                    onclick="datatable.goToPage(${pagination.current_page - 1})"
                    ${