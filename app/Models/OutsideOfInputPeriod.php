<?php

namespace App\Models;

class OutsideOfInputPeriod implements Period
{
    /** @var \Carbon\Carbon */
    public $end_at;

    /**
     * @return boolean
     * @see Period
     */
    public function canInput(): boolean
    {
        return false;
    }

    /**
     * @return string
     * @see Period
     */
    public function guideMessage(): string
    {
        return '現在入力期間ではありません。';
    }

    /**
     * @return \App\Models\AlertLevel
     * @see Period
     */
    public function alertLevel(): AlertLevel
    {
        return new AlertLevel(AlertLevel::INFO);
    }
}
