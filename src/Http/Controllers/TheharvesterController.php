<?php

namespace Ikay\TheharvesterService\Http\Controllers;

use Ikay\TheharvesterService\Http\Requests\TheharvesterRequest;
use Ikay\TheharvesterService\Models\Theharvester;
use Illuminate\Routing\Controller;

class TheharvesterController extends Controller
{
    public function index()
    {
        auth()->user()?->userActivityLogs()->create([
            'action' => "Kullanıcı Theharvester görev listesi görüntelendi.",
            'ip' => request()?->ip()
        ]);
        $theharvesters = Theharvester::query()->latest()->paginate(10);
        
        return view('theharvester-service::theharvester.index', compact('theharvesters'));
    }
    
    public function create()
    {
        return view('theharvester-service::theharvester.create');
    }
    
    public function store(TheharvesterRequest $request)
    {
        $user = auth()->user();
        $user?->theharvesters()->create($request->validated());
        $user?->userActivityLogs()->create([
            'action' => "Kullanıcı yeni bir Theharvester görevi oluşturdu. Görev Başlığı: $request->title",
            'ip' => request()?->ip()
        ]);
        
        return to_route('tasks.theharvesters.index')->with('success', 'Added with Successful');
    }
    
    public function show(Theharvester $theharvester)
    {
        auth()->user()?->userActivityLogs()->create([
            'action' => "Kullanıcı başlığ : $theharvester->title olan Theharvester görevi görüntelendi.",
            'ip' => request()?->ip()
        ]);
        
        return view('theharvester-service::theharvester.show',compact('theharvester'));
    }
}