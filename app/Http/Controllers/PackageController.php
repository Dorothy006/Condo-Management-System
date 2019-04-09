<?php

namespace App\Http\Controllers;
use App\Residents;
use App\Rooms;
use App\Mailbox;
use App\Packages;



use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use Mail;
use Hash;
use App\Mail\ConfirmPackage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Response;
class PackageController extends Controller
{


    public function index(){
        if(Session::get('resident_id')==-1){
              $packages = Packages::join('rooms','packages.roomId','=','rooms.id')
                          ->select('packages.*','rooms.roomnumber')->get();
              $rooms=Rooms::get();
              $mailbox=Mailbox::where('available',0)->get();
              $residents=Residents::get();
              return view('admin.package',['residents'=>$residents,'packages'=>$packages,'rooms'=>$rooms,'mailbox'=>$mailbox]);
        }
        else
          return redirect('error');
    }



    public function add_package(Request $request){

        Log::notice($request);

          $request->validate([
          'roomId'=>'required|integer',
          'packageName'=>'required',
          'packageInfo'=>'required',
          'mailbox'=>'required|integer']);

      	  $package = new Packages;
          $package->roomId=$request->roomId;
          $package->packageName=$request->packageName;
          $package->packageInfo=$request->packageInfo;
          $package->mailboxId=$request->mailbox;
          $package->mailboxPW= rand ( 10000 , 99999 );
          $package->date=date('Y-m-d H:i:s');
          $package->save();

          self::setMailBoxUnAva($request->mailbox,$request->mailboxPW);


        $packageGet=Packages::where('mailboxId',$request->mailbox)->first();
        $resident=Residents::where('roomid',$request->roomId)
                    ->where('name', 'like', '%'.$request->packageName.'%')->first();
        if ($resident == null){
            $resident=Residents::where('roomid',$request->roomId)->first();
        }
        self::package_email($resident,$packageGet);
    }



    public function package_email($resident,$package){
        set_time_limit(60);
        Mail::to($resident->email)->send(new ConfirmPackage($resident,$package));
        return 'Email sending success';
    }


    public function pack_confirm($id,$packid){
        Packages::where('id',$packid)->update(['status' => 0]);
        return redirect('login');
    }


    public function get_update_package(Request $request){
        //$url='';
        Log::notice($request);
        $package = Packages::where('id',$request->id)->get();
        return Response::json($package);

    }

    public function update_package(Request $request){
        Log::notice($request);

          $request->validate([
          'roomId'=>'required|integer',
          'packageName'=>'required',
          'packageInfo'=>'required',
          'mailbox'=>'required|integer']);

          $mailbox_id_old = $request->mailbox_id_old;

        if($request->mailbox != $mailbox_id_old){
                self::setMailBoxAva($mailbox_id_old);
                  $mailboxPW = rand ( 10000 , 99999 );
                  Packages::where('id', $request->package_id)
                    ->update(['roomId' => $request->roomId,'packageName' => $request->packageName,
                      'packageInfo' =>$request->packageInfo,'mailboxId' =>$request->mailbox,
                      'mailboxPW'=>$mailboxPW, 'date' => date('Y-m-d H:i:s')]);

                self::setMailBoxUnAva($request->mailbox,  $mailboxPW);

                $packageGet=Packages::where('mailboxId',$request->mailbox)->first();
                $resident=Residents::where('roomid',$request->roomId)
                            ->where('name', 'like', '%'.$request->packageName.'%')  ->first();
                if ($resident == null){
                    $resident=Residents::where('roomid',$request->roomId)->first();
                }
                self::package_email($resident,$packageGet);
        }
       else{
             Packages::where('id', $request->package_id)
               ->update(['roomId' => $request->roomId,'packageName' => $request->packageName,
                 'packageInfo' =>$request->packageInfo,'mailboxId' =>$request->mailbox,
                 'date' => date('Y-m-d H:i:s')]);
       }
    }

    public function remove_package(Request $request){
        Log::notice($request);

        Packages::where('id',$request->package_id)->delete();

        self::setMailBoxAva($request->mailbox_id);
    }


    public function add_mailbox(Request $request){
        $mailbox = new Mailbox;
        $mailbox->save();

    }


    public function setMailBoxUnAva( $mailbox_id,$mailboxPW) {

        Mailbox::where('id',$mailbox_id)
          ->update(['available' => 1, 'password' => $mailboxPW]);

    }

    public function setMailBoxAva($mailbox_id) {

      Mailbox::where('id',$mailbox_id)
        ->update(['available' => 0, 'password' => NULL]);

    }



}
