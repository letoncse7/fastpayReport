<?php

namespace App\Report\Engagement\Daily;
use DB;

class NewReport
{
    use ReportsTrait;

  private $fname;
  private $data;

  public function __construct()
  {
    $this->fname = "New-Report-".date('Y-m-d') . uniqid();
    $this->process();
  }

  private function process()
  {
    $this->collectData();
    $this->generateExcel();
  }

  private function collectData()
  {
      $this->data = DB::select(
          DB::raw("SELECT users.id, users.name,users.account_no, users.mobile_no, users.email, users.balance, users.status, users.created_at FROM users
                    LEFT JOIN transactions ON transactions.sender_id = users.id
                    WHERE
                        users.account_no IS NOT NULL AND
                        transactions.created_at < CURDATE() AND
                        transactions.created_at > DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    GROUP BY users.id, users.account_no, users.mobile_no, users.email, users.balance, users.status, users.created_at
                    HAVING COUNT(transactions.id) = 1
                        
                    UNION 
                    
                    SELECT users.id,users.name, users.account_no, users.mobile_no, users.email, users.balance, users.status, users.created_at FROM users
                        LEFT JOIN transactions ON transactions.receiver_id = users.id
                        WHERE
                            users.account_no IS NOT NULL AND
                            transactions.created_at < CURDATE() AND
                            transactions.created_at > DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        GROUP BY users.id, users.account_no, users.mobile_no, users.email, users.balance, users.status, users.created_at
                        HAVING COUNT(transactions.id) = 1")
          );
        
  }
}
