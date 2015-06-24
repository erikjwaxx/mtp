<?hh

namespace MTP\Test\Entity;

require_once('EntityTest.php');

class ArtistTest extends EntityTest
{
  const string TEST_CLASS = '\MTP\Entity\Artist';

  public static function setUpBeforeClass(): void
  {
    parent::setUpBeforeClass();
    self::$repo = self::$em->getRepository(self::TEST_CLASS);
  }

  public function testFindById(): void
  {
    $a = self::$repo->find(1);
    $this->assertInstanceOf(self::TEST_CLASS, $a);
    $this->assertEquals('Artist 1', $a->getName());
  }

  public function testSongsAssociation(): void
  {
    $expectedSongNames = ['Song 1', 'Song 3'];
    $a = self::$repo->find(1);
    $songNameArray = $a->getSongs()->map($s ==> $s->getName())->toArray();
    $this->assertArraySubset($expectedSongNames, $songNameArray);
    $this->assertArraySubset($songNameArray, $expectedSongNames);
  }

  public function testAlbumsAssociation(): void
  {
      $expectedAlbumNameArray = ['Album 1', 'Album 2'];

      $a = self::$repo->find(1);
      $albumNameArray = $a->getAlbums()->map($l ==> $l->getName())->toArray();

      $this->assertArraySubset($expectedAlbumNameArray, $albumNameArray);
      $this->assertArraySubset($albumNameArray, $expectedAlbumNameArray);
  }
}
