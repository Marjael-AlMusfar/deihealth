<?php

namespace App\Support;

final class Role
{
    public const ADMIN = 'admin';
    public const PETUGAS_KESEHATAN = 'petugas_kesehatan';
    public const MUSYRIF = 'musyrif';
    public const PENGURUS = 'pengurus';
    public const WALI_SANTRI = 'wali_santri';

    public const ALL = [
        self::ADMIN,
        self::PETUGAS_KESEHATAN,
        self::MUSYRIF,
        self::PENGURUS,
        self::WALI_SANTRI,
    ];
}
