# ToolboxBundle for Symfony 4
<img src="https://badgen.net/packagist/v/atournayre/toolbox-bundle/latest" /> <img src="https://badgen.net/github/tag/atournayre/toolbox-bundle" /> <img src="https://badgen.net/packagist/php/atournayre/toolbox-bundle" /> <img src="https://badgen.net/github/last-commit/atournayre/toolbox-bundle" /> <img src="https://badgen.net/travis/atournayre/toolbox-bundle" /> <img src="https://badgen.net/codacy/grade/3b38b47687f744b2b5c18b1035d9a2d8" /> [![CodeFactor](https://www.codefactor.io/repository/github/atournayre/toolbox-bundle/badge)](https://www.codefactor.io/repository/github/atournayre/toolbox-bundle)


## Services

| Services              | Description                                                                        |
|---                    |---                                                                                 |
| Array                 | Array manipulation (shortcuts for core functions, usage of symfony/property-access |
| CRUD Controllers      | Only Create and Delete controllers for the moment                                  |
| Date                  | Carbon with additional methods                                                     |
| Doctrine 2 extensions | [A set of Doctrine 2 extensions](https://github.com/beberlei/DoctrineExtensions)   |
| Email                 | Send mail using Swiftmailer                                                        |
| Excel                 | Create and manage Excel files                                                      |
| File                  | Create and manage files                                                            |
| Form themes           | Form themes (Bootstrap 3, Materialize                                              |
| Google                | Connect to Google Calendar API                                                     |
| Maintenance           | Activate/Desactivate maintenance for your application                              |
| Numbering             | Manage numbering (for invoices and more                                            |
| PDF                   | Integration of Html2Pdf                                                            |

## CRUD Controllers
Form basics CRUD operations, use this controllers with `$this->forward()`

Minimal example :

```
    return $this->forward(
        DeleteController::ACTION_DELETE_JSON,
        [
            'objectClass' => User::class,
            'entityId' => $id,
        ]
    );
```

Full example :

```
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

```
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
```
twig:
  form_themes:
    - @AtournayreToolbox/Form/theme/bootstrap3.html.twig
    - @AtournayreToolbox/Form/theme/materialize.html.twig
```

## Maintenance

`php bin/console maintenance`

If `custom.template` is defined it overrides the `system` parameters.
```
  maintenance:
    custom:
      template: YOUR_TWIG #default null
    system:
      base: YOUR_BASE_TWIG #default base.html.twig
      title: YOUR_TITLE #default Maintenance
      content: YOUR_TWIG #default null
```
## Numbering

For `pad_type` authorized values, see [https://www.php.net/manual/fr/function.str-pad.php](https://www.php.net/manual/fr/function.str-pad.php)
```
  numbering:
    pad_length: #default null
    pad_string: #default null
    pad_type: #default null
    prefix: #default null
    suffix: #default null
```
## PDF

It supports only Html2Pdf.

```
    pdf:
      orientation: #default P
      format: #default A4
      language: #default fr
      unicode: #default true 
      encoding: #defaultValue UTF-8
      margins: #default [0, 0, 0, 0]
```
