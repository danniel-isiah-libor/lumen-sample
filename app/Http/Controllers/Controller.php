<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{DB, Log};
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Handle service response.
     * 
     * @param String $msg
     * @param function $fn
     * @return \Illuminate\Http\Response
     */
    protected function response($msg, $fn)
    {
        DB::beginTransaction();

        try {
            $data = $fn();

            DB::commit();

            return response()->json([
                'message' => $msg,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Exception : ", [$e->getMessage()]);

            if (
                env('APP_DEBUG') &&
                (env('APP_ENV') !== 'production' || env('APP_ENV') !== 'release')
            ) throw $e;

            return response()->json([
                'message' => 'Internal Server Error',
                'data' => null
            ], 500);
        }
    }
}
