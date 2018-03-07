<?php
namespace raphievila\Tools;
/*
 * ©2017 Rafael Vilá for Revolution Visual Arts
 * Code by: Rafael Vilá
 * Version 1.0.1RC
 * Created On: Aug 17, 2017
 * Modified On:
 * Modified By:
 */

/**
 * Description of Units
 *
 * @author Rafael Vila <rafael@stealthproducts.com>
 */

use Utils\Utils;

class Units {
    static public $format = 'inches';
    static public $dimension = 1;
    static private $u;
    
    function __construct($obj = FALSE) {
        self::$u = new Utils();
        if (self::$u->isMap($obj)) {
            if (isset($obj['format'])) { self::$format = $obj['format']; }
            if (isset($obj['dimension'])) { self::$dimension = $obj['dimension']; }
        }
    }
    
    private static function auto($size) {
        $kb = 1024;
        if (!is_numeric($size)) { abs($size); }

        if ($size < $kb) { return 'b'; }
        elseif ($size < $kb * 1000) { return 'Kb'; }
        elseif ($size < $kb * 1000000) { return 'Mb'; }
        elseif ($size < $kb * 1000000000) { return 'Gb'; }
        elseif ($size < $kb * 1000000000000) { return 'Tb'; }
        elseif ($size < $kb * 1000000000000000) { return 'Pb'; }
        elseif ($size < $kb * 1000000000000000000) { return 'Eb'; }
        elseif ($size < $kb * 1000000000000000000000) { return 'Zb'; }
        elseif ($size < $kb * 1000000000000000000000000) { return 'Yb'; }
        elseif ($size < $kb * 1000000000000000000000000000) { return 'Bb'; }
        else { return 'bits'; }
    }

    public static function diskStorage($filesize, $s = NULL) {
        $kb = 1024;
        if (is_null($s) || is_numeric($s)){ $s = self::auto($filesize); }
        switch ($s) {
            case 'b':
                $cs = 8;
                $ab = $s;
                break;
            case 'Kb':
                $cs = $kb;
                $ab = $s;
                break;
            case 'Mb':
                $cs = $kb * 1000;
                $ab = $s;
                break;
            case 'Gb':
                $cs = $kb * 1000000;
                $ab = $s;
                break;
            case 'Tb':
                $cs = $kb * 1000000000;
                $ab = $s;
                break;
            case 'Pb':
                $cs = $kb * 1000000000000;
                $ab = $s;
                break;
            case 'Eb':
                $cs = $kb * 1000000000000000;
                $ab = $s;
                break;
            case 'Zb':
                $cs = $kb * 1000000000000000000;
                $ab = $s;
                break;
            case 'Yb':
                $cs = $kb * 1000000000000000000000;
                $ab = $s;
                break;
            case 'Bb':
                $cs = $kb * 1000000000000000000000000;
                $ab = $s;
                break;
            default: $cs = 1;
                $ab = ' bits';
        }
        return round((abs($filesize) / $cs), 2) . $ab;
    }
    
    static private function dimensionInchesToMetrics($dim,$unit='cm'){
        if(abs($dim) < 1){ $unit='mm'; }
        $metricUnit = ($unit === 'cm')? 2.54 : 25.4;
        return number_format(abs($dim)*$metricUnit,2).$unit;
    }

    static public function feet_inches($n,$unit) {
        $ut = self::$u;
        $result = (string) number_format((abs($n)/$unit) / 12,2);
        $feet = $result . 'ft';
        if(strpos($result,'.') > 0){
            $numbers = explode('.',$result);
            $inches =(isset($numbers[1]) && abs($numbers[1]) > 0) ? $ut->decToFraction(ceil(number_format($numbers[1] / 12,2))) . 'in' : '';
            $feet = $numbers[0] . 'ft';
            if(!empty($inches)){ $feet .= ' '.$inches; }
        }
        return $feet;
    }

    static private function dimensionMetricsToInches($dim,$unit="cm"){
        if(abs($dim) < 1){ $unit='mm'; }
        $metricUnit = ($unit === 'cm')? 2.54 : 25.4;
        $formula = (abs($dim) > 12) ? feet_inches(abs($dim),$metricUnit) : number_format(abs($dim)/$metricUnit,2) . 'in';
        return $formula;
    }

    static private function dimensionGramsToKilogram($dim) {
        return number_format(abs($dim)/1000, 2) . "kg";
    }

    static private function dimensionGramsToNewtons($dim) {
        return number_format((abs($dim)/1000) * 9.81, 2) . "N";
    }

    static private function dimensionGramsToPound($dim){
        return number_format(abs($dim) * 0.00220462262,2)."lbs";
    }

    static private function dimensionPoundToGrams($dim){
        return number_format(abs($dim) * 453.6,2)."g";
    }

    static private function dimensionPoundToNewtons($dim){
        return number_format(abs($dim)* 4.44822162,2)."N";
    }

    static private function dimensionNewtonsToPounds($dim){
        return number_format(abs($dim)* 0.224808943,2)."lbf";
    }

