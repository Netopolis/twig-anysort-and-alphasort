<?php
/**
 * Copyright (c) 2019 Hugues Delalande
 * License: MIT
 *
 * Created: 10/04/2019
 *
 * Use this file in your projects, or simply copy the relevant filters and imports
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Doctrine\Common\Collections\Collection;

class AppExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            /** Sorts alphabetically arrays or objects (doctrine collections)
             * Usage: for element in object.elements|alphasort('key_name') */
            new TwigFilter('alphasort', function($elements, $key = null) {
                if ($key === null) {
                    throw new \InvalidArgumentException('Did you forget the \'key\' to sort by? Usage: for element in elements|alphasort(\'key_name\')');
                }
                if ($elements instanceof Collection) {
                    $elements = $elements->toArray();
                }
                if (!is_array($elements)) {
                    throw new \InvalidArgumentException('Variable passed is not an array
                     nor a doctrine collection');
                }

                if (is_object(current($elements)) && property_exists(current($elements), $key)) {
                    usort($elements, function ($a, $b) use ($key) {
                        $aValue = $a->{'get' . ucfirst($key)}();
                        $bValue = $b->{'get' . ucfirst($key)}();
                        return strcmp($aValue, $bValue);
                    });
                }

                if (is_array(current($elements))) {
                    usort($elements, function ($a, $b) use ($key) {
                        return strcmp($a[$key], $b[$key]);
                    });
                }

                return $elements;
            }),
            /** Sorts arrays or objects (doctrine collection) by values: strings, integers, floats, or DateTimes
             * Usage: for element in object.elements|anysort('key_name')
             * For filtering in descending order, just add the reverse filter, e.g.
             * for element in object.elements|anysort('key_name')|reverse (or |reverse(true) to preserve the keys) */
            new TwigFilter('anysort', function($elements, $key = null) {
                if ($key === null) {
                    throw new \InvalidArgumentException('Did you forget the \'key\' to sort by? Usage: for element in elements|anysort(\'key_name\')');
                }
                if ($elements instanceof Collection) {
                    $elements = $elements->toArray();
                }
                if (!is_array($elements)) {
                    throw new \InvalidArgumentException('Variable passed is not an array
                     nor a doctrine collection');
                }

                if (is_object(current($elements)) && property_exists(current($elements), $key)) {
                    usort($elements, function ($a, $b) use ($key) {
                        $aValue = $a->{'get' . ucfirst($key)}();
                        $bValue = $b->{'get' . ucfirst($key)}();
                        return $aValue > $bValue;
                    });
                }

                if (is_array(current($elements)) && array_key_exists($key, $elements)) {
                    usort($elements, function ($a, $b) use ($key) {
                        return $a[$key] > $b[$key];
                    });
                }

                return $elements;
            }),
        ];
    }

}
