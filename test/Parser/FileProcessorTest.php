<?hh

namespace MTP\Test\Parser;

use MTP\Parser\FileProcessor;

class FileProcessorTest extends \PHPUnit_Framework_TestCase
{
  public function setUp(): void
  {
    $this->processor = new FileProcessor(
      new \SplFileInfo(__DIR__ . '/fixture/test.mp3'),
      new \getID3()
    );
  }

  public function testGetSong(): void
  {
    $this->assertEquals('Test Song', $this->processor->title());
  }

  public function testGetArtist(): void
  {
    $this->assertEquals('Test Artist', $this->processor->artist());
  }

  public function testGetAlbum(): void
  {
    $this->assertEquals('Test Album', $this->processor->album());
  }
}
