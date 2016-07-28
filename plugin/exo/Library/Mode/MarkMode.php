<?php

namespace UJM\ExoBundle\Library\Mode;

/**
 * Defines when the marks of an Exercise become available.
 */
final class MarkMode
{
    /**
     * The marks are available at the same time than the Correction.
     *
     * @see \UJM\ExoBundle\Entity\Mode\CorrectionMode
     *
     * @var int
     */
    const WITH_CORRECTION = '1';

    /**
     * The marks are available once the User has validated his Paper.
     * 
     * @var int
     */
    const AFTER_END = '2';

    /**
     * The marks will never be available to Users.
     *
     * @var int
     */
    const NEVER = '4';

    /**
     * Returns the list of all MarkMode available (the value is the corresponding translation key).
     * 
     * @return array
     */
    public static function getList()
    {
        return [
            static::WITH_CORRECTION => 'at_the_same_time_that_the_correction',
            static::AFTER_END => 'at_the_end_of_assessment',
            static::NEVER => 'never',
        ];
    }
}
