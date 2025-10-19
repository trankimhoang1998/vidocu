<?php

namespace App\Helpers;

class ReadingTime
{
    /**
     * Calculate reading time in minutes
     *
     * @param string $content
     * @param int $wordsPerMinute
     * @return int
     */
    public static function calculate($content, $wordsPerMinute = 200)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / $wordsPerMinute);

        return max(1, $minutes); // Minimum 1 minute
    }

    /**
     * Format reading time to string
     *
     * @param string $content
     * @param int $wordsPerMinute
     * @return string
     */
    public static function format($content, $wordsPerMinute = 200)
    {
        $minutes = self::calculate($content, $wordsPerMinute);

        return $minutes . ' phút đọc';
    }
}
