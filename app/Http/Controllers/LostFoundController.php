<?php

namespace App\Http\Controllers;
use App\Residents;
use App\Rooms;
use App\LostFoundTopic;
use App\LostFoundReply;

use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Session;
use Response;
class LostFoundController extends Controller
{
    //
    public function index(){
      if(Session::get('resident_id')>0){
          $lostFoundTopics = LostFoundTopic::orderBy('created_at', 'desc')->paginate(3);
          $rooms=Rooms::get();
          $residents=Residents::get();

          return view('resident.LostFoundTopics',['residents'=>$residents,'lostFoundTopics'=>$lostFoundTopics,'rooms'=>$rooms]);
        }else return redirect('error');

    }

    public function add_topic(Request $request){
        Log::notice($request);
         $rid = $request->session()->get('resident_id');
         Log::notice($rid);
          $resident = Residents::where('id',$rid)->first();
          Log::notice($resident);

          $request->validate([
          'category'=>'required|boolean',
          'subject'=>'required',
          'message'=>'required']);

        $lfTopic = new LostFoundTopic;
        $lfTopic->residentId=$resident->id;
        $lfTopic->email=$resident->email;
        $lfTopic->category=$request->category;
        $lfTopic->subject=$request->subject;
        $lfTopic->message=$request->message;
        $lfTopic->date=date('Y-m-d H:i:s');
        $lfTopic->save();

    }

    public function remove_topic(Request $request){
        Log::notice($request);
        Log::notice($request->id);
        LostFoundTopic::where('id',$request->id)->delete();
        Log::notice($request->id);
        Log::notice($request->id);
    }




    public function get_edit_topic(Request $request){
        //$url='';
        Log::notice($request);

        $topic = LostFoundTopic::where('id',$request->id)->get();
        return Response::json($topic);

    }

    public function edit_topic (Request $request){
        Log::notice($request);
        Log::notice($request->session()->get('resident_id'));

        $request->validate([
        'subject'=>'required',
        'message'=>'required']);

        if($request->residentId ==  $request->session()->get('resident_id')) {
        LostFoundTopic::where('id', $request->topic_id)
          ->update(['subject' => $request->subject, 'message' => $request->message,'date' => date('Y-m-d')]);
          }
          else{
            //error page
          }

    }

    public function index_reply($id){
      if(Session::get('resident_id')>0){
        $lostFoundTopic = LostFoundTopic::where('id',$id)->get();
        $lostFoundReplies = LostFoundReply::where('topicId',$id)->orderBy('created_at', 'desc')->paginate(3);
        $rooms=Rooms::get();
        $residents=Residents::get();

        return view('resident.LostFoundReplies',['topic'=>$lostFoundTopic,'residents'=>$residents,'lostFoundReplies'=>$lostFoundReplies,'rooms'=>$rooms,'id'=>$id]);
        }else return redirect('error');

    }

    public function add_reply(Request $request){
      Log::notice($request);
      $rid = $request->session()->get('resident_id');
      Log::notice($rid);
       $resident = Residents::where('id',$rid)->first();
       Log::notice($resident);

       $request->validate([
       'message'=>'required']);

      $lfReply = new LostFoundReply;
      $lfReply->topicId=$request->topicId;
      $lfReply->residentId=$resident->id;
      $lfReply->email=$resident->email;
      $lfReply->message=$request->message;
      $lfReply->date= date('Y-m-d');
      $lfReply->save();
      LostFoundTopic::where('id',$request->topicId)->increment('reply_count');

    }


    public function get_edit_reply(Request $request){
        //$url='';
        Log::notice($request);
        $reply = LostFoundReply::where('id',$request->rid)->get();
        return Response::json($reply);

    }

    public function edit_reply (Request $request){
        Log::notice($request);
        Log::notice($request->session()->get('resident_id'));

        $request->validate([
        'message'=>'required']);

        if($request->residentId ==  $request->session()->get('resident_id')) {
        LostFoundReply::where('id', $request->reply_id)
          ->update(['message' => $request->message,'date' => date('Y-m-d')]);
          }
          else{
            //error page
          }

    }

    public function remove_reply(Request $request){
        Log::notice($request);

        LostFoundReply::where('id',$request->rid)->delete();

        LostFoundTopic::where('id',$request->id)->decrement('reply_count');

    }



    public function searchLostFound(Request $request){

      Log::notice($request);
        if($request->category == 0){
          if($request->search === null){
              $lostFoundTopics = LostFoundTopic::where('category',0)->orderBy('created_at', 'desc')->paginate(3);
          }
          else{
              $lostFoundTopics = LostFoundTopic::where('category',0)
                                          ->where('subject', 'like', '%'.$request->search.'%')
                                        //  ->where('message', 'like', '%'.$request->search.'%')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(3);
          }
        }
        else if($request->category == 1){
          if($request->search === null){
              $lostFoundTopics = LostFoundTopic::where('category',1)->orderBy('created_at', 'desc')->paginate(3);
          }
          else{
              $lostFoundTopics = LostFoundTopic::where('category',1)
                                          ->where('subject', 'like', '%'.$request->search.'%')
                                        //  ->where('message', 'like', '%'.$request->search.'%')
                                         ->orderBy('created_at', 'desc')
                                          ->paginate(3);
          }
        }
        else{
          if($request->search === null){
              $lostFoundTopics = LostFoundTopic::orderBy('created_at', 'desc')->paginate(3);
          }
          else{
              $lostFoundTopics = LostFoundTopic::where('subject', 'like', '%'.$request->search.'%')
                                          //->where('message', 'like', '%'.$request->search.'%')
                                          ->orderBy('created_at', 'desc')
                                          ->paginate(3);
          }
        }

           //$lostFoundTopics->withPath('/php-group-project-c4i/public/LostFoundTopics');
           $lostFoundTopics->appends(['search' => $request->search]);
        $rooms=Rooms::get();
        $residents=Residents::get();
        return view('resident.LostFoundTopics',['residents'=>$residents,'lostFoundTopics'=>$lostFoundTopics,'rooms'=>$rooms]);


    }



    public function indexAdmin(){
      if(Session::get('resident_id')==-1){
          $lostFoundTopics = LostFoundTopic::get();
          $rooms=Rooms::get();
          $residents=Residents::get();

          return view('admin.LostFoundTopicsAdmin',['residents'=>$residents,'lostFoundTopics'=>$lostFoundTopics,'rooms'=>$rooms]);
        }else return redirect('error');
    }

    public function index_reply_admin($id){
      if(Session::get('resident_id')==-1){
          $lostFoundTopic = LostFoundTopic::where('id',$id)->get();
          $lostFoundReplies = LostFoundReply::where('topicId',$id)->get();
          $rooms=Rooms::get();
          $residents=Residents::get();
          return view('admin.LostFoundRepliesAdmin',['topic'=>$lostFoundTopic,'residents'=>$residents,'lostFoundReplies'=>$lostFoundReplies,'rooms'=>$rooms,'id'=>$id]);
        }else return redirect('error');
    }
}
