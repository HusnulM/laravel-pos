<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, DataTables;
use Validator,Redirect,Response;

class ItemMasterController extends Controller
{
    public function findItem(Request $request){
        $query['data'] = DB::table('0_item_codes')
            ->where('item_code', 'like', '%'. $request->search . '%')
            ->orWhere('description', 'like', '%'. $request->search . '%')
            ->get();

        // return \Response::json($query);
        return $query;
    }

    public function itemList(Request $request){
        $params = $request->params;        
        // $whereClause = $params['sac'];
        $query = DB::table('0_item_codes')->orderBy('id');
        return DataTables::queryBuilder($query)->setRowId('item_code')->toJson();
    }
}
