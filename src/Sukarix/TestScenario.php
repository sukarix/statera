<?php

declare(strict_types=1);

namespace Sukarix;

use SebastianBergmann\CodeCoverage\CodeCoverage;

class TestScenario
{
    protected $group = 'Test Scenario';

    /**
     * @param mixed $f3
     *
     * @throws \ReflectionException
     */
    public function run($f3): array
    {
        /**
         * @var CodeCoverage $coverage
         */
        $class   = new \ReflectionClass($this);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        $results = [];
        foreach ($methods as $method) {
            // Select methods starting by test and run them
            if (preg_match('/^test/i', $method->name)) {
                $humanisedMethodName = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', str_replace('test', '', $method->name));
                Statera::startCoverage($this->group . ' :: ' . $humanisedMethodName);
                $results = array_merge($results, \call_user_func_array([$this, $method->name], [$f3]));
                Statera::stopCoverage();
            }
        }

        return [$this->group => $results];
    }

    public function responseHasFlash($response, $text, $type): bool
    {
        return 1 === preg_match('/{text:"' . $text . '", type: "' . $type . '"}/', $response, $matches);
    }

    public function uploadImage($name, $file): string
    {
        // Put the file in the magic variable
        $_FILES = [
            $name => [
                'name'     => $fileName = uniqid($name, false) . '.jpg',
                'type'     => 'image/jpg',
                'size'     => filesize($file),
                'tmp_name' => $file,
                'error'    => 0,
            ],
        ];

        return $fileName;
    }

    /**
     * @return \Test
     */
    protected function newTest()
    {
        // We logout any existing user if there is anyone to force flushing session data
        \Base::instance()->clear('utest.rerouted');
        \Base::instance()->clear('form_errors');
        \Base::instance()->clear('data');
        \Base::instance()->clear('cdn_render');
        \Base::instance()->clear('utest.headers');
        // @fixme: to be activated Base::instance()->mock('GET /logout');
        \Base::instance()->set('utest.number', $this->currentTestNumber() + 1);
        $this->resetErrorHandler();

        $test = new UnitTest();
        $test->setGroup($this->group);

        return $test;
    }

    protected function resetErrorHandler(): void
    {
        $f3 = \Base::instance();

        // Remove error handler in unit test mode
        $f3->set('ONERROR', static function() use ($f3): void {
            // Never use $f3->clear('ERROR'); here as it needs to be done by the developer after checking the error
            $f3->set('utest.errors.' . $f3->hash(serialize($f3->get('ERROR'))), $f3->get('ERROR'));
        });
    }

    protected function currentTestNumber(): int
    {
        return \Base::instance()->get('utest.number');
    }

    protected function postData($array): array
    {
        $array['csrf_token'] = \Registry::get('session')->generateToken();

        return $array;
    }

    protected function rerouted(): ?string
    {
        return \Base::instance()->get('utest.rerouted');
    }

    /**
     * @param array $params
     * @param mixed $alias
     */
    protected function reroutedTo($alias, $params = []): bool
    {
        return $this->rerouted() === \Base::instance()->alias($alias, $params);
    }

    protected function returnedError($code): bool
    {
        $f3        = \Base::instance();
        $lastError = $f3->get('utest.errors.' . $this->hashError($f3->get('ERROR')));
        $f3->clear('utest.errors.' . $this->hashError($f3->get('ERROR')));

        return $code === $lastError['code'];
    }

    /**
     * @param array $error
     */
    protected function hashError($error): string
    {
        return \Base::instance()->hash(serialize($error));
    }
}
