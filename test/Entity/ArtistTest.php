<?hh

namespace MTP\Test\Entity;

require_once('EntityTest.php');

class ArtistTest extends EntityTest
{
  protected static string $testClass = '\MTP\Entity\Artist';

  public function testFindById(): void
  {
    $a = $this->repo->find(1);
    $this->assertInstanceOf(self::$testClass, $a);
    $this->assertEquals('Artist 1', $a->getName());
  }

  public function testSongsAssociation(): void
  {
    $expectedSongNames = ['Song 1', 'Song 3'];
    $a = $this->repo->find(1);
    $songNameArray = $a->getSongs()->map($s ==> $s->getName())->toArray();
    $this->assertArraySubset($expectedSongNames, $songNameArray);
    $this->assertArraySubset($songNameArray, $expectedSongNames);
  }

  public function testSongsInverseAssociation(): void
  {
    $s = $this->em->getRepository('\MTP\Entity\Song')->find(1);

    $this->assertEquals('Artist 1', $s->getArtist()->getName());
  }

  public function testAlbumsAssociation(): void
  {
      $expectedAlbumNameArray = ['Album 1', 'Album 2'];

      $a = $this->repo->find(1);
      $albumNameArray = $a->getAlbums()->map($l ==> $l->getName())->toArray();

      $this->assertArraySubset($expectedAlbumNameArray, $albumNameArray);
      $this->assertArraySubset($albumNameArray, $expectedAlbumNameArray);
  }

  public function testAlbumsInverseAssociation(): void
  {
    $expectedArtistNameArray = ['Artist 1', 'Artist 2'];

    $l = $this->em->getRepository('\MTP\Entity\Album')->find(2);
    $artistNameArray = $l->getArtists()->map($a ==> $a->getName())->toArray();

    // HACK: PHPUnit_Framework_TestCase::assertArraySubset seems to have some bug
    // that incorrectly identifies these as not subsets when they are. Directly
    // iterate over each array for testing membership instead.
    foreach ($expectedArtistNameArray as $name) $this->assertContains($name, $artistNameArray);
    foreach ($artistNameArray as $name) $this->assertContains($name, $expectedArtistNameArray);
  }


  public function testAddSong(): void
  {
    $s = new \MTP\Entity\Song();
    $s->setName('New Song');

    $a = $this->repo->find(1);

    $a->addSong($s);
    $this->em->persist($a);

    $this->em->flush();

    $b = $this->repo->find(1);
    $this->assertContains('New Song', $b->getSongs()->map($l ==> $l->getName()));

    $sr = $this->em->getRepository('\MTP\Entity\Song');
    $this->assertInstanceOf('\MTP\Entity\Song', $sr->findOneBy(['name' => 'New Song']));
  }

  public function testAddAlbum(): void
  {
    $l = new \MTP\Entity\Album();
    $l->setName('New Album');

    $a = $this->repo->find(1);
    $a->addAlbum($l);
    $this->em->flush();

    $b = $this->repo->find(1);
    $this->assertContains('New Album', $b->getAlbums()->map($l ==> $l->getName()));

    $lr = $this->em->getRepository('\MTP\Entity\Album');
    $this->assertInstanceOf('\MTP\Entity\Album', $lr->findOneBy(['name' => 'New Album']));
  }
}
