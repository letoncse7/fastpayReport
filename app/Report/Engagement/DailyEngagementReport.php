<?php

namespace App\Report\Engagement;

class DailyEngagementReport
{
  public static function build()
  {
      $engagements = Engagement::whereDate('created_at', date('Y-m-d'))->get();

      if(count($engagements)){
        //\Log::info('Daily Engagement Report is already exists');
      }else{

        try{
          $builder = new DailyEngagementReportBuilder();
          try{
            \DB::beginTransaction();
            $e = new Engagement();
            $e->counts = $builder->getCountList('json');
            $e->files = $builder->getFileList('json');
            $e->save();
            \DB::commit();
          }catch(\Exception $ee){
            \DB::rollback();
            //\Log::error($ee);
          }
        }catch(\Exception $e){
            //\Log::error($e);
        }
      }
  }

  public static function getTodaysData()
  {
    $engR = Engagement::whereDate('created_at', date('Y-m-d'))->get()->first();

    if(!empty($engR))
    {
      return $engR;
    }

    self::build();
    
    return Engagement::whereDate('created_at', date('Y-m-d'))->get()->first();
  }

  public static function getRangeData($starting_date, $ending_date)
  {
    $from = date('Y-m-d', strtotime($starting_date));
    $to   = date('Y-m-d', strtotime($ending_date));

    return Engagement::whereBetween('created_at', [$from, $to])
      ->orderBy('created_at', 'DESC')
      ->get();
  }
}
