<?php
/**
 * Test file
 * PHP Version 7.0+
 * 
 * @category  TestONe
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
require __DIR__ . '/../vendor/autoload.php';

use raphievila\Tools\Units;

$u = new Units();
$u::$format = 'cm';

echo $u->returnDimensions(2.54);
