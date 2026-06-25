<?php
namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    public function index(){
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, $id){
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $notification->update(['is_read' => true]);
        if($request->expectsJson() || $request->ajax()){
            return response()->json(['success' => true]);
        }
        return redirect($notification->link ?? route('notifications.index'));
    }

    public function destroy($id){
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail()
            ->delete();
        return back()->with('success', 'Notification deleted.');
    }
}
