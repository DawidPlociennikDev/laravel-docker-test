<?php

namespace App\Services;

use App\Models\Sms;
use Exception;
use Illuminate\Http\JsonResponse;

use Smsapi\Client\Curl\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;

class SmsService
{

    private string $apiKey;
    private string $smsFrom;
    private object $smsClient;

    public function __construct()
    {
        $this->apiKey = env('SMS_API_TOKEN');
        $this->smsFrom = env('SMS_FROM');
        $this->smsClient = new SmsapiHttpClient();
    }

    public function sendSms(object $smsData): JsonResponse
    {
        try {
            $storeSms = $this->storeSms((array) $smsData)->getData();
            if ($storeSms->success) {
                $service = $this->smsClient->smsapiPlService($this->apiKey);
                $result = $service->pingFeature()->ping();
                if ($result->authorized) {
                    $sms = SendSmsBag::withMessage($smsData->phone_number, $smsData->message);
                    $sms->from = $this->smsFrom;
                    $sms->encoding = 'utf-8';
                    $sendSms = $service->smsFeature()->sendSms($sms);
                    if ($sendSms->id) {
                        $this->updateStatus($storeSms->data->id);
                        return response()->json([
                            'success'   => true,
                            'code'      =>  200,
                            'data'   =>  $sendSms
                        ], 500);
                    }
                }
                throw new Exception("Not authorized");
            }
            throw new Exception($storeSms->data);
        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'code'      =>  500,
                'data'   =>  $th->getMessage(),
                'api_key'   =>  $this->apiKey
            ], 500);
        }
    }

    private function storeSms(array $smsData): JsonResponse
    {
        try {
            $data = Sms::create($smsData);
            if ($data) {
                return response()->json([
                    'success'   => true,
                    'code'      =>  200,
                    'data'   =>  $data
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success'   => false,
                'code'      =>  500,
                'data'   =>  $th->getMessage()
            ], 500);
        }
    }

    private function updateStatus(int $id): void
    {
        Sms::where('id', $id)->update(['status' => 1]);
    }
}
