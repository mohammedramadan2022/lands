<?php


namespace App\Http\Traits;



use App\Models\FirebaseToken;

trait NotificationFirebaseTrait
{
    /*
       |--------------------------------------------------------------------------
       | send Firebase Notification
       |--------------------------------------------------------------------------
       |
       |this function take a 3 params
       |1- array of users Id , you want to sent
       |2-single id to get the name of sender
       |3-mess array to send
       |
       | Support: "ios ", "android"
       |
       */
    public function sendFCMNotification($array_to,$user_type, $mess)
    {

        $API_ACCESS_KEY = env('FIREBASE_KEY');
        //-------------------------------------------------------
        $tokens = FirebaseToken::whereIn("user_id", $array_to)->where('user_type',$user_type)->get();

        //--------------------------------------------------------
        $android_tokens = null;
        $ios_tokens = null;
        //check the tokens software types
        foreach ($tokens as $item) {
            if ($item->type == 'android') {
                $android_tokens[] = $item->token;
            } else if ($item->type == 'ios') {
                $ios_tokens[] = $item->token;
            }
        }
        //-------------------------------------------------------
        /*if ($i==3){
            dd($android_tokens);
        }*/
        $this->send_to_android_devices($android_tokens, $API_ACCESS_KEY, $mess);
        $this->send_to_ios_devices($ios_tokens, $API_ACCESS_KEY, $mess);
    }

    //------------------Send To Android Device---------------
    private function send_to_android_devices($android_tokens, $API_ACCESS_KEY, $notifications)
    {

        //handle android tokens
        if ($android_tokens != null) {

            //prep the android payload
            $fields = array
            (
                'registration_ids' => $android_tokens,
                'data' => $notifications['data'],
                'notification'=>$notifications['notification'],
            );

            //Generating JSON encoded string form the above array.
            $json = json_encode($fields);
            //Setup headers:
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key= ' . $API_ACCESS_KEY; // key here
            //Setup curl, add headers and post parameters.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            /* curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);*/
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
    }//end fun

    //------------------Send To Ios Device-------------------
    private function send_to_ios_devices($ios_tokens, $API_ACCESS_KEY, $notifications)
    {
        //handle ios tokens
        if ($ios_tokens != null) {
            $notifications['sound'] = 'default';
            $fields = array
            (
                'registration_ids' => $ios_tokens,
                'data' => $notifications['data'],
                'notification'=>$notifications['notification'],
            );

            $headers = array
            (
                'Authorization: key=' . $API_ACCESS_KEY,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            $json = json_encode($fields);
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }//end fun
    //--------------------------------------------------------
}
