<?php

namespace Jbohn\Bundle\ExamBundle\Document;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Exam implements \Iterator
{
	private $dispatcher;
	private $description;
	private $user;
	private $status;
	private $steps;
	private $position;

	public function __construct(EventDispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;
		$this->steps = array();
		$this->rewind();
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setSteps(array $steps = array())
	{
		$this->steps = $steps;
	}

	public function getSteps()
	{
		return $this->steps;
	}

	public function evaluate()
	{
		if (empty($this->steps)) {
			throw new \LogicException('Cannot evaluate with no steps.');
		}

		// No definition how to calculate pass/fail.
	}

	public function rewind()
	{
		$this->position = 0;
	}

	public function current()
	{
		return $this->steps[$this->position];
	}

	public function next()
	{
		++$this->position;
	}

	public function key()
	{
		return $this->position;
	}

	public function valid()
	{
		return isset($this->steps($this->position));
	}
}