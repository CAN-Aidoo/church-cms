# Contributing to Church Management System

First off, thank you for considering contributing to the Church Management System! It's people like you that make this project such a great tool for churches worldwide.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Process](#development-process)
- [Pull Request Process](#pull-request-process)
- [Coding Standards](#coding-standards)
- [Testing Guidelines](#testing-guidelines)
- [Documentation](#documentation)
- [Community](#community)

---

## Code of Conduct

### Our Pledge

We pledge to make participation in our project a harassment-free experience for everyone, regardless of age, body size, disability, ethnicity, gender identity, level of experience, nationality, personal appearance, race, religion, or sexual identity and orientation.

### Our Standards

**Examples of behavior that contributes to creating a positive environment include:**
- Using welcoming and inclusive language
- Being respectful of differing viewpoints and experiences
- Gracefully accepting constructive criticism
- Focusing on what is best for the community
- Showing empathy towards other community members

**Examples of unacceptable behavior include:**
- The use of sexualized language or imagery
- Trolling, insulting/derogatory comments, and personal or political attacks
- Public or private harassment
- Publishing others' private information without explicit permission
- Other conduct which could reasonably be considered inappropriate

---

## Getting Started

### Prerequisites

Before you begin, ensure you have:
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- NPM >= 9.x
- Git
- A code editor (VS Code recommended)

### Fork and Clone

1. Fork the repository on GitHub
2. Clone your fork locally:
```bash
git clone https://github.com/YOUR-USERNAME/church-cms.git
cd church-cms
```

3. Add the upstream repository:
```bash
git remote add upstream https://github.com/original-org/church-cms.git
```

### Initial Setup

1. Install dependencies:
```bash
composer install
npm install
```

2. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

3. Create test database:
```bash
mysql -u root -p
CREATE DATABASE church_management_test;
EXIT;
```

4. Run migrations:
```bash
php artisan migrate --seed
```

5. Start development server:
```bash
php artisan serve
npm run dev
```

---

## Development Process

### Branch Naming Convention

- **Feature**: `feature/feature-name`
- **Bug Fix**: `bugfix/bug-description`
- **Hotfix**: `hotfix/issue-description`
- **Documentation**: `docs/what-changed`
- **Refactor**: `refactor/what-was-refactored`

Examples:
```bash
git checkout -b feature/add-visitor-analytics
git checkout -b bugfix/fix-attendance-calculation
git checkout -b docs/update-api-documentation
```

### Workflow

1. **Create a branch** from `main`:
```bash
git checkout main
git pull upstream main
git checkout -b feature/your-feature-name
```

2. **Make your changes** following our coding standards

3. **Write tests** for your changes

4. **Run tests** to ensure nothing breaks:
```bash
php artisan test
vendor/bin/pint  # Code style check
```

5. **Commit your changes** with clear, descriptive messages:
```bash
git add .
git commit -m "Add visitor analytics dashboard

- Created analytics service
- Added dashboard view
- Implemented daily/weekly/monthly stats
- Added tests for analytics service"
```

6. **Keep your branch updated**:
```bash
git fetch upstream
git rebase upstream/main
```

7. **Push to your fork**:
```bash
git push origin feature/your-feature-name
```

8. **Create a Pull Request** on GitHub

---

## Pull Request Process

### Before Submitting

- [ ] Code follows our coding standards
- [ ] Tests pass locally (`php artisan test`)
- [ ] Code style is correct (`vendor/bin/pint`)
- [ ] Documentation is updated (if applicable)
- [ ] Commit messages are clear and descriptive
- [ ] Branch is up-to-date with `main`

### PR Template

When creating a PR, use this template:

```markdown
## Description
Brief description of what this PR does.

## Type of Change
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] New feature (non-breaking change which adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] Documentation update

## Related Issue
Fixes #(issue number)

## Changes Made
- Change 1
- Change 2
- Change 3

## Testing Done
- [ ] Unit tests added/updated
- [ ] Feature tests added/updated
- [ ] Manual testing performed
- [ ] All tests pass

## Screenshots (if applicable)
Add screenshots here

## Checklist
- [ ] My code follows the project's coding standards
- [ ] I have commented my code, particularly in hard-to-understand areas
- [ ] I have made corresponding changes to the documentation
- [ ] My changes generate no new warnings
- [ ] I have added tests that prove my fix is effective or that my feature works
- [ ] New and existing unit tests pass locally with my changes
```

### Review Process

1. **Automated Checks**: CI/CD will run tests and code style checks
2. **Code Review**: At least one maintainer will review your PR
3. **Feedback**: Address any feedback from reviewers
4. **Approval**: Once approved, a maintainer will merge your PR

---

## Coding Standards

### PHP Standards

We follow **PSR-12** coding standards. Use Laravel Pint to check:

```bash
vendor/bin/pint
```

### Laravel Best Practices

#### Controllers
- Keep controllers thin
- Delegate business logic to Services
- Use Form Requests for validation
- Return JSON responses for API endpoints

```php
// Good
class MemberController extends Controller
{
    public function __construct(
        private MemberService $memberService
    ) {}

    public function store(StoreMemberRequest $request)
    {
        $member = $this->memberService->create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $member
        ], 201);
    }
}

// Bad - Business logic in controller
class MemberController extends Controller
{
    public function store(Request $request)
    {
        $member = new Member();
        $member->name = $request->name;
        $member->email = $request->email;
        // ... lots of business logic here
        $member->save();

        return response()->json($member);
    }
}
```

#### Services
- All business logic goes in Services
- Services should be testable
- Use dependency injection

```php
class MemberService
{
    public function __construct(
        private MemberRepository $memberRepository,
        private NotificationService $notificationService
    ) {}

    public function create(array $data): Member
    {
        DB::transaction(function() use ($data) {
            $member = $this->memberRepository->create($data);
            $this->assignToShepherd($member);
            $this->notificationService->sendWelcomeMessage($member);

            return $member;
        });
    }
}
```

#### Repositories
- Abstract database queries
- Use Eloquent query builder
- Implement caching where appropriate

```php
class MemberRepository
{
    public function findActive(): Collection
    {
        return Cache::remember('members.active', 300, function() {
            return Member::where('status', 'active')
                ->with(['shepherd', 'serviceUnits'])
                ->get();
        });
    }
}
```

### JavaScript Standards

- Use ES6+ syntax
- Prefer `const` over `let`, avoid `var`
- Use arrow functions where appropriate
- Comment complex logic

```javascript
// Good
const fetchMembers = async () => {
    try {
        const response = await ChurchApp.apiCall('/api/v1/members', 'GET');
        if (response.success) {
            renderMembers(response.data);
        }
    } catch (error) {
        console.error('Failed to fetch members:', error);
    }
};

// Bad
function fetchMembers() {
    var url = '/api/v1/members';
    $.get(url, function(data) {
        // ...
    });
}
```

### Database Migrations

- Never modify existing migrations in production
- Use descriptive names
- Include rollback logic
- Add comments for complex changes

```php
public function up()
{
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        $table->string('full_name');
        $table->string('email')->unique()->nullable();
        $table->string('phone', 20)->unique();
        // ... more columns

        // Foreign keys
        $table->foreignId('shepherd_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete()
            ->comment('Shepherd assigned to this member');

        $table->timestamps();
        $table->softDeletes();

        // Indexes
        $table->index(['status', 'created_at']);
    });
}

public function down()
{
    Schema::dropIfExists('members');
}
```

---

## Testing Guidelines

### Writing Tests

All new features and bug fixes **must** include tests.

#### Unit Tests

Test individual components in isolation:

```php
namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\MemberService;

class MemberServiceTest extends TestCase
{
    public function test_can_calculate_attendance_rate()
    {
        $memberService = new MemberService();

        $rate = $memberService->calculateAttendanceRate(
            totalServices: 10,
            attended: 8
        );

        $this->assertEquals(80.0, $rate);
    }
}
```

#### Feature Tests

Test complete user workflows:

```php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class MemberManagementTest extends TestCase
{
    public function test_admin_can_create_member()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->post('/api/v1/members', [
                'full_name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+233201234567',
                'status' => 'active'
            ]);

        $response->assertStatus(201)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('members', [
            'email' => 'john@example.com'
        ]);
    }
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/MemberManagementTest.php

# Run with coverage
php artisan test --coverage

# Run specific test method
php artisan test --filter test_admin_can_create_member
```

---

## Documentation

### Code Comments

- Comment **why**, not **what**
- Use PHPDoc blocks for classes and methods
- Keep comments up-to-date

```php
/**
 * Calculate the attendance rate for a member.
 *
 * This uses the committed threshold (80%) to determine
 * if a member is considered "committed" vs "regular"
 * based on their attendance pattern.
 *
 * @param int $totalServices Total services in period
 * @param int $attended Number of services attended
 * @return float Attendance rate as percentage
 */
public function calculateAttendanceRate(int $totalServices, int $attended): float
{
    if ($totalServices === 0) {
        return 0.0;
    }

    return round(($attended / $totalServices) * 100, 2);
}
```

### Updating Documentation

If your changes affect:
- **API**: Update `SKILL.md`
- **User features**: Update `USER_GUIDE.md`
- **Installation/setup**: Update `README.md`
- **Breaking changes**: Update `CHANGELOG.md`

---

## Security

### Reporting Vulnerabilities

**Do NOT create a public GitHub issue for security vulnerabilities.**

Instead, email security@yourchurch.com with:
- Description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)

We will respond within 48 hours.

### Security Best Practices

- Never commit secrets (API keys, passwords) to the repository
- Use environment variables for sensitive configuration
- Validate and sanitize all user input
- Use prepared statements (Eloquent does this automatically)
- Follow OWASP guidelines

---

## Communication

### Where to Get Help

- **Questions**: [GitHub Discussions](https://github.com/your-org/church-cms/discussions)
- **Bug Reports**: [GitHub Issues](https://github.com/your-org/church-cms/issues)
- **Chat**: [Discord Server](#) (if available)
- **Email**: developers@yourchurch.com

### Issue Reporting

When reporting issues, include:
- Clear, descriptive title
- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)
- Environment (PHP version, Laravel version, OS)
- Error messages and stack traces

---

## Recognition

Contributors will be:
- Listed in `CONTRIBUTORS.md`
- Mentioned in release notes
- Given credit in relevant documentation

---

## Questions?

If you have any questions about contributing, please:
1. Check existing documentation
2. Search GitHub Discussions
3. Ask in our chat (if available)
4. Email us at developers@yourchurch.com

---

**Thank you for contributing to the Church Management System!** 🎉

Your efforts help churches worldwide operate more efficiently and serve their communities better.

---

**Last Updated**: December 28, 2025
