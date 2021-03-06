<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class PetsLayout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("pets");
        $message->appendInt32(3);
        $message->appendString($this->getHeaderImage());
        $message->appendString($this->getTeaserImage());
        $message->appendInt32(4);
        $message->appendString($this->getTextOne());
        $message->appendString($this->getTextTwo());
        $message->appendString($this->getTextDetails());
        $message->appendString($this->getTextTeaser());
    }

}
