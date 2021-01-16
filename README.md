# Coding Challenge | Facility Booking
A coding challenge put forward in an interview, involves facility (operand) and booking (operation) with simple rule.

**Entites:**

1. Facility
2. User
3. Amount
4. Rule

**Entity Description:**

1. An apartment complex can have multiple facilities like Club house, Tennis Court etc.
2. Residents can book these facilities
3. Each facility has an amount assigned to it
4. Assignment Rule
     1. Slot Based (Club House : 10am to 4pm : 100Rs per hour, 4pm to 10pm : 500Rs per hour)
     2. A simple multiplier (Tennis Court : Rs.50 per hour )

**Runtime Example:**

Input  | Output
------------- | -------------
Club House, 2012-10-26, 16:00,22:00   | Booked, Rs. 1000
Tennis Court, 2012-10-26, 10:00,20:00 | Booked, Rs. 500
Club House, 2012-10-26, 16:00,22:00   | Booking Failed, Already Booked


## Requirements
PHP 7

## Usage

### Functional Usage

1. Make Facility Object
2. Make Booking Object
3. Pass as many facilities for booking using bookFacility function.
	1. Return value of each objetct will be either ture or false
	2. Print status and amount based on the return value
4. Book another Facility using same Booking Object to continue

See index.php for working examples


### Command Line Usage
1. Place quiery line by line and in same format as in input.txt
2. Open command line interface (terminal) and run command ```php cli.php input.txt```
