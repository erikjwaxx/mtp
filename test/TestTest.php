<?hh
namespace MTP\Test\Entity;
require_once('EntityTest.php');

class TestTest extends EntityTest
{
  public function testIHaventFuckedUpPhpUnitYet(): void
  {
    $this->assertTrue(true);
  }

  public function testGetRowCount()
  {

    $this->assertEquals(3, $this->getConnection()->getRowCount('album_artists'));
  }

}
