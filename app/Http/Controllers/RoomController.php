<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Validator;

class RoomController extends Controller
{

	public function index(){
        $user = \JWTAuth::parseToken()->authenticate();

		$rooms = Room::whereNotNull('id');
        $rooms->whereStatus(Room::STATUS_ACTIVE);
        $rooms->where('user_id', $user->id);
        $rooms->orderBy(request('sortBy'),request('order'));

        $rooms = $rooms->paginate(request('pageLength'));

        foreach ($rooms->items() as $room) {
            $room->city_name = $room->City()->name;
            $room->type_name = $room->Type()->name;
            $room->condition_name = $room->Condition()->name;
        }

		return $rooms;
	}

    public function store(Request $request){

        $room = new Room();
        $validation = $room->validate($request);

        if($validation->fails())
        	return response()->json(['message' => $validation->messages()->first()],422);

        $user = \JWTAuth::parseToken()->authenticate();
        $room->fill(request()->all());
        $room->user_id = $user->id;
        $room->status  = Room::STATUS_ACTIVE;
        $room->save();

        return response()->json(['message' => 'Room added!', 'data' => $room]);
    }

    public function destroy(Request $request, $id){
        $room = Room::find($id);

        if(!$room)
            return response()->json(['message' => 'Couldnot find room!'],422);

        $room->status  = Room::STATUS_NOT_ACTIVE;
        $room->save();

        return response()->json(['message' => 'Room deleted!']);
    }

    public function show($id){
        $room = Room::find($id);

        if(!$room)
            return response()->json(['message' => 'Couldnot find room!'],422);

        return $room;
    }

    public function update(Request $request, $id){

        $room = Room::find($id);

        if(!$room)
            return response()->json(['message' => 'Couldnot find room!']);

        $roomModel = new Room();
        $validation = $roomModel->validate($request);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $room->city_id = request('city_id');
        $room->address = request('address');
        $room->type_id = request('type_id');
        $room->condition_id = request('condition_id');
        $room->area = request('area');
        $room->save();

        return response()->json(['message' => 'Room updated!', 'data' => $room]);
    }
}
