/**
 * Member Portal Module - Self-service features for members
 */
class MemberPortal {
    constructor(options = {}) {
        this.profileEndpoint = '/api/v1/my/profile';
        this.attendanceEndpoint = '/api/v1/my/attendance';
        this.contributionsEndpoint = '/api/v1/my/contributions';
        this.programsEndpoint = '/api/v1/my/programs';
        this.ministryEndpoint = '/api/v1/my/ministry';
        
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.headers = { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
        if (this.csrfToken) this.headers['X-CSRF-TOKEN'] = this.csrfToken;
        
        this.init();
    }
    
    async init() {
        await this.loadProfile();
        this.setupEventListeners();
    }
    
    async loadProfile() {
        const response = await fetch(this.profileEndpoint, { headers: this.headers });
        const data = await response.json();
        this.memberData = data.member;
        this.renderProfile(data.member);
    }
    
    renderProfile(member) {
        console.log('Member loaded:', member.full_name);
    }
    
    setupEventListeners() {
        document.querySelectorAll('[data-section]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.loadSection(e.currentTarget.dataset.section);
            });
        });
    }
    
    async loadSection(section) {
        console.log('Loading section:', section);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('member-portal')) {
        window.memberPortal = new MemberPortal();
    }
});
