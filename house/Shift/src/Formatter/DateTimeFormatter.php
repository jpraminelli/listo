<?

namespace Shift\Formatter;

use DateTime;
use IntlDateFormatter;
use Shift\SM;
use Zend\I18n\Exception;

class DateTimeFormatter
{
    protected $timezone;

    protected $formatters = array();

    public function __construct()
    {
        if (!extension_loaded('intl')) {
            throw new Exception\ExtensionNotLoadedException(sprintf(
                'O componente %s requer a extensão intl do PHP.',
                __NAMESPACE__
            ));
        }
    }

    public function format($datetime, $timeType = IntlDateFormatter::SHORT)
    {
        if (!$datetime) {
            return '';
        }
        $dateType = IntlDateFormatter::MEDIUM;
        $pattern  = null;
        $translator = SM::get('translator');
        $locale = $translator->getLocale();
        if (!$locale) {
            $locale = 'pt_BR';
        }
        $timezone    = $this->getTimezone();
        $formatterId = md5($dateType . "\0" . $timeType . "\0" . $locale ."\0" . $pattern);
        if (!isset($this->formatters[$formatterId])) {
            $this->formatters[$formatterId] = new IntlDateFormatter(
                $locale,
                $dateType,
                $timeType,
                $timezone,
                IntlDateFormatter::GREGORIAN,
                $pattern
            );
        }
        // DateTime support for IntlDateFormatter::format() was only added in 5.3.4
        if ($datetime instanceof DateTime && (PHP_VERSION_ID < 50304)) {
            $datetime = $datetime->getTimestamp();
        }
        return $this->formatters[$formatterId]->format($datetime);
    }

    public function setTimezone($timezone)
    {
        $this->timezone = (string) $timezone;
        // The method setTimeZoneId is deprecated as of PHP 5.5.0
        $setTimeZoneMethodName = (PHP_VERSION_ID < 50500) ? 'setTimeZoneId' : 'setTimeZone';
        foreach ($this->formatters as $formatter) {
            $formatter->$setTimeZoneMethodName($this->timezone);
        }
        return $this;
    }

    public function getTimezone()
    {
        if (!$this->timezone) {
            return date_default_timezone_get();
        }
        return $this->timezone;
    }
}
