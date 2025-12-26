# UI/UX Consistency Guide - Church Management System

**Last Updated**: December 3, 2025
**Version**: 1.0.0

---

## Table of Contents

1. [Design System Overview](#design-system-overview)
2. [Color Palette](#color-palette)
3. [Typography](#typography)
4. [Component Library](#component-library)
5. [Layout Structure](#layout-structure)
6. [Spacing System](#spacing-system)
7. [Animation & Transitions](#animation--transitions)
8. [Responsive Design](#responsive-design)
9. [Accessibility Guidelines](#accessibility-guidelines)
10. [Implementation Checklist](#implementation-checklist)

---

## Design System Overview

The Church Management System uses a modern, professional design system based on:
- **Primary Color**: Gradient Blue (#2563eb → #1d4ed8)
- **Accent Color**: Gold (#eab308 → #ca8a04)
- **Neutral**: White (#ffffff) with gray shades
- **Font**: Inter (sans-serif)
- **Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js for interactivity

### Design Principles

1. **Consistency**: All pages should use the same design tokens (colors, fonts, spacing)
2. **Simplicity**: Clean, uncluttered interfaces with clear hierarchy
3. **Accessibility**: WCAG 2.1 AA compliance for all components
4. **Responsiveness**: Mobile-first design approach
5. **Performance**: Fast page loads, optimized assets

---

## Color Palette

### Primary Colors

```css
/* Blue Gradient (Primary) */
primary-50:  #eff6ff
primary-100: #dbeafe
primary-200: #bfdbfe
primary-300: #93c5fd
primary-400: #60a5fa
primary-500: #3b82f6
primary-600: #2563eb  /* PRIMARY BASE */
primary-700: #1d4ed8  /* SECONDARY BASE */
primary-800: #1e40af
primary-900: #1e3a8a
primary-950: #172554
```

### Accent Colors

```css
/* Gold (Accent) */
accent-50:  #fefce8
accent-100: #fef9c3
accent-200: #fef08a
accent-300: #fde047
accent-400: #facc15
accent-500: #eab308  /* ACCENT BASE */
accent-600: #ca8a04  /* ACCENT DARK */
accent-700: #a16207
accent-800: #854d0e
accent-900: #713f12
accent-950: #422006
```

### Neutral Colors

```css
/* Grays & Whites */
neutral-50:  #f9fafb   /* Light backgrounds */
neutral-100: #f3f4f6
neutral-200: #e5e7eb   /* Borders */
neutral-300: #d1d5db
neutral-400: #9ca3af
neutral-500: #6b7280   /* Secondary text */
neutral-600: #4b5563
neutral-700: #374151
neutral-800: #1f2937
neutral-900: #111827   /* Primary text */
neutral-950: #030712
```

### Semantic Colors

```css
/* Success (Green) */
green-500: #22c55e
green-600: #16a34a

/* Danger (Red) */
red-500: #ef4444
red-600: #dc2626

/* Warning (Yellow) */
yellow-500: #eab308
yellow-600: #ca8a04

/* Info (Blue) */
blue-500: #3b82f6
blue-600: #2563eb
```

### Gradient Definitions

```css
/* Primary Gradient */
bg-gradient-primary: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)

/* Sidebar Gradient */
bg-gradient-sidebar: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%)

/* Gold Gradient */
bg-gradient-gold: linear-gradient(135deg, #eab308 0%, #ca8a04 100%)
```

### Usage Guidelines

- **Primary Blue**: Use for primary actions, navigation, key UI elements
- **Gold Accent**: Use for highlights, secondary actions, special features
- **Gray**: Use for text, borders, backgrounds
- **Green**: Success states, positive indicators
- **Red**: Errors, destructive actions, warnings
- **White**: Card backgrounds, content areas

---

## Typography

### Font Family

```css
font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif
```

**Import in HTML**:
```html
<link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
```

### Font Scales

```css
/* Headings */
h1: text-3xl md:text-4xl  (30px/36px → 36px/48px)
h2: text-2xl md:text-3xl  (24px/32px → 30px/36px)
h3: text-xl md:text-2xl   (20px/28px → 24px/32px)
h4: text-lg md:text-xl    (18px/24px → 20px/28px)

/* Body Text */
base:   text-base  (16px/24px)
sm:     text-sm    (14px/20px)
xs:     text-xs    (12px/16px)

/* Font Weights */
light:    font-light    (300)
normal:   font-normal   (400)
medium:   font-medium   (500)
semibold: font-semibold (600)
bold:     font-bold     (700)
```

### Text Usage

```html
<!-- Page Title -->
<h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard</h1>

<!-- Card Title -->
<h3 class="text-lg font-semibold text-gray-900">Recent Members</h3>

<!-- Section Header -->
<h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Quick Actions</h3>

<!-- Body Text -->
<p class="text-sm text-gray-600">Regular paragraph text</p>

<!-- Labels -->
<label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>

<!-- Captions -->
<p class="text-xs text-gray-500">Helper text or captions</p>
```

---

## Component Library

### Buttons

#### Primary Button
```html
<button class="btn btn-primary">
    <svg class="w-5 h-5 mr-2">...</svg>
    Save Changes
</button>
```
**CSS**: `bg-gradient-primary text-white hover:opacity-90`

#### Secondary Button
```html
<button class="btn btn-secondary">Cancel</button>
```
**CSS**: `bg-white text-gray-900 border border-gray-200 hover:bg-gray-50`

#### Accent Button
```html
<button class="btn btn-accent">Special Action</button>
```
**CSS**: `bg-gradient-gold text-white hover:opacity-90`

#### Outline Button
```html
<button class="btn btn-outline">View Details</button>
```
**CSS**: `border-2 border-primary-600 text-primary-600 hover:bg-primary-50`

#### Danger Button
```html
<button class="btn btn-danger">Delete</button>
```
**CSS**: `bg-red-600 text-white hover:bg-red-700`

#### Button Sizes
```html
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Default</button>
<button class="btn btn-primary btn-lg">Large</button>
```

---

### Cards

#### Basic Card
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Card Title</h3>
        <a href="#" class="text-sm text-primary-600">View All</a>
    </div>
    <div class="card-body">
        <!-- Card content -->
    </div>
</div>
```

**CSS**: `bg-white rounded-xl shadow-sm border border-gray-100 p-6`

#### Stat Card
```html
<div class="stat-card">
    <div class="stat-value">1,234</div>
    <div class="stat-label">Total Members</div>
</div>
```

**Variants**:
- `stat-card-gradient-blue` - Blue gradient background
- `stat-card-gradient-green` - Green gradient background
- `stat-card-gradient-gold` - Gold gradient background

---

### Forms

#### Input Field
```html
<div>
    <label for="email" class="form-label">Email Address</label>
    <input type="email" id="email" class="form-input" placeholder="john@example.com">
    <p class="form-error">This field is required</p>
</div>
```

#### Select Dropdown
```html
<select class="form-select">
    <option>Option 1</option>
    <option>Option 2</option>
</select>
```

#### Textarea
```html
<textarea class="form-textarea" rows="4"></textarea>
```

#### Checkbox
```html
<input type="checkbox" class="form-checkbox">
```

#### Required Field Indicator
```html
<label class="form-label required">First Name</label>
```
Add `.required::after { content: ' *'; color: red; }` in CSS

---

### Badges

```html
<span class="badge badge-primary">Active</span>
<span class="badge badge-accent">Featured</span>
<span class="badge badge-success">Completed</span>
<span class="badge badge-warning">Pending</span>
<span class="badge badge-danger">Cancelled</span>
```

---

### Alerts

```html
<!-- Success Alert -->
<div class="alert-success">
    <svg class="w-5 h-5">...</svg>
    <span>Operation completed successfully!</span>
</div>

<!-- Error Alert -->
<div class="alert-error">
    <svg class="w-5 h-5">...</svg>
    <span>An error occurred. Please try again.</span>
</div>

<!-- Warning Alert -->
<div class="alert-warning">
    <svg class="w-5 h-5">...</svg>
    <span>Please review your changes before submitting.</span>
</div>

<!-- Info Alert -->
<div class="alert-info">
    <svg class="w-5 h-5">...</svg>
    <span>New features are available. Check them out!</span>
</div>
```

---

### Tables

```html
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td><span class="badge badge-success">Active</span></td>
                <td>
                    <button class="btn btn-sm btn-outline">Edit</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

---

### Navigation

#### Sidebar Link
```html
<!-- Active Link -->
<a class="nav-link-active" href="#">
    <svg class="w-5 h-5">...</svg>
    <span class="mx-3 font-medium">Dashboard</span>
</a>

<!-- Inactive Link -->
<a class="nav-link" href="#">
    <svg class="w-5 h-5">...</svg>
    <span class="mx-3">Members</span>
</a>
```

#### Collapsible Section (Alpine.js)
```html
<div x-data="{ open: false }">
    <button @click="open = !open" class="sidebar-section-header">
        <span>Member Management</span>
        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform">...</svg>
    </button>
    <div x-show="open" x-collapse class="mt-2 space-y-1">
        <!-- Submenu items -->
    </div>
</div>
```

---

## Layout Structure

### Main Layout (`layouts/app.blade.php`)

```
┌─────────────────────────────────────────────┐
│            Sidebar (Fixed Left)             │
│                                             │
│  ┌───────────────────────────────────────┐ │
│  │         Navbar (Top Bar)              │ │
│  ├───────────────────────────────────────┤ │
│  │                                       │ │
│  │      Main Content Area                │ │
│  │      (Scrollable)                     │ │
│  │                                       │ │
│  │      px-6 py-8 bg-gray-100            │ │
│  │                                       │ │
│  ├───────────────────────────────────────┤ │
│  │         Footer                        │ │
│  └───────────────────────────────────────┘ │
└─────────────────────────────────────────────┘
```

### Sidebar
- **Width**: `w-64` (256px)
- **Position**: Fixed left on desktop, overlay on mobile
- **Background**: `bg-gradient-sidebar` (blue gradient)
- **Text**: White (`text-white`)
- **Scrollable**: `overflow-y-auto`

### Main Content
- **Margin**: `lg:ml-64` (offset for sidebar on desktop)
- **Padding**: `px-6 py-8` (24px horizontal, 32px vertical)
- **Background**: `bg-gray-100`

### Page Header
```html
<div class="page-header">
    <div>
        <h1 class="page-title">Members</h1>
        <nav class="breadcrumb">
            <a href="#">Dashboard</a>
            <span>/</span>
            <span>Members</span>
        </nav>
    </div>
    <div class="page-actions">
        <button class="btn btn-primary">Add New</button>
    </div>
</div>
```

---

## Spacing System

### Margin & Padding Scale

```css
0:   0px
1:   4px
2:   8px
3:   12px
4:   16px
5:   20px
6:   24px    /* Preferred for containers */
8:   32px    /* Preferred for sections */
10:  40px
12:  48px
16:  64px
```

### Common Spacing Patterns

```html
<!-- Container Padding -->
<div class="px-6 py-8">...</div>

<!-- Card Padding -->
<div class="p-5">...</div>
<div class="p-6">...</div>

<!-- Gap Between Elements -->
<div class="gap-4">...</div>   <!-- 16px -->
<div class="gap-6">...</div>   <!-- 24px -->

<!-- Margin Between Sections -->
<div class="mb-6">...</div>    <!-- 24px -->
<div class="mb-8">...</div>    <!-- 32px -->

<!-- Grid Gaps -->
<div class="grid grid-cols-3 gap-6">...</div>
```

---

## Animation & Transitions

### Transition Classes

```css
/* Default Transition */
transition-all duration-200

/* Color Transitions */
transition-colors duration-200

/* Transform Transitions */
transition-transform duration-300

/* Opacity Transitions */
transition-opacity duration-150
```

### Common Animations

```html
<!-- Fade In -->
<div class="animate-fade-in">...</div>

<!-- Fade In Up -->
<div class="animate-fade-in-up">...</div>

<!-- Slide In -->
<div class="animate-slide-in">...</div>

<!-- Scale In -->
<div class="animate-scale-in">...</div>
```

### Alpine.js Transitions

```html
<div x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-1">
    ...
</div>
```

---

## Responsive Design

### Breakpoints

```css
sm:  640px   /* Small tablets */
md:  768px   /* Tablets */
lg:  1024px  /* Laptops */
xl:  1280px  /* Desktops */
2xl: 1536px  /* Large desktops */
```

### Grid Patterns

```html
<!-- 1 Column on Mobile, 2 on Tablet, 4 on Desktop -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">...</div>

<!-- Responsive Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">...</div>

<!-- Full Width on Mobile, Sidebar on Desktop -->
<div class="w-full lg:w-64">...</div>
```

### Mobile Sidebar

```html
<!-- Sidebar Hidden on Mobile, Fixed on Desktop -->
<aside class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gradient-sidebar lg:translate-x-0 lg:static">
    ...
</aside>

<!-- Mobile Overlay -->
<div x-show="sidebarOpen"
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 lg:hidden">
</div>
```

---

## Accessibility Guidelines

### Color Contrast

- **Text on White**: Use `text-gray-900` (21:1 contrast)
- **Text on Primary**: Use white text (4.5:1+ contrast)
- **Links**: Use `text-primary-600` with underline on hover
- **Disabled States**: 50% opacity

### Keyboard Navigation

- All interactive elements must be keyboard accessible
- Focus states: `focus:outline-none focus:ring-2 focus:ring-primary-500`
- Tab order should follow visual layout

### ARIA Labels

```html
<!-- Button with icon only -->
<button aria-label="Delete member">
    <svg>...</svg>
</button>

<!-- Form inputs -->
<label for="email">Email</label>
<input id="email" type="email" aria-required="true">

<!-- Status indicators -->
<span class="badge badge-success" role="status">Active</span>
```

### Screen Reader Text

```html
<span class="sr-only">Loading...</span>
```

---

## Implementation Checklist

### For Every New Page

- [ ] Extends `layouts.app`
- [ ] Uses `@section('title', 'Page Title')`
- [ ] Includes page header with breadcrumb
- [ ] Uses consistent card styling (`rounded-xl shadow-sm border border-gray-100`)
- [ ] Uses consistent button classes (`.btn-primary`, `.btn-secondary`, etc.)
- [ ] Uses consistent spacing (`px-6 py-8` for containers, `gap-6` for grids)
- [ ] Uses Inter font throughout
- [ ] Uses primary blue and gold accent colors
- [ ] Includes responsive grid classes (`grid-cols-1 md:grid-cols-2 lg:grid-cols-4`)
- [ ] Includes hover states on interactive elements
- [ ] Includes focus states for keyboard navigation
- [ ] Includes proper ARIA labels where needed
- [ ] Mobile-responsive (sidebar collapses, grids stack)

### Component Consistency

- [ ] All buttons use `.btn` + variant classes
- [ ] All cards use `.card` with `rounded-xl shadow-sm border border-gray-100`
- [ ] All forms use `.form-input`, `.form-select`, `.form-label`
- [ ] All tables use `.table-container` and `.table`
- [ ] All badges use `.badge` + color variant
- [ ] All alerts use `.alert-success`, `.alert-error`, etc.

### Color Consistency

- [ ] Primary actions use blue gradient (`bg-gradient-primary`)
- [ ] Secondary actions use white/gray (`bg-white border border-gray-200`)
- [ ] Accent features use gold gradient (`bg-gradient-gold`)
- [ ] Success states use green (`text-green-600`, `bg-green-50`)
- [ ] Error states use red (`text-red-600`, `bg-red-50`)
- [ ] Text uses gray-900 for primary, gray-600 for secondary, gray-500 for tertiary

### Animation Consistency

- [ ] Buttons have `transition-all duration-200`
- [ ] Cards have `hover:shadow-md transition-shadow`
- [ ] Links have `transition-colors`
- [ ] Dropdowns use Alpine.js `x-transition` with consistent timings

---

## Example: Complete Page Structure

```blade
@extends('layouts.app')

@section('title', 'Members')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Members</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Members</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('members.statistics') }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2">...</svg>
            Statistics
        </a>
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2">...</svg>
            Add New Member
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-value">1,234</div>
        <div class="stat-label">Total Members</div>
    </div>
    <!-- More stat cards -->
</div>

<!-- Main Content Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Members</h3>
        <button class="btn btn-sm btn-outline">Export</button>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>{{ $member->full_name }}</td>
                        <td>{{ $member->email }}</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>
                            <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-outline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
```

---

## Design Tokens Reference

### Quick Copy/Paste

```css
/* Primary Colors */
primary: #2563eb
secondary: #1d4ed8
accent: #eab308

/* Backgrounds */
bg-gray-50: #f9fafb
bg-gray-100: #f3f4f6
bg-white: #ffffff

/* Text Colors */
text-gray-900: #111827  (Primary text)
text-gray-600: #4b5563  (Secondary text)
text-gray-500: #6b7280  (Tertiary text)

/* Border Colors */
border-gray-100: #f3f4f6
border-gray-200: #e5e7eb

/* Shadows */
shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05)
shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1)
shadow-blue: 0 4px 14px 0 rgba(37, 99, 235, 0.25)
shadow-gold: 0 4px 14px 0 rgba(234, 179, 8, 0.25)

/* Border Radius */
rounded-lg: 8px
rounded-xl: 12px
rounded-full: 9999px

/* Spacing */
Container: px-6 py-8  (24px, 32px)
Card: p-5 or p-6  (20px or 24px)
Gap: gap-4 or gap-6  (16px or 24px)
```

---

## Conclusion

This guide ensures consistent UI/UX across all pages of the Church Management System. All developers should reference this document when creating new pages or modifying existing ones to maintain design consistency.

**Key Takeaways**:
1. Use the component classes defined in `app.css` (`.btn`, `.card`, `.form-input`, etc.)
2. Stick to the color palette (primary blue, accent gold, neutral grays)
3. Use Inter font throughout
4. Maintain consistent spacing (px-6 py-8 for containers, gap-6 for grids)
5. Ensure mobile responsiveness with Tailwind's responsive classes
6. Add hover/focus states to all interactive elements
7. Use Alpine.js for simple interactivity (dropdowns, modals, collapsibles)

---

**Questions or Suggestions?**
Contact the development team or create an issue in the repository.
