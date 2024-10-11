<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $attendance = Attendance::where('user_id', Auth::id())->latest()->first();
        $canStartWork = session()->get('can_start_work', true);
        $canEndWork = session()->get('can_end_work', false);
        $canStartBreak = session()->get('can_start_break', false);
        $canEndBreak = session()->get('can_end_break', false);
        return view('stamp', compact('attendance', 'canStartWork', 'canEndWork', 'canStartBreak', 'canEndBreak'));
    }
    public function startWork(Request $request)
    {
        $attendance = Attendance::updateOrCreate([
            'user_id' => Auth::id(),
            'start_work' => now()->toTimeString()
        ]);
        $request->session()->put([
            'can_start_work' => false,
            'can_end_work' => true,
            'can_start_break' => true,
            'can_end_break' => false
        ]);

        return redirect("/");
    }

    public function endWork(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::now()->startOfDay();
        $end_of_yesterday = Carbon::yesterday()->endOfDay();
        $attendance = Attendance::where('user_id', $user->id)
            ->whereNull('end_work')
            ->latest()
            ->first();

        $carbon_of_start_time = new Carbon($attendance->start_work);

        if ($attendance && $carbon_of_start_time->lt($today)) {
            $attendance::update([
                'end_work' => "$end_of_yesterday"
            ]);
            Attendance::create([
                'user_id' => "$user->id",
                'start_work' => "$today",
                'end_work' => now()->toTimeString(),
            ]);
        } else {
            $attendance = Attendance::where('user_id', Auth::id())->latest()->first();
            $attendance->update(['end_work' => now()]);
        }
        $request->session()->put([
            'can_start_work' => true,
            'can_end_work' => false,
            'can_start_break' => false,
            'can_end_break' => false
        ]);

        return redirect("/");
    }

    private $timeOfStartBreak;
    private $timeOfEndBreak;

    public function startBreak(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::now()->startOfDay();
        $end_of_yesterday = Carbon::yesterday()->endOfDay();
        $attendance = Attendance::where('user_id', $user->id)
            ->whereNull('end_work')
            ->latest()
            ->first();

        $carbon_of_start_time = new Carbon($attendance->start_work);

        if ($attendance && $carbon_of_start_time->lt($today)) {
            $attendance::update([
                'end_work' => $end_of_yesterday->toTimeString()
            ]);
            Attendance::create([
                'user_id' => "$user->id",
                'start_work' => $today->toTimeString(),
            ]);
        }

        $request->session()->put([

            'time_of_start_break' => now(),

            'can_start_work' => false,
            'can_end_work' => false,
            'can_start_break' => false,
            'can_end_break' => true,
        ]);
        return redirect("/");
    }

    public function endBreak(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::now()->startOfDay();
        $end_of_yesterday = Carbon::yesterday()->endOfDay();
        $attendance = Attendance::where('user_id', $user->id)
            ->whereNull('end_work')
            ->latest()
            ->first();

        $carbon_of_start_time = new Carbon($attendance->start_work);
        $timeOfStartBreak = session()->get('time_of_start_break');

        if ($attendance && $carbon_of_start_time->lt($today)) {
            Breaktime::create([
                "attendance_id" => $attendance->id,
                "time" => $timeOfStartBreak->diffInSeconds($end_of_yesterday),
            ]);
            $attendance::update([
                'end_work' => $end_of_yesterday->toTimeString()
            ]);
            Attendance::create([
                'user_id' => "$user->id",
                'start_work' => $today->toTimeString(),
            ]);
            $request->session()->put([
                'time_of_start_break' => $today
            ]);
        }
        $attendance = Attendance::where('user_id', Auth::id())->latest()->first();
        $timeOfStartBreak = session()->get('time_of_start_break');
        Breaktime::create([
            "attendance_id" => $attendance->id,
            "time" => $timeOfStartBreak->diffInSeconds(now()),
        ]);
        $request->session()->put([
            'can_start_work' => false,
            'can_end_work' => true,
            'can_start_break' => true,
            'can_end_break' => false
        ]);
        return redirect("/");
    }
    public function date(Request $request)
    {
        if ($request->input("reset") == "yes") {
            $carbon_date = new Carbon(now());
            $string_date = $carbon_date->toDateString();
        } else {
            $carbon_date = new Carbon(now());
            $date = $carbon_date->toDateString();
            $string_date = $request->session()->get('date', $date);
        }
        //dd($date);
        $attendances = Attendance::whereDate('created_at', "$string_date")
            ->paginate(5);
        $date = new Carbon($string_date);
        $date = $date->toDateString();
        return view("date", compact("attendances", "date"));
    }
    public function addDate(Request $request)
    {
        $date = new Carbon("$request->date");
        $added_date = $date->addDays(1);
        $request->session()->put('date', "$added_date");
        return redirect("/date");
    }
    public function subDate(Request $request)
    {
        $date = new Carbon("$request->date");
        $subbed_date = $date->subDays(1);
        $request->session()->put('date', "$subbed_date");
        return redirect("/date");
    }

    public function users()
    {
        $users = User::orderBy('updated_at')->paginate(5);
        return view("users", compact("users"));
    }
    public function detail(Request $request)
    {
        if ($request->input("reset") == "yes") {
            $carbon_date = new Carbon(now());
            $string_date = $carbon_date->toDateString();
            $request->session()->put('date_on_detail', $string_date);
        } else {
            $carbon_date = new Carbon(now());
            $date = $carbon_date->toDateString();
            $string_date = $request->session()->get('date_on_detail', $date);
        }

        $user_id = $request->user_id;
        $attendances = Attendance::where('user_id', "$user_id")
            ->whereDate('created_at', "$string_date")
            ->paginate(5);
        $date = new Carbon($string_date);
        $date = $date->toDateString();
        return view("detail", compact("attendances", "date", "user_id"));
    }
    public function addDateOnDetail(Request $request)
    {
        $date = new Carbon("$request->date");
        $added_date = $date->addDays(1);
        $user_id = $request->user_id;
        $request->session()->put([
            'date_on_detail' => "$added_date"
        ]);

        return redirect(route("detail", compact("user_id")));
    }
    public function subDateOnDetail(Request $request)
    {
        $date = new Carbon("$request->date");
        $subbed_date = $date->subDays(1);
        $user_id = $request->user_id;
        $request->session()->put([
            'date_on_detail' => "$subbed_date"
        ]);
        return redirect(route("detail", compact("user_id")));
    }
}
