<?php
namespace App;
use Eloquent;
use Validator;

class Room extends Eloquent {

    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 2;

    protected $fillable = [
							'user_id',
							'city_id',
							'type_id',
                            'address',
                            'area',
                            'condition_id',
                            'status'
						];
	protected $primaryKey = 'id';
	protected $table = 'room';

	public function validate($request)
    {
        return Validator::make($request->all(), [
            'city_id' => 'required',
            'address' => 'required',
            'type_id' => 'required',
            'area' => 'required',
            'condition_id' => 'required'
        ]);
    }

    public function City()
    {
        return City::find($this->city_id);
    }

    public function Type()
    {
        return RoomType::find($this->type_id);
    }

    public function Condition()
    {
        return Condition::find($this->condition_id);
    }
}
