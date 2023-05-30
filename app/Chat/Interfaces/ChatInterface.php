<?php

namespace App\Chat\Interfaces;

interface ChatInterface
{
    /**
     * @param int $itemId
     * @return void
     */
    public function join(int $itemId);
}
