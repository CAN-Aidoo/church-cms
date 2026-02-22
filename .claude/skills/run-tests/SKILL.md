---
name: run-tests
description: Run the PHPUnit test suite for the Church CMS. Use after making code changes to verify nothing is broken, or when the user asks to run tests.
allowed-tools: Bash(vendor/bin/phpunit *)
---

Run the PHPUnit test suite:

1. If `$ARGUMENTS` is provided, run: `vendor/bin/phpunit $ARGUMENTS`
   - Examples: `tests/Feature/AttendanceTest.php`, `--filter testSelfReport`
2. If no argument is given, run the full suite: `vendor/bin/phpunit`

After running:
- Report the total pass/fail/skip counts
- For any failures, show the test method name, the file and line number, and the assertion that failed
- If there are failures, read the failing test file and the code under test to identify the likely cause
- Suggest a fix if the cause is clear
