<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class RecyclerInfoLayout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("recycler_info");
        $message->appendInt32(3);
        $message->appendString($this->getHeaderImage());
        $message->appendString($this->getTeaserImage());
        $message->appendString($this->getSpecialImage());
        $message->appendInt32(3);
        $message->appendString($this->getTextOne());
        $message->appendString($this->getTextDetails());
        $message->appendString($this->getTextTeaser());
    }

}
