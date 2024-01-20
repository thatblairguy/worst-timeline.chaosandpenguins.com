<?php
    class PandemicDate {
        const PANDEMIC_START_DATE = '2020-03-01';

        public function __construct() {
            $UTC = new DateTimeZone('UTC');

            $instant = new DateTime('now', $UTC);
            $details = getdate($instant->getTimeStamp());

            $this->day = $details['weekday'];
            $this->hour = $details['hours'];
            $this->minutes = $details['minutes'];
            $this->seconds = $details['seconds'];

            $startDate = new DateTime(self::PANDEMIC_START_DATE, $UTC);
            // Coerce to numeric and add one since this is zero-based.
            $this->elapsed = $instant->diff($startDate)->format('%a') + 1;
        }

        public function GetDay() {
            return $this->day;
        }

        public function DayOfMarch2020() {
            switch ($this->elapsed % 10) {
                case 1: $suffix = 'st'; break;
                case 2: $suffix = 'nd'; break;
                case 3: $suffix = 'rd'; break;
                
                default:
                    $suffix = 'th';
                    break;
            }

            return $this->elapsed . $suffix;
        }

        public function GetTime() {
            
            if ($this->hour > 12) {
                $meridian = 'PM';
                $hour = $this->hour - 12;
            } else {
                $meridian = 'AM';
                $hour = $this->hour > 0 ? $this->hour : 12;
            }

            return "{$hour}:{$this->minutes}:{$this->seconds} {$meridian} UTC";
        }
    }

    $now = new PandemicDate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>This is the worst timeline.</title>
<meta name="description" content="Time has lost all meaning during the COVID-19 pandemic. What day is it anyhow?">
<meta name="twitter:description" content="Time has lost all meaning during the COVID-19 pandemic. What day is it anyhow?">
<meta name="twitter:card" content="summary" >
<meta name="twitter:site" content="@ThatBlairGuy" >
<meta name="twitter:title" content="This is the worst timeline" >

</head>
<body>
    <p>Time has lost all meaning during the COVID-19 pandemic. What day is it anyhow?</p>
    <p>The time is <?php echo $now->GetTime() ?>  on <?php echo $now->GetDay(); ?>, the <?php echo $now->DayOfMarch2020() ?> day of March, 2020.</p>
    <p><a href="https://github.com/thatblairguy/worst-timeline">GitHub</a>
</body>
</html>
