<?php

namespace ShotLog\Utils;

use Exception;

class Config
{
    /**
     * Reads and parses the given INI file.
     *
     * @param string $filePath The path to the config file.
     * @return array Parsed config data.
     * @throws Exception If the file does not exist.
     */
    private static function getFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new \Exception("Config file not found: $filePath");
        }
        return parse_ini_file($filePath);
    }

    /**
     * Fetches a value from the configuration file.
     *
     * @param string $key The key to fetch from the file.
     * @return string|null The value of the key, or null if not found.
     * @throws Exception
     */
    public static function getFromDBProperties(string $key): ?string
    {
        $filePath = __DIR__ . '/../DAO/config.properties';

        return self::getFile($filePath)[$key] ?? null;
    }
}
