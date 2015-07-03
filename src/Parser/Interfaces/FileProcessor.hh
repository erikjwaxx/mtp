<?hh

namespace MTP\Parser\Interfaces;

interface FileProcessor
{
  public function artist(): string;
  public function album(): string;
  public function title(): string;
}
