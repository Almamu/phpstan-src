<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\ClassNameNodePair;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Class_>
 */
class ExistingClassesInClassImplementsRule implements \PHPStan\Rules\Rule
{

	private \PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck;

	private ReflectionProvider $reflectionProvider;

	public function __construct(
		ClassCaseSensitivityCheck $classCaseSensitivityCheck,
		ReflectionProvider $reflectionProvider
	)
	{
		$this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
		$this->reflectionProvider = $reflectionProvider;
	}

	public function getNodeType(): string
	{
		return Node\Stmt\Class_::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$messages = $this->classCaseSensitivityCheck->checkClassNames(
			array_map(static function (Node\Name $interfaceName): ClassNameNodePair {
				return new ClassNameNodePair((string) $interfaceName, $interfaceName);
			}, $node->implements)
		);

		$currentClassName = null;
		if (isset($node->namespacedName)) {
			$currentClassName = (string) $node->namespacedName;
		}

		foreach ($node->implements as $implements) {
			$implementedClassName = (string) $implements;
			if (!$this->reflectionProvider->hasClass($implementedClassName)) {
				if (!$scope->isInClassExists($implementedClassName)) {
					$messages[] = RuleErrorBuilder::message(sprintf(
						'%s implements unknown interface %s.',
						$currentClassName !== null ? sprintf('Class %s', $currentClassName) : 'Anonymous class',
						$implementedClassName
					))->nonIgnorable()->discoveringSymbolsTip()->build();
				}
			} else {
				$reflection = $this->reflectionProvider->getClass($implementedClassName);
				if ($reflection->isClass()) {
					$messages[] = RuleErrorBuilder::message(sprintf(
						'%s implements class %s.',
						$currentClassName !== null ? sprintf('Class %s', $currentClassName) : 'Anonymous class',
						$implementedClassName
					))->nonIgnorable()->build();
				} elseif ($reflection->isTrait()) {
					$messages[] = RuleErrorBuilder::message(sprintf(
						'%s implements trait %s.',
						$currentClassName !== null ? sprintf('Class %s', $currentClassName) : 'Anonymous class',
						$implementedClassName
					))->nonIgnorable()->build();
				}
			}
		}

		return $messages;
	}

}
