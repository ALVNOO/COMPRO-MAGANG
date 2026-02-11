<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait CalculatesWorkingDays
{
    /**
     * Get working days excluding Saturday and Sunday.
     * Returns a collection of date strings sorted from oldest to newest.
     *
     * @param Carbon $fromDate Starting date to count backwards from
     * @param int $count Number of working days to return
     * @return Collection
     */
    protected function getWorkingDays(Carbon $fromDate, int $count = 7): Collection
    {
        $workingDays = collect();
        $currentDate = $fromDate->copy();
        $daysBack = 0;
        $maxIterations = $count * 3; // Safety limit to prevent infinite loop

        while ($workingDays->count() < $count && $daysBack < $maxIterations) {
            $checkDate = $currentDate->copy()->subDays($daysBack);

            // Skip Saturday (6) and Sunday (0)
            if (!$checkDate->isWeekend()) {
                $workingDays->push($checkDate->toDateString());
            }

            $daysBack++;
        }

        // Sort from oldest to newest
        return $workingDays->sort()->values();
    }

    /**
     * Get working days between two dates.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return Collection
     */
    protected function getWorkingDaysBetween(Carbon $startDate, Carbon $endDate): Collection
    {
        $workingDays = collect();
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            if (!$currentDate->isWeekend()) {
                $workingDays->push($currentDate->toDateString());
            }
            $currentDate->addDay();
        }

        return $workingDays;
    }

    /**
     * Count working days between two dates.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return int
     */
    protected function countWorkingDays(Carbon $startDate, Carbon $endDate): int
    {
        return $this->getWorkingDaysBetween($startDate, $endDate)->count();
    }

    /**
     * Check if a given date is a working day.
     *
     * @param Carbon $date
     * @return bool
     */
    protected function isWorkingDay(Carbon $date): bool
    {
        return !$date->isWeekend();
    }

    /**
     * Get the next working day from a given date.
     *
     * @param Carbon $date
     * @return Carbon
     */
    protected function getNextWorkingDay(Carbon $date): Carbon
    {
        $nextDay = $date->copy()->addDay();

        while ($nextDay->isWeekend()) {
            $nextDay->addDay();
        }

        return $nextDay;
    }

    /**
     * Get the previous working day from a given date.
     *
     * @param Carbon $date
     * @return Carbon
     */
    protected function getPreviousWorkingDay(Carbon $date): Carbon
    {
        $prevDay = $date->copy()->subDay();

        while ($prevDay->isWeekend()) {
            $prevDay->subDay();
        }

        return $prevDay;
    }
}
