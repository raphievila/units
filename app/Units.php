<?php
/**
 * Description of Units
 * PHP Version 7.0+
 * 
 * @category  Class
 * @package   Units
 * @author    Rafael Vila <rvila@revolutionvisualarts.com>
 * @copyright 2018 Rafael Vila
 * @license   <GPL-3 class="0">GNU GENERAL PUBLIC LICENSE
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * for more information go to:
 * https://github.com/raphievila/units/blob/master/LICENSE
 * </GPL-3>
 * @version   GIT:v1.0.0
 * @link      (
 *        github:   https://github.com/raphievila/units/
 *        website:  https://revolutionvisualarts.com
 * )
 */
namespace raphievila\Tools;

use Utils\Utils;

/**
 * Raphie Vila Units
 * 
 * @category Tool
 * @package  Units
 * @author   Rafael Vila <rvila@revolutionvisualarts.com>
 * @license  <GPL-3 class="0"></GPL-3>
 * @version  Release: v1.0.0
 * @link     (
 *           github: https://github.com/raphievila/units
 *           )
 */
class Units
{
    public static $format = 'inches';
    public static $dimension = 1;
    private static $_u;
    
    /**
     * Class construct
     *
     * Optional parameter set as array
     *
     * @param [array|boolean] $obj Has to be an array
     */
    public function __construct($obj = false)
    {
        self::$_u = new Utils();
        if (self::$_u->isMap($obj)) {
            if (isset($obj['format'])) {
                self::$format = $obj['format'];
            }
            if (isset($obj['dimension'])) {
                self::$dimension = $obj['dimension'];
            }
        }
    }
    
    /**
     * Private function to return Storage Unit abbreviation
     *
     * @param [number] $size Integer or Float number
     * 
     * @return string
     */
    private static function _auto($size)
    {
        $kb = 1024;
        if (!is_numeric($size)) {
            abs($size);
        }

        if ($size < $kb) {
            return 'b';
        } elseif ($size < $kb * pow(10, 3)) {
            return 'Kb';
        } elseif ($size < $kb * pow(10, 6)) {
            return 'Mb';
        } elseif ($size < $kb * pow(10, 9)) {
            return 'Gb';
        } elseif ($size < $kb * pow(10, 12)) {
            return 'Tb';
        } elseif ($size < $kb * pow(10, 15)) {
            return 'Pb';
        } elseif ($size < $kb * pow(10, 18)) {
            return 'Eb';
        } elseif ($size < $kb * pow(10, 21)) {
            return 'Zb';
        } elseif ($size < $kb * pow(10, 24)) {
            return 'Yb';
        } elseif ($size < $kb * pow(10, 27)) {
            return 'Bb';
        } else {
            return 'bits';
        }
    }

