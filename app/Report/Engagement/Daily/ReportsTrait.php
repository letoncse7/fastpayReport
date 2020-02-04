<?php

namespace App\Report\Engagement\Daily;


trait ReportsTrait
{
    protected $dir = 'engagements/';

    public function generateExcel()
    {
        $data = $this->data;
        $file = \Excel::create($this->fname, function($excel) use($data) {
            $excel->sheet('sheet1', function($sheet) use($data) {
                $sheet->setOrientation('landscape');
                $sheet->row(1, array(
                        'Name',
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
                        $row->name,
                        $row->account_no,
                        $row->mobile_no,
                        $row->email,
                        $row->balance,
                        $row->status,
                        dateFormatForReport($row->created_at)
                    ]);
                    $rowIndex++;
                }

            });
        })->string('xls');

        $this->fname = $this->fname.'.xls';

        if(in_array(config('app.url'), ['https://secure.fast-pay.cash', 'https://dev.fast-pay.cash'])) {
            \Storage::disk('s3')->put('engagements/' . $this->fname, $file, 'private');
        } else {
            \Storage::put($this->dir . $this->fname, $file, 'private');
        }
    }

    public function getFileName()
    {
//        return config('app.assetcdn') . $this->dir . $this->fname;
        return $this->dir . $this->fname;
    }

    public function getCountValue()
    {
        return count($this->data);
    }
}