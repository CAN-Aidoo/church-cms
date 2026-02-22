---
name: commit
description: Write and create a conventional git commit for staged or modified changes. Use when the user asks to commit, save changes, or finalize work.
allowed-tools: Bash(git diff *), Bash(git status *), Bash(git add *), Bash(git commit *)
---

Create a git commit following conventional commits format:

1. Run `git status` to see what's changed
2. Run `git diff --staged` (and `git diff` if nothing staged) to read the actual changes
3. Analyse the changes to determine:
   - **Type**: `feat` (new feature), `fix` (bug fix), `refactor` (restructure), `style` (formatting), `test` (tests), `docs` (docs), `chore` (config/build)
   - **Scope**: the module affected, e.g. `mobile`, `attendance`, `finance`, `auth`, `qr`
   - **Subject**: imperative, max 72 chars, no period
4. If `$ARGUMENTS` is provided, use it as the commit message instead of writing one
5. Stage relevant files with `git add` if nothing is staged (avoid staging `.env`, `*.log`, or sensitive files)
6. Create the commit:

```
git commit -m "$(cat <<'EOF'
type(scope): subject line

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>
EOF
)"
```

7. Confirm the commit was created with `git log --oneline -1`