    /**
     * Disk Storage calculator
     *
     * @param number $filesize Integer / Float
     * @param string $s        Optional
     * 
     * @return string
     */
    public static function diskStorage($filesize, $s = null)
    {
        $kb = 1024;
        if (is_null($s) || is_numeric($s)) {
            $s = self::_auto($filesize);
        }
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
            $cs = $kb * pow(10, 3); //1000
            $ab = $s;
            break;
        case 'Gb':
            $cs = $kb * pow(10, 6); //1000000
            $ab = $s;
            break;
        case 'Tb':
            $cs = $kb * pow(10, 9); //1000000000
            $ab = $s;
            break;
        case 'Pb':
            $cs = $kb * pow(10, 12); //1000000000000;
            $ab = $s;
            break;
        case 'Eb':
            $cs = $kb * pow(10, 15); //1000000000000000;
            $ab = $s;
            break;
        case 'Zb':
            $cs = $kb * pow(10, 18); //1000000000000000000;
            $ab = $s;
            break;
        case 'Yb':
            $cs = $kb * pow(10, 21); //1000000000000000000000;
            $ab = $s;
            break;
        case 'Bb':
            $cs = $kb * pow(10, 24); //1000000000000000000000000;
            $ab = $s;
            break;
        default: $cs = 1;
            $ab = ' bits';
        }
        return round((abs($filesize) / $cs), 2) . $ab;
    }
    
    /**
     * Returns a string value pre formatted from inches to metric
     *
     * @param number $dim  Integer or Float
     * @param string $unit String formatted unit ex. cm or grams_pounds
     * 
     * @return void
     */
    private static function _dimensionInchesToMetrics($dim, $unit='cm')
    {
        if (abs($dim) < 1) {
            $unit='mm';
        }
        $metricUnit = ($unit === 'cm')? 2.54 : 25.4;
        return number_format(abs($dim)*$metricUnit, 2).$unit;
    }

    /**
     * Separate Integer Feets from Fractions if number higher that 11 inches
     *
     * @param number $n    Integer or Float
     * @param string $unit Related to format
     * 
     * @return void
     */
    public static function feetInches($n, $unit)
    {
        $ut = self::$_u;
        $result = (string) number_format((abs($n)/$unit) / 12, 2);
        $feet = $result . 'ft';
        if (strpos($result, '.') > 0) {
            $numbers = explode('.', $result);
            $inches =(isset($numbers[1]) && abs($numbers[1]) > 0) ? $ut->decToFraction(ceil(number_format($numbers[1] / 12, 2))) . 'in' : '';
            $feet = $numbers[0] . 'ft';
            if (!empty($inches)) {
                $feet .= ' '.$inches;
            }
        }
        return $feet;
    }

    /**
     * Handles lenght request
     *
     * @param number $dim  Integer or float number
     * @param string $unit Related to Units::$format
     * 
     * @return void
     */
    private static function _dimensionMetricsToInches($dim, $unit="cm")
    {
        if (abs($dim) < 1) {
            $unit='mm';
        }
        $metricUnit = ($unit === 'cm')? 2.54 : 25.4;
        $foot = ($unit === 'cm')? 30.48 : 304.8;
        switch ($unit) {
        case 'cm':
            $foot = 30.48;
            break;
        case 'mm':
            $foot = 304.8;
            break;
        case 'inches':
            $foot = 12;
            break;
        default:
            $foot = false;
        }
        $formula = ($foot && abs($dim) > $foot) ? self::_feetInches(abs($dim), $metricUnit) : number_format(abs($dim)/$metricUnit, 2) . 'in';
        return $formula;
    }

    /**
     * Handle Grams to Kilogram requests
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionGramsToKilogram($dim)
    {
        return number_format(abs($dim)/1000, 2) . "kg";
    }

    /**
     * Handles Grams to Newtons requets
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionGramsToNewtons($dim)
    {
        return number_format((abs($dim)/1000) * 9.81, 2) . "N";
    }

    /**
     * Handles Grams to Pounds requets
     *
     * @param number  $dim   Integer or Float
     * @param boolean $force Force to return pound or pound-of-force abbreviation
     * 
     * @return string
     */
    private static function _dimensionGramsToPound($dim, $force = false)
    {
        $ab = ($force) ? "lbf" : "lbs";
        return number_format(abs($dim) * 0.00220462262, 2).$ab;
    }

    /**
     * Handles Pound to Grams requets
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionPoundToGrams($dim)
    {
        return number_format(abs($dim) * 453.6, 2)."g";
    }

    /**
     * Handles Pound to Kilograms requets
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionPoundToKilograms($dim)
    {
        $result = number_format(abs($dim) * 0.4536, 2) . "kg";
        return str_replace('.00', '', $result);
    }

    /**
     * Handles Pound to Newtons requets
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionPoundToNewtons($dim)
    {
        return number_format(abs($dim)* 4.44822162, 2)."N";
    }

    /**
     * Handles Newtons to Pounds requets
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionNewtonsToPounds($dim)
    {
        return number_format(abs($dim)* 0.224808943, 2)."lbf";
    }

    /**
     * Handles Ounces to Grams requets
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionOuncesToGrams($dim)
    {
        return number_format(abs($dim)* 28.3495231, 2)."g";
    }

    /**
     * Handles Grams to Ounces requets
     *
     * @param number $dim Integer or Float
     * 
     * @return void
     */
    private static function _dimensionGramsToOunces($dim)
    {
        return number_format(abs($dim)* 0.03527396, 2)."oz";
    }

    /**
     * Handles Fahrenheit to Celcius requets
     *
     * @param number $temp Integer or Float
     * 
     * @return void
     */
    private static function _temperatureFahrenheitToCelsius($temp)
    {
        $t = (strpos($temp, '-') > -1)? abs($temp) * -1 : abs($temp);
        $formula = ($t < 0) ? $formula =  ($t - 32) / 1.8 : ($t - 32) * (5/9);
        return number_format($formula). "&deg;C";
    }

    /**
     * Handles Celcius to Fahrenheit requets
     *
     * @param number $temp Integer or Float
     * 
     * @return void
     */
    private static function _temperatureCelsiusToFahrenheit($temp)
    {
        $t = (strpos($temp, '-') > -1)? abs($temp) * -1 : abs($temp);
        $formula = ($t < 0) ? (1.8 * $t) + 32 : ($t * 1.8) + 32;
        return number_format($formula). "&deg;F";
    }

    /**
     * Handles Fahrenheit to Kelvin requets
     *
     * @param number $temp Integer or Float
     * 
     * @return void
     */
    private static function _temperatureFahrenheitToKelvin($temp)
    {
        $t = (strpos($temp, '-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format((($t - 32) / 1.8) + 273.15). '&deg;K';
    }

    /**
     * Handles Kelvin to Fahrenheit requets
     *
     * @param number $temp Integer or Float
     * 
     * @return void
     */
    private static function _temperatureKelvinToFahrenheit($temp)
    {
        $t = (strpos($temp, '-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format(($t * 1.8) - 459.7). '&deg;F';
    }

    /**
     * Handles Celcius to Kelvin requets
     *
     * @param number $temp Integer or Float
     * 
     * @return void
     */
    private static function _temperatureCelsiusToKelvin($temp)
    {
        $t = (strpos($temp, '-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format($t + 273.15). '&deg;K';
    }

    /**
     * Handles Kelvin to Celcius requets
     *
     * @param number $temp Integer or Float
     * 
     * @return void
     */
    private static function _temperatureKelvinToCelsius($temp)
    {
        $t = (strpos($temp, '-') > -1)? abs($temp) * -1 : abs($temp);
        return number_format($t - 273.15). '&deg;C';
    }

    /**
     * MVP
     *
     * @param number $dimension Integer or float
     * @param string $format    Related to Units::$format
     * 
     * @return void
     */
    private static function _switchFormat($dimension, $format)
    {
        switch ($format) {
        case 'cm':
        case 'mm':
            return self::_dimensionMetricsToInches($dimension, $format);
        case 'pounds':
            return self::_dimensionPoundToGrams($dimension);
        case 'grams':
            return self::_dimensionGramsToPound($dimension);
        case 'grams_force':
            return self::_dimensionGramsToPound($dimension, true);
        case 'ounces':
            return self::_dimensionOuncesToGrams($dimension);
        case 'grams_ounces':
            return self::_dimensionGramsToOunces($dimension);
        case 'grams_kilogram':
            return self::_dimensionGramsToKilogram($dimension);
        case 'grams_newtons':
            return self::_dimensionGramsToNewtons($dimension);
        case 'pounds_kilograms':
            return self::_dimensionPoundToKilograms($dimension);
        case 'pounds_newtons':
            return self::_dimensionPoundToNewtons($dimension);
        case 'newtons_pounds':
            return self::_dimensionNewtonsToPounds($dimension);
        case 'fahrenheit':
            return self::_temperatureFahrenheitToCelsius($dimension);
        case 'fahrenheit_kelvin':
            return self::_temperatureFahrenheitToKelvin($dimension);
        case 'celsius':
            return self::_temperatureCelsiusToFahrenheit($dimension);
        case 'celcius_kelvin':
            return self::_temperatureCelsiusToKelvin($dimension);
        case 'kelvin':
            return self::_temperatureKelvinToFahrenheit($dimension);
        case 'kelvin_celsius':
            return self::_temperatureKelvinToCelsius($dimension);
        default:
            return self::_dimensionInchesToMetrics($dimension);
        }
    }

    /**
     * MVP for format not declared with similar functions to the ones declared
     *
     * @param number $dimension Integer or Float
     * @param string $format    Related to Units::$format
     * 
     * @return void
     */
    private static function _returnDimensionWithUnit($dimension, $format)
    {
        $ut = self::$_u;
        $x = new xTags();
        $units = array(
            'inches' => 'in',
            'cm' => 'cm',
            'mm' => 'mm',
            'pounds' => 'lbs',
            'grams' => 'g',
            'grams_force' => 'gf',
            'ounces' => 'oz',
            'pounds_newtons' => 'lbf',
            'newtons_pounds' => 'N',
            'fahrenheit' => '&deg;F',
            'celsius' => '&deg;C',
            'celsius_kelvin' => '&deg;C',
            'kelvin' => '&deg;K',
            'kelvin_celcius' => '&deg;K'
            );
        
        switch ($format) {
        case 'inches':
            $unit = $ut->decToFraction($dimension).'in';
            break;
        case 'pounds_kilograms':
            $unit = $dimension.'lbs';
            break;
        default:
            $unit = (isset($units[$format])) ? $dimension.$units[$format] : false;
        }
        
        if (!$unit) {
            if (preg_match('/^grams_/', $format)) {
                $force = ($format === 'grams_newtons')? 'f' : '';
                $unit = $dimension.'g'.$force;
            } elseif (preg_match('/^fahrenheit_/', $format)) {
                $unit = $dimension.'&deg;F';
            } elseif (preg_match('/^celcius_/', $format)) {
                $unit = $dimension.'&deg;C';
            } elseif (preg_match('/^kelvin_/', $format)) {
                $unit = $dimension.'&deg;K';
            }
        }
        
        return $unit;
    }

    /**
     * Returns string with submitted dimenstion and (requested format)
     *
     * @param number $dimension Integer or Float
     * @param string $format    Related to Units::$format
     * 
     * @return string
     */
    private static function _returnConvertion($dimension, $format)
    {
        $oringaldimension = self::_returnDimensionWithUnit($dimension, $format);
        $converted = "(" .  self::_switchFormat($dimension, $format) . ")";
        return $oringaldimension." ".$converted;
    }

    /**
     * Execute request - need to set dimension/temperature 
     * and format to process conversion, ex:
     * (18.5) inches = 1ft 6 1/3in (45.72cm)
     *
     * @return string
     */
    public function returnDimensions()
    {
        $dim = self::$dimension;
        $format = self::$format;
        if (strpos($dim, ':') > -1) {
            $wxh = explode(':', $dim);
            $dimensions = array();
            foreach ($wxh as $dimension) {
                $dimensions[] = self::_returnConvertion($dimension, $format);
            }
            return join(' to ', $dimensions);
        } elseif (strpos($dim, 'x') > -1) {
            $wxh = explode('x', $dim);
            $dimensions = array();
            foreach ($wxh as $dimension) {
                $dimensions[] = self::_returnConvertion($dimension, $format);
            }
            return join(' x ', $dimensions);
        } elseif (is_numeric($dim)) {
            return self::_returnConvertion($dim, $format);
        }
        return false;
    }
}
