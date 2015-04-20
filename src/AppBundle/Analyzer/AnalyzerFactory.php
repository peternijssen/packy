<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Analyzer;

class AnalyzerFactory
{
    /**
     * Create for manager
     *
     * @param string $manager
     *
     * @return AnalyzerInterface
     */
    public function createForManager($manager)
    {
        $class = "AppBundle\\Analyzer\\".ucfirst(strtolower($manager)).'Analyzer';
        dump($class);
        if (!class_exists($class)) {
            throw new \InvalidArgumentException('Unknown manager: '.$manager);
        }

        return new $class();
    }
}
