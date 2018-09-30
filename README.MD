# Unit Conversion Parser

raphievila/Units allows you to dynamcally add unit conversion features directly in your code. For example:

```php
<?php
    //include Composer Autoload
    require 'vendor/autoload.php';
    use raphievila\Tools\Units;

    $u = new Units();

    //By default format used is Inches to Centimeters
    $u->returnDimensions();

    //this will return
    //1in (2.54cm)

    //To change format
    $u::$dim = 2.54;
    $u::$format = 'cm';
    $u->returnDimensions();

    //OR

    $u = new Units(array('dim' => 2.54, 'format' => 'cm'));

    //this will return
    //2.54cm (1in)
```

## Currently you can Convert the following patterns

### Length

Format|Conversion
---|----------
*inches*|_Default__ :: Converts from 1 inch and up to centimeters, under 1in converts to millimeters
*cm*|Converts centimeter to inches
*mm*|Converts milimeter to inches

#### Usage:
```php
<?php
$u::$format = 'cm';
$u::$dim = 2.54;

echo $u->returnDimensions();
//echo 2.54cm (1in)

$u::$format = 'mm';
echo $u->returnDimensions();
//echo 25.40mm (1in)

$u::$format = 'inches';
echo $u->returnDimensions();
//echo 2.54in (6.45cm)
```

### Weight / Pressure

Format|Conversion
---|----------
*grams*|Converts grams to pounds
*grams_force*|Same as `grams` using _gf_ or _lbf_ abbreviations instead
*grams_ounces*|Converts grams to ounces
*grams_kilograms*|Converts grams to kilograms
*grams_newtons*|Converts grams to Newtons
*newtons_pounds*|Converts Newtons to pounds
*pounds*|Converts pounds to grams
*pounds_kilograms*|Converts pounds to kilograms
*pounds_newtons*|Converts pounds to Newtons

### Temperature

Format|Conversion
---|----------
*celcius*|Converts from Celcius to Fahrenheit
*celcius_kelvin*|Converts from Celcius to Kelvin
*fahrenheit*|Converts from Fahrenheit to Celcius
*fahrenheit_kelvin*|Converts from Fahrenheit to Kelvin
*kelvin*|Converts from Kelvin to Fahrenheit
*kelvin_celcius*|Converts from Kelvin to Celcius