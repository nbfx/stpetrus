<?php

namespace App\Helpers;


class NameHelper
{
    /**
     * @param string $title
     * @return string
     */
    public static function generateNameByTitle(string $title)
    {
        return preg_replace(
            "/[\s_]/",
            "-",
            preg_replace(
                "/[\s-]+/",
                " ",
                preg_replace(
                    "/[^a-z0-9_\s-]/",
                    "",
                    self::transliterate(mb_strtolower($title))
                )
            )
        );
    }

    /**
     * @param $string
     * @return string
     */
    public static function transliterate($string)
    {
        $converter = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '\'',
            'ы' => 'y',
            'ъ' => '\'',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
        ];

        return strtr($string, $converter);
    }

    /**
     * @param string $string
     * @param bool $capitalizeFirstCharacter
     * @return mixed|string
     */
    public static function snakeToCamel(string $string, bool $capitalizeFirstCharacter = false)
    {
        return $capitalizeFirstCharacter ?
            str_replace('_', '', ucwords($string, '_')) :
            lcfirst(str_replace('_', '', ucwords($string, '_')));
    }

    /**
     * Translate string to camel case
     *
     * @param string $string
     * @param bool $capitalizeFirstCharacter
     * @param array $noStrip
     * @return mixed|string
     */
    public static function toCamelCase(string $string, bool $capitalizeFirstCharacter = false, array $noStrip = [])
    {
        $string = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $string);
        $string = trim($string);
        $string = ucwords($string);
        $string = str_replace(" ", "", $string);

        return $capitalizeFirstCharacter ? $string : lcfirst($string);

    }
}
