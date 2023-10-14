<?php

namespace App\Models;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string id
 * @property string address
 * @property Gender gender
 * @property string avatar
 * @property Carbon birth_date
 * @property string birth_place
 */
class Profile extends Model
{
    use HasFactory, HasUuids, HasUuids;

    protected $fillable = [
        "address", "gender", "avatar", "birth_date", "birth_place"
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "id");
    }
}
