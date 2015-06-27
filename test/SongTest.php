<?hh

namespace MTP\Test\Entity;

require_once('EntityTest.php');

class SongTest extends EntityTest
{
  protected static string $testClass = '\MTP\Entity\Song';

  public function testFindById(): void
  {
    $s = $this->repo->find(1);
    $this->assertInstanceOf(self::$testClass, $s);
    $this->assertEquals('Song 1', $s->getName());
  }

  public function testArtistAssociation(): void
  {
    $s = $this->repo->find(1);
    $this->assertEquals($s->getArtist()->getName(), 'Artist 1');
  }

  public function testArtistInverseAssociation(): void
  {
    $a = $this->em->find('\MTP\Entity\Artist', 1);

    $expected = ['Song 1', 'Song 3'];
    $actual = $a->getSongs()->map($s ==> $s->getName())->toArray();

    $this->assertArraysEqual($expected, $actual);
  }
  
  public function testAlbumAssociation(): void
  {
      $s = $this->repo->find(1);
      $this->assertEquals($s->getAlbum()->getName(), 'Album 1');
  }

  public function testAlbumsInverseAssociation(): void
  {
    $l = $this->em->find('\MTP\Entity\Album', 2);

    $actual = $l->getSongs()->map($l ==> $l->getName())->toArray();
    $expected = ['Song 2', 'Song 3'];

    $this->assertArraysEqual($expected, $actual);
  }

  public function testCreateNewSong(): void
  {
      $s = new \MTP\Entity\Song();
      $a = new \MTP\Entity\Artist();
      $l = new \MTP\Entity\Album();

      $s->setName('New Song');
      $a->setName('New Artist');
      $l->setName('New Album');

      $s->setArtist($a);
      $s->setAlbum($l);

      $this->em->persist($s);
      $this->em->flush();

      $newA = $this->em
	->getRepository('\MTP\Entity\Artist')
	->findOneBy([
	  'name' => 'New Artist'
	]);

      $this->assertInstanceOf('\MTP\Entity\Artist', $newA);
      $this->assertContains(
	'New Song',
	$newA->getSongs()->map($s ==> $s->getName())->toArray()
      );

      $newL = $this->em
	->getRepository('\MTP\Entity\Album')
	->findOneBy([
	  'name' => 'New Album'
	]);

      $this->assertInstanceOf('\MTP\Entity\Album', $newL);
      $this->assertContains(
	'New Song',
	$newL->getSongs()->map($s ==> $s->getName())->toArray()
      );
  }
      
}
