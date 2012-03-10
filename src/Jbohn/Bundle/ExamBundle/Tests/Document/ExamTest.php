<?php

namespace Jbohn\Bundle\ExamBundle\Tests\Document;

use Faker\Lorem;
use Faker\Internet;
use Jbohn\Bundle\ExamBundle\Document\Exam;
use Jbohn\Bundle\ExamBundle\Tests\TestCase;

class ExamTest extends TestCase
{
    private $dispatcher;
    private $exam;

    protected function setUp()
    {
        $this->dispatcher = $this->getMockEventDispatcher();
        $this->exam = new Exam($this->dispatcher);
    }

    protected function tearDown()
    {
        unset($this->dispatcher);
        unset($this->exam);
    }

    public function testDescription()
    {
        $description = Lorem::paragraph();
        $this->assertNull($this->exam->getDescription());
        $this->exam->setDescription($description);
        $this->assertEquals($description, $this->exam->getDescription());
    }

    public function testUser()
    {
        $user = $this->getMockUser();
        $this->assertNull($this->exam->getUser());
        $this->exam->setUser($user);
        $this->assertSame($user, $this->exam->getUser());
    }

    public function testStatus()
    {
        $status = Internet::slug();
        $this->assertNull($this->exam->getStatus());
        $this->exam->setStatus($status);
        $this->assertEquals($status, $this->exam->getStatus());
    }

    public function testIteration()
    {
        $this->assertInstanceOf('Iterator', $this->exam, 'Exam is iterable.');

        $steps = array(
            $this->getMockExamStep(),
            $this->getMockExamStep(),
        );

        $this->exam->setSteps($steps);
        $this->assertEquals(0, $this->exam->key());
        $this->assertTrue($this->exam->valid());
        $this->assertSame($steps[0], $this->exam->current());

        $this->exam->next();
        $this->assertEquals(0, $this->exam->key());
        $this->assertSame($steps[0], $this->exam->current());

    }

    public function testIterator()
    {
        $steps = array(
            $this->getMockExamStep(),
            $this->getMockExamStep(),
        );

        $this->assertTrue(is_array($this->exam->getSteps()));
        $this->assertEquals(0, count($this->exam->getSteps()));
        $this->exam->setSteps($steps);
        $this->assertSame($steps, $this->exam->getSteps());
    }

    /**
     * Cannot evalute Exam without steps
     * @expectedException LogicException
     */
    public function testEvaluation()
    {
        $this->exam->evaluate();
    }

    private function getMockExamStep()
    {
        return $this->getMock('Jbohn\Bundle\ExamBundle\Document\Exam\ExamStep');
    }

    private function getMockUser()
    {
        return $this->getMock('Symfony\Component\Security\Core\User\UserInterface');
    }

    private function getMockEventDispatcher()
    {
        return $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
    }
}