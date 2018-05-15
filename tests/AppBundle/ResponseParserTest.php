<?php

namespace Tests\AppBundle;

use AppBundle\Exceptions\ErrorResponseException;
use AppBundle\Exceptions\InvalidResponseFormatException;
use AppBundle\Exceptions\MalformedJsonException;
use AppBundle\Model\PlaceOfInterest;
use AppBundle\ResponseParser;
use \Exception;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../../vendor/autoload.php';

class ResponseParserTest extends TestCase
{
    const
        TOWER_NAME = 'Eiffel Tower',
        TOWER_LATITUDE = 21.12,
        TOWER_LONGITUDE = 19.56,
        KREMLIN_NAME = 'Moscow Kremlin',
        KREMLIN_LATITUDE = 15.13,
        KREMLIN_LONGITUDE = 11.44
    ;

    /**
     * @test
     */
    public function successfulParse()
    {
        $parser = new ResponseParser();

        $results = $parser->parse($this->getSuccessfulData());

        $this->assertEquals($this->getExpectedResults(), $results);
    }

    /**
     * @test
     * @dataProvider unsuccessfulResponseDataProvider
     * @param string $data
     * @param Exception $expectedException
     */
    public function unsuccessfulParse(string $data, Exception $expectedException)
    {
        $parser = new ResponseParser();

        try {
            $parser->parse($data);
        } catch (Exception $exception) {
            $this->assertEquals(get_class($expectedException), get_class($exception));
        }
    }

    public function unsuccessfulResponseDataProvider()
    {
        return
            array(
                array(
                    '',
                    new MalformedJsonException()
                ),
                array(
                    'some_strange_string',
                    new MalformedJsonException()
                ),
                array(
                    '{
                        "data": {
                            "message": "test",
                            "code": 23
                        },
                        "success": false
                    }',
                    new ErrorResponseException("test", 23)
                ),
                array(
                    '{
                        "data": {
                            "locations": [
                                {
                                    "name": "Fail Tower",
                                    "coordinates": {
                                        "lat": 12.24,
                                        "long": 23.45
                                    }
                                },
                                                                {
                                    "name": "Fail Tower",
                                    "coordinates": {
                                        "lat": 12.24,
                                        "long": 23.45
                                    }
                                }
                            ]
                        }
                    }',
                    new InvalidResponseFormatException()
                )
            );
    }

    /**
     * @return string
     */
    private function getSuccessfulData()
    {
        return
            sprintf(
                '{
                    "data": {
                        "locations": [
                            {
                                "name": "%s",
                                "coordinates": {
                                    "lat": %d,
                                    "long": %d
                                }
                            },
                            {
                                "name": "%s",
                                "coordinates": {
                                    "lat": %d,
                                    "long": %d
                                }
                            }
                        ]
                    },
                    "success": true
                }',
                self::TOWER_NAME,
                self::TOWER_LATITUDE,
                self::TOWER_LONGITUDE,
                self::KREMLIN_NAME,
                self::KREMLIN_LATITUDE,
                self::KREMLIN_LONGITUDE
            );
    }

    /**
     * @return PlaceOfInterest[]
     */
    private function getExpectedResults()
    {
        return
            array(
                new PlaceOfInterest(self::TOWER_NAME, self::TOWER_LATITUDE, self::TOWER_LONGITUDE),
                new PlaceOfInterest(self::KREMLIN_NAME, self::KREMLIN_LATITUDE, self::KREMLIN_LONGITUDE),
            );
    }
}