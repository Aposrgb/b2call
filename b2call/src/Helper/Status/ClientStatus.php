<?php

namespace App\Helper\Status;

class ClientStatus extends AbstractStatus
{
    public const ACTIVE = 1;
    public const APPROVED = 10;
    public const BLOCK = 11;
    public const ARCHIVE = 21;

    protected static $statusNames = [
        self::ACTIVE => 'Активен',
        self::APPROVED => 'Не подтвержден',
        self::ARCHIVE => 'В архиве',
        self::BLOCK => 'Заблокирован'
    ];
}