<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Zone;
class ParkingPriceService
{
    public function calculatePrice(int $zone_id, string $startTime, string $stopTime = null): int
    {
        $start = new Carbon($startTime);
        $stop = is_null($stopTime) ? now() : new Carbon($stopTime);

        $totalMinutes = $start->diffInMinutes($stop);

        $priceByMinutes = Zone::find($zone_id)->price_per_hour / 60;

        return ceil($totalMinutes * $priceByMinutes);
    }
}