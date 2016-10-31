<?php

namespace UaNormalizerTest\Generic;

use UaNormalizer\Generic\SerialNumbers;
use UaNormalizerTest\TestBase;

/**
 * Class SerialNumbersTest
 *
 * @group Handlers
 */
class SerialNumbersTest extends TestBase
{
    protected function setUp()
    {
        $this->normalizer = new SerialNumbers();
    }

    /**
     * @test
     * @dataProvider serialNumbersDataProvider
     *
     * @param string $userAgent
     * @param string $expected
     */
    public function testRemoveSerialNumber($userAgent, $expected)
    {
        $found = $this->normalizer->normalize($userAgent);
        self::assertEquals($expected, $found);
    }

    public function serialNumbersDataProvider()
    {
        return array(
            array(
                'r451[TFXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX] UP.Browser/6.2.3.8 (GUI) MMP/2.0',
                'r451 UP.Browser/6.2.3.8 (GUI) MMP/2.0',
            ),
            array(
                'LG-LG1500[TF011231004305163000940013045946416] UP.Browser/6.2.3 (GUI) MMP/1.0 UP.Link/6.3.0.0.0',
                'LG-LG1500 UP.Browser/6.2.3 (GUI) MMP/1.0 UP.Link/6.3.0.0.0',
            ),
            array(
                'MOT-V176/6.6.61[ST010913001046723002023302085980278] UP.Browser/6.2.3.9.c.9 (GUI) MMP/2.0 UP.Link/6.3.0.0.0',
                'MOT-V176/6.6.61 UP.Browser/6.2.3.9.c.9 (GUI) MMP/2.0 UP.Link/6.3.0.0.0',
            ),
            array('Mozilla', 'Mozilla'),
            array(
                'Vodafone/1.0/V702NK/NKJ001/IMEI/SN354350000005026 Series60/2.6 Nokia6630/2.40.235 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'Vodafone/1.0/V702NK/NKJ001/IMEI Series60/2.6 Nokia6630/2.40.235 Profile/MIDP-2.0 Configuration/CLDC-1.1',
            ),

        );
    }
}
