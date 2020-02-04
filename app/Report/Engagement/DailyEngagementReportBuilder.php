<?php

namespace App\Report\Engagement;

use App\Report\Engagement\Daily\NewReport;
use App\Report\Engagement\Daily\EvaluatingReport;
use App\Report\Engagement\Daily\EngagedReport;
use App\Report\Engagement\Daily\BouncedReport;
use App\Report\Engagement\Daily\LapsingReport;
use App\Report\Engagement\Daily\DisapearingReport;

class DailyEngagementReportBuilder
{
  private $files = array();
  private $countList = array();

  public function __construct()
  {
    $newReport  = new NewReport;
    $evaluatingReport = new EvaluatingReport;
    $engagedReport  = new EngagedReport;
    $bouncedReport  = new BouncedReport;
    $lapsingReport  = new LapsingReport;
    $disapearingReport  = new DisapearingReport;

    $this->files = [
      'new' => $newReport->getFileName(),
      'evaluating' => $evaluatingReport->getFileName(),
      'engaged' => $engagedReport->getFileName(),
      'bounced' => $bouncedReport->getFileName(),
      'lapsing' => $lapsingReport->getFileName(),
      'disapearing' => $disapearingReport->getFileName()
    ];

    $this->countList = [
      'new' => $newReport->getCountValue(),
      'evaluating' => $evaluatingReport->getCountValue(),
      'engaged' => $engagedReport->getCountValue(),
      'bounced' => $bouncedReport->getCountValue(),
      'lapsing' => $lapsingReport->getCountValue(),
      'disapearing' => $disapearingReport->getCountValue()
    ];
  }

  public function getCountList($type = 'json')
  {
    if($type == 'json')
    {
        return json_encode($this->countList);
    }
  }

  public function getFileList($type = 'json')
  {
    if($type == 'json')
    {
        return json_encode($this->files);
    }
  }
}
