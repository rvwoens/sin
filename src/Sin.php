<?php namespace Cosninix\Sin;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

/**
 * Class Sin
 *   convert a string with nl::xxxx|en::xxxx|@@::xxxx into the right language, otherwise just return string
 *   convert an array [nl=>dutch, en=>english, de=>german, fr=>french, @@=>translate via laravel]
 * @version 1.0
 * @Author rvwoens <rvw@cosninix.com>
 */
class Sin {


    /**
   	 * Sin::lang
   	 * @param  array|string $s - translations for the current placeholder
   	 * @return string|null
   	 */
   	public static function lang() {

   		//get function arguments, assuming first string is 'legacy' "en::english|fr:french"
   		$args = func_get_args();

   		$line = array_shift($args);

   		$currentLanguage = strtolower(Config::get('app.locale'));

   		//enable support for array definition (['nl' => 'hallo wereld', 'en' => 'hello world'])
   		if(is_array($line)) {
   			//try to resolve "locale" -> "fallback_locale" -> "first item in array"
   			return array_get($line, $currentLanguage, array_get($line, strtolower(Config::get('app.fallback_locale')), current($line)));
   		}

   		// string format XX:: found
   		if (substr($line, 2, 2)=='::') { // } && in_array(substr($s,0,2),Config::get('app.available_languages'))) {

   			//reduce translations to form [lang => line]
   			/** @var \Illuminate\Support\Collection $translations */
   			$translations = collect(explode('|', $line))->reduce(function ($carry, $lang) {
   				list($key, $value) = explode('::', $lang);
   				$carry[$key] = $value;
   				return $carry;
   			}, collect());

   			$translation = function () use ($translations, $currentLanguage) {

   				//try to find key, to use laravel language files
   				$translationByKey = $translations->get('@@');

   				if ($translationByKey && Lang::has($translationByKey)) {
   					return Lang::get($translationByKey);
   				}

   				//try to find a translation in the users current language
   				$translationByCurrentLanguage = $translations->get($currentLanguage);

   				if ($translationByCurrentLanguage) {
   					return $translationByCurrentLanguage;
   				}

   				//try to find a translation in our fallback language
   				$defaultLanguageMatchedTranslation = $translations->get(Config::get('app.fallback_locale'));

   				if ($defaultLanguageMatchedTranslation) {
   					return $defaultLanguageMatchedTranslation;
   				}

   				//return the first translation if all else fails
   				return $translations->first();
   			};

   			//prepend translation string as first argument to call sprintf with
   			// replece "nl::dutch%d|en::english%d" with "english%d"
   			array_unshift($args, $translation());

   			return call_user_func_array('sprintf', $args);
   		}

   		return $line;
   	}
}
