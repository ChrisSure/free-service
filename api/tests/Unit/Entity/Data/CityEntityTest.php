<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 11:23
 */

namespace App\Tests\Unit\Entity\Data;

use App\Entity\Data\City;
use App\Entity\Data\Region;
use PHPUnit\Framework\TestCase;


class CityEntityTest extends TestCase
{
    public function testEntity(): void
    {
        $city = new City();
        $city->setName($name = "City1");
        $city->setRegion($region = $this->createMock(Region::class));

        $this->assertEquals($name, $city->getName());
        $this->assertEquals(gettype($region), gettype($city->getRegion()));
    }
}