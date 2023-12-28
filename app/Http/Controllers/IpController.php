<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use App\Models\Ip;

class IpController extends Controller
{
    public function index(Request $request)
    {
        $isSuccess = true;
        $ipInfoForResponse = [];
        // @todo написать валидацию ip-адреса
        $receivedIp = $request->input('ipv4');

        $ipInfoFromDB = Ip::where('ip', $receivedIp)->first();

        if (!empty($ipInfoFromDB)) {
            $ipInfoForResponse = [
                'countryName' => $ipInfoFromDB->countryName,
                'regionName' => $ipInfoFromDB->regionName,
                'cityName' => $ipInfoFromDB->cityName,
            ];
        } elseif ($ipInfoFromRemoteHost = Location::get($receivedIp)) {
            Ip::created([
                'ip' => $receivedIp,
                'countryName' => $ipInfoFromRemoteHost->countryName,
                'regionName' => $ipInfoFromRemoteHost->regionName,
                'cityName' => $ipInfoFromRemoteHost->cityName
            ]);
            // @todo выяснить почему не записывается дата в БД
            $ipInfoForResponse = Ip::where('ip', $receivedIp)->first();
//            dd($ipInfoForResponse);
        } else {
            if ($ipInfoFromRemoteHost == false) {
                $ipInfoForResponse['error'] = "IP $receivedIp not found";
                $isSuccess = false;
            }
        }

        return response()->json(array_merge(['success' => $isSuccess], $ipInfoForResponse), 200);
    }
}
