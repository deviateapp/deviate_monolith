<?php

namespace Deviate\Activities\Rules;

class ActivityEndDate extends ActivityDates
{
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The end date for the activity must be between the collections activities dates';
    }
}
