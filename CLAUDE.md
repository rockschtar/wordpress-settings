# Project Notes

## CLI Commands

Always use Lando for all CLI commands:

```bash
# PHP / Composer
lando composer --working-dir=/app/plugin <args>
lando composer --working-dir=/app/plugin run test

# PHPCS
lando phpcs
lando phpcbf   # auto-fix

# Node / npm
lando npm <args>
lando node <args>
lando npx <args>
```

Do NOT run `composer`, `vendor/bin/phpcs`, `vendor/bin/phpunit`, `npm`, or `node` directly outside of Lando.

## Coding Standards

All PHP code in `src/` must pass **PSR-12** as configured in `phpcs.xml`. Run PHPCS before finishing any PHP task:

```bash
lando phpcs
```

Key PSR-12 rules that are commonly violated:
- 4-space indentation (no tabs)
- Opening braces for classes and methods on the same line for control structures, own line for declarations
- One blank line between methods
- Visibility (`public`/`protected`/`private`) required on all methods and properties
- No trailing whitespace
- `declare(strict_types=1)` is not required by PSR-12 but preferred in this project
