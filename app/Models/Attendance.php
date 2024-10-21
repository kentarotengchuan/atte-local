<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "start_work", "end_work", "start_break", "end_break"];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function breaktimes()
    {
        return $this->hasMany(Breaktime::class);
    }
    public function sumWorkTimes()
    {
        //休憩時間が存在しない場合
        $startwork = new Carbon($this->start_work);
        $endwork = new Carbon($this->end_work);
        $wholetime = $startwork->diffinSeconds($endwork);

        $hours = floor($wholetime / 3600);
        $minutes = floor(($wholetime % 3600) / 60);
        $seconds = $wholetime % 60;
        $expression = sprintf('%02d', $hours) . ":" . sprintf('%02d', $minutes) . ":" . sprintf('%02d', $seconds);
        //休憩時間が存在する場合
        if (Breaktime::where("attendance_id", $this->id)->exists()) {
            $break = $this->sumBreakTimes();
            $wholetime = new Carbon("$expression");
            $breaktime = new Carbon("$break");
            $diff = $breaktime->diffinSeconds($wholetime);

            $hours = floor($diff / 3600);
            $minutes = floor(($diff % 3600) / 60);
            $seconds = $diff % 60;
            $expression = sprintf('%02d', $hours) . ":" . sprintf('%02d', $minutes) . ":" . sprintf('%02d', $seconds);
        }
        return $expression;
    }
    public function sumBreakTimes()
    {
        //休憩時間が存在しない場合
        $expression = "00:00:00";

        //休憩時間が存在する場合
        if (Breaktime::where("attendance_id", $this->id)->exists()) {
            $breaks = Breaktime::selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(time))) as total')
                ->where("attendance_id", "$this->id")
                ->first();
            $expression = $breaks->total;
        }
        return $expression;
    }
}
