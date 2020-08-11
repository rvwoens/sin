## Sin - Simple Internationalization for Laravel
[![GitHub Release](https://img.shields.io/github/v/tag/rvwoens/sin.svg?style=flat)](//packagist.org/packages/cosninix/sin)
[![GitHub Release](https://img.shields.io/packagist/v/cosninix/sin.svg?style=flat)](//packagist.org/packages/cosninix/sin)
[![Total Downloads](https://poser.pugx.org/cosninix/sin/downloads)](//packagist.org/packages/cosninix/sin)
[![License](https://poser.pugx.org/cosninix/sin/license)](//packagist.org/packages/cosninix/sin)
[![Actions Status](https://github.com/rvwoens/sin/workflows/CI/badge.svg)](https://github.com/rvwoens/sin/actions)

Sin takes a whole new approach to internationalization (i18n) that is useful for simple projects or when the developer can make fast translations on the fly.
The way it works is very simple: Just define a string in a special format containg all the languages, as follows:
```
"en::What is your name?|nl::Wat je is naam?|de::Wie heisst du?|fr::Comment t'appelles-tu?"
```

Because Sin uses strings only, it can be used in code, but also in databases, yaml or json files or anywhere where a string is presented to the user.

Sin integrates seemless with Laravel and uses the old and new laravel internationalization styles so it can be seen as an add-on to this mechanism.

Sin is most useful for bi-lingual applications (like dutch/english) where the developer is bi-lingual as well. 

#### Installation
```
    composer install cosninix/sin
```
The sin package creates the *Sin* facade alias, a serviceprovider and a helper function

#### Basic usage

```
    echo app('Sin')->lang("nl::via de serviceprovider\n|en::via the serviceprovider\n");

    echo Sin::lang("nl::via de Sin facade deze keer\n|en::through the Sin facade this time\n");
    
    // three underscores
    echo ___("nl::via de sinlang helper werkt ook geweldig\n|en::works great as well through the sinlang helper\n");
```
and also in blade:
```
    <h1>@slang('nl::blade constructie|en::blade construct')</h1>
```

If the language construct is not found, Sin passes the string as is, so:
```
    Sin::lang('no language specified'); --> 'no language specified'
```
So you can pass for instance database strings through Sin before showing the user, as this adds the opportunity to add a language later on.

Sin runs every result through sprintf so this works fine:
```
    Sin::lang("en::We have %d smartphones in stock|nl::nu %d smartphones op voorraad",20); 
```
Of course, Sin is not limited to code. You can use Sin in yaml or json files:
```
    list: { options: [ 1, 3 ], text: [ "nl::kies 1|en::choose 1", "nl::Neem er 3|en::Take 3" ] }
```

#### Laravel integration
Sin takes the app.locale config as the default language and app.fallback_locale as fallback. If you change the app language using 
```
    App::setLocale('nl');
```
You can prepare for Laravel translations by giving an additional laravel key that can be used with the traditional @lang construct:
```
    Sin::lang('nl::Nederlands|en::English|@@::language_key);
```
If the *language_key* exists in the laravel translations, this takes priority, otherwise the Sin translations are used. So you can add traditional translations later on.



