<?php

namespace Rockschtar\WordPress\Controller;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

final class WordPressController
{
    public static function autoInitialize(string $controllerDirectoryPath): void
    {
        $controllerClasses = array();

        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($controllerDirectoryPath));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');

        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2;
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2;
                    $class = $namespace . '\\' . $tokens[$index][1];
                    $classUsesTraits = class_uses($class, true);
                    if (is_array($classUsesTraits) && in_array(HookController::class, $classUsesTraits, true)) {
                        $controllerClasses[] = $class;
                    }

                    break;
                }
            }
        }

        foreach ($controllerClasses as $controllerClass) {
            $controllerClass::init();
        }
    }
}
