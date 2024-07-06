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

class ContactFieldData extends Model
{
    protected $fillable = [
        'contact_id',
        'field_id',
        'value',
    ];

    protected $table = 'contact_fields_data';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function field()
    {
        return $this->belongsTo(ContactField::class, 'field_id')->with('default_lang_field')->with('file');
    }

    public function file()
    {
        return $this->belongsTo(DriveFile::class, 'value', 'code');
    }
}
