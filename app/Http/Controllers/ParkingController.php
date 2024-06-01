<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Services\ParkingPriceService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParkingController extends Controller
{
    public function start(ParkingRequest $request)
    {

        $parking = Parking::where('vehicle_id', $request->vehicle_id)->active()->exists();

        if ($parking) {
            return response()->json([
                'errors' => ['general' => ['Can\'t start parking twice using same vehicle. Please stop currently active parking.']]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($request->all());
        $parking->load('vehicle', 'zone');

        return ParkingResource::make($parking);
    }

    public function show(Parking $parking)
    {
        return ParkingResource::make($parking);
    }

    public function update(Parking $parking)
    {
        $parking->update([
            'stop_time' => now(),
        ]);

        return ParkingResource::make($parking);
    }

    public function stop(Parking $parking)
    {
        $parking_service = new ParkingPriceService();
        $parking->stop_time = now();
        $parking->total_price = $parking_service->calculatePrice($parking->zone_id, $parking->start_time, $parking->stop_time);
        $parking->save();

        return ParkingResource::make($parking);
    }
}
