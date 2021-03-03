<?php

/** @OA\Tag(
 *     name="Action",
 *     description ="Actions Users"
 * )
 */

namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest;
use App\Http\Requests\IncomeRequest;
use App\Models\Action;
use App\Services\ActionCreator;
use App\Services\Report;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /** @OA\Get(
     *     tags={"Action"},
     *     path="/api/action",
     *     description="Get the user's actions",
     *     @OA\Response(response="200", description="User model" ),
     *     @OA\Response(response="403", description="Unauthorized")
     * )
     */
    public function index()
    {
        return Action::where('user_id', auth()->id())->get();
    }

    /** @OA\Post (
     *     tags={"Action"},
     *     path="/api/action",
     *     description="Add new action",
     *     @OA\Parameter(
     *         name="{AddActionForm}",
     *         in="header",
     *         description="Form parameters",
     *         required=true,
     *  ),
     *     @OA\Response(response="200", description="unknown request" ),
     *     @OA\Response(response="201", description="added")
     * )
     */
    public function store(Request $request)
    {
        $actionRequest  =new ActionRequest();
        switch ($request->action) {
            case 'income':
                $request->validate($actionRequest->rules('income'));
                $actionCreator = new ActionCreator(auth()->id());
                if ($request->forceDate == null && $request->forceRate == null) {
                    $actionCreator->income($request->sum, $request->currency, $request->date);
                    return response('{"status":"added"}', 201);
                } else {
                    $actionCreator->income($request->sum, $request->currency, $request->date);
                    $actionCreator->forceExchange($request->sum, $request->currency, $request->forceDate,
                        $request->forceRate, auth()->user()->force_exchange_percentage);
                    return response('{"status":"added"}', 201);
                }
            case 'exchange':
                $request->validate($actionRequest->rules('exchange'));
                $actionCreator = new ActionCreator(auth()->id());
                $error = $actionCreator->exchange($request->sum, $request->currency, $request->date, $request->rate);
                return $this->errorHandler($error);
            case 'forceExchange':
                $request->validate($actionRequest->rules('exchange'));
                $actionCreator = new ActionCreator(auth()->id());
                $error = $actionCreator->forceExchange($request->sum, $request->currency, $request->date,
                    $request->rate, auth()->user()->force_exchange_percentage);
                return $this->errorHandler($error);
            default:
                return response(('{"status":"unknown request"}'), 200);
        }
    }

    private function errorHandler($error)
    {
        if ($error != null) {
            return response('{"status":"' . $error . '"}', 200);
        } else {
            return response('{"status":"added"}', 201);
        }
    }

    /** @OA\Post (
     *     tags={"Action"},
     *     path="/api/checkCount",
     *     description="Check sum of possible currency exchange",
     *     @OA\Parameter(
     *         name="currency",
     *         in="header",
     *         description="Currency",
     *         required=true,
     *  ),
     *     @OA\Response(response="200", description="sum of currency" ),
     * )
     */
    public function checkCount(Request $request)
    {
        $actionCreator = new ActionCreator(auth()->id());
        $sum = $actionCreator->checkCount(auth()->id(), $request->currency);
        return response('{"sum":"' . $sum . '"}', 200);
    }

    /** @OA\Post (
     *     tags={"Action"},
     *     path="/api/report",
     *     description="Create Report",
     *     @OA\Parameter(
     *         name="startDate",
     *         in="header",
     *         description="From date",
     *         required=true,
     *  ), @OA\Parameter(
     *         name="endDate",
     *         in="header",
     *         description="To date",
     *         required=true,
     *  ),
     *     @OA\Response(response="200", description="Formed" ),
     * )
     */
    public function report(Request $request)
    {
        $request->validate([
            'startDate' => 'required',
            'endDate' => 'required',
        ]);
        $report = new Report($request->startDate, $request->endDate, auth()->user()->id, auth()->user()->tax_rate);
        $response = '{"status":"Formed", '.$report->makeReport().', "startDate":"'.$request->startDate.'", "endDate":"'.$request->endDate.'" }';
        return response($response);
    }

    /** @OA\Post (
     *     tags={"Action"},
     *     path="/api/action/{id}",
     *     description="Create Report",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Delete by id",
     *         required=true,
     *  ),
     *     @OA\Response(response="200", description="deleted" ),
     *     @OA\Response(response="400", description="incorrect combination user and action" ),
     * )
     */
    public function destroy($id)
    {
        $action = Action::find($id);
        if ($action->user_id === auth()->id()) {
            $action->delete();
            return response('{"status":"deleted"}', 200);
        } else {
            return response('{"status":"incorrect combination user and action "}', 400);
        }
    }
}
