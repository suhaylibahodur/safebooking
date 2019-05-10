<?php

namespace App\Http\Controllers;

use App\RoomType;
use Illuminate\Http\Request;
use Validator;

class RoomTypeController extends Controller
{

	public function index(){
		$roomTypes = RoomType::whereNotNull('id');

		if(request()->has('name'))
            $roomTypes->where('name','like','%'.request('name').'%');

        $roomTypes->orderBy(request('sortBy'),request('order'));

		return $roomTypes->paginate(request('pageLength'));
	}

    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validation->fails())
        	return response()->json(['message' => $validation->messages()->first()],422);

        $roomType = new RoomType();
        $roomType->fill(request()->all());
        $roomType->save();

        return response()->json(['message' => 'RoomType added!', 'data' => $roomType]);
    }

    public function destroy(Request $request, $id){
        $roomType = RoomType::find($id);

        if(!$roomType)
            return response()->json(['message' => 'Couldnot find roomType!'],422);

        $roomType->delete();

        return response()->json(['message' => 'Task deleted!']);
    }

    public function show($id){
        $roomType = RoomType::find($id);

        if(!$roomType)
            return response()->json(['message' => 'Couldnot find roomType!'],422);

        return $roomType;
    }

    public function update(Request $request, $id){

        $roomType = RoomType::find($id);

        if(!$roomType)
            return response()->json(['message' => 'Couldnot find roomType!']);

        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $roomType->name = request('name');
        $roomType->save();

        return response()->json(['message' => 'RoomType updated!', 'data' => $roomType]);
    }
}
