<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Validator;

class CityController extends Controller
{

	public function index(){
		$cities = City::whereNotNull('id');

		if(request()->has('name'))
            $cities->where('name','like','%'.request('name').'%');

        $cities->orderBy(request('sortBy'),request('order'));

		return $cities->paginate(request('pageLength'));
	}

    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validation->fails())
        	return response()->json(['message' => $validation->messages()->first()],422);

        $city = new City();
        $city->fill(request()->all());
        $city->save();

        return response()->json(['message' => 'City added!', 'data' => $city]);
    }

    public function destroy(Request $request, $id){
        $city = City::find($id);

        if(!$city)
            return response()->json(['message' => 'Couldnot find city!'],422);

        $city->delete();

        return response()->json(['message' => 'Task deleted!']);
    }

    public function show($id){
        $city = City::find($id);

        if(!$city)
            return response()->json(['message' => 'Couldnot find city!'],422);

        return $city;
    }

    public function update(Request $request, $id){

        $city = City::find($id);

        if(!$city)
            return response()->json(['message' => 'Couldnot find city!']);

        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $city->name = request('name');
        $city->save();

        return response()->json(['message' => 'City updated!', 'data' => $city]);
    }
}
