<?php
namespace App\Http\Controllers;

//use App\Image;
use App\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    protected $roomsPath = 'images/rooms/';

    public function upload(Request $request)
    {
        $roomId = request('room_id');
        if (!isset($roomId)) {
            return response()->json(['message' => 'Please, send roomId!'],422);
        }
        if (count($request->images)) {
            foreach ($request->images as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = uniqid();
                $file = $image->move($this->roomsPath, $filename.".".$extension);
                $img = \Image::make($this->roomsPath.$filename.".".$extension);
                $img->save($this->roomsPath.$filename.".".$extension);

                $image = new Image();
                $image->room_id = $roomId;
                $image->path = $this->roomsPath.$filename.".".$extension;
                $image->save();
            }
        }
        return response()->json([
            "message" => "Uploaded successfully"
        ]);
    }

    public function getByRoomId($roomId)
    {
        $images = Image::whereNotNull('id');
        $images->where('room_id', $roomId);
        $images->orderBy('created_at','asc');
        return $images->paginate(1000);
    }
}