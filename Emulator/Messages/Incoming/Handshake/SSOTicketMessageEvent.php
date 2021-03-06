<?php

namespace Emulator\Messages\Incoming\Handshake;

use Emulator\HabboHotel\GameEnvironment;
use Emulator\HabboHotel\GameClients\GameClient;
use Emulator\Messages\ClientMessage;
use Emulator\Emulator;

class SSOTicketMessageEvent {

    public function __construct(GameClient $client, ClientMessage $packet, GameEnvironment $environment) {
        $sso = $packet->readString();

        if ($client->getHabbo() == null) {
            $habbo = $environment->getHabboManager()->loadHabbo($sso, $client);

            if ($habbo != null) {
                $client->setHabbo($habbo);
                $client->getHabbo()->connect();

                $environment->getHabboManager()->addHabbo($habbo);

                $messages = array();
            }
        }
    }

}
