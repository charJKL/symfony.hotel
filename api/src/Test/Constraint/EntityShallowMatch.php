<?php
namespace App\Test\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use \ReflectionClass ;

class EntityShallowMatch extends Constraint
{
	private $entity = null;
	private $reasons = [];
	
	public function __construct(object $entity)
	{
		$this->entity = $entity;
		$this->reasons = [];
	}
	
	protected function matches($entity): bool
	{
		// Check if provided argument is object:
		if(gettype($entity) !== 'object')
		{
			$this->reasons[] = sprintf("Object to compare to must be an instance of class, `%s` was given.", gettype($entity));
			return false;
		}
		
		$one = new ReflectionClass($this->entity);
		$two = new ReflectionClass($entity);
		
		// Check if class types matches:
		$oneNameClass = $one->getName();
		$twoNameClass = $two->getName();
		if($oneNameClass !== $twoNameClass)
		{
			$this->reasons[] = sprintf("Object type `%s` is not the same as object type `%s`.", $this->entityName($this->entity), $this->entityName($entity));
			return false;
		}
		
		// If types matches, then properties order must match:
		$oneProperties = $one->getProperties();
		$twoProperties = $two->getProperties();

		$result = true;
		$count = count($oneProperties);
		for($i = 0; $i < $count; $i++)
		{
			$oneProperty = $oneProperties[$i];
			$twoProperty = $twoProperties[$i];
			$oneProperty->setAccessible(true);
			$twoProperty->setAccessible(true);
			if($oneProperty->getName() === 'id' && $twoProperty->getName() === 'id') continue; // $id values always will be diffrent, skip it.
			
			$oneValue = $oneProperty->getValue($this->entity);
			$twoValue = $twoProperty->getValue($entity);
			$oneType = gettype($oneValue);
			$twoType = gettype($twoValue);
			
			$isOneValueScalarType = $this->isScalarType($oneType);
			$isTwoValueScalarType = $this->isScalarType($twoType);
			if($isOneValueScalarType === true && $isTwoValueScalarType === true)
			{
				if($oneValue !== $twoValue)
				{
					$this->reasons[] = sprintf("Property value %s.%s{%s} is not equal %s.%s{%s}.", $this->entityName($this->entity), $oneProperty->getName(), $oneValue, $this->entityName($entity), $twoProperty->getName(), $twoValue);
					$result = false;
				}
				continue;
			}
			if($isOneValueScalarType === false || $isTwoValueScalarType === false) // in case of complex types, check types. Evaluation of real value will be complicated (require recursion) and unnecessary in our case.
			{
				if($oneType !== $twoType)
				{
					$this->reasons[] = sprintf("Property value %s.%s{%s} is not equal %s.%s{%s}.", $this->entityName($this->entity), $oneProperty->getName(), $oneType, $this->entityName($entity), $twoProperty->getName(), $twoType);
					$result = false;
				}
			}
		}
		return $result;
	}
	
	public function toString(): string
	{
		return "compared object are the same entity";
	}
	
	protected function failureDescription($other): string
	{
		return "compared object are the same entity";
	}

	protected function additionalFailureDescription($other): string
	{
		$additional = '';
		foreach($this->reasons as $reason)
		{
			$additional .= $reason . PHP_EOL;
		}
		return $additional;
	}
	
	private function isScalarType(string $type) : bool
	{
		return in_array($type, ['boolean', 'integer', 'double', 'string'], true);
	}
	
	private function entityName($object)
	{
		if(gettype($object) !== 'object') return gettype($object);
		
		$id = $this->tryGetObjectId($object);
		return ($id === null) ? get_class($object) : get_class($object)."#".$id;
	}
	
	private function tryGetObjectId(object $object) : ?int
	{
		$reflection = new ReflectionClass($object);
		$hasProperty = $reflection->hasProperty('id');
		if($hasProperty === false) return null;
		$property = $reflection->getProperty('id');
		$property->setAccessible(true);
		return $property->getValue($object);
	}
	
}