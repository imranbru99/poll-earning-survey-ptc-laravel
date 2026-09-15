<?php

namespace App\Exports;

use App\ComplatedSurvey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class SurveyExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }
    public function headings():array{
        return[
            'Id',
            'User Name',
            'Name',
            'Question',
            'Answer',
            'Amount',
            'created_at',
        ];
    } 

    public function collection()
    {
        return ComplatedSurvey::join('users','users.id','=','completed_surveys.user_id')
            ->join('surveys','surveys.id','=','completed_surveys.survey_id')
            ->join('survey_questions','survey_questions.id','=','completed_surveys.survey_question_id')
            ->where('completed_surveys.user_id',$this->id)
            ->select('surveys.id','users.username','surveys.name','survey_questions.question','completed_surveys.option','surveys.amount','completed_surveys.created_at')
            ->get();
    }
}
