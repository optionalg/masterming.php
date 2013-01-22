<?php

namespace Mastermind;

class Scorer
{
    protected $numberOfWellPlacedColors = 0;
    protected $numberOfMisplacedColors = 0;
    protected $secret;

    public function __construct(array $secret)
    {
        $this->secret = $secret;
    }

    public function isSuccess()
    {
        return $this->numberOfWellPlacedColors === count($this->secret);
    }

    public function score(array $code)
    {
        $this->assertValidCodeLength($code);
        $this->countMisplacedColors($code);
        $this->countWellPlacedColors($code);
    }

    protected function assertValidCodeLength(array $code)
    {
        if (count($code) !== count($this->secret)) {
            throw new \Mastermind\Exception\InvalidCodeLengthException();
        }
    }

    protected function countMisplacedColors(array $code)
    {
        $this->numberOfMisplacedColors = 0;

        $remainingColorsCountInSecret = array();
        $remainingColorsInCode = array();

        for ($i = 0; $i < count($code); $i++) {
            if ($code[$i] !== $this->secret[$i]) {
                if (!array_key_exists($this->secret[$i], $remainingColorsCountInSecret)) {
                    $remainingColorsCountInSecret[$this->secret[$i]] = 0;
                }

                $remainingColorsCountInSecret[$this->secret[$i]]++;
                $remainingColorsInCode[] = $code[$i];
            }
        }

        foreach ($remainingColorsInCode as $color) {
            if (array_key_exists($color, $remainingColorsCountInSecret) && $remainingColorsCountInSecret > 0) {
                $this->numberOfMisplacedColors++;
                $remainingColorsCountInSecret[$color]--;
            }
        }
    }

    protected function countWellPlacedColors(array $code)
    {
        $this->numberOfWellPlacedColors = 0;

        for ($i = 0; $i < count($code); $i++) {
            if ($code[$i] === $this->secret[$i]) {
                $this->numberOfWellPlacedColors++;
            }
        }
    }

    public function getNumberOfWellPlacedColors()
    {
        return $this->numberOfWellPlacedColors;
    }

    public function getNumberOfMisplacedColors()
    {
        return $this->numberOfMisplacedColors;
    }
}
