<?php

namespace App\Utils;

class Generator
{

    public static function getRandomStringWithSpecialChar(int $length)
    {
        $digits = '0123456789';
        $alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $specialChar = '@$&_-';
        $characters = $digits . $alpha . $specialChar;
        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function getRandomString(int $length, bool $digits = true, bool $lowercase = true, bool $uppercase = true)
    {

        $num = '0123456789';
        $alphaU = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $alphaL = 'abcdefghijklmnopqrstuvwxyz';

        $new = "";
        $new .= $digits ? $num : "";
        $new .= $lowercase ? $alphaL : "";
        $new .= $uppercase ? $alphaU : "";

        $new = $new == "" ? $num . $alphaL . $alphaU : $new;

        $charactersLength = strlen($new);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $new[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function getUniqueRandomString(int $length, bool $digits = true, bool $lowercase = false, bool $uppercase = true)
    {

        $num = range(0, 9);
        $alphaL = range('a', 'z');
        $alphaU = range('A', 'Z');

        shuffle($num);
        shuffle($alphaL);
        shuffle($alphaU);

        $new = [];

        if (!$digits && $lowercase && $uppercase) {
            $new = array_merge($alphaL, $alphaU);
        } elseif ($digits && !$lowercase && $uppercase) {
            $new = array_merge($num, $alphaU);
        } elseif ($digits && $lowercase && !$uppercase) {
            $new = array_merge($num, $alphaL);
        } elseif (!$digits && !$lowercase && $uppercase) {
            $new = $alphaU;
        } elseif ($digits && !$lowercase && !$uppercase) {
            $new = $num;
        } elseif (!$digits && $lowercase && !$uppercase) {
            $new = $alphaL;
        }

        shuffle($new);

        $final = "";
        for ($i = 0; $i < $length; $i++) {
            $final .= $new[$i];
        }

        return $final;
    }

    public static function getWarehouseCode()
    {
        return Generator::getRandomString(1, false, false) . Generator::getUniqueRandomString(5);
    }

    public static function generateSlug(string $blockname){
        $blockslug = str_replace("&", "and", $blockname);
        $blockslug = preg_replace('/[^a-zA-Z0-9]+/', '-', $blockslug);
        $blockslug = preg_replace('/^[\-]/', '', $blockslug);
        $blockslug = preg_replace('/[\-]$/', '', $blockslug);
        $blockslug = strtolower($blockslug);

        return $blockslug;
    }

    public static function generateCatSlug(string $categoryname){
        $categoryslug = str_replace("&", "and", $categoryname);
        $categoryslug = preg_replace('/[^a-zA-Z0-9]+/', '-', $categoryslug);
        $categoryslug = preg_replace('/^[\-]/', '', $categoryslug);
        $categoryslug = preg_replace('/[\-]$/', '', $categoryslug);
        $categoryslug = strtolower($categoryslug);

        return $categoryslug;
    }
    public static function generateVariationTypeSlug(string $variationname){
        $variationslug = str_replace("&", "and", $variationname);
        $variationslug = preg_replace('/[^a-zA-Z0-9]+/', '-', $variationslug);
        $variationslug = preg_replace('/^[\-]/', '', $variationslug);
        $variationslug = preg_replace('/[\-]$/', '', $variationslug);
        $variationslug = strtolower($variationslug);

        return $variationslug;
    }
    
    public static function generateVariationSlug(string $variationname){
        $variationslug = str_replace("&", "and", $variationname);
        $variationslug = preg_replace('/[^a-zA-Z0-9]+/', '-', $variationslug);
        $variationslug = preg_replace('/^[\-]/', '', $variationslug);
        $variationslug = preg_replace('/[\-]$/', '', $variationslug);
        $variationslug = strtolower($variationslug);

        return $variationslug;
    }

    public static function generateProductSlug(string $productname){
        $productslug = str_replace("&", "and", $productname);
        $productslug = preg_replace('/[^a-zA-Z0-9]+/', '-', $productslug);
        $productslug = preg_replace('/^[\-]/', '', $productslug);
        $productslug = preg_replace('/[\-]$/', '', $productslug);
        $productslug = strtolower($productslug);

        return $productslug;
    }


}
