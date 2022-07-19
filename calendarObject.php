<?php

/**
 * THIS WAS RETRIEVED FROM https://startutorial.com/view/how-to-build-a-web-calendar-in-php
 * We do not take any ownership of this calendar, however we have customised it to ourselves.
 */
class Calendar
{

    /********************* PROPERTY ********************/
    private $dayLabels = array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;
    private $naviHref = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }

    /********************* PUBLIC **********************/

    /**
     * print out the calendar
     */
    public function show()
    {
        $year = null;

        $month = null;

        if (null == $year && isset($_GET['year'])) {

            $year = $_GET['year'];

        } else if (null == $year) {

            $year = date("Y", time());

        }

        if (null == $month && isset($_GET['month'])) {

            $month = $_GET['month'];

        } else if (null == $month) {

            $month = date("m", time());

        }

        $this->currentYear = $year;

        $this->currentMonth = $month;

        $this->daysInMonth = $this->_daysInMonth($month, $year);

        $content = '<div id="calendar">' .
            '<div class="box">' .
            $this->_createNavi() .
            '</div>' .
            '<div class="box-content">' .
            '<ul class="label">' . $this->_createLabels() . '</ul>';
        $content .= '<div class="clear"></div>';
        $content .= '<ul class="dates">';

        $weeksInMonth = $this->_weeksInMonth($month, $year);
        // Create weeks in a month
        for ($i = 0; $i < $weeksInMonth; $i++) {

            //Create days in a week
            for ($j = 1; $j <= 7; $j++) {
                $content .= "<strong>" . $this->_showDay($i * 7 + $j) . "</strong>";
            }
        }

        $content .= '</ul>';

        $content .= '<div class="clear"></div>';

        $content .= '</div>';

        $content .= '</div>';
        return $content;
    }

    /********************* PRIVATE **********************/

    /**
     * calculate number of days in a particular month
     */
    private function _daysInMonth($month = null, $year = null)
    {

        if (null == ($year))
            $year = date("Y", time());

        if (null == ($month))
            $month = date("m", time());

        return date('t', strtotime($year . '-' . $month . '-01'));
    }

    /**
     * create navigation
     */
    private function _createNavi()
    {

        $nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth) + 1;

        $nextYear = $this->currentMonth == 12 ? intval($this->currentYear) + 1 : $this->currentYear;

        $preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth) - 1;

        $preYear = $this->currentMonth == 1 ? intval($this->currentYear) - 1 : $this->currentYear;

        return
            '<div class="header">' .
            '<a class="prev" href="' . $this->naviHref . '?month=' . sprintf('%02d', $preMonth) . '&year=' . $preYear . '">Prev</a>' .
            '<span class="title">' . date('Y M', strtotime($this->currentYear . '-' . $this->currentMonth . '-1')) . '</span>' .
            '<a class="next" href="' . $this->naviHref . '?month=' . sprintf("%02d", $nextMonth) . '&year=' . $nextYear . '">Next</a>' .
            '</div>';
    }

    /**
     * create calendar week labels
     */
    private function _createLabels()
    {

        $content = '';

        foreach ($this->dayLabels as $index => $label) {

            $content .= '<li class="' . ($label == 6 ? 'end title' : 'start title') . ' title">' . $label . '</li>';

        }

        return $content;
    }


    /**
     * calculate number of weeks in a particular month
     */
    private function _weeksInMonth($month = null, $year = null)
    {

        if (null == ($year)) {
            $year = date("Y", time());
        }

        if (null == ($month)) {
            $month = date("m", time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month, $year);

        $numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);

        $monthEndingDay = date('N', strtotime($year . '-' . $month . '-' . $daysInMonths));

        $monthStartDay = date('N', strtotime($year . '-' . $month . '-01'));

        if ($monthEndingDay < $monthStartDay) {

            $numOfweeks++;

        }

        return $numOfweeks;
    }

    /**
     * create the li element for ul
     */
    private function _showDay($cellNumber)
    {

        if ($this->currentDay == 0) {

            $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));

            if (intval($cellNumber) == intval($firstDayOfTheWeek)) {

                $this->currentDay = 1;

            }
        }

        if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {

            $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));

            $queryEvent = "SELECT Speaker_Name,Dep FROM seminar_event";
            $queryYear = "SELECT EXTRACT(YEAR FROM DateandTime) FROM seminar_event";
            $queryMonth = "SELECT EXTRACT(MONTH FROM DateandTime) FROM seminar_event";
            $queryDay = "SELECT EXTRACT(DAY FROM DateandTime) FROM seminar_event";
            $queryHours = "SELECT EXTRACT(HOUR FROM DateandTime) FROM seminar_event";
            $queryMinute = "SELECT EXTRACT(MINUTE FROM DateandTime) FROM seminar_event";
            $queryFurther = "SELECT Abstract,Speaker_Bio,Seminar_Type,Zoom_Information FROM seminar_event";

            $event = null;
            $furtherInfo = null;
            $colour = null;
            include('htaccess/dbconnection.php');
            if (isset($conn)) {
                $years = $conn->query($queryYear);
                $months = $conn->query($queryMonth);
                $days = $conn->query($queryDay);
                $timeHour = $conn->query($queryHours);
                $timeMinute = $conn->query($queryMinute);
                $speaker = $conn->query($queryEvent);
                $info = $conn->query($queryFurther);

                $yearsarray = mysqli_fetch_all($years, MYSQLI_NUM);
                $monthsarray = mysqli_fetch_all($months, MYSQLI_NUM);
                $daysarray = mysqli_fetch_all($days, MYSQLI_NUM);
                $eventDetail = mysqli_fetch_all($speaker);
                $timeHourarray = mysqli_fetch_all($timeHour);
                $timeMinutearray = mysqli_fetch_all($timeMinute);
                $infoarray = mysqli_fetch_all($info);

                $iterator = new MultipleIterator();
                $iterator->attachIterator(new ArrayIterator ($yearsarray));
                $iterator->attachIterator(new ArrayIterator ($monthsarray));
                $iterator->attachIterator(new ArrayIterator ($daysarray));
                $iterator->attachIterator(new ArrayIterator ($eventDetail));
                $iterator->attachIterator(new ArrayIterator ($timeHourarray));
                $iterator->attachIterator(new ArrayIterator ($timeMinutearray));
                $iterator->attachIterator(new ArrayIterator ($infoarray));
                foreach ($iterator as $date) {
                    if ($date[0][0] == $this->currentYear) {
                        if ($date[1][0] == $this->currentMonth) {
                            if ($date[2][0] == $this->currentDay) {
                                $event = "Speaker: " . $date[3][0] . "<br>" . "Department: " . $date[3][1] . "<br>" . "Time: " . $date[4][0] . ":" . $date[5][0];
                                $furtherInfo = "Speaker: " . $date[3][0] . "<br><br>" . "Bio: " . $date[6][1] . "<br><br>" . "Abstract: " . $date[6][0] . "<br><br>" . "Seminar Type: " . $date[6][2] . "<br><br>" . "Zoom Info: " . $date[6][3];
                                if ($date[3][1] === "IS") {
                                    $colour = 'style = "background:rgba(51, 170, 51, .1)" >';
                                } else if ($date[3][1] === "CS") {
                                    $colour = 'style = "background:rgba(170, 51, 51, .1)" >';
                                }
                            }
                        }
                    }
                }
            }


            $cellContent = $this->currentDay;
            $this->currentDay++;
        } else {

            $this->currentDate = null;
            $event = null;
            $cellContent = null;
            $furtherInfo = null;
            $colour = null;
        }


        $finshedoutput = '<li id="li-' . $this->currentDate . '" class="' . ($cellNumber % 7 == 1 ? ' start ' : ($cellNumber % 7 == 0 ? ' end ' : ' ')) .
            ($cellContent == null ? 'mask' : '') . '"';
        if ($colour != null) {
            $finshedoutput .= $colour;
        } else {
            $finshedoutput .= '> ';
        }
        $finshedoutput .= $cellContent . ' <br>' . $event . ' </br > ';
        if ($furtherInfo != null) {
            $finishedoutput = $finshedoutput . '<div id="pop" class="popup" onclick="popup(' . $this->currentDay . ')">--More--<span class="popuptext" id=' . $this->currentDay . '>' . $furtherInfo . '</span>' . '</div>' . '</li>';
        } else {
            $finishedoutput = $finshedoutput . '</li>';
        }
        return ($finishedoutput);

    }

}

?>