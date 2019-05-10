<?php

namespace App\Http\Controllers;

use App\Condition;
use Illuminate\Http\Request;
use Validator;

class ConditionController extends Controller
{

	public function index(){
		$conditions = Condition::whereNotNull('id');

		if(request()->has('name'))
            $conditions->where('name','like','%'.request('name').'%');

        $conditions->orderBy(request('sortBy'),request('order'));

		return $conditions->paginate(request('pageLength'));
	}

    public function store(Request $request){

        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validation->fails())
        	return response()->json(['message' => $validation->messages()->first()],422);

        $condition = new Condition();
        $condition->fill(request()->all());
        $condition->save();

        return response()->json(['message' => 'Condition added!', 'data' => $condition]);
    }

    public function destroy(Request $request, $id){
        $condition = Condition::find($id);

        if(!$condition)
            return response()->json(['message' => 'Couldnot find condition!'],422);

        $condition->delete();

        return response()->json(['message' => 'Task deleted!']);
    }

    public function show($id){
        $condition = Condition::find($id);

        if(!$condition)
            return response()->json(['message' => 'Couldnot find condition!'],422);

        return $condition;
    }

    public function update(Request $request, $id){

        $condition = Condition::find($id);

        if(!$condition)
            return response()->json(['message' => 'Couldnot find condition!']);

        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first()],422);

        $condition->name = request('name');
        $condition->save();

        return response()->json(['message' => 'Condition updated!', 'data' => $condition]);
    }
}
