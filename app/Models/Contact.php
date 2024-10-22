<?php

/*
 * NuraWeb - Free and Open Source Website Builder
 *
 * Copyright (C) 2024  Chimilevschi Iosif Gabriel, https://nurasoftware.com.
 *
 * LICENSE:
 * NuraWeb is licensed under the GNU General Public License v3.0
 * Permissions of this strong copyleft license are conditioned on making available complete source code 
 * of licensed works and modifications, which include larger works using a licensed work, under the same license. 
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights.
 *    
 * @copyright   Copyright (c) 2024, Chimilevschi Iosif Gabriel, https://nurasoftware.com.
 * @license     https://opensource.org/licenses/GPL-3.0  GPL-3.0 License.
 * @author      Chimilevschi Iosif Gabriel <office@nurasoftware.com>
 * 
 * 
 * IMPORTANT: DO NOT edit this file manually. All changes will be lost after software update.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'source_lang_id',
        'name',
        'email',
        'subject',
        'message',
        'ip',
        'geo_country',
        'geo_country_code',
        'geo_city',
        'created_at',
        'read_at',
        'responded_at',
        'is_important',
        'deleted_at',
    ];

    protected $table = 'contact';

    public $timestamps = false;

    public function lang(): BelongsTo
    {
        return $this->BelongsTo(Language::class, 'source_lang_id');
    }
}
