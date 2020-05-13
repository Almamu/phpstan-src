<?php declare(strict_types = 1);

namespace PHPStan\Rules\Variables;

/**
 * @extends \PHPStan\Testing\RuleTestCase<DefinedVariableRule>
 */
class DefinedVariableRuleTest extends \PHPStan\Testing\RuleTestCase
{

	/** @var bool */
	private $cliArgumentsVariablesRegistered;

	/** @var bool */
	private $checkMaybeUndefinedVariables;

	/** @var bool */
	private $polluteScopeWithLoopInitialAssignments;

	/** @var bool */
	private $polluteCatchScopeWithTryAssignments;

	/** @var bool */
	private $polluteScopeWithAlwaysIterableForeach;

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new DefinedVariableRule(
			$this->cliArgumentsVariablesRegistered,
			$this->checkMaybeUndefinedVariables
		);
	}

	protected function shouldPolluteScopeWithLoopInitialAssignments(): bool
	{
		return $this->polluteScopeWithLoopInitialAssignments;
	}

	protected function shouldPolluteCatchScopeWithTryAssignments(): bool
	{
		return $this->polluteCatchScopeWithTryAssignments;
	}

	protected function shouldPolluteScopeWithAlwaysIterableForeach(): bool
	{
		return $this->polluteScopeWithAlwaysIterableForeach;
	}

	public function testDefinedVariables(): void
	{
		require_once __DIR__ . '/data/defined-variables-definition.php';
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/defined-variables.php'], [
			[
				'Undefined variable: $definedLater',
				5,
			],
			[
				'Variable $definedInIfOnly might not be defined.',
				10,
			],
			[
				'Variable $definedInCases might not be defined.',
				21,
			],
			[
				'Undefined variable: $fooParameterBeforeDeclaration',
				29,
			],
			[
				'Undefined variable: $parseStrParameter',
				34,
			],
			[
				'Undefined variable: $foo',
				39,
			],
			[
				'Undefined variable: $willBeUnset',
				44,
			],
			[
				'Undefined variable: $mustAlreadyExistWhenDividing',
				50,
			],
			[
				'Undefined variable: $arrayDoesNotExist',
				57,
			],
			[
				'Undefined variable: $undefinedVariable',
				59,
			],
			[
				'Undefined variable: $this',
				96,
			],
			[
				'Undefined variable: $this',
				99,
			],
			[
				'Undefined variable: $variableInEmpty',
				145,
			],
			[
				'Undefined variable: $variableInEmpty',
				155,
			],
			[
				'Variable $negatedVariableInEmpty might not be defined.',
				156,
			],
			[
				'Variable $variableInIsset might not be defined.',
				161,
			],
			[
				'Undefined variable: $anotherVariableInIsset',
				161,
			],
			[
				'Undefined variable: $http_response_header',
				185,
			],
			[
				'Undefined variable: $http_response_header',
				191,
			],
			[
				'Undefined variable: $assignedInKey',
				203,
			],
			[
				'Undefined variable: $assignedInKey',
				204,
			],
			[
				'Variable $forI might not be defined.',
				250,
			],
			[
				'Variable $forJ might not be defined.',
				251,
			],
			[
				'Variable $variableDefinedInTry might not be defined.',
				260,
			],
			[
				'Variable $variableAvailableInAllCatches might not be defined.',
				266,
			],
			[
				'Variable $variableDefinedOnlyInOneCatch might not be defined.',
				267,
			],
			[
				'Undefined variable: $variableInBitwiseAndAssign',
				277,
			],
			[
				'Variable $mightBeUndefinedInDoWhile might not be defined.',
				282,
			],
			[
				'Undefined variable: $variableInSecondCase',
				290,
			],
			[
				'Variable $variableInSecondCase might not be defined.',
				293,
			],
			[
				'Undefined variable: $variableAssignedInSecondCase',
				300,
			],
			[
				'Variable $variableInFallthroughCase might not be defined.',
				302,
			],
			[
				'Variable $variableFromDefaultFirst might not be defined.',
				312,
			],
			[
				'Undefined variable: $undefinedVariableInForeach',
				315,
			],
			[
				'Variable $anotherForLoopVariable might not be defined.',
				328,
			],
			[
				'Variable $maybeDefinedInTernary might not be defined.',
				351,
			],
			[
				'Variable $anotherMaybeDefinedInTernary might not be defined.',
				354,
			],
			[
				'Variable $whileVariableUsedAndThenDefined might not be defined.',
				356,
			],
			[
				'Variable $forVariableUsedAndThenDefined might not be defined.',
				360,
			],
			[
				'Undefined variable: $unknownVariablePassedToReset',
				368,
			],
			[
				'Undefined variable: $unknownVariablePassedToReset',
				369,
			],
			[
				'Undefined variable: $variableInAssign',
				384,
			],
			[
				'Undefined variable: $undefinedArrayIndex',
				409,
			],
			[
				'Undefined variable: $anotherUndefinedArrayIndex',
				409,
			],
			[
				'Variable $str might not be defined.',
				423,
			],
			[
				'Variable $str might not be defined.',
				428,
			],
		]);
	}

	public function testDefinedVariablesInClosures(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/defined-variables-closures.php'], [
			[
				'Undefined variable: $this',
				14,
			],
		]);
	}

	public function testDefinedVariablesInShortArrayDestructuringSyntax(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/defined-variables-array-destructuring-short-syntax.php'], [
			[
				'Undefined variable: $f',
				11,
			],
			[
				'Undefined variable: $f',
				14,
			],
			[
				'Undefined variable: $var3',
				32,
			],
		]);
	}

	public function testCliArgumentsVariablesNotRegistered(): void
	{
		$this->cliArgumentsVariablesRegistered = false;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/cli-arguments-variables.php'], [
			[
				'Undefined variable: $argc',
				3,
			],
			[
				'Undefined variable: $argc',
				5,
			],
		]);
	}

	public function testCliArgumentsVariablesRegistered(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/cli-arguments-variables.php'], [
			[
				'Undefined variable: $argc',
				5,
			],
		]);
	}

	public function dataLoopInitialAssignments(): array
	{
		return [
			[
				false,
				false,
				[],
			],
			[
				false,
				true,
				[
					[
						'Variable $i might not be defined.',
						7,
					],
					[
						'Variable $whileVar might not be defined.',
						13,
					],
				],
			],
			[
				true,
				false,
				[],
			],
			[
				true,
				true,
				[],
			],
		];
	}

	/**
	 * @dataProvider dataLoopInitialAssignments
	 * @param bool $polluteScopeWithLoopInitialAssignments
	 * @param bool $checkMaybeUndefinedVariables
	 * @param mixed[][] $expectedErrors
	 */
	public function testLoopInitialAssignments(
		bool $polluteScopeWithLoopInitialAssignments,
		bool $checkMaybeUndefinedVariables,
		array $expectedErrors
	): void
	{
		$this->cliArgumentsVariablesRegistered = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->polluteScopeWithLoopInitialAssignments = $polluteScopeWithLoopInitialAssignments;
		$this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/loop-initial-assignments.php'], $expectedErrors);
	}

	public function dataCatchScopePollutedWithTryAssignments(): array
	{
		return [
			[
				false,
				false,
				[],
			],
			[
				false,
				true,
				[
					[
						'Variable $variableInTry might not be defined.',
						6,
					],
				],
			],
			[
				true,
				false,
				[],
			],
			[
				true,
				true,
				[],
			],
		];
	}

	/**
	 * @dataProvider dataCatchScopePollutedWithTryAssignments
	 * @param bool $polluteCatchScopeWithTryAssignments
	 * @param bool $checkMaybeUndefinedVariables
	 * @param mixed[][] $expectedErrors
	 */
	public function testCatchScopePollutedWithTryAssignments(
		bool $polluteCatchScopeWithTryAssignments,
		bool $checkMaybeUndefinedVariables,
		array $expectedErrors
	): void
	{
		$this->cliArgumentsVariablesRegistered = false;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = $polluteCatchScopeWithTryAssignments;
		$this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/catch-scope-polluted-with-try-assignments.php'], $expectedErrors);
	}

	public function testDefineVariablesInClass(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/define-variables-class.php'], []);
	}

	public function testDeadBranches(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/dead-branches.php'], [
			[
				'Undefined variable: $test',
				21,
			],
			[
				'Undefined variable: $test',
				33,
			],
			[
				'Undefined variable: $test',
				55,
			],
			[
				'Undefined variable: $test',
				66,
			],
			[
				'Undefined variable: $test',
				94,
			],
		]);
	}

	public function testForeach(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/foreach.php'], [
			[
				'Variable $val might not be defined.',
				9,
			],
			[
				'Variable $test might not be defined.',
				10,
			],
			[
				'Undefined variable: $val',
				46,
			],
			[
				'Undefined variable: $test',
				47,
			],
			[
				'Variable $val might not be defined.',
				62,
			],
			[
				'Variable $test might not be defined.',
				63,
			],
			[
				'Undefined variable: $val',
				171,
			],
			[
				'Undefined variable: $test',
				172,
			],
			[
				'Undefined variable: $val',
				187,
			],
			[
				'Undefined variable: $test',
				188,
			],
			[
				'Variable $val might not be defined.',
				217,
			],
			[
				'Variable $test might not be defined.',
				218,
			],
		]);
	}

	public function dataForeachPolluteScopeWithAlwaysIterableForeach(): array
	{
		return [
			[
				true,
				[
					[
						'Undefined variable: $key',
						8,
					],
					[
						'Undefined variable: $val',
						9,
					],
					[
						'Undefined variable: $test',
						10,
					],
					[
						'Variable $test might not be defined.',
						34,
					],
					[
						'Variable $key might not be defined.',
						47,
					],
					[
						'Variable $test might not be defined.',
						48,
					],
					[
						'Variable $key might not be defined.',
						61,
					],
					[
						'Variable $test might not be defined.',
						62,
					],
				],
			],
			[
				false,
				[
					[
						'Undefined variable: $key',
						8,
					],
					[
						'Undefined variable: $val',
						9,
					],
					[
						'Undefined variable: $test',
						10,
					],
					[
						'Variable $key might not be defined.',
						19,
					],
					[
						'Variable $val might not be defined.',
						20,
					],
					[
						'Variable $test might not be defined.',
						21,
					],
					[
						'Variable $key might not be defined.',
						32,
					],
					[
						'Variable $val might not be defined.',
						33,
					],
					[
						'Variable $test might not be defined.',
						34,
					],
					[
						'Variable $key might not be defined.',
						47,
					],
					[
						'Variable $test might not be defined.',
						48,
					],
					[
						'Variable $key might not be defined.',
						61,
					],
					[
						'Variable $test might not be defined.',
						62,
					],
					[
						'Variable $key might not be defined.',
						75,
					],
					[
						'Variable $test might not be defined.',
						76,
					],
				],
			],
		];
	}

	/**
	 * @dataProvider dataForeachPolluteScopeWithAlwaysIterableForeach
	 *
	 * @param bool $polluteScopeWithAlwaysIterableForeach
	 * @param mixed[] $errors
	 */
	public function testForeachPolluteScopeWithAlwaysIterableForeach(bool $polluteScopeWithAlwaysIterableForeach, array $errors): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = $polluteScopeWithAlwaysIterableForeach;
		$this->analyse([__DIR__ . '/data/foreach-always-iterable.php'], $errors);
	}

	public function testBooleanOperatorsTruthyFalsey(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/boolean-op-truthy-falsey.php'], [
			[
				'Variable $matches might not be defined.',
				9,
			],
			[
				'Variable $matches might not be defined.',
				15,
			],
		]);
	}

	public function testArrowFunctions(): void
	{
		if (!self::$useStaticReflectionProvider && PHP_VERSION_ID < 70400) {
			$this->markTestSkipped('Test requires PHP 7.4.');
		}

		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/defined-variables-arrow-functions.php'], [
			[
				'Undefined variable: $a',
				10,
			],
			[
				'Undefined variable: $this',
				19,
			],
		]);
	}

	public function testCoalesceAssign(): void
	{
		if (!self::$useStaticReflectionProvider && PHP_VERSION_ID < 70400) {
			$this->markTestSkipped('Test requires PHP 7.4.');
		}

		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/defined-variables-coalesce-assign.php'], [
			[
				'Undefined variable: $b',
				16,
			],
		]);
	}

	public function testBug2748(): void
	{
		$this->cliArgumentsVariablesRegistered = true;
		$this->polluteScopeWithLoopInitialAssignments = false;
		$this->polluteCatchScopeWithTryAssignments = false;
		$this->checkMaybeUndefinedVariables = true;
		$this->polluteScopeWithAlwaysIterableForeach = true;
		$this->analyse([__DIR__ . '/data/bug-2748.php'], [
			[
				'Undefined variable: $foo',
				10,
			],
			[
				'Undefined variable: $foo',
				15,
			],
		]);
	}

}
