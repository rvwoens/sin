# sin
Simple Internationalisation for Laravel

Sin takes a whole new approach to internationalization (i18n) that is useful for simple projects or when the developer can make fast translations on the fly.
The way it works is very simple: Just define a string in a special format containg all the languages, as follows:
```
"en::What is your name?|nl::Wat je is naam?|de::Wie heisst du?|fr::Comment t'appelles-tu?"
```

Because Sin uses strings only, it can be used in code, but also in databases, yaml or json files or anywhere where a string is presented to the user.

Because Sin integrates seemless with Laravel and uses the old and new laravel internationalization styles it can be seen as an add-on.

