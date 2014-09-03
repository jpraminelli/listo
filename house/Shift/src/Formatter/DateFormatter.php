<?

namespace Shift\Formatter;

use IntlDateFormatter;
use Shift\SM;
use Zend\I18n\Exception;

class DateFormatter
{
    public function __construct()
    {
        if (!extension_loaded('intl')) {
            throw new Exception\ExtensionNotLoadedException(sprintf(
                'O componente %s requer a extensão intl do PHP.',
                __NAMESPACE__
            ));
        }
    }

    public function format($date)
    {
        $formatter = SM::get('shift.formatter.datetime_formatter');
        return $formatter->format($date, IntlDateFormatter::NONE);
    }
}
