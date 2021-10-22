#Draft Instances

####Class generator using templates ("drafts")

This way is different from the traditional **DI (Dependency injection)**,
since it does not injects dependencies programmatically at runtime, but in advance,
by generating and changing classes according to settings. The created classes exist as files;
their correctness can be checked, dependencies are "visible" for IDE, so as testing is possible.

[Link to instructions](https://phphleb.ru/ru/v1/di/) (RU)

Draft Instances is an experimental technique, as well as some others in [HLEB](https://github.com/phphleb/hleb) framework encompassing this library.
*Unsuitable for using recklessly.* If desired, the library may be connected separately (generation is implemented in **GeneratingTask** class).

#####Installation
```bash
$ composer require phphleb/draft
```
#####Deployment
```bash
$ php console phphleb/draft --add
```
#####Generation
Generating classes and updating the autoloader. Every time when the settings or template classes are changed, this command is to be started.
```bash
$ php console drafts/generating-task --update-all
$ composer dump-autoload
```

The only distinction between the generated classes and the usual ones created by a developer is that the former are editable only from the "draft" or settings.

Using settings from one template ("draft"), you can create a lot of similar classes for different tasks. Each
"draft" is arbitrary in content, the principle of substituting settings into it is simple, and it is specified as follows.

`1` Array with settings:
```php
return [
'AClass' => [
        'TestDraftClass' => [
            'ActionName' => 'new \DateTime',
            'Value' => '\'now\'',
            'ReturnType' => '\DateTimeInterface',
            'Description' => 'Demo A class'
        ]
    ],
'BClass' => [
        'TestDraftClass' => [
            'ActiontName' => 'implode',
            'Value' => '[100,500]',
            'ReturnType' => 'string',
            'Description' => 'Demo B class'
        ]
    ],
];
```
`2` Schematic template class **TestDraftClass.php** (default setting values for substitution are neutral-random to support syntax highlighting in IDE)
```php
<?php
/* *//**<-@Description*/
class TestDraftClass/**<-@ClassName*/
{
  private const VALUE = null/**<-@Value*/;
  public function get(): void/**<-@ReturnType*/
  {
     return /**<-@ActiontName*/(self::VALUE);
  }
}
````
`3` After starting the generation, two working classes are obtained:

```php
<?php
/* Demo A class */
class AClass
{
  private const VALUE = 'now';
  public function get(): \DateTimeInterface
  {
     return new \DateTime(self::VALUE);
  }
}
````
```php
<?php
/* Demo B class */
class BClass
{
  private const VALUE = [100,500];
  public function get(): string
  {
     return implode(self::VALUE);
  }
}
````

The substitution was performed according to markers ```/**<-@```...```*/```, then the value on the left to the marker, before the gap char, was taken, and all this was substituted with the suitable value from the class configuration.
Only this rule is to be taken into account, on creating your own classes-"drafts" and their settings.

By default, some examples illustrating generation capabilities were created in this library (**services.php** file and **DraftInstances** folder with "drafts").

#####Updating the library

```bash
$ composer update phphleb/draft
$ php console phphleb/draft --add
$ php console drafts/generating-task --update-all
$ composer dump-autoload
```

-----------------------------------


[![License: MIT](https://img.shields.io/badge/License-MIT%20(Free)-brightgreen.svg)](https://github.com/phphleb/draft/blob/main/LICENSE) ![PHP](https://img.shields.io/badge/PHP-^7.3.0-blue) ![PHP](https://img.shields.io/badge/PHP-8-blue) ![PHP](https://img.shields.io/badge/HLEB->=1.5.72-brightgreen)