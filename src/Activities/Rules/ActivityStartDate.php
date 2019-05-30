<?php

namespace Deviate\Activities\Rules;

class ActivityStartDate extends ActivityDates
{
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The start date for the activity must be between the collections activities dates';
    }
}
