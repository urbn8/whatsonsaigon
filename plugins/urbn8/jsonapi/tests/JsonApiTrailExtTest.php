<?php namespace Urbn8\JsonApi\Tests;

use PluginTestCase;
use Urbn8\JsonApi\Exts\JsonApiTrailExt;

class EventMock
{
  
}

class Country
{
  public $table = 'urbn8_wos_countries';
}

class JsonApiTrailExtTest extends PluginTestCase
{
    public function testRelationFilters()
    {
        $result = JsonApiTrailExt::relationFilters([
        "categories" => [
          "id" => "1"
        ],
        "name" => "2222",
        ]);

        $this->assertEquals($result, [
        "categories" => [
          "id" => "1"
        ],
        ]);
    }

    public function testFieldFilters()
    {
        $result = JsonApiTrailExt::fieldFilters([
        "categories" => [
          "id" => "1"
        ],
        "name" => "2222",
        ]);

        $this->assertEquals($result, [
        "name" => "2222",
        ]);
    }

    public function testDatabaseEntityName()
    {
        $result = JsonApiTrailExt::databaseEntityName(new EventMock);

        $this->assertEquals($result, 'event_mock');
    }

    public function testPageOffset()
    {
      {
        $page = $this->getMock('Page', ['number', 'size']);
        $page->expects($this->once())->method('number')->will($this->returnValue(2));
        $page->expects($this->once())->method('size')->will($this->returnValue(3));

        $offset = JsonApiTrailExt::pageOffset($page);

        $this->assertEquals(3, $offset);
      }
      

      {
        $page = $this->getMock('Page', ['number', 'size']);
        $page->expects($this->once())->method('number')->will($this->returnValue(1));
        $page->expects($this->once())->method('size')->will($this->returnValue(3));

        $result = JsonApiTrailExt::pageOffset($page);

        $this->assertEquals($result, 0);
      }
    }

    public function testBelongsToOneWhereClause()
    {
        {
          $result = JsonApiTrailExt::belongsToOneWhereClause('urbn8_wos_events', [
            'organiser' => [
                'Urbn8\Wos\Models\Organiser',
            ],
          ], [
            "organiser" => [
              "id" => "1"
            ]
          ]);

          $this->assertEquals([
            "joins" => [
              [
                'table' => 'urbn8_wos_organisers',
                'on' => ['urbn8_wos_organisers.id', '=', 'urbn8_wos_events.organiser_id'],
                'where' => [
                  ['urbn8_wos_organisers.id', '=', '1']
                ]
              ]
            ],
          ], $result, 'case where on relation id');
        }
        
        {
          $result = JsonApiTrailExt::belongsToOneWhereClause('urbn8_wos_events', [
            'organiser' => [
                'Urbn8\Wos\Models\Organiser',
            ],
          ], [
            "organiser" => [
              "name" => "ABC"
            ]
          ]);

          $this->assertEquals([
            "joins" => [
              [
                'table' => 'urbn8_wos_organisers',
                'on' => ['urbn8_wos_organisers.id', '=', 'urbn8_wos_events.organiser_id'],
                'where' => [
                  ['urbn8_wos_organisers.name', '=', 'ABC']
                ]
              ]
            ],
          ], $result, 'case where on a relation standard property (name in this case)');
        }

        {
          $result = JsonApiTrailExt::belongsToOneWhereClause('urbn8_wos_events', [
            'organiser' => [
                'Urbn8\Wos\Models\Organiser',
            ],
          ], [
            "organiser" => [
              "name" => "ABC",
              "status" => 1
            ]
          ]);

          $this->assertEquals([
            "joins" => [
              [
                'table' => 'urbn8_wos_organisers',
                'on' => ['urbn8_wos_organisers.id', '=', 'urbn8_wos_events.organiser_id'],
                'where' => [
                  ['urbn8_wos_organisers.name', '=', 'ABC'],
                  ['urbn8_wos_organisers.status', '=', 1],
                ]
              ]
            ],
          ], $result, 'case where on multi relation standard properties');
        }

        {
          $result = JsonApiTrailExt::belongsToOneWhereClause('urbn8_wos_events', [
            'organiser' => [
                'Urbn8\Wos\Models\Organiser',
            ],
            'country' => [
                'Urbn8\JsonApi\Tests\Country'
            ],
          ], [
            "organiser" => [
              "name" => "ABC",
              "status" => 1
            ],
            "country" => [
              "code" => "VN",
            ]
          ]);

          $this->assertEquals([
            "joins" => [
              [
                'table' => 'urbn8_wos_organisers',
                'on' => ['urbn8_wos_organisers.id', '=', 'urbn8_wos_events.organiser_id'],
                'where' => [
                  ['urbn8_wos_organisers.name', '=', 'ABC'],
                  ['urbn8_wos_organisers.status', '=', 1],
                ]
              ],
              [
                'table' => 'urbn8_wos_countries',
                'on' => ['urbn8_wos_countries.id', '=', 'urbn8_wos_events.country_id'],
                'where' => [
                  ['urbn8_wos_countries.code', '=', 'VN'],
                ]
              ]
            ],
          ], $result, 'case where on multi relations');
        }
    }

    public function testBelongsToManyWhereClause()
    {
      {
        $result = JsonApiTrailExt::belongsToManyWhereClause('urbn8_wos_events',
        new \Urbn8\Wos\Models\Event,
        [
            'categories' => [
                'Urbn8\Wos\Models\EventCategory',
                'table' => 'urbn8_wos_event_category_joins',
                'key'      => 'event_id',
                'otherKey' => 'category_id',
            ],
        ], [
          "categories" => [
            "id" => "1"
          ]
        ]);

        $this->assertEquals([
          "joins" => [
            [
              'table' => 'urbn8_wos_event_category_joins',
              'on' => ['urbn8_wos_event_category_joins.event_id', '=', 'urbn8_wos_events.id'],
              'where' => [
                ['urbn8_wos_event_category_joins.category_id', '=', '1']
              ]
            ]
          ],
        ], $result, 'case where on relation id');
      }
    }
}
