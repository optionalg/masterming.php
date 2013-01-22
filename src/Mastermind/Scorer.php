<?php

namespace Mastermind;

class Scorer
{
    protected $isSuccess = false;
    protected $numberOfWellPlacedColors = 0;
    protected $numberOfMisplacedColors = 0;
    protected $secret;

    public function __construct(array $secret)
    {
        $this->secret = $secret;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }

    public function score(array $code)
    {
        $this->isSuccess = true;
        $this->numberOfWellPlacedColors = 0;
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

                $this->isSuccess = false;
            }

            if ($code[$i] === $this->secret[$i]) {
                $this->numberOfWellPlacedColors++;
            }
        }

        foreach ($remainingColorsInCode as $color) {
            if (array_key_exists($color, $remainingColorsCountInSecret) && $remainingColorsCountInSecret > 0) {
                $this->numberOfMisplacedColors++;
                $remainingColorsCountInSecret[$color]--;
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
