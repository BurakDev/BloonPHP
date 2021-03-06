<?php

namespace Emulator;

use Emulator\Core\Logging;
use Emulator\Threading\ThreadPooling;
use Emulator\Core\ConfigurationManager;
use Emulator\Core\TextsManager;
use Emulator\Core\CleanerThread;
use Emulator\Database\Database;
use Emulator\Networking\GameServer;
use Emulator\HabboHotel\GameEnvironment;
use Emulator\Util\System;
use Ubench;

class Emulator {

    public static $build = 1;
    public static $isReady = false;
    public static $stopped = false;
    private static $config;
    private static $texts;
    private static $gameServer;
    private static $rconServer;
    private static $database;
    private static $logging;
    private static $threading;
    private static $gameEnvironment;
    private static $pluginManager;
    public static $logo = "\r######                              ######  #     # ######   ###\n#     # #       ####   ####  #    # #     # #     # #     #  ###\n#     # #      #    # #    # ##   # #     # #     # #     #  ###\n######  #      #    # #    # # #  # ######  ####### ######    # \n#     # #      #    # #    # #  # # #       #     # #           \n#     # #      #    # #    # #   ## #       #     # #        ###\n######  ######  ####   ####  #    # #       #     # #        ###";

    public static function start() {
        try {
            $bench = new Ubench();
            $bench->start();
            self::$stopped = false;
            self::$logging = new Logging();
            self::$logging->logStart(self::$logo);
            self::$threading = new ThreadPooling(System::getAvailableProcessors() * 2 + 100);
            self::$config = new ConfigurationManager("config.ini");
            self::$database = new Database(self::$config);
            self::$config->loadFromDatabase();
            self::$config->loaded = true;
            self::$texts = new TextsManager();
            //new CleanerThread()->start();
            self::$gameEnvironment = new GameEnvironment();
            self::$gameEnvironment->load(self::$database);
            self::$gameServer = new GameServer(self::$config->getValue("game.host", "127.0.0.1"), self::$config->getInt("game.port", 3000), self::$logging, self::$gameEnvironment);
            self::$gameServer->start();

            $bench->end();
            self::$logging->logStart("Habbo Hotel Emulator has succesfully loaded.");
            self::$logging->logStart("You're running: Version: 1.0");
            self::$logging->logStart("System launched in: " . $bench->getTime());
            self::$logging->logStart("PHP Max memory : " . System::getMaxMemory() . "GB, physical memory : " . System::getPhysicalMemory() . "GB");
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public static function getConfig(): ConfigurationManager {
        return self::$config;
    }

    public static function getTexts(): TextsManager {
        return self::$texts;
    }

    public static function getGameServer(): GameServer {
        return self::$gameServer;
    }

    public static function getRconServer() {
        return self::$rconServer;
    }

    public static function getDatabase(): Database {
        return self::$database;
    }

    public static function getLogging(): Logging {
        return self::$logging;
    }

    public static function getThreading(): ThreadPooling {
        return self::$threading;
    }

    public static function getGameEnvironment(): GameEnvironment {
        return self::$gameEnvironment;
    }

    public static function getPluginManager() {
        return self::$pluginManager;
    }

    public static function getIntUnixTimestamp(): int {
        return time();
    }

}
