<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProfitCalculationTrait;
use App\Http\Requests;
use App\Transaction;
use App\DailyTransactionDetails;
use App\DailyTypewiseDetails;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Report\Engagement\DailyEngagementReport as EReport;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

         //if (auth()->user()->type !=="Admin")
                     //abort(403);

        try {

                $title = 'Welcome To Dashboard';
                $current_date = '2020-01-07';
                $totalTransactions = null;

                $current_day_summary = DailyTransactionDetails::selectRaw("
                                                    SUM(`numbers`) as quantity, SUM(`dailysales`) as amount, SUM(`arpu`) as arpu
                                                   ")
                                                ->whereRaw("`trn_date` = '".$current_date."'")
                                                ->where("type", 4)
                                                ->first();

                $cashIn_quantity = $current_day_summary->quantity;

                /** Divided BY 1000000 FROM Convert Amount in Million **/

                $cashIn_amount = ($current_day_summary->amount / 1000000); 


                $previous_day_summary = DailyTransactionDetails::selectRaw("
                                                    SUM(`numbers`) as quantity, SUM(`dailysales`) as amount, SUM(`arpu`) as arpu
                                                   ")
                                                ->whereRaw("`trn_date` BETWEEN '".$current_date."' - INTERVAL 1 DAY AND '".$current_date."' - INTERVAL 1 SECOND")
                                                ->where("type", 4)
                                                ->first();

               $cashIn_amount_percent = ($current_day_summary->amount - $previous_day_summary->amount) / $current_day_summary->amount;

               $cashIn_quantity_percent = ($current_day_summary->quantity - $previous_day_summary->quantity) / $current_day_summary->quantity;

               
               $max_quantity = DailyTransactionDetails::selectRaw("
                                                    name, SUM(`numbers`) as quantity
                                                   ")
                                                ->whereRaw("`trn_date` BETWEEN '".$current_date."' AND '".$current_date."'")
                                                ->where("type", 4)
                                                ->groupBy("receiver_id")
                                                ->orderBy("quantity", "DESC")
                                                ->first();

                $max_amount = DailyTransactionDetails::selectRaw("name, SUM(`dailysales`) as amount")
                                                ->whereRaw("`trn_date` BETWEEN '".$current_date."' AND '".$current_date."'")
                                                ->where("type", 4)
                                                ->groupBy("receiver_id")
                                                ->orderBy("amount", "DESC")
                                                ->first();
       
                
        return view('dashboard.dashboard', compact('title', 'cashIn_quantity', 'cashIn_amount', 'max_quantity', 'max_amount', 'previous_day_summary', 'cashIn_amount_percent', 'cashIn_quantity_percent'));

        } catch (\Exception $e) {

            Log::error($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());

            abort(503);
        }
    }



    public function getTypeWiseChart($request){

        $db_raw = DB::raw(" `trn_date` BETWEEN '".$request->_fromDate."' AND '".$request->_toDate."'");
        
        $totalDailyTranasction = DailyTypewiseDetails::select('type_name as name', DB::raw('SUM(qty) as quantity, SUM(dailysales) as amount, SUM(arpu) as arpu'))
                                ->whereRaw($db_raw)->whereNotIn("type", [14])->groupBy("type")
                                ->get();

        return $totalDailyTranasction;

    }

   public function getSingleTypeChart($request){
              
        
         $db_raw = DB::raw(" `trn_date` BETWEEN '".$request->_fromDate."' AND '".$request->_toDate."'");

         $totalDailyTranasction = DailyTransactionDetails::select('name', 'type',  DB::raw('SUM(numbers) as quantity, SUM(dailysales) as amount, SUM(arpu) as arpu'))
                                 ->whereIn("type", [$request->_type])
                                 ->whereRaw($db_raw)
                                 ->groupBy("receiver_id")
                                 ->get();

        return $totalDailyTranasction;
   }



   public function dashboardReport(Request $request){

         $data = [];

         try {
          
          if($request->_type=="all"){

            $data = $this->getTypeWiseChart($request);

          }
          else{

            $data = $this->getSingleTypeChart($request);

          }

          
          $summary = $this->summaryReportDashboard($request);

          return response()->json(["chart"=>$data, "summary"=>$summary, 'message'=>"Success!!", "code"=>200]);
             
         } catch (Exception $e) {

            return response()->json(["chart"=>[], "summary"=>[], 'message'=>"Bad Request!!", "code"=>"420"]);
             
         }


   }


   public function summaryReportDashboard($request){

      try {

                $title = 'Welcome To Dashboard';
                $from_date = $request->_fromDate;
                $to_date = $request->_toDate;
                $cashIn_quantity = 0;
                $cashIn_amount = 0;
                $cashIn_amount_percent = 0;
                $cashIn_quantity_percent = 0;


               $current_day_summary = DailyTransactionDetails::selectRaw("
                                                    SUM(`numbers`) as quantity, SUM(`dailysales`) as amount, SUM(`arpu`) as arpu
                                                   ")
                                                ->whereRaw("`trn_date` BETWEEN '".$from_date."' AND '".$to_date."'")
                                                ->where("type", 4)
                                                ->first();


              

                
            $previous_day_summary = DailyTransactionDetails::selectRaw("
                                                    SUM(`numbers`) as quantity, SUM(`dailysales`) as amount, SUM(`arpu`) as arpu
                                                   ")
                                                ->whereRaw("`trn_date` BETWEEN '".$from_date."' - INTERVAL 1 DAY AND '".$from_date."' - INTERVAL 1 SECOND")
                                                ->where("type", 4)
                                                ->first();





            if($current_day_summary->quantity > 0 &  $current_day_summary->amount > 0){

                $cashIn_quantity = $current_day_summary->quantity;

                /** Divided BY 1000000 FROM Convert Amount in Million **/

                $cashIn_amount = ($current_day_summary->amount / 1000000); 

               $cashIn_amount_percent = ($current_day_summary->amount - $previous_day_summary->amount) / $current_day_summary->amount;

               $cashIn_quantity_percent = ($current_day_summary->quantity - $previous_day_summary->quantity) / $current_day_summary->quantity;


                } 
                                          
              



               $max_quantity = DailyTransactionDetails::selectRaw("
                                                    name, SUM(`numbers`) as quantity
                                                   ")
                                                ->whereRaw("`trn_date` BETWEEN '".$from_date."' AND '".$to_date."'")
                                                ->where("type", 4)
                                                ->groupBy("receiver_id")
                                                ->orderBy("quantity", "DESC")
                                                ->first();

                $max_amount = DailyTransactionDetails::selectRaw("name, SUM(`dailysales`) as amount")
                                                ->whereRaw("`trn_date` BETWEEN '".$from_date."' AND '".$to_date."'")
                                                ->where("type", 4)
                                                ->groupBy("receiver_id")
                                                ->orderBy("amount", "DESC")
                                                ->first();
       
                
        return ["q"=>$cashIn_quantity, "a"=>$cashIn_amount, 'qp'=>$cashIn_quantity_percent, 'ap'=>$cashIn_amount_percent, "mq"=>$max_quantity, "ma"=>$max_amount];

        } catch (\Exception $e) {

            Log::error($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());

            abort(503);
        }

   }

   
}
