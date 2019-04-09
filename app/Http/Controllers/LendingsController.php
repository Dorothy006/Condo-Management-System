<?php

namespace App\Http\Controllers;
use App\Lendings;
use Illuminate\Support\Facades\Session;
use Log;
use Illuminate\Http\Request;

class LendingsController extends Controller
{
    //
    public function index()
    {
        if(Session::get('resident_id')==-1){
            $lending =Lendings::OrderBy('itemName','desc')->get();
            return view('admin.lendings')->with('lending',$lending);
        }else return redirect('error');
    }

    public function add_lendings(Request $request){
        Log::notice($request);
        $lending = new Lendings();
        $lending->itemName=$request->itemName;
        $lending->borrowerName=$request->borrowerName;
        $lending->borrowDate=$request->borrowDate;
        $lending->save();
        return redirect(route('lendings'));
    }
    public function update_lendings(Request $request){
        Lendings::where('id', $request->id)
            ->update(['itemName' => $request-> itemName,
                'borrowerName' => $request->borrowerName,
                'borrowDate' => $request->borrowDate]);
        return redirect(route('lendings'));
    }
    public function delete_lendings(Request $request){
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            Lendings::where('id', $one)->delete();
        }
        return "Lending has been removed!";
    }
}
