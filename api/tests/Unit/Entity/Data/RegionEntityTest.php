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


class RegionEntityTest extends TestCase
{
    public function testEntity(): void
    {
        $region = new Region();
        $region->setName($name = "Region1");

        $this->assertEquals($name, $region->getName());
    }
}