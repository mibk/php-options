<?php

/**
 * This file is part of the PhpOptions library.
 * Copyright (c) 2014 Michal Bohuslávek
 */

namespace PhpOptions;

class InvalidArgumentException extends \InvalidArgumentException
{
}

class OptionAlreadyRegisteredException extends \InvalidArgumentException
{
	public function __construct($name, $longOption = TRUE, \Exception $previous = NULL)
	{
		$msg = ($longOption ? 'Long' : 'Short')." option '$name' is already registered.";
		parent::__construct($msg, 0, $previous);
	}
}

/**
 * @author Michal Bohuslávek
 */
abstract class OptionException extends \Exception
{
	/** @var Option */
	protected $option;

	/** @var bool */
	protected $longOption;


	public function __construct(Option $option, $longOption = TRUE, \Exception $previous = NULL)
	{
		$this->option = $option;
		$this->longOption = $longOption;
		parent::__construct($this->formatMsg(), 0, $previous);
	}

	abstract protected function formatMsg();

	public function getOption()
	{
		return $this->option;
	}

	public function isLongOption()
	{
		return $this->longOption;
	}
}


/**
 * @author Michal Bohuslávek
 */
class MissingArgumentException extends OptionException
{
	protected function formatMsg()
	{
		return "No argument for option '{$this->option->getName()}'.";
	}
}


/**
 * @author Michal Bohuslávek
 */
class UnexpectedArgumentException extends OptionException
{
	protected function formatMsg()
	{
		return "Option '{$this->option->getName()}' doesn't expect an argument.";
	}
}


/**
 * @author Michal Bohuslávek
 */
class UnknownOptionException extends \Exception
{
	/** @var string */
	protected $name;

	/** @var bool */
	protected $longOption;


	public function __construct($name, $longOption = TRUE, \Exception $previous = NULL)
	{
		$this->name = $name;
		$this->longOption = $longOption;
		$msg = 'Unknown '.($longOption ? 'long' : 'short')." option '$name'.";
		parent::__construct($msg, 0, $previous);
	}

	public function getName()
	{
		return $this->name;
	}

	public function isLongOption()
	{
		return $this->longOption;
	}
}
