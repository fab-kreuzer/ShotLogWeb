<?php

namespace ShotLog\Utils;

use ShotLog\Models\Session;

class CalenderUtils
{
    /**
     * Converts an array of Session objects to a JSON string.
     *
     * @param array $sessions Array of Session objects.
     * @return string JSON string representing the array of sessions.
     */
    public static function toCalenderEntries(array $sessions): string
    {
        // Convert each Session object to an associative array
        $data = array_map(function ($session) {
            return [
                'id' => $session->getId(),
                'title' => $session->getDesc(),
                'start' => $session->getStartAt(),
                'end' => $session->getStartAt(),
                'extendedProps' => [ // Nested properties
                    'location' => $session->getOrt()
                ],
                'color' => $session->getIsWettkampf() ? '#4a1f17' : '#3a4a17'
            ];
        }, $sessions);

        // Return the JSON-encoded string
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public static function log(string $txt) {
        return "<script>console.log(\"" . $txt ."\");</script>";
    }
}
