<?php

namespace App\Report\Engagement;
use Carbon\Carbon;
use DB;

class UniqueTransactionReportBuilder
{
  public static function build($rdate = null, $year = null, $month = null)
  {
    \Log::info("RDate :".$rdate." Year: ".$year." Month: ".$month);

    if($month==null)
    {
      $month = date('m');
    }

    if($year == null)
    {
      $year = date('Y');
    }

    if($rdate == null)
    {
      $rdate = date('Y-m-d');
    }

    $previous_year = ( $month-1 == 0) ? ($year-1) : $year;
    $previous_month = ( $month-1 == 0) ? 12 : ($month-1) ;

    $starting_date = Carbon::create($previous_year, $previous_month, 1)->format('Y-m-d');
    $ending_date = date("Y-m-t", strtotime($starting_date));

    $transactionReport = UniqueTransactionReport::where('month', $month)->where('year', $year)->get();



    if(count($transactionReport) == 0){
      try{
          $fileName = "Monthly-unique-transaction-report-".$rdate . uniqid();
          $dir = 'engagements/';

          $transactions = DB::select(DB::raw("SELECT
              users.id,
              users.account_no,
              users.mobile_no,
              users.email,
              users.balance,
              users.status,
              users.created_at
          FROM
              users
          LEFT JOIN
              transactions
          ON
              transactions.sender_id = users.id
          WHERE
              users.account_no IS NOT NULL AND transactions.created_at BETWEEN '$starting_date' AND '$ending_date'
          GROUP BY
              users.id,
              users.account_no,
              users.mobile_no,
              users.email,
              users.balance,
              users.status,
              users.created_at
          HAVING
              COUNT(transactions.id) > 0
          UNION
          SELECT
              users.id,
              users.account_no,
              users.mobile_no,
              users.email,
              users.balance,
              users.status,
              users.created_at
          FROM
              users
          LEFT JOIN
              transactions
          ON
              transactions.receiver_id = users.id
          WHERE
              users.account_no IS NOT NULL AND transactions.created_at BETWEEN '$starting_date' AND '$ending_date'
          GROUP BY
              users.id,
              users.account_no,
              users.mobile_no,
              users.email,
              users.balance,
              users.status,
              users.created_at
          HAVING
              COUNT(transactions.id) > 0"));


          $data = $transactions;

          $file = \Excel::create($fileName, function($excel) use($data) {
              $excel->sheet('sheet1', function($sheet) use($data) {
                  $sheet->setOrientation('landscape');
                  $sheet->row(1, array(
                          'Account No',
                          'Mobile No',
                          'Email',
                          'Balance',
                          'Status',
                          'Created At'
                      )
                  );

                  $rowIndex = 2;
                  foreach($data as $row)
                  {
                      $sheet->row($rowIndex, [
                          $row->account_no,
                          $row->mobile_no,
                          $row->email,
                          $row->balance,
                          $row->status,
                          $row->created_at
                      ]);
                      $rowIndex++;
                  }
              });
          })->string('xls');

          $fileName = $dir . $fileName.'.xls';


          if(in_array(config('app.url'), ['https://secure.fast-pay.cash', 'https://dev.fast-pay.cash'])) {
              \Storage::disk('s3')->put($fileName, $file, 'private');
          } else {
              \Storage::put($fileName, $file, 'private');
          }

          \DB::beginTransaction();
          $e = new UniqueTransactionReport();
          $e->month = $month;
          $e->year = $year;
          $e->count = count($transactions);
          $e->file = $fileName;
          $e->created_at = date('Y-m-d H:i:s', strtotime($rdate));
          $e->save();
          \DB::commit();

      }catch(\Exception $e){
          \Log::error($e->getFile() . ' ' . $e->getLine() . ' ' . $e->getMessage());
      }
    }
  }
}
