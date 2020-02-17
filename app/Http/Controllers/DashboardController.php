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

                $max_amount = DailyTransactionDetails::selectRaw("name, SUM(`dailysales`)  as amount")
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


   public function chartReport(){

      $title = "Bar Chart";
      return view('dashboard.chart', compact('title'));

   }



   public function getDataForTransactionChart(Request $repquest){

    

     try {

       $year = $repquest->_year;

       $db_raw = DB::raw("YEAR(trn_date) ='$year'");

      $totalMonthlyTranasction = DailyTransactionDetails::select(DB::raw('SUM(dailysales) as amount'), DB::raw('YEAR(trn_date) year, MONTH(trn_date) month,
                                 CASE 
                                      WHEN month(`trn_date`) = 1 THEN "January"
                                      WHEN month(`trn_date`) = 2 THEN "February"
                                      WHEN month(`trn_date`) = 3 THEN "March"
                                      WHEN month(`trn_date`) = 4 THEN "April"
                                      WHEN month(`trn_date`) = 5 THEN "May"
                                      WHEN month(`trn_date`) = 6 THEN "June"
                                      WHEN month(`trn_date`) = 7 THEN "July"
                                      WHEN month(`trn_date`) = 8 THEN "August"
                                      WHEN month(`trn_date`) = 9 THEN "September"
                                      WHEN month(`trn_date`) = 10 THEN "October"
                                      WHEN month(`trn_date`) = 11 THEN "November"
                                      WHEN month(`trn_date`) = 12 THEN "December"
                                      ELSE "Not Define"       
                                  END AS MonthText'))
                                 ->whereRaw($db_raw)
                                 ->groupBy('year','month')
                                 ->get();

     
      $totalDailyTranasction = DailyTransactionDetails::select(DB::raw('SUM(dailysales) as amount'), DB::raw('YEAR(trn_date) year, MONTH(trn_date) month,
                                 DAY(trn_date) day, CASE 
                                      WHEN month(`trn_date`) = 1 THEN "January"
                                      WHEN month(`trn_date`) = 2 THEN "February"
                                      WHEN month(`trn_date`) = 3 THEN "March"
                                      WHEN month(`trn_date`) = 4 THEN "April"
                                      WHEN month(`trn_date`) = 5 THEN "May"
                                      WHEN month(`trn_date`) = 6 THEN "June"
                                      WHEN month(`trn_date`) = 7 THEN "July"
                                      WHEN month(`trn_date`) = 8 THEN "August"
                                      WHEN month(`trn_date`) = 9 THEN "September"
                                      WHEN month(`trn_date`) = 10 THEN "October"
                                      WHEN month(`trn_date`) = 11 THEN "November"
                                      WHEN month(`trn_date`) = 12 THEN "December"
                                      ELSE "Not Define"       
                                  END AS MonthText'))
                                 ->whereRaw($db_raw)
                                 ->groupBy('trn_date')
                                 ->get();
          $day = [];
          foreach ($totalDailyTranasction as $key => $value) {

             $day[$value->MonthText][] = [$value->day, (float)$value->amount];
          
          }

          $daily_transaction_data = [];

          foreach ($day as $key => $value) {
            
            $daily_transaction_data[] = ["name"=>$key, "id"=>$key, "data"=>$value];

          }



      

          $monthly_transaction_data = [];

          foreach ($totalMonthlyTranasction as $key => $value) {

                    
                    $monthly_transaction_data[] = ["name"=>$value->MonthText, "y"=>(float)$value->amount, "drilldown"=>$value->MonthText];

          }

          return response()->json(["monthly"=>$monthly_transaction_data, "daily"=>$daily_transaction_data, 'message'=>"Success!!", "code"=>200]);
             
         } catch (Exception $e) {

          return response()->json(["monthly"=>[], "daily"=>[], 'message'=>"Bad Request!!", "code"=>"420"]);
             
         }




   }

   
}
