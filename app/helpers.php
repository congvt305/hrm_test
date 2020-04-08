<?php

if (!function_exists('getTotalOfNumberStaff')) {
    function getTotalOfNumberStaff($status)
    {
        $total = 0;

        if ($status == -1) {
            $total = App\User::all()->count();
        } elseif ($status == 0) {
            $total = App\User::where('active', 0)->get()->count();
        } elseif ($status == 1) {
            $total = App\User::where('active', 1)->get()->count();
        }

        return $total;
    }
}
