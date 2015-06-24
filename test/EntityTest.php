<?hh

namespace MTP\Test\Entity;

use \Doctrine\ORM\EntityManager;

abstract class EntityTest extends \PHPUnit_Extensions_Database_TestCase
{
  protected static ?\PDO $dbh;
  protected static ?EntityManager $em;
  protected static ?\Doctrine\ORM\EntityRepository $repo;

  public static function setUpBeforeClass(): void
  {
    $cfg = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration([__DIR__ . "/../Entity"], true);
    self::$em = EntityManager::create(['pdo' => self::_dbInstance()], $cfg);
  }

  private static function _dbInstance(): \PDO
  {
    if (!isset(self::$dbh)) {
      self::$dbh = new \PDO('sqlite:' . TEST_DB, null, null, [\PDO::ATTR_PERSISTENT => true]);
      self::$dbh->exec('PRAGMA foreign_keys = ON');
    }

    return self::$dbh;
  }
  
  public function getConnection(): \PHPUnit_Extensions_Database_DB_IDatabaseConnection
  {
    return $this->createDefaultDBConnection(self::_dbInstance());
  }

  public function getDataSet()
  {
      return $this->createArrayDataSet([
          'artists' => [
              ['id' => 1, 'name' => 'Artist 1'],
              ['id' => 2, 'name' => 'Artist 2']
          ],
          'albums' => [
              ['id' => 1, 'name' => 'Album 1'],
              ['id' => 2, 'name' => 'Album 2']
          ],
          'album_artists' => [
              ['albumid' => 1, 'artistid' => 1],
              ['albumid' => 2, 'artistid' => 2],
              ['albumid' => 2, 'artistid' => 1]
          ],
          'songs' => [
              ['id' => 1, 'name' => 'Song 1', 'albumid' => 1, 'artistid' => 1],
              ['id' => 2, 'name' => 'Song 2', 'albumid' => 2, 'artistid' => 2],
              ['id' => 3, 'name' => 'Song 3', 'albumid' => 2, 'artistid' => 1]
         ]
      ]);
  }
}
