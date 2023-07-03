<?php

namespace App\Http\Controllers;

use App\Services\SmsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use stdClass;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sms(Request $request, SmsService $sms): JsonResponse
    {
        try {
            $smsData = new stdClass;
            $smsData->phone_number = (int) $request->phone_number;
            $smsData->message = $request->message;
            if ($smsData->phone_number && $smsData->message) {
                $sms = $sms->sendSms((object) $smsData);
                if ($sms->getData()->success) {
                    Log::info($sms);
                    return response()->json([
                        'success'   => false,
                        'code'      =>  200,
                        'data'   =>  $sms
                    ], 200);
                } else {
                    Log::error($sms);
                    throw new Exception($sms);
                }
            } else {
                throw new Exception("Missing variables");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'success'   => false,
                'code'      =>  500,
                'data'   =>  $th->getMessage()
            ], 500);
        }
    }
}
