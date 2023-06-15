<?php

namespace App\Http\Controllers\RoutePlanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aws\LocationService\LocationServiceClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Http;

class RoutePlannerController extends Controller
{
    public function routeCalculation(Request $request)
    {
        // start
        /*
         * $result = $client->calculateRoute([
    'CalculatorName' => '<string>', // REQUIRED
    'CarModeOptions' => [
        'AvoidFerries' => true || false,
        'AvoidTolls' => true || false,
    ],
    'DepartNow' => true || false,
    'DeparturePosition' => [<float>, ...], // REQUIRED
    'DepartureTime' => <integer || string || DateTime>,
    'DestinationPosition' => [<float>, ...], // REQUIRED
    'DistanceUnit' => 'Kilometers|Miles',
    'IncludeLegGeometry' => true || false,
    'TravelMode' => 'Car|Truck|Walking|Bicycle|Motorcycle',
    'TruckModeOptions' => [
        'AvoidFerries' => true || false,
        'AvoidTolls' => true || false,
        'Dimensions' => [
            'Height' => <float>,
            'Length' => <float>,
            'Unit' => 'Meters|Feet',
            'Width' => <float>,
        ],
        'Weight' => [
            'Total' => <float>,
            'Unit' => 'Kilograms|Pounds',
        ],
    ],
    'WaypointPositions' => [
        [<float>, ...],
        // ...
    ],
]);*/

        /*try {*/
            $client = new LocationServiceClient(
                [
                    'credentials' => array(
                        'key'    => env('AWS_LOCATION_SERVICE_KEY'),
                        'secret' => env('AWS_LOCATION_SERVICE_SECRET'),
                    ),
                    'region' => 'us-east-1',
                    'version' => '2020-11-19'
                ]
            );

            $result = $client->calculateRoute([
                'CalculatorName' => 'route-planner-acmg',
                /*'CarModeOptions' => [
                    'AvoidFerries' => $request->avoidFerries,
                    'AvoidTolls' => $request->avoidTolls,
                ],*/
                'DepartNow' => true,
                'DistanceUnit' => $request->distanceUnit,
                'TravelMode' => $request->travelMode,
                'DeparturePosition' => $request->departurePosition,// REQUIRED longitude,latitude
                'DestinationPosition' => $request->destinationPosition, // REQUIRED longitude,latitude
                'WaypointPositions' => $request->wayPointPositions
            ]);


            $response = array('Legs' => $result->get('Legs'), 'Summary' => $result->get('Summary'), '@metadata' => $result->get('@metadata'));
            return response($response,200);

        /*} catch (\Exception $exception) {

            return response(array('error' => $exception->getMessage()),500);
        }*/
    }

    public function addresses(Request $request) {

        $response = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
            'query' => $request->address,
            'key' => env('GOOGLE_PLACES_KEY'),
        ]);

        return response($response->body(),200);
    }
}
