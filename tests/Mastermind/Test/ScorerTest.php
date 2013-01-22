<?php

namespace Mastermind\Test;

use Mastermind\Scorer;

class ScorerTest extends \PHPUnit_Framework_TestCase
{
    protected $scorer;

    public function setUp()
    {
        $this->scorer = new Scorer(array(2, 1));
    }

    public function testWhenScorerIsCreatedThenItIsNotASuccess()
    {
        assertFalse($this->scorer->isSuccess());
    }

    public function testWhenScoreAWrongCodeThenItIsNotASuccess()
    {
        $this->scorer->score(array(1, 2));
        assertFalse($this->scorer->isSuccess());
    }

    public function testWhenScoreAValidCodeThenItIsASuccess()
    {
        $this->scorer->score(array(2, 1));
        assertTrue($this->scorer->isSuccess());
    }

    public function testCountsWellPlacedColors()
    {
        $this->scorer->score(array(3, 1));
        assertEquals(1, $this->scorer->getNumberOfWellPlacedColors());

        $this->scorer->score(array(9, 8));
        assertEquals(0, $this->scorer->getNumberOfWellPlacedColors());
    }

    public function testCountsMisplacedColors()
    {
        $this->scorer->score(array(1, 3));
        assertEquals(1, $this->scorer->getNumberOfMisplacedColors());

        $this->scorer->score(array(9, 3));
        assertEquals(0, $this->scorer->getNumberOfMisplacedColors());
    }

    /**
     * @expectedException Mastermind\Exception\InvalidCodeLengthException
     */
    public function testFailsWhenCodeLengthIsNotEqualsToSecretLength()
    {
        $this->scorer->score(array(1, 2, 3, 4));
    }
}
