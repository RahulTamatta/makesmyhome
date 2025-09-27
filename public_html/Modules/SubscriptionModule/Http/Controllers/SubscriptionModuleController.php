<?php

namespace Modules\SubscriptionModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ServiceManagement\Entities\Service;
use Modules\SubscriptionModule\Entities\SubscriptionService;
use Modules\SubscriptionModule\Entities\BuySubscription;
use Modules\SubscriptionModule\Entities\Pin;
use Modules\SubscriptionModule\Entities\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubscriptionModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('subscriptionmodule::index');
    }
    public function list()
    {
        $subscriptions = \Modules\SubscriptionModule\Entities\Subscription::all();
        return view('subscriptionmodule::list', compact('subscriptions'));
    }
      public function subscriberlist()
    {
        $subscriptions = \Modules\SubscriptionModule\Entities\BuySubscription::all();
        return view('subscriptionmodule::listofsuscriber', compact('subscriptions'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    { $services=Service::all();
        return view('subscriptionmodule::create',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
  public function store(Request $request)
{
    // Validate input
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'status' => 'required|in:active,inactive',
        'duration' => 'required|numeric',
        'services' => 'required|array|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = null;
$imageurl=null;
   
      // Handle new image upload
    if ($request->hasFile('image')) {
        // Store in storage/app/public/subscriptions
        $imagePath = $request->file('image')->store('subscriptions', 'public');

      

        // Save public URL (accessible via storage symlink)
        $imageurl = 'https://housecraft.online/storage/app/public/' . $imagePath;
    }

    // Create subscription
    $subscription = Subscription::create([
        'name' => $data['name'],
        'price' => $data['price'],
        'status' => $data['status'],
        'duration' => $data['duration'],
        'image' => $imageurl, // only filename saved in DB
    ]);

    try {
        foreach ($request->services as $serviceId) {
            SubscriptionService::create([
                'subscription_id' => $subscription->id,
                'service_id' => $serviceId
            ]);
        }
    } catch (\Exception $e) {
        \Log::error('Subscription store error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }

    return redirect()->route('admin.subscriptionmodule.list')
                     ->with('success', 'Subscription created successfully.');
}


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('subscriptionmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    { try{
        
        $plan =Subscription::findOrFail($id);
        $slectedservices=SubscriptionService::where('subscription_id',$plan->id)->get();
       $services=Service::all();
         return view('subscriptionmodule::edit',compact('plan','services','slectedservices'));
    }
        catch (\Exception $e) {
              dd($e);
    return redirect()->back()->with('error', 'Failed to delete subscription: ' . $e->getMessage());
}
       
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
 public function update(Request $request, $id)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'status' => 'required|in:active,inactive',
        'duration'=> 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $subscription = \Modules\SubscriptionModule\Entities\Subscription::findOrFail($id);

    // Handle new image upload
    if ($request->hasFile('image')) {
        // Store in storage/app/public/subscriptions
        $imagePath = $request->file('image')->store('subscriptions', 'public');

        // Delete old image if exists
        if ($subscription->image && \Storage::disk('public')->exists(str_replace('storage/', '', $subscription->image))) {
            \Storage::disk('public')->delete(str_replace('storage/', '', $subscription->image));
        }

        // Save public URL (accessible via storage symlink)
        $data['image'] = 'https://housecraft.online/storage/app/public/' . $imagePath;
    }

    $subscription->update($data);

    return redirect()->route('admin.subscriptionmodule.list')
                     ->with('success', 'Subscription updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete($id)
    {
        $subscription = \Modules\SubscriptionModule\Entities\Subscription::findOrFail($id);
  $subscription->delete();


        return redirect()->route('admin.subscriptionmodule.list')->with('success', 'Subscription deleted successfully.');
    }
    public function apilist(Request $request)
{
    // User ki buy subscriptions list
    $buy = BuySubscription::where("user_id", $request->user_id)
        ->pluck("subscription_id")
        ->toArray();

    // Sab subscriptions with services
    $subscriptions = DB::select("
        SELECT 
            subscriptions.id AS subscription_id,
            subscriptions.*,
            services.id AS service_id,
            services.*
        FROM 
            subscriptions
        JOIN 
            subscription_services ON subscriptions.id = subscription_services.subscription_id
        JOIN 
            services ON services.id = subscription_services.service_id
    ");

    // Add subscribed status
    $subscriptions = collect($subscriptions)->map(function ($sub) use ($buy) {
        $sub->subscribed = in_array($sub->subscription_id, $buy);
        return $sub;
    });

    return response()->json($subscriptions);
}



public function apiGetMySubcription(Request $request)
{
    $user = Auth::guard('api')->user(); 

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $subscriptions = BuySubscription::where('buy_subscriptions.user_id', $user->id)
        ->join('subscriptions', 'buy_subscriptions.subscription_id', '=', 'subscriptions.id')
        ->select(
            'buy_subscriptions.id as buy_id',
            'buy_subscriptions.user_id',
            'buy_subscriptions.subscription_id',
            'buy_subscriptions.amount',
            'buy_subscriptions.purchase_date',
            'buy_subscriptions.status as buy_status',
            'buy_subscriptions.transaction_id',
            'buy_subscriptions.payment_method',
            'buy_subscriptions.total_working',
            'buy_subscriptions.created_at as buy_created_at',
            'buy_subscriptions.updated_at as buy_updated_at',
            'subscriptions.id as subscription_id',
            'subscriptions.name',
            'subscriptions.description',
            'subscriptions.price',
            'subscriptions.image',
            'subscriptions.status as subscription_status',
            'subscriptions.duration',
            'subscriptions.start_date',
            'subscriptions.end_date',
            'subscriptions.created_at as sub_created_at',
            'subscriptions.updated_at as sub_updated_at'
        )
        ->get();

    return response()->json(['my_Subscription' => $subscriptions]);
}


// public function apiGetMySubcription(Request $request){
    
//     $user_id=$request->user()->id;
//     // $subscriptions=BuySubscription::where('user_id',$id)->get();
//     return response()->json($user_id);
// }

    public function apistore(Request $request){
        $data = $request->validate([
           'subscription_id' => 'required|exists:subscriptions,id',
           'amount' => 'required|numeric',
           'transaction_id' => 'nullable|string|max:255',
           'payment_method' => 'nullable|string|max:255',
        ]);
        $data['user_id'] = $request->user_id; // Assuming the user is authenticated
        $data['purchase_date'] = now(); // Set the purchase date to now
        $data['status'] = 'active'; // Default status for new purchases
        $subscription = \Modules\SubscriptionModule\Entities\BuySubscription::create($data);
        return response()->json($subscription, 201);
    }
public function generatepin(Request $request, $id)
{
    // Create a hash and take first 6 chars
  $pin = mt_rand(1000, 9999);


    // Save pin to DB
    Pin::create([
        'pin' => strtoupper($pin),
        'user_id' => $id,
        'subscription_id'=>$request->subscription_id
    ]);

    return response()->json(['pin' => strtoupper($pin)], 201);
    return $id;
}
public function verifypin(Request $request){
 $pin=Pin::where('pin',$request->pin)->where('subscription_id',$request->subscription_id)->first(); 
  $pin->status=1;
  $pin->save();
 if($pin){
        $subscription=BuySubscription::findOrFail($pin->subscription_id);
        $subscription->total_working=$subscription->total_working+1;
        $subscription->save();
    }
     return response()->json(['pin' => strtoupper($pin)], 201);
}

}