    static private function dimensionOuncesToGrams($dim){
        return number_format(abs($dim)* 28.3495231,2)."g";
    }

    static private function dimensionGramsToOunces($dim){
        return number_format(abs($dim)* 0.03527396,2)."oz";
    }

    static private function temperatureFahrenheitToCelsius($temp){
        $t = (strpos($temp,'-') > -1)? abs($temp) * -1 : abs($temp);
        $formula = ($t < 0) ? $formula =  ($t - 32) / 1.8 : ($t - 32) * (5/9);
        return number_format($formula). "&deg;C";
    }

    static private function temperatureCelsiusToFahrenheit($temp){
        $t = (strpos($temp,'-') > -1)? abs($temp) * -1 : abs($temp);
        $formula = ($t < 0) ? (1.8 * $t) + 32 : ($t * 1.8) + 32;
        return number_format($formula). "&deg;F";
    }

    static private function temperatureFahrenheitToKelvin($temp) {
        $t = (strpos($temp,'-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format((($t - 32) / 1.8) + 273.15). '&deg;K';
    }

    static private function temperatureKelvinToFahrenheit($temp) {
        $t = (strpos($temp,'-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format(($t * 1.8) - 459.7). '&deg;F';
    }

    static private function temperatureCelsiusToKelvin($temp) {
        $t = (strpos($temp,'-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format($t + 273.15). '&deg;K';
    }

    static private function temperatureKelvinToCelsius($temp) {
        $t = (strpos($temp,'-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format($t - 273.15). '&deg;C';
    }

    static private function switchFormat($dimension,$format){
        switch($format){
            case 'cm':
            case 'mm':
                return self::dimensionMetricsToInches($dimension,$format);
            case 'pounds':
                return self::dimensionPoundToGrams($dimension);
            case 'grams':
                return self::dimensionGramsToPound($dimension);
            case 'ounces':
                return self::dimensionOuncesToGrams($dimension);
            case 'grams_ounces':
                return self::dimensionGramsToOunces($dimension);
            case 'grams_kilogram':
                return self::dimensionGramsToKilogram($dimension);
            case 'grams_newtons':
                return self::dimensionGramsToNewtons($dimension);
            case 'pounds_newtons':
                return self::dimensionPoundToNewtons($dimension);
            case 'newtons_pounds':
                return self::dimensionNewtonsToPounds($dimension);
            case 'fahrenheit':
                return self::temperatureFahrenheitToCelsius($dimension);
            case 'fahrenheit_kelvin':
                return self::temperatureFahrenheitToKelvin($dimension);
            case 'celsius':
                return self::temperatureCelsiusToFahrenheit($dimension);
            case 'celcius_kelvin':
                return self::temperatureCelsiusToKelvin($dimension);
            case 'kelvin':
                return self::temperatureKelvinToFahrenheit($dimension);
            case 'kelvin_celsius':
                return self::temperatureKelvinToCelsius($dimension);
            default:
                return self::dimensionInchesToMetrics($dimension);
        }
    }

    static private function returnDimensionWithUnit($dimension,$format){
        $ut = self::$u;
        $units = array(
            'inches'=>'in',
            'cm'=>'cm',
            'mm'=>'mm',
            'pounds'=>'lbs',
            'grams'=>'g',
            'ounces'=>'oz',
            'grams_ounces'=>'g',
            'grams_kilogram'=>'g',
            'grams_newtons'=>'g',
            'pounds_newtons'=>'lbf',
            'newtons_pounds'=>'N',
            'fahrenheit'=>'&deg;F',
            'fahrenheit_kelvin'=>'&deg;F',
            'celsius'=>'&deg;C',
            'celsius_kelvin'=>'&deg;C',
            'kelvin'=>'&deg;K',
            'kelvin_celcius'=>'&deg;K'
            );
        switch($format){
            case 'inches':
                return $ut->decToFraction($dimension).'in';
            default:
                return $dimension.$units[$format];
        }
    }

    static private function returnConvertion($dimension, $format){
        $oringaldimension = self::returnDimensionWithUnit($dimension, $format);
        $converted = "(" .  self::switchFormat($dimension,$format) . ")";
        return $oringaldimension." ".$converted;
    }

    function returnDimensions(){
        $dim = self::$dimension;
        $format = self::$format;
        if(strpos($dim,':') > -1){
            $wxh = explode(':',$dim);
            $dimensions = array();
            foreach($wxh as $dimension){
                $dimensions[] = self::returnConvertion($dimension, $format);
            }
            return join(' to ',$dimensions);
        } elseif(strpos($dim,'x') > -1){
            $wxh = explode('x',$dim);
            $dimensions = array();
            foreach($wxh as $dimension){
                $dimensions[] = self::returnConvertion($dimension, $format);
            }
            return join(' x ',$dimensions);
        } elseif(is_numeric($dim)) {
            return self::returnConvertion($dim, $format);
        }
        return false;
    }
}
