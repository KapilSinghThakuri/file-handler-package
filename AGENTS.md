# AGENTS.md

## Package Info
- **Name**: `kapil/file-handler`
- **Namespace**: `Kapil\FileHandler`
- **Entry points**: `src/FileHandler.php`, `src/FileHandlerServiceProvider.php`, `src/FileHandlerFacade.php`

## Commands
```bash
composer test          # Run PHPUnit
composer test-coverage # Run with coverage report
```

## Test structure
- Uses Orchestra Testbench for Laravel package testing
- Tests live in `tests/Feature/` and `tests/Unit/`
- Base test class: `tests/TestCase.php` (extends Orchestra Testbench's `TestCase`)

## Code style
- StyleCI config at `.styleci.yml` uses `laravel` preset with `single_class_element_per_statement` disabled
- PSR-2 coding standard (per CONTRIBUTING.md)

## CI quirks
- Workflow (`main.yml`) tests PHP 7.4/8.0, but `composer.json` requires PHP ^8.2 (verify compatibility if modifying)

## Dependencies
- `illuminate/support`: ^10.0|^11.0
- `orchestra/testbench`: ^8.0|^9.0 (dev)
- `phpunit/phpunit`: ^10.0 (dev)