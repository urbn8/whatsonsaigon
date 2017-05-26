<?php namespace Urbn8\JsonApi\Tests;

use PluginTestCase;
use Urbn8\JsonApi\Exts\JsonApiTrailExt;

// use NilPortugues\Api\JsonApi\Http\Request\Parameters\Page as Page;

class EventMock {

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

    // public function testPageOffset()
    // {
    //   $page = new Page(
    //      2, // number
    //     null, // cursor
    //     3, // limit
    //     null, // offset
    //     10 // size
    //   );
    //   $result = JsonApiTrailExt::pageOffset($page);

    //   $this->assertEquals($result, 4);

    //   $page = new Page(
    //      1, // number
    //     null, // cursor
    //     3, // limit
    //     null, // offset
    //     10 // size
    //   );
    //   $result = JsonApiTrailExt::pageOffset($page);

    //   $this->assertEquals($result, 0);
    // }

    public function testBelongsToOneWhereClause()
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

      $this->assertEquals($result, [
        ""
      ]);
    }
}
