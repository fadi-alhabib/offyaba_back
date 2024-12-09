<?php

namespace App\Models;

use App\Services\EncryptionServices;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Crypt;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expiration_date',
        'period',
        'number_of_usage'
    ];
    protected $appends = ['is_valid'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: function () {
                $arr = array(
                    'id' => $this['id'],
                    'token' => config('app.qr_code.usage')
                );
                return EncryptionServices::encrypt($arr);
            }
        );
    }

    protected function isValid(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ((now()->subDay()->greaterThan($this['expiration_date'])) || ($this['number_of_usage'] == 0)) {
                    return false;
                }
                return true;
            }
        );
    }
}
