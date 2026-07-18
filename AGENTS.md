# Statera

Open-source unit testing kit for the Sukarix framework, built on F3's `Test` class.
MIT licensed. Standalone, optional. Contributions welcome.

## Quick start

```bash
composer install
```

## Tech stack

- PHP 8.2+, strict types
- Fat-Free Framework — `\Test` base class
- `phpunit/php-code-coverage` — for Xdebug coverage reports only (not PHPUnit itself)

## Key classes

- `Sukarix\Statera` — test runner, coverage management, CLI/Web output
- `Sukarix\TestCase` — extends `\Test`, adds CLI output and source tracking
- `Sukarix\TestScenario` — base for test scenarios; provides `newTest()`, `expect()`, reroute helpers
- `Sukarix\TestGroup` — aggregates scenarios into a runnable group

## Writing tests

```php
$test = $this->newTest();
$test->expect($condition, 'message');
return $test->results();
```

For exceptions: use try/catch with `expect($threw, '...')` — Statera has no `expectException`.

## Conventions

- `declare(strict_types=1)` in every file
- Keep the kit lightweight — it wraps F3's `Test`, not a full assertion library

## AI usage

This project is developed with AI assistance (Devin, GitHub Copilot, and others).
AI-generated contributions are welcome and should follow the same conventions as human contributions.

## Commits

One logical change per commit.

```
<description>

Co-Authored-By: Devin
```
