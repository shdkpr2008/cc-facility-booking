<?php
    /// ToDo : Type Checking, Interface, Cross Date Range

    namespace Facilities;

    class FacilityBooking {
        private $facility;
        private $date;
        private $stime;
        private $etime;
        private $status;
        private $amount;

        public function __construct() {
            $this->facility = NULL;
            $this->date = "";
            $this->stime = "";
            $this->etime = "";
            $this->amount = 0;
            $this->status = "";
            $this->booked = [];
        }

        public function getFacility() {
            return $this->facility;
        }
        
        public function getDate() {
            return $this->date;
        }

        public function getSTime() {
            return $this->stime;
        }

        public function getETime() {
            return $this->etime;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getAmount() {
            return $this->amount;
        }

        public function setStatus($status) {
            $this->status = $status;
        }

        public function setAmount($amount) {
            $this->amount = $amount;
        }
        
        public function isBooked(){
            $facility = $this->getFacility();
            $stime  = $this->getSTime();
            $etime  = $this->getETime();
            $date  = $this->getDate();
            $type = $facility->getType();
            $timein = strtotime($stime);
            $timeout = strtotime($etime);
            $booked = [];
            if(isset($this->booked[$facility->getName()][$date])){
                $booked = $this->booked[$facility->getName()][$date];
                $flag = True;
                foreach ($booked as $range => $isBooked)
                {
                    $intime = strtotime(explode('-',$range)[0]);
                    $outtime = strtotime(explode('-',$range)[1]);

                    if ($intime > $timeout)
                        continue;
                    if ($outtime < $timein)
                        continue;

                    if($intime > $timein && $outtime < $timeout)
                        $flag = false;
                    elseif(($intime > $timein && $intime < $timeout) || ($outtime > $timein && $outtime < $timeout))
                        $flag = false;
                    elseif($intime==$timein || $outtime==$timeout)
                        $flag = false;
                    elseif($timein > $intime && $timeout < $outtime)
                        $flag = false;
                    
                    if(!$flag)
                        break;
                }
                return $flag;
            }
            return !isset($this->booked[$facility->getName()][$date]);
        }

        public function setBooked($facility, $date, $stime, $etime){
            $this->booked[$facility->getName()][$date][$stime."-".$etime] = True;
        }

        public function setFacility($facility){
            $this->facility = $facility;
        }

        public function setDate($date){
            $this->date = $date;
        }

        public function setSTime($stime){
            $this->stime = $stime;
        }

        public function setETime($etime){
            $this->etime = $etime;
        }

        public function bookFacility($facility, $date, $stime, $etime) {
            $this->setFacility($facility);
            $this->setDate($date);
            $this->setSTime($stime);
            $this->setETime($etime);
            if($this->isBooked()){
                $facility = $this->getFacility();
                $stime  = $this->getSTime();
                $etime  = $this->getETime();
                $date  = $this->getDate();
                $rate = $facility->getRate();
                $type = $facility->getType();
                $timein = strtotime($stime);
                $timeout = strtotime($etime);
                $amount = 0;
                $hour = 0;
                $slotedHour = 0;
                $totalHour = 0;
                $unslotedHour = 0;
                if('slot' != $type){
                    $amount = $rate * round(abs($timein - $timeout) / (60*60) ,2);
                } else {
                    foreach ($rate as $range => $r)
                    {
                        if("*" == $range)
                            continue;
                        $intime = strtotime(explode('-',$range)[0]);
                        $outtime = strtotime(explode('-',$range)[1]);

                        //Out of Time Ranges
                        if ($intime > $timeout)
                            continue;
                        if ($outtime < $timein)
                            continue;

                        if($timein >= $intime && $timeout <= $outtime) //Within Current Time Range
                             $hour = round(abs($timeout -$timein) / (60*60) ,2);
                        elseif($timein >= $intime && $timeout > $outtime) //On Right Border
                            $hour = round(abs($outtime -$timein) / (60*60) ,2);
                        elseif($timein < $intime && $timeout <= $outtime) //On Left Border
                            $hour = round(abs($timeout -$intime) / (60*60) ,2);
                        else //Else Where
                            $hour = round(abs($outtime -$intime) / (60*60) ,2);

                        $slotedHour = $slotedHour + $hour;
                        $amount = $amount+($r*$hour);
                    }
                }

                //Consideration for universal amount rate
                $totalHour = round(abs($timeout -$timein) / (60*60) ,2);
                $unslotedHour = $totalHour - $slotedHour;
                $amount = $amount+($rate["*"]*$unslotedHour); 

                $this->setBooked($facility, $date, $stime, $etime);
                $this->setStatus("Booked");
                $this->setAmount($amount);
                return true;
            }
            else
            {
                $this->setStatus("Booking Failed, Already Booked");
                $this->setAmount(0);
                return false;
            }
        }
    }
?>