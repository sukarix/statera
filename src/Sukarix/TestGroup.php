<?php

declare(strict_types=1);

namespace Sukarix;

class TestGroup
{
    protected $classes = [];

    protected $quiet = false;

    /**
     * @param $f3 \Base
     *
     * @return array
     */
    public function run($f3)
    {
        if ($this->quiet) {
            $f3->set('QUIET', true);
        }
        $results = [];
        foreach ($this->classes as $class) {
            /** @var TestScenario $object */
            $object  = new $class();
            $results = array_merge($results, $object->run($f3));
        }
        if ($this->quiet) {
            $f3->set('QUIET', false);
        }

        return $results;
    }
}
