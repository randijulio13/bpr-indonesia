<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function initials($str)
{
    $ret = '';
    foreach (explode(' ', $str) as $word)
        $ret .= strtoupper($word[0]);
    return $ret;
}

function get_state_id($str, $percent = 65)
{
    $data = [];
    $states = DB::table('states')->get()->toArray();
    foreach ($states as $state) {
        similar_text($str, $state->label, $similarity);
        if ($similarity > $percent)
            $data[] = [
                'percent'   => $similarity,
                'id'        => $state->state_id
            ];
    }
    return max($data)['id'];
}

function get_district_id($str, $state_id, $percent = 65)
{
    $districts = DB::table('districts')->where('state_id', '=', $state_id)->get()->toArray();
    foreach ($districts as $district) {
        similar_text($str, $district->label, $similarity);
        if ($similarity > $percent)
            $data[] = [
                'percent'   => $similarity,
                'id'        => $district->district_id
            ];
    }
    return max($data)['id'];
}

function get_state($id)
{
    return DB::table('states')->where('state_id', '=', $id)->value('label');
}

function get_district($id)
{
    return DB::table('districts')->where('district_id', '=', $id)->value('label');
}

function get_sub_district($id)
{
    return DB::table('sub_districts')->where('sub_district_id', '=', $id)->value('label');
}

function str_only($join)
{
    $newString = preg_replace('/[^a-z0-9]/i', '', $join);
    return $newString;
}
