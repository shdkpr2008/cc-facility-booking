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

$date = "2012-10-26";
$stime = "16:00";
$etime = "22:00";

if($booking->bookFacility($ClubHouse, $date, $stime, $etime)){
    print $booking->getStatus();
    print ', Rs.';
    print $booking->getAmount();
}
else
    print $booking->getStatus();


$date = "2012-10-26";
$stime = "10:00";
$etime = "20:00";

if($booking->bookFacility($TennisCourt, $date, $stime, $etime)){
    print $booking->getStatus();
    print ', Rs.';
    print $booking->getAmount();
}
else
    print $booking->getStatus();

$date = "2012-10-26";
$stime = "16:00";
$etime = "22:00";

if($booking->bookFacility($ClubHouse, $date, $stime, $etime)){
    print $booking->getStatus();
    print ', Rs.';
    print $booking->getAmount();
}
else
    print $booking->getStatus();

?>