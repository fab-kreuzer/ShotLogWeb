<?php

namespace ShotLog\Utils;

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
                'id' => $session->id,
                'title' => $session->isWettkampf ? 'Wettkampf' : 'Training',
                'start' => $session->startAt,
                'end' => $session->startAt,
                'extendedProps' => [ // Nested properties
                    'location' => $session->ort
                ],
                'color' => $session->isWettkampf ? '#4a1f17' : '#3a4a17'
            ];
        }, $sessions);

        // Return the JSON-encoded string
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public static function log(string $txt) {
        return "<script>console.log(\"" . $txt ."\");</script>";
    }
}
