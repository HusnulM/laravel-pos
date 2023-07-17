<?php

use Illuminate\Support\Facades\DB;

function getDBFrefix(){
    $baseurl = env('DATABASE_FREFIX');
    return $baseurl;
}