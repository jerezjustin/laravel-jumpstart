# Continuous Integration (CI)

This project uses GitHub Actions for continuous integration to ensure code quality and catch issues early.

## Workflows

### CI Workflow (`.github/workflows/ci.yml`)

Runs on every push and pull request to `main` and `develop` branches.

#### Jobs

1. **Code Quality Checks**
   - Runs typo checks with Peck
   - Runs static analysis with PHPStan (Larastan)
   - Checks code style with Laravel Pint
   - Validates refactoring rules with Rector

2. **Tests**
   - Runs the full test suite with Pest
   - Tests against multiple PHP versions (8.4, 8.5)
   - Uses parallel test execution for speed

3. **Coverage**
   - Generates code coverage reports
   - Enforces minimum 80% coverage threshold

### Security Workflow (`.github/workflows/security.yml`)

Runs on:
- Every push and pull request to `main` and `develop` branches
- Weekly schedule (Sundays at midnight)

Performs security audits using Composer to check for known vulnerabilities in dependencies.

## Running Locally

You can run the same checks locally before pushing:

### All Checks
```bash
vendor/bin/sail composer run check
```

### Individual Checks
```bash
# Typo check
vendor/bin/sail composer run test:typos

# Static analysis
vendor/bin/sail composer run test:types

# Code style check
vendor/bin/sail composer run test:lint

# Refactoring check
vendor/bin/sail composer run test:refactor

# Tests
vendor/bin/sail artisan test --parallel

# Tests with coverage
vendor/bin/sail composer run test:coverage
```

### Fixing Issues

```bash
# Fix code style issues
vendor/bin/sail composer run lint

# Apply refactoring suggestions
vendor/bin/sail composer run refactor
```

## CI Status Badges

The README includes badges showing the current status of:
- CI pipeline (code quality and tests)
- Security audit

## Tips

- Run `composer run check` before committing to catch issues early
- The CI uses the same commands as your local environment for consistency
- Failed checks will prevent merging pull requests
- Coverage reports help identify untested code
