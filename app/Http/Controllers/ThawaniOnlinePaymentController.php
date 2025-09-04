<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\ThawaniOnlinePayment;
use App\Services\ThawaniOnlinePaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThawaniOnlinePaymentController extends Controller
{

    public function createSession(Request $request)
    {
        $request->merge([
            'name' => 'Mada',
            'amount' => 10,
        ]);
        $thawani_online_payment_service = new ThawaniOnlinePaymentService(env('thawani_publishable_key'), env('thawani_secret_key'));
        ThawaniOnlinePayment::where('user_id', auth()->id())->delete();
        $thawani_online_payment_service_response = $thawani_online_payment_service->createCheckoutSession($request->name,$request->amount,$request->name);
        $session_id = $thawani_online_payment_service_response->data->session_id;
        $thwani = ThawaniOnlinePayment::whereSessionId($session_id)->first();
        if($this->pay($thwani))
        {
            $publishableKey = env('thawani_publishable_key');
            $paymentUrl = "https://uatcheckout.thawani.om/pay/{$thwani->session_id}?key={$publishableKey}";
            return redirect()->to($paymentUrl);
        }
        return $this->pay($thwani);
    }
    public function pay($thawani_online_payment)
    {
        $thawani_online_payment_service = new ThawaniOnlinePaymentService(env('thawani_publishable_key'), env('thawani_secret_key'));
        $thawani_online_payment_service_response = $thawani_online_payment_service->getCheckoutSession($thawani_online_payment->session_id);
        //Update thawani online payment
        $thawani_online_payment->status = $thawani_online_payment_service_response->data->payment_status;
        $thawani_online_payment->data = $thawani_online_payment_service_response;
        $thawani_online_payment->save();
        $thawani_online_payment->user_id = auth()->id();
        $thawani_online_payment->save();
        return true;
    }


    private function payStudentCourseFeeInstallment($thawani_online_payment)
    {
        $school = School::where('id', session('school_id'))->first();
        $thawani_online_payment_service = new ThawaniOnlinePaymentService($school->thawani_publishable_key, $school->thawani_secret_key);
        $thawani_online_payment_service_response = $thawani_online_payment_service->getCheckoutSession(session('thawani_online_payment_session_id'));

        //Update thawani online payment
        $thawani_online_payment->status = $thawani_online_payment_service_response->data->payment_status;
        $thawani_online_payment->data = $thawani_online_payment_service_response;
        $thawani_online_payment->user_id = session('father_id');
        $thawani_online_payment->save();

        if ($thawani_online_payment_service_response->data->payment_status == 'paid') {
            //update school fee installment data
            $student_course_fee_installment = StudentSchoolFeeInstallment::where('id', session('student_course_fee_installment_id'))->first();
            $student_course_fee_installment->pay_transaction_id = session('thawani_online_payment_session_id');
            $student_course_fee_installment->user_id = session('father_id');
            $student_course_fee_installment->is_paid = 1;
            $student_course_fee_installment->save();

            //forget session
            session()->forget(['student_course_fee_installment_id', 'thawani_online_payment_session_id', 'school_id', 'father_id']);
        }

        return true;
    }

    /**
     * Cancel
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function cancel(Request $request)
    {
        return $request->all();
        if (!session('thawani_online_payment_session_id')) {
            abort(404);
        }

        $thawani_online_payment = ThawaniOnlinePayment::where('session_id', session('thawani_online_payment_session_id'))->first();
        if ($thawani_online_payment == null) {
            abort(404);
        }

        $thawani_online_payment->status = 'cancelled';
        $thawani_online_payment->user_id = session('father_id');
        $thawani_online_payment->save();

        if (session('type') == 'subscribe') {
            $course = Course::where('id', session('course_id'))->first();

            session()->forget(['type', 'thawani_online_payment_session_id', 'school_id', 'student_id', 'course_id', 'father_id']);

            return view('site.subscribe', compact('course'))->withErrors(['error' => 'تم إلغاء عملية الدفع']);
        } else {
            session()->forget(['type', 'student_course_fee_installment_id', 'thawani_online_payment_session_id', 'school_id', 'father_id']);

            return redirect()->route('students.school_fees')->withErrors(['error' => 'تم إلغاء عملية الدفع']);
        }
    }

    public function success(Request $request)
    {
        return $request->all();
        //success reset sessinos
        $subscription = Subscription::whereId($request->subscription_id)->first();
        $expire_at = $subscription->days > 0 ? Carbon::now()->addDays($subscription->days) : NULL;
        Payment::create([
            'user_id'=>Auth::id(),
            'subscription_id'=>$subscription->id,
            'expire_at' =>$expire_at,
            'transaction_id'=>rand(123456,987342),
            'currency'=>$request->price_type,
            'is_trail'=>0,
            'status'=>1,
            'price'=>$request->price_type == "EGP" ? $subscription->price_egp : $subscription->price,
        ]);
        Auth::user()->update([
            'subscription_id'=>$subscription->id,
            'expire_at'=>$expire_at,
        ]);
        ThawaniOnlinePayment::where('user_id', auth()->id())->delete();
    }
}
