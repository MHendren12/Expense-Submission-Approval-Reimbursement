<?php
class Calendar {  

    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }

    private $dayLabels = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
    private $currentYear=0;
    private $currentMonth=0;
    private $currentDay=0;
    private $currentDate=null;
    private $daysInMonth=0;
    private $naviHref= null;

    public function show() {
        $year  == null;
        $month == null;
         
        if(null==$year&&isset($_GET['year'])){
            $year = $_GET['year'];
        }else if(null==$year){
            $year = date("Y",time());  
        }          
         
        if(null==$month&&isset($_GET['month'])){
            $month = $_GET['month'];
        }else if(null==$month){
 
            $month = date("m",time());
        }                  
         
        $this->currentYear=$year;
        $this->currentMonth=$month;
        $this->daysInMonth=$this->daysInMonth($month,$year);  
         
        $content='<table id="calendar" class="table table-bordered table-style table-responsive">'.
                        '<div class="box">'.
                        $this->createNavi().
                        '</div>'.
                                '<ul class="label">'.$this->createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->weeksInMonth($month,$year);
                                
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                    $content.='<tr>';
                                    for($j=0;$j<=6;$j++){
                                        $content.=$this->showDay($i*7+$j);
                                    }
                                    $content.='</tr>';
                                }
                                 
                                $content.='</ul>';
                                $content.='<div class="clear"></div>';     
                 
        $content.='</table>';
        return $content;   
    }
     
    private function showDay($cellNumber){
        //sets the default date
        if($this->currentDay==0){
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                $this->currentDay=1;
            }
        }
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            $cellContent = $this->currentDay;
            $this->currentDay++;   
             
        }else{
            $this->currentDate =null;
            $cellContent=null;
        }
        $dateContent = '<td style ="width:10%;" id="'.$this->currentDate.'" class="'.($cellNumber%7==0?' start ':($cellNumber%7==6?' end ':' ')).
                ($cellContent==null?'mask':'').($cellContent==date('j')&&$this->currentMonth==date('m')&&$this->currentYear==date('Y')?'today':'').'">'.$cellContent.'</td>';
        return $dateContent;
    }
     
    private function createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<tr class="header">'.
                '<th colspan="2"><a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'"><span class="glyphicon glyphicon-chevron-left"></span></a></th>'.
                    '<th colspan="3"> <span class="title">'.date('M - Y',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span></th>'.
                '<th colspan="2"><a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'"><span class="glyphicon glyphicon-chevron-right"></span></a></th>'.
            '</tr>';
    }

    private function createLabels(){  
                 
        $content='';
        foreach($this->dayLabels as $index=>$label){
            $content.='<th class="'.($label==6?'end title':'start title').' title">'.$label.'</th>';
 
        }
        return $content;
    }
     
    private function weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        $daysInMonths = $this->daysInMonth($month,$year);
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
        if($monthEndingDay<$monthStartDay){
            $numOfweeks++;
        }
        return $numOfweeks;
    }
 
    private function daysInMonth($month=null,$year=null){
        if(null==($year))
            $year =  date("Y",time()); 
        if(null==($month))
            $month = date("m",time());
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}