<?php namespace Cosninix\Sin;

use Exception;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Class Sin
 *   convert a string with nl::xxxx|en::xxxx|@@::xxxx into the right language, otherwise just return string
 *   convert an array [nl=>dutch, en=>english, de=>german, fr=>french, @@=>translate via laravel]
 * @version 1.0
 * @Author rvwoens <rvw@cosninix.com>
 */
class SinBase {
	/** @var Config locale */
	private $config = null;

	public function __construct($config) {
		$this->config = $config;
	}

	/**
	 * Sin::lang
	 * @param array|string $s - translations for the current placeholder
	 * @return string|null
	 */
	public function lang() {

		//get function arguments, assuming first string is 'legacy' "en::english|fr:french"
		$args = func_get_args();

		$line = array_shift($args);

		$currentLanguage = strtolower($this->config->get('app.locale'));

		//enable support for array definition (['nl' => 'hallo wereld', 'en' => 'hello world'])
		if (is_array($line)) {
			//try to resolve "locale" -> "fallback_locale" -> "first item in array"
			if (isset($line[$currentLanguage]))
				return $line[$currentLanguage];
			$fallback = strtolower($this->config->get('app.fallback_locale'));
			if (isset($line[$fallback]))
				return $line[$fallback];
			return current($line);
		}

		// string format XX:: found
		if (substr($line, 2, 2) == '::') {

            //reduce translations to form [lang => line]
            /** @var Collection $translations */
            $translations=collect(explode('|', $line))->reduce(function($carry, $lang) {
                try {
                    list($key, $value)=explode('::', $lang);
                    $carry[$key]=$value;
                }
                catch(Exception $e) {
                    Log::error("Sin::lang syntax error: $lang");
                }
                return $carry;
            }, collect());

            $translation=function() use ($translations, $currentLanguage) {

                //try to find key, to use laravel language files
                $translationByKey=$translations->get('@@');

                if($translationByKey && Lang::has($translationByKey)) {
                    return Lang::get($translationByKey);
                }

                //try to find a translation in the users current language
                $translationByCurrentLanguage=$translations->get($currentLanguage);

                if($translationByCurrentLanguage) {
                    return $translationByCurrentLanguage;
                }

                //try to find a translation in our fallback language
                $defaultLanguageMatchedTranslation=$translations->get($this->config->get('app.fallback_locale'));

                if($defaultLanguageMatchedTranslation) {
                    return $defaultLanguageMatchedTranslation;
                }

                //return the first translation if all else fails
                return $translations->first();
            };

            //prepend translation string as first argument to call sprintf with
            // replece "nl::dutch%d|en::english%d" with "english%d"
            array_unshift($args, $translation());
            try {
                return call_user_func_array('sprintf', $args);
            }
            catch(Exception $e) {
                return $translation();  // exception in sprintf. Possible mismatched %s
            }

		}

		return $line;
	}
}
