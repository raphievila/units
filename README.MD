# Unit Conversion Parser

raphievila/Units allows you to dynamcally add unit conversion features directly in your code. For example:

```php
<?php
    //include Composer Autoload
    require 'vendor/autoload.php';
    use raphievila\Tools\Units;

    $u = new Units();

    //By default format used is Inches to Centimeters
    $u->returnDimensions(1);

    //this will return
    //1in (2.54cm)

    //To change format
    $u::$format = 'cm';
    $u->returnDimensions(2.54);

    //OR

    $u = new Units(array('dim' => 2.54, 'format' => 'cm'));

    //this will return
    //2.54cm (1in)
?>
```

## Currently you can convert the following patterns

### Length

1. Inches <-> metric (cmm / mm)

### Weight

3. Pounds <-> Grams
4. Pound of Force <-> Gram of Force
5. Pounds <-> Kilograms
5. Ounces <-> Grams
6. Grams to Kilograms
7. Grams <-> Newtons
8. Pounds to Kilograms
9. Pounds <-> Newtons

### Temperature

10. Fahrenheit <-> Celcius
11. Fahrenheit <-> Kelvin
12. Celcius <-> Kelvin
