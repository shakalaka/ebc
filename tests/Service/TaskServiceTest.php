<?php

use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


final class SomeServiceTest extends WebTestCase
{

    /**
     * Тестирует метод тестовой задачи
     *
     * @dataProvider dataProvider
     *
     * @param $num
     * @param $data
     * @param $expected
     * @throws ReflectionException
     */
    public function testTaskCalc($num, $data, $expected)
    {
        $mock = $this->getMockBuilder(TaskService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->invokeMethod($mock, 'taskCalc', [$num, $data]);

        $this->assertEquals($expected, $result);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     * @throws ReflectionException
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function dataProvider()
    {
        return [
            [5, [5, 5, 1, 7, 2, 3, 5], 4],
            [5, [5, 5, 5, 1, 7, 2, 1, 3, 5], 5],
            [5, [5, 5, 5, 1], 1],
        ];
    }
}