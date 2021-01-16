<?php
include_once('./Facility.php');
include_once('./FacilityBooking.php');
use Facilities\Facility as Facility;
use Facilities\FacilityBooking as FacilityBooking;

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//Facilities
/*
* Name : *
* Type : [slot, simple]
* Rate : [["time-range" => rate], rate]
*/
$name = "Club House";
$type = "slot";
$rate = ['10:00-16:00' => 100, '16:00-22:00' => 500, "*" => "50"];
$ClubHouse = new Facility($name,$type,$rate);


$name = "Tennis Court";
$type = "simple";
$rate = 50;
$TennisCourt = new Facility($name,$type,$rate);

//Facility Booking
/*
* Function : bookFacility
* Facility : obj Facility
* Date : ????-??-??
* STime : ??:??
* ETime : ??:??
* 
*/

$booking = new FacilityBooking();

if ($argv) {
    $file = fopen("input.txt","r");

    while(! feof($file))
    {
        $values = explode(",",fgets($file));
        if( 4 != count($values)) {
            print "Invalid Input \n";
            continue;
        }

        $facility = $values[0];
        $date = $values[1];
        $stime = $values[2];
        $etime = trim($values[3]);

        if(strtolower(str_replace(' ', '', $facility)) === "clubhouse"){
            $facility = $ClubHouse;
            
        }elseif(strtolower(str_replace(' ', '', $facility)) === "tenniscourt"){
            $facility = $TennisCourt;
        }else {
            print "Invalid Input \n";
            continue;
        }

        if ( 3 != count(explode("-",$date))) {
            print "Invalid Input \n";
            continue;
        }

        if ( 2 != count(explode(":",$stime))) {
            print "Invalid Input \n";
            continue;
        }

        if ( 2 != count(explode(":",$etime))) {
            print "Invalid Input \n";
            continue;
        }
        
        if(True === $booking->bookFacility($facility, $date, $stime, $etime)){
            print $booking->getStatus();
            print ', Rs.';
            print $booking->getAmount();
            print "\n";
        }
        else {
            print $booking->getStatus();
            print "\n";
        }
    }
    fclose($file);
}

?>