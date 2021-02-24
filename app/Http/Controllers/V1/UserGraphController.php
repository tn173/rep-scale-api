<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\UserMeasurement;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UserGraphController extends Controller
{

    public function index(Request $request)
    {

        switch ($request['period']){
        case '1W':
            $data = UserMeasurement::select('date','weight')
            ->where('user_id',$request->user_id)
            ->whereDate('date', '>', Carbon::now()->subDays(7))
            ->orderBy('date', 'asc')
            ->get()->toJson(); 
            break;
        case '1M':
            $data = UserMeasurement::select('date','weight')
            ->where('user_id',$request->user_id)
            ->whereDate('date', '>', Carbon::now()->subMonths(1))
            ->orderBy('date', 'asc')
            ->get()->toJson();
            break;
        case '3M':
            $data = UserMeasurement::select('date','weight')
            ->where('user_id',$request->user_id)
            ->whereDate('date', '>', Carbon::now()->subMonths(3))
            ->orderBy('date', 'asc')
            ->get()->toJson();
            break;
        case '1Y':
            $data = UserMeasurement::select('date','weight')
            ->where('user_id',$request->user_id)
            ->whereDate('date', '>', Carbon::now()->subYears(1))
            ->orderBy('date', 'asc')
            ->get()->toJson();
            break;
        default:
            $data = UserMeasurement::select('date','weight')
            ->where('user_id',$request->user_id)
            ->orderBy('date', 'asc')
            ->get()->toJson();
        }

        return $data;
    }

    public function update(Request $request)
    {
        $data = UserMeasurement::find($request->id);
        $data->date = $request["data"]["date"];
        $data->weight = $request["data"]["weight"];
        $data->save();

        return [
            'result' => true
        ];
    }

    public function delete(Request $request)
    {
        UserMeasurement::find($request->id)->delete();

        return [
            'result' => true
        ];
    }

    public function store(Request $request)
    {
        $data = new UserMeasurement;
        $data->user_id = $request->user_id;
        $data->date = $request["data"]["date"];
        $data->impedance = $request["data"]["impedance"];
        $data->weight = $request["data"]["weight"];
        $data->BMI = $request["data"]["BMI"];
        $data->body_fat_percentage = $request["data"]["body_fat_percentage"];
        $data->muscle_kg = $request["data"]["muscle_kg"];
        $data->water_percentage = $request["data"]["water_percentage"];
        $data->VFAL = $request["data"]["VFAL"];
        $data->bone_kg = $request["data"]["bone_kg"];
        $data->BMR = $request["data"]["BMR"];
        $data->protein_percentage = $request["data"]["protein_percentage"];
        $data->VF_percentage = $request["data"]["VF_percentage"];
        $data->lose_fat_weight_kg = $request["data"]["lose_fat_weight_kg"];
        $data->body_standard = $request["data"]["body_standard"];
        $data->save();
        return [
            'result' => true
        ];
    }

}

