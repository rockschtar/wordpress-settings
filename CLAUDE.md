# Project Notes

## CLI Commands

Always use Lando for all CLI commands:

```bash
# PHP / Composer
lando composer --working-dir=/app/plugin <args>
lando composer --working-dir=/app/plugin run test

# Node / npm
lando npm <args>
lando node <args>
lando npx <args>
```

Do NOT run `composer`, `vendor/bin/phpunit`, `npm`, or `node` directly outside of Lando.
