# ToolboxBundle for Symfony 4
<img src="https://badgen.net/packagist/v/atournayre/toolbox-bundle/latest" /> <img src="https://badgen.net/github/tag/atournayre/toolbox-bundle" /> <img src="https://badgen.net/packagist/php/atournayre/toolbox-bundle" /> <img src="https://badgen.net/github/last-commit/atournayre/toolbox-bundle" /> <img src="https://badgen.net/travis/atournayre/toolbox-bundle" /> <img src="https://badgen.net/codacy/grade/3b38b47687f744b2b5c18b1035d9a2d8" /> [![CodeFactor](https://www.codefactor.io/repository/github/atournayre/toolbox-bundle/badge)](https://www.codefactor.io/repository/github/atournayre/toolbox-bundle)


## Services

| Services              | Description                                                                          |
|---                    |---                                                                                   |
| Amount                | Pass an out of taxes amount, a VAT percent or not and get all parts of an amount.    |
| Array                 | Array manipulation (shortcuts for core functions, usage of symfony/property-access). |
| Calculation           | Revert sign of number.                                                               |
| CRUD Controllers      | Only Create and Delete controllers for the moment.                                   |
| Date                  | Carbon with additional methods.                                                      |
| Doctrine 2 extensions | [A set of Doctrine 2 extensions](https://github.com/beberlei/DoctrineExtensions).    |
| Email                 | Send mail using Swiftmailer.                                                         |
| Encrypt               | Encrypt/Decrypt datas.                                                               |
| Excel                 | Create and manage Excel files.                                                       |
| File                  | Create and manage files.                                                             |
| Form themes           | Form themes (Bootstrap 3, Materialize).                                              |
| Google                | Connect to Google Calendar API.                                                      |
| IBAN                  | Form, data validation, encryption.                                                   |
| Maintenance           | Activate/Desactivate maintenance for your application.                               |
| Number                | Manage integer and float.                                                            |
| Numbering             | Manage numbering (for invoices and more).                                            |
| PDF                   | Integration of Html2Pdf.                                                             |
| PDF Merger            | Combine PDFs.                                                                        |
| SIREN/SIRET           | Use INSEE API to check SIREN/SIRET informations.                                     |

## Amount

Use `integer` only.

```php
<?php
use Atournayre\ToolboxBundle\Service\Amount\Amount;

// 12.34 => 1234
$amountWithoutTaxes = new Amount(1234);
$amountWithoutTaxes->getPartsWithoutTaxes();

// 12.34 => 1234
// 20 % => 20 
$amountWithTaxes = new Amount(1234, 20);
$amountWithTaxes->getPartsWithTaxes();

```

## Calculation
```php
<?php
use Atournayre\ToolboxBundle\Service\Calculation\Calculation;

$calculation = new Calculation();
$calculation->invertSign(1234); // -1234
```

## CRUD Controllers
Form basics CRUD operations, use this controllers with `$this->forward()`

Minimal example :

```php
<?php
use Atournayre\ToolboxBundle\Controller\DeleteController;

return $this->forward(
    DeleteController::ACTION_DELETE_JSON,
    [
        'objectClass' => User::class,
        'entityId' => $id,
    ]
);
```

Full example :

```php
<?php
use Atournayre\ToolboxBundle\Controller\DeleteController;

return $this->forward(
    DeleteController::ACTION_DELETE_JSON,
    [
        'objectClass' => User::class,
        'entityId' => $id,
        'successMessage' => 'My custom success message.',
        'confirmationMessage' => 'Are you really really sure?',
        'errorMessage' => 'My custom error message.',
    ]
);
```

## Environments commands
`php bin/console init`

By default it runs in development environment.

Use `--env` to define the environment you want.

```yaml
environment_commands:
  dev:
    - 'mkdir public/uploads'
    - 'mkdir public/tests'
    - 'load fixtures'
  prod:
    - 'mkdir public/uploads'
  ...
```

## Form themes
`config/packages/twig.yaml`
```yaml
twig:
  form_themes:
    - @AtournayreToolbox/Form/theme/bootstrap3.html.twig
    - @AtournayreToolbox/Form/theme/materialize.html.twig
```

## IBAN

### Form
Use `IbanType`

### Validation
Using form, validation is automatic using DataTransformer, an error will be thrown to the form.

### Encryption
Datas are crypted using your application secret.

**/!\ Be careful, changing your secret make all datas unrecoverable.**

## Maintenance

`php bin/console maintenance`

If `custom.template` is defined it overrides the `system` parameters.
```yaml
maintenance:
  custom:
    template: YOUR_TWIG #default null
  system:
    base: YOUR_BASE_TWIG #default base.html.twig
    title: YOUR_TITLE #default Maintenance
    content: YOUR_TWIG #default null
```
## Number

Database should only store integers, so you have to convert int to float and vice versa.

```php
<?php
use Atournayre\ToolboxBundle\Service\Number\Number;
use Atournayre\ToolboxBundle\Service\Number\NumberNullable;

$number = new Number();
$numberNullable = new NumberNullable();

// Convert Integer to Float
$float = $number->intToFloat(1234); // $float = 12.34

// Convert Float To Integer
$integer = $number->floatToInt(12.34); // $integer = 1234

// Convert Null To Float, because sometimes a value could be null
$float = $numberNullable->intToFloat(null); // $float = 0

// Convert Null To Integer, because sometimes a value could be null
$integer = $numberNullable->floatToInt(null); // $integer = 0
```

## Numbering

For `pad_type` authorized values, see [https://www.php.net/manual/fr/function.str-pad.php](https://www.php.net/manual/fr/function.str-pad.php)
```yaml
numbering:
  pad_length: #default null
  pad_string: #default null
  pad_type: #default null
  prefix: #default null
  suffix: #default null
```
## PDF

It supports only Html2Pdf.

```yaml
pdf:
  orientation: #default P
  format: #default A4
  language: #default fr
  unicode: #default true 
  encoding: #defaultValue UTF-8
  margins: #default [0, 0, 0, 0]
```

## PDF Merger

```php
<?php
use Atournayre\ToolboxBundle\Service\Pdf\Merger\PdfMerger;

$filePaths = [];
$mergeFilePath = '~/merge.pdf';
$pdfMerger = new PdfMerger();
$pdfMerger->addDocuments($filePaths);
$pdfMerger->merge($mergeFilePath);
```

## SIREN/SIRET

To check SIREN/SIRET informations, first go to [http://api.insee.fr](http://api.insee.fr), then create an application and add credentials to your `.env`.

```dotenv
INSEE_CONSUMER_KEY = XXXXXXXXXX
INSEE_CONSUMER_SECRET = XXXXXXXXXX
```

### Validation

```php
<?php
use Atournayre\ToolboxBundle\Service\Insee\InseeToken;
use Atournayre\ToolboxBundle\Service\Insee\InseeSirene;
use Atournayre\ToolboxBundle\Service\Insee\InseeSirenValidator;

// Use Dependency Injection for lines below.
$validator = new InseeSirenValidator(
    new InseeToken(INSEE_CONSUMER_KEY, INSEE_CONSUMER_SECRET), 
    new InseeSirene()
);

// To validate a SIREN
$validator->validate('000000000');

// To validate a SIRET
$validator->validate('00000000000000');
```
