
# rockschtar/wordpress-controller

Controller Trait for handling WordPress Hooks

## Requirements

* PHP >= 7.1
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

Use [composer](https://composer.org/) to install vendor/package-name.

```bash
composer install rockschtar/wordpress-controller
```
## Usage

```php
use Rockschtar\WordPress\Controller\HookController;

class MyController
{
    use HookController;

    private function __construct()
    {
        $this->addAction('wp_head', 'wpHead');
        $this->addFilter('body_class', 'bodyClass');
    }

    private function wpHead(): void
    {
        echo '<something></something>';
    }

    private function bodyClass(?array $classes = []): array
    {
        if ($classes === null) {
            $classes = [];
        }

        $classes[] = 'my-body-class';

        return $classes;
    }
}
```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)