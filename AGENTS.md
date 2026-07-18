# Statera — Agent Guidelines

## Project

Statera is the unit testing kit for the Sukarix framework, built on top of
the Fat-Free Framework's `Test` class. It is a standalone, optional package
that applications can choose to use.

## Tech stack

- **PHP 8.2+**, strict types
- **Fat-Free Framework** — `\Test` base class
- **phpunit/php-code-coverage** — for Xdebug coverage reports only (not PHPUnit itself)

## Key classes

- `Sukarix\Statera` — test runner, coverage management, CLI/Web output
- `Sukarix\TestCase` — extends `\Test`, adds CLI output and source tracking
- `Sukarix\TestScenario` — base for test scenarios; provides `newTest()`, `expect()`, reroute helpers
- `Sukarix\TestGroup` — aggregates scenarios into a runnable group

## Code style

- Follow existing PSR-12 conventions.
- Keep the kit lightweight — it wraps F3's `Test`, not a full assertion library.

## Commits

- One logical change per commit (unitary commits).
- Author: Ghazi Triki <ghazi.triki@riadvice.com>
- Co-author trailer:
  ```
  Co-Authored-By: Devin <158243242+devin-ai-integration[bot]@users.noreply.github.com>
  ```
- Format:
  ```
  <short description>

  Generated with [Devin](https://devin.ai)

  Co-Authored-By: Devin <158243242+devin-ai-integration[bot]@users.noreply.github.com>
  ```
