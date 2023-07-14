<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GreetingStatusEnum;


class GreetingCompany extends Model
{
    use HasFactory;
    protected $fillable = ['message_company', 'name_company', 'celebrant_id', 'status'];

    protected $casts = [
        'status' => GreetingStatusEnum::class
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(
            function ($model) {
                $model->publish_at = self::GreetingDate($model->celebrant_id);
            }
        );
    }
    /**
     * Generate date for publishing greeting company
     * @param int $celebrant_id
     * @return mixed
     */
    public static function GreetingDate(int $celebrant_id)
    {
        $birthday            = Celebrant::where('id', $celebrant_id)->value('birthday');
        $birthdayCurrentYear = Carbon::create($birthday)->year(now()->format('Y'))->format('Y-m-d');
        if (Carbon::create($birthdayCurrentYear)->gt(Carbon::now())) {
            return $birthdayCurrentYear;
        } else {

            return Carbon::create($birthdayCurrentYear)->addYear(1)->format('Y-m-d');
        }
    }
}