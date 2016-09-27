<?php
namespace Mia3\Expose\Utility;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 */
class StringFormatter {

	public static function formNameToPath($formName) {
		$parts = explode('[', $formName);
		array_walk($parts, function(&$value, $key){
			$value = trim($value, ']');
		});
		return implode('.', $parts);
	}

	public static function pathToFormId($path) {
		return str_replace('.', '-', $path);
	}

	public static function pathToTranslationId($path) {
		return preg_replace('/\.[0-9]*\./', '.', $path);
	}

	public static function pathToFormName($path) {
        if (stristr($path, '.') === FALSE) {
            return $path;
        }

        $parts = explode('.', $path);
        foreach ($parts as $key => $part) {
            if ($key > 0) {
                $parts[$key] = '[' . $part . ']';
            }
        }

        return implode('', $parts);
    }

    /**
     * @param string $word The word to pluralize
     * @return string The pluralized word
     */
    public static function pluralizeWord($word) {
        return \Sho_Inflect::pluralize($word);
    }

    /**
     * Convert a model class name like "BlogAuthor" or a field name like
     * "blogAuthor" to a humanized version like "Blog author" for better readability.
     *
     * @param string $camelCased The camel cased value
     * @param boolean $lowercase Return lowercase value
     * @return string The humanized value
     */
    public static function camelCaseToSentence($camelCased, $lowercase = FALSE) {
        $spacified = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', $camelCased);
        $result = strtolower($spacified);
        if (!$lowercase) {
            $result = ucfirst($result);
        }
        return $result;
    }
}