---
name: pint
description: Format PHP code using Laravel Pint (PSR-12). Run after writing or editing PHP files to ensure code style compliance.
allowed-tools: Bash(vendor/bin/pint *)
---

Format PHP files using Laravel Pint:

1. If `$ARGUMENTS` is provided (a file path or directory), run: `vendor/bin/pint $ARGUMENTS`
2. If no argument is given, format the entire project: `vendor/bin/pint`

After formatting:
- Report how many files were changed
- If files were changed, summarise which files were reformatted
- Do NOT show a diff unless the user asks
