<?php

namespace App\Http\Controllers;

use App\Announcements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Log;
use Illuminate\Support\Facades\Session;
class AnnouncementController extends Controller
{
    //
    public function index(){
        if(Session::get('resident_id')==-1){
            $announcement = Announcements::orderby('id')->get();
            return view('admin.announcement',['announcement'=>$announcement]);
        }else return redirect('error');
    }


    public function add_announcement(Request $request){
        if($request->date <= Carbon::today()){
            return "You can not add anything before current date";
        }

        $announcement = new Announcements();
        $announcement->announce_desc=$request->announce_desc;
        $announcement->time=$request->time;
        $announcement->date=$request->date;
        $announcement->save();
    }

    public function update_announcement(Request $request){
        Announcements::where('id', $request->id)
            ->update(['announce_desc' => $request-> announce_desc,'time' => $request->time,'date' => $request->date]);
        return "Announcement has been updated!";
    }

    public function delete_announcement(Request $request){
        $list=explode(',',$request->remove_list);
        foreach($list as $one){
            Announcements::where('id', $one)->delete();
        }
        return "Announcements has been removed!";
    }
}
