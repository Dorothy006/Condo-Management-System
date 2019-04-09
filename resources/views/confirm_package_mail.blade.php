You, or some in you condo has recieved a Package.<br>
It can be collected for MailBox No. {{$package->mailboxId}} in the Condo Atrium.<br>
The Password to the MailBox is {{$package->mailboxPW}}<br>
<a href="{{route('packconfirmed',["id"=>$resident->id,"packid"=>$package->id])}}">
  Click this link to confirm you have collected you Package.</a><br>
 <br>Thank you
