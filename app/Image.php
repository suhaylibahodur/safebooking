<?php
namespace App;
use Eloquent;
use Validator;

class Image extends Eloquent {

    protected $fillable = [
							'room_id',
							'path',
						];
	protected $primaryKey = 'id';
	protected $table = 'image';

	public function validate($request)
    {
        return Validator::make($request->all(), [
            'room_id' => 'required',
            'path' => 'required',
        ]);
    }
}
