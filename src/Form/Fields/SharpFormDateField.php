<?php

namespace Code16\Sharp\Form\Fields;

class SharpFormDateField extends SharpFormField
{
    /**
     * @var bool
     */
    protected $hasDate = true;

    /**
     * @var bool
     */
    protected $hasTime = false;

    /**
     * @var bool
     */
    protected $mondayFirst = false;

    /**
     * @var string
     */
    protected $minTime = '00:00';

    /**
     * @var string
     */
    protected $maxTime = '23:59';

    /**
     * @var int
     */
    protected $stepTime = 30;

    /**
     * @var string
     */
    protected $displayFormat = "YYYY-MM-DD";

    /**
     * @param string $key
     * @return static
     */
    public static function make(string $key)
    {
        return new static($key, 'date');
    }

    /**
     * @param bool $hasDate
     * @return $this
     */
    public function setHasDate($hasDate = true)
    {
        $this->hasDate = $hasDate;

        return $this;
    }

    /**
     * @param bool $hasTime
     * @return $this
     */
    public function setHasTime($hasTime = true)
    {
        $this->hasTime = $hasTime;

        return $this;
    }

    /**
     * @param bool $mondayFirst
     * @return $this
     */
    public function setMondayFirst(bool $mondayFirst = true)
    {
        $this->mondayFirst = $mondayFirst;

        return $this;
    }

    /**
     * @param bool $sundayFirst
     * @return $this
     */
    public function setSundayFirst(bool $sundayFirst = true)
    {
        return $this->setMondayFirst(!$sundayFirst);
    }

    /**
     * @param int $hours
     * @param int $minutes
     * @return $this
     */
    public function setMinTime(int $hours, int $minutes = 0)
    {
        $this->minTime = $this->formatTime($hours, $minutes);

        return $this;
    }

    /**
     * @param int $hours
     * @param int $minutes
     * @return $this
     */
    public function setMaxTime(int $hours, int $minutes = 0)
    {
        $this->maxTime = $this->formatTime($hours, $minutes);

        return $this;
    }

    /**
     * @param int $step
     * @return $this
     */
    public function setStepTime(int $step)
    {
        $this->stepTime = $step;

        return $this;
    }

    /**
     * @param string $displayFormat
     * @return $this
     */
    public function setDisplayFormat(string $displayFormat)
    {
        $this->displayFormat = $displayFormat;

        return $this;
    }

    /**
     * @return array
     */
    protected function validationRules()
    {
        return [
            "hasDate" => "required|boolean",
            "hasTime" => "required|boolean",
            "displayFormat" => "required",
            "minTime" => "regex:/[0-9]{2}:[0-9]{2}/",
            "maxTime" => "regex:/[0-9]{2}:[0-9]{2}/",
            "stepTime" => "integer|min:1|max:60",
            "mondayFirst" => "required|boolean",
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return parent::buildArray([
            "hasDate" => $this->hasDate,
            "hasTime" => $this->hasTime,
            "minTime" => $this->minTime,
            "maxTime" => $this->maxTime,
            "stepTime" => $this->stepTime,
            "mondayFirst" => $this->mondayFirst,
            "displayFormat" => $this->displayFormat,
        ]);
    }

    /**
     * @param int $hours
     * @param int $minutes
     * @return string
     */
    private function formatTime(int $hours, int $minutes)
    {
        return str_pad($hours, 2, "0", STR_PAD_LEFT)
            . ":"
            . str_pad($minutes, 2, "0", STR_PAD_LEFT);
    }
}