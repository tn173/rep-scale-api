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
        $data->weight = $request["data"]["weight"];
        // $data->BMI = $request->BMI;
        // $data->body_fat_rate = $request->body_fat_rate;
        // $data->subcutaneous_fat = $request->subcutaneous_fat;
        // $data->visceral_fat = $request->visceral_fat;
        // $data->body_water_rate = $request->body_water_rate;
        // $data->muscle_rate = $request->muscle_rate;
        // $data->bone_mass = $request->bone_mass;
        // $data->BMR = $request->BMR;
        // $data->body_type = $request->body_type;
        // $data->protein = $request->protein;
        // $data->lean_body_weight = $request->lean_body_weight;
        // $data->muscle_mass = $request->muscle_mass;
        // $data->metabolic_age = $request->metabolic_age;
        // $data->health_score = $request->health_score;
        // $data->heart_rate = $request->heart_rate;
        // $data->heart_index = $request->heart_index;
        // $data->fat_mass = $request->fat_mass;
        // $data->obesity_degree = $request->obesity_degree;
        // $data->water_content = $request->water_content;
        // $data->protein_mass = $request->protein_mass;
        // $data->mineral_salt = $request->mineral_salt;
        // $data->best_visual_weight = $request->best_visual_weight;
        // $data->stand_weight = $request->stand_weight;
        // $data->weight_control = $request->weight_control;
        // $data->fat_control = $request->fat_control;
        // $data->muscle_control = $request->muscle_control;
        // $data->muscle_mass_rate = $request->muscle_mass_rate;
        $data->save();
        return [
            'result' => true
        ];
    }

}

