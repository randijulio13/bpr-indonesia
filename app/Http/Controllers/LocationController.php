<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\State;
use App\Models\SubDistrict;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    function get(Request $request)
    {
        if ($request->type == 'state')
            return $this->get_state();
        if ($request->type == 'district')
            return $this->get_district($request->id);
        if ($request->type == 'sub_district')
            return $this->get_sub_district($request->id);
    }

    private function get_state()
    {
        return State::get();
    }

    private function get_district($id)
    {
        return District::where('state_id', '=', $id)->get();
    }

    private function get_sub_district($id)
    {
        return SubDistrict::where('district_number', '=', $id)->get();
    }
}
