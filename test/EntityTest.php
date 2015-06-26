<?hh

namespace MTP\Test\Entity;

use \Doctrine\ORM\EntityManager;

abstract class EntityTest extends \PHPUnit_Extensions_Database_TestCase
{
  private static ?\PDO $dbh = null;
  private static $mdCfg;
  protected static string $testClass = 'CHANGEME';

  public function __construct()
  {
    parent::__construct();

    // This has to be done here instead of in setUpBeforeClass to appease the Hack typechecker.
    if (!isset(self::$dbh)) {
      self::$dbh = new \PDO('sqlite:' . TEST_DB, null, null, [\PDO::ATTR_PERSISTENT => true]);
      self::$dbh->exec('PRAGMA foreign_keys = ON');
    }
  }

  public static function setUpBeforeClass(): void
  {
    self::$mdCfg = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration([__DIR__ . "/../Entity"], true);
  }

  public function setUp(): void
  {
    parent::setUp();

    $this->em = EntityManager::create(['pdo' => self::$dbh], self::$mdCfg);
    $this->repo = $this->em->getRepository(static::$testClass);
  }

  public function getConnection(): \PHPUnit_Extensions_Database_DB_IDatabaseConnection
  {
    return $this->createDefaultDBConnection(self::$dbh);
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
