<?hh

namespace MTP\Parser;

class FileProcessor implements Interfaces\FileProcessor
{
  private \getID3 $_id3Parser;
  private array $_id3Info = [];

  public function __construct(\SplFileInfo $finfo, \getID3 $parser): void
  {
    $this->_id3Parser = $parser;
    $this->_id3info = $this->_id3Parser->analyze($finfo->getRealPath());
  }

  public function artist(): string
  {
    return $this->_id3info['tags']['id3v2']['artist'][0];
  }

  public function album(): string
  {
    return $this->_id3info['tags']['id3v2']['album'][0];
  }

  public function title(): string
  {
    return $this->_id3info['tags']['id3v2']['title'][0];
  }
}
