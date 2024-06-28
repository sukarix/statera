<?php

declare(strict_types=1);

namespace Sukarix;

use Sukarix\Utils\CliUtils;

/**
 * @internal
 *
 * @coversNothing
 */
final class TestCase extends \Test
{
    /**
     * Text represented group of tests.
     *
     * @var string
     */
    protected $group = '';

    public function expect($cond, $text = null)
    {
        $result = parent::expect($cond, $text);
        if (\PHP_SAPI === 'cli') {
            usleep(1000);
        }

        foreach (debug_backtrace() as $frame) {
            if (isset($frame['file'])) {
                $result->data[0]['source'] = \Base::instance()->
                    fixslashes($frame['file']) . ':' . $frame['line'];

                break;
            }
        }

        CliUtils::instance()->writeTestResult(end($result->data), $this->group);

        return $result;
    }

    /**
     * @param string $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }
}
