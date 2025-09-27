<?php
$booking = \Modules\BookingModule\Entities\Booking::get();
$max_booking_amount = (business_config('max_booking_amount', 'booking_setup'))->live_values ?? 0;
$pending_booking_count = \Modules\BookingModule\Entities\Booking::where('booking_status', 'pending')
    ->when($max_booking_amount > 0, function ($query) use ($max_booking_amount) {
        $query->where(function ($query) use ($max_booking_amount) {
            $query->where('payment_method', 'cash_after_service')
                ->where(function ($query) use ($max_booking_amount) {
                    $query->where('is_verified', 1)
                        ->orWhere('total_booking_amount', '<=', $max_booking_amount);
                })
                ->orWhere('payment_method', '<>', 'cash_after_service');
        });
    })
    ->count();

$offline_booking_count = \Modules\BookingModule\Entities\Booking::whereIn('booking_status', ['pending', 'accepted'])
    ->where('payment_method', 'offline_payment')->where('is_paid', 0)->count();

$accepted_booking_count = \Modules\BookingModule\Entities\Booking::where('booking_status', 'accepted')
    ->when($max_booking_amount > 0, function ($query) use ($max_booking_amount) {
        $query->where(function ($query) use ($max_booking_amount) {
            $query->where('payment_method', 'cash_after_service')
                ->where(function ($query) use ($max_booking_amount) {
                    $query->where('is_verified', 1)
                        ->orWhere('total_booking_amount', '<=', $max_booking_amount);
                })
                ->orWhere('payment_method', '<>', 'cash_after_service');
        });
    })
    ->count();
$pending_providers = \Modules\ProviderManagement\Entities\Provider::ofApproval(2)->count();
$denied_providers = \Modules\ProviderManagement\Entities\Provider::ofApproval(0)->count();
$logo = getBusinessSettingsImageFullPath(key: 'business_logo', settingType: 'business_information', path: 'business/', defaultPath: 'public/assets/placeholder');
?>
<style>a{color:white}</style>
<aside class="aside" style="background-color:black; color:white">
    <div class="aside-header">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo d-flex gap-2">
            <img class="main-logo onerror-image" src="<?php echo e($logo); ?>" alt="<?php echo e(translate('image')); ?>">
        </a>

        <button class="toggle-menu-button aside-toggle border-0 bg-transparent p-0 white-color">
            <span class="material-icons">menu</span>
        </button>
    </div>


    <div class="aside-body" data-trigger="scrollbar">
        <div class="user-profile media gap-3 align-items-center my-3">
            <div class="avatar">
                <img class="avatar-img rounded-circle aspect-square object-fit-cover" src="<?php echo e(auth()->user()->profile_image_full_path); ?>" alt="<?php echo e(translate('profile_image')); ?>">
            </div>
            <div class="media-body ">
                <h5 class="card-title"><?php echo e(\Illuminate\Support\Str::limit(auth()->user()->email,15)); ?></h5>
                <span class="card-text"><?php echo e(auth()->user()->user_type); ?></span>
            </div>
        </div>

        <ul class="nav">
            <li class="nav-category"><?php echo e(translate('main')); ?></li>

            <li>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->is('admin/dashboard')?'active-menu':''); ?>">
                    <span class="material-icons" title="<?php echo e(translate('dashboard')); ?>">dashboard</span>
                    <span class="link-title"><?php echo e(translate('dashboard')); ?></span>
                </a>
            </li>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['booking_view'])): ?>
                <li class="nav-category" title="<?php echo e(translate('booking_management')); ?>">
                    <?php echo e(translate('booking_management')); ?>

                </li>
                <li class="has-sub-item <?php echo e(request()->is('admin/booking/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/booking/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="Bookings">calendar_month</span>
                        <span class="link-title"><?php echo e(translate('bookings')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <li>
                            <a href="<?php echo e(route('admin.booking.post.list', ['type'=>'all'])); ?>"
                               class="<?php echo e(request()->is('admin/booking/post') || request()->is('admin/booking/post/details*') ? 'active-menu' : ''); ?>">
                                <span class="link-title"><?php echo e(translate('Customized_Requests')); ?>

                                    <span
                                        class="count"><?php echo e(\Modules\BidModule\Entities\Post::where('is_booked', 0)->count()??0); ?></span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.booking.list.verification', ['booking_status'=>'pending', 'type' => 'pending'])); ?>"
                               class="<?php echo e(request()->is('admin/booking/list/verification') && request()->query('booking_status')=='pending' ?'active-menu':''); ?>"><span
                                    class="link-title"><?php echo e(translate('verify_requests')); ?> <span
                                        class="count"><?php echo e(\Modules\BookingModule\Entities\Booking::where('is_verified', '0')->where('payment_method', 'cash_after_service')->Where('total_booking_amount', '>', $max_booking_amount)->whereIn('booking_status', ['pending', 'accepted'])->count()); ?></span></span></a>
                        </li>
                        <li><a href="<?php echo e(route('admin.booking.list', ['booking_status'=>'pending','service_type'=>'all'])); ?>"
                               class="<?php echo e(request()->is('admin/booking/list') && request()->query('booking_status')=='pending'?'active-menu':''); ?>"><span
                                    class="link-title"><?php echo e(translate('Booking_Requests')); ?> <span
                                        class="count"><?php echo e($pending_booking_count); ?></span></span></a>
                        </li>

                        <li><a href="<?php echo e(route('admin.booking.offline.payment')); ?>"
                               class="<?php echo e(request()->is('admin/booking/list/offline-payment') && request()->query('booking_status')=='pending'?'active-menu':''); ?>"><span
                                    class="link-title"><?php echo e(translate('Offline Payment List')); ?> <span
                                        class="count"><?php echo e($offline_booking_count); ?></span></span></a>
                        </li>

                        <li><a href="<?php echo e(route('admin.booking.list', ['booking_status'=>'accepted','service_type'=>'all'])); ?>"
                               class="<?php echo e(request()->is('admin/booking/list') && request()->query('booking_status')=='accepted'?'active-menu':''); ?>"><span
                                    class="link-title"><?php echo e(translate('Accepted')); ?> <span
                                        class="count"><?php echo e($accepted_booking_count); ?></span></span></a>
                        </li>
                        <li><a href="<?php echo e(route('admin.booking.list', ['booking_status'=>'ongoing','service_type'=>'all'])); ?>"
                               class="<?php echo e(request()->is('admin/booking/list') && request()->query('booking_status')=='ongoing'?'active-menu':''); ?>"><span
                                    class="link-title"><?php echo e(translate('Ongoing')); ?> <span
                                        class="count"><?php echo e($booking->where('booking_status', 'ongoing')->count()); ?></span></span></a>
                        </li>
                        <li><a href="<?php echo e(route('admin.booking.list', ['booking_status'=>'completed','service_type'=>'all'])); ?>"
                               class="<?php echo e(request()->is('admin/booking/list') && request()->query('booking_status')=='completed'?'active-menu':''); ?>"><span
                                    class="link-title"><?php echo e(translate('Completed')); ?> <span
                                        class="count"><?php echo e($booking->where('booking_status', 'completed')->count()); ?></span></span></a>
                        </li>
                        <li><a href="<?php echo e(route('admin.booking.list', ['booking_status'=>'canceled','service_type'=>'all'])); ?>"
                               class="<?php echo e(request()->is('admin/booking/list') && request()->query('booking_status')=='canceled'?'active-menu':''); ?>"><span
                                    class="link-title"><?php echo e(translate('Canceled')); ?> <span
                                        class="count"><?php echo e($booking->where('booking_status', 'canceled')->count()); ?></span></span></a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['discount_view', 'discount_add', 'coupon_view', 'coupon_add', 'bonus_view', 'bonus_add', 'campaign_view', 'campaign_add','advertisement_view', 'advertisement_add', 'banner_add', 'push_notification_view','push_notification_add' ])): ?>
                <li class="nav-category" title="<?php echo e(translate('promotion_management')); ?>">
                    <?php echo e(translate('promotion_management')); ?>

                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['discount_view', 'discount_add'])): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/discount/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/discount/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('discounts')); ?>">redeem</span>
                        <span class="link-title"><?php echo e(translate('discounts')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <li>
                            <a href="<?php echo e(route('admin.discount.list')); ?>"
                               class="<?php echo e(request()->is('admin/discount/list')?'active-menu':''); ?>">
                                <?php echo e(translate('discount_list')); ?>

                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('discount_add')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.discount.create')); ?>"
                                   class="<?php echo e(request()->is('admin/discount/create')?'active-menu':''); ?>">
                                    <?php echo e(translate('add_new_discount')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['coupon_view', 'coupon_add'])): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/coupon/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/coupon/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('coupons')); ?>">sell</span>
                        <span class="link-title"><?php echo e(translate('coupons')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.coupon.list')); ?>"
                                   class="<?php echo e(request()->is('admin/coupon/list')?'active-menu':''); ?>">
                                    <?php echo e(translate('coupon_list')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon_add')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.coupon.create')); ?>"
                                   class="<?php echo e(request()->is('admin/coupon/create')?'active-menu':''); ?>">
                                    <?php echo e(translate('add_new_coupon')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['bonus_view', 'bonus_add'])): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/bonus/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/bonus/*')?'active-menu':''); ?>">
                    <span class="material-icons matarial-symbols-outlined"
                          title="<?php echo e(translate('bonus')); ?>">price_change</span>
                        <span class="link-title"><?php echo e(translate('Wallet Bonus')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.bonus.list')); ?>"
                                   class="<?php echo e(request()->is('admin/bonus/list')?'active-menu':''); ?>">
                                    <?php echo e(translate('bonus_list')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_add')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.bonus.create')); ?>"
                                   class="<?php echo e(request()->is('admin/bonus/create')?'active-menu':''); ?>">
                                    <?php echo e(translate('add_new_bonus')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['campaign_view', 'campaign_add'])): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/campaign/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/campaign/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('campaigns')); ?>">campaign</span>
                        <span class="link-title"><?php echo e(translate('campaigns')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campaign_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.campaign.list')); ?>"
                                   class="<?php echo e(request()->is('admin/campaign/list')?'active-menu':''); ?>">
                                    <?php echo e(translate('campaign_list')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campaign_add')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.campaign.create')); ?>"
                                   class="<?php echo e(request()->is('admin/campaign/create')?'active-menu':''); ?>">
                                    <?php echo e(translate('add_new_campaign')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['advertisement_view', 'advertisement_add'])): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/advertisements/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/advertisements/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('advertisements')); ?>">campaign</span>
                        <span class="link-title"><?php echo e(translate('advertisements')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.advertisements.ads-list', ['status' => 'all'])); ?>"
                                   class="<?php echo e(request()->is('admin/advertisements/ads-list')?'active-menu':''); ?>">
                                    <?php echo e(translate('Ads List')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('advertisement_add')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.advertisements.new-ads-request', ['status' => 'new'])); ?>"
                                   class="<?php echo e(request()->is('admin/advertisements/new-ads-request')?'active-menu':''); ?>">
                                    <?php echo e(translate('New Ads Request')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('banner_add')): ?>
                <li>
                    <a href="<?php echo e(route('admin.banner.create')); ?>"
                       class="<?php echo e(request()->is('admin/banner/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('promotional_banners')); ?>">flag</span>
                        <span class="link-title"><?php echo e(translate('promotional_banners')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('push_notification_add')): ?>
                <li>
                    <a href="<?php echo e(route('admin.push-notification.create')); ?>"
                       class="<?php echo e(request()->is('admin/push-notification/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('push_notification')); ?>">notifications</span>
                        <span class="link-title"><?php echo e(translate('Send Notifications')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['provider_view', 'provider_add', 'provider_approve_or_deny','withdraw_view', 'withdraw_add'])): ?>
                <li class="nav-category"
                    title="<?php echo e(translate('provider_management')); ?>">
                    <?php echo e(translate('provider_management')); ?>

                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['provider_view', 'provider_approve_or_deny'])): ?>
                <li>
                    <a href="<?php echo e(route('admin.provider.onboarding_request', ['status'=>'onboarding'])); ?>"
                       class="<?php echo e(request()->is('admin/provider/onboarding*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('Onboarding_Request')); ?>">description</span>
                        <span class="link-title"><?php echo e(translate('Onboarding_Request')); ?> <span
                                class="count"><?php echo e($pending_providers + $denied_providers); ?></span></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['provider_view', 'provider_add'])): ?>
                <li class="has-sub-item  <?php echo e((request()->is('admin/provider/list') || request()->is('admin/provider/create') || request()->is('admin/provider/details*') || request()->is('admin/provider/edit*') || request()->is('admin/provider/collect-cash*'))?'sub-menu-opened':''); ?>">
                    <a href="#"
                       class="<?php echo e((request()->is('admin/provider/list') || request()->is('admin/provider/create') || request()->is('admin/provider/details*') || request()->is('admin/provider/edit*') || request()->is('admin/provider/collect-cash*'))?'active-menu':''); ?>">
                        <span class="material-icons" title="Providers">engineering</span>
                        <span class="link-title"><?php echo e(translate('providers')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('provider_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.provider.list', ['status'=>'all'])); ?>"
                                   class="<?php echo e((request()->is('admin/provider/list'))?'active-menu':''); ?>"><?php echo e(translate('Provider_List')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('provider_add')): ?>
                            <li><a href="<?php echo e(route('admin.provider.create')); ?>"
                                   class="<?php echo e((request()->is('admin/provider/create'))?'active-menu':''); ?>"><?php echo e(translate('Add_New_Provider')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['withdraw_view', 'withdraw_add'])): ?>
                <li class="has-sub-item  <?php echo e(request()->is('admin/withdraw/method*')||request()->is('admin/withdraw/method/create')||request()->is('admin/withdraw/method/edit*') || request()->is('admin/withdraw/request*') ?'sub-menu-opened':''); ?>">
                    <a href="#"
                       class="<?php echo e(request()->is('admin/withdraw/method*')||request()->is('admin/withdraw/method/create')||request()->is('admin/withdraw/method/edit*') || request()->is('admin/withdraw/request*') ?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('withdraw_methods')); ?>">payments</span>
                        <span class="link-title"><?php echo e(translate('Withdraws')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.withdraw.request.list', ['status'=>'all'])); ?>"
                                   class="<?php echo e(request()->is('admin/withdraw/request*')?'active-menu':''); ?>">
                                    <?php echo e(translate('Withdraw Requests')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('withdraw_add')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.withdraw.method.list')); ?>"
                                   class="<?php echo e(request()->is('admin/withdraw/method*')||request()->is('admin/withdraw/method/create')||request()->is('admin/withdraw/method/edit*')?'active-menu':''); ?>">
                                    <?php echo e(translate('Withdraw method setup')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['service_view','service_add','zone_add','category_add'])): ?>
                <li class="nav-category" title="<?php echo e(translate('service_management')); ?>">
                    <?php echo e(translate('service_management')); ?>

                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone_add')): ?>
                <li>
                    <a href="<?php echo e(route('admin.zone.create')); ?>"
                       class="<?php echo e(request()->is('admin/zone/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('service_zones')); ?>">map</span>
                        <span class="link-title"><?php echo e(translate('Service Zones Setup')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_add')): ?>
                <li class="has-sub-item <?php echo e((request()->is('admin/category/*') || request()->is('admin/sub-category/*'))?'sub-menu-opened':''); ?>">
                    <a href="#"
                       class="<?php echo e((request()->is('admin/category/*') || request()->is('admin/sub-category/*'))?'active-menu':''); ?>">
                        <span class="material-icons" title="Service Categories">category</span>
                        <span class="link-title"><?php echo e(translate('Categories')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <li>
                            <a href="<?php echo e(route('admin.category.create')); ?>"
                               class="<?php echo e(request()->is('admin/category/*')?'active-menu':''); ?>">
                                <?php echo e(translate('Category Setup')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.sub-category.create')); ?>"
                               class="<?php echo e(request()->is('admin/sub-category/*')?'active-menu':''); ?>">
                                <?php echo e(translate('Sub Category Setup')); ?>

                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <li>
                                <a href="<?php echo e(route('admin.subscriptionmodule.list')); ?>"
                                   class="<?php echo e(request()->is('admin/service/create')?'active-menu':''); ?>">
                                    Subscription Package
                                </a>
                            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['service_view','service_add'])): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/service/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/service/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="Services">design_services</span>
                        <span class="link-title"><?php echo e(translate('services')); ?></span>
                    </a>
                    <ul class="nav flex-column sub-menu">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.service.index')); ?>"
                                   class="<?php echo e(request()->is('admin/service/list')?'active-menu':''); ?>">
                                    <?php echo e(translate('service_list')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_add')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.service.create')); ?>"
                                   class="<?php echo e(request()->is('admin/service/create')?'active-menu':''); ?>">
                                    <?php echo e(translate('add_new_service')); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('service_view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.service.request.list')); ?>"
                                   class="<?php echo e(request()->is('admin/service/request/list*')?'active-menu':''); ?>">
                                    <span class="link-title"><?php echo e(translate('New Service Requests')); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['wallet_add','wallet_view','customer_view','customer_add','point_view'])): ?>
                <li class="nav-category" title="<?php echo e(translate('customer_management')); ?>">
                    <?php echo e(translate('customer_management')); ?>

                </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['customer_view','customer_add'])): ?>
                    <li class="has-sub-item <?php echo e(request()->is('admin/customer/list')||request()->is('admin/customer/create') ?'sub-menu-opened':''); ?>">
                        <a href="#"
                           class="<?php echo e(request()->is('admin/customer/list') || request()->is('admin/customer/detail*') || request()->is('admin/customer/edit/*') ||request()->is('admin/customer/create')?'active-menu':''); ?>">
                            <span class="material-icons" title="Customers">person_outline</span>
                            <span class="link-title"><?php echo e(translate('customers')); ?></span>
                        </a>
                        <ul class="nav sub-menu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_view')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.customer.index')); ?>"
                                       class="<?php echo e(request()->is('admin/customer/list')?'active-menu':''); ?>">
                                        <?php echo e(translate('customer_list')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customer_add')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.customer.create')); ?>"
                                       class="<?php echo e(request()->is('admin/customer/create')?'active-menu':''); ?>">
                                        <?php echo e(translate('add_new_customer')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['wallet_add','wallet_view'])): ?>
                    <li class="has-sub-item <?php echo e(request()->is('admin/customer/wallet*')?'sub-menu-opened':''); ?>">
                        <a href="#" class="<?php echo e(request()->is('admin/customer/wallet*')?'active-menu':''); ?>">
                            <span class="material-icons" title="Customers">wallet</span>
                            <span class="link-title"><?php echo e(translate('customer_wallet')); ?></span>
                        </a>
                        <ul class="nav sub-menu">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('wallet_add')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.customer.wallet.add-fund')); ?>"
                                       class="<?php echo e(request()->is('admin/customer/wallet/add-fund')?'active-menu':''); ?>">
                                        <?php echo e(translate('Add Fund to Wallet')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('wallet_view')): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.customer.wallet.report')); ?>"
                                       class="<?php echo e(request()->is('admin/customer/wallet/report')?'active-menu':''); ?>">
                                        <?php echo e(translate('Wallet Transactions')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('point_view')): ?>
                    <li class="has-sub-item <?php echo e(request()->is('admin/customer/loyalty-point*')?'sub-menu-opened':''); ?>">
                        <a href="#" class="<?php echo e(request()->is('admin/customer/loyalty-point*')?'active-menu':''); ?>">
                            <span class="material-icons" title="Customers">paid</span>
                            <span class="link-title"><?php echo e(translate('loyalty_point')); ?></span>
                        </a>
                        <ul class="nav sub-menu">
                            <li>
                                <a href="<?php echo e(route('admin.customer.loyalty-point.report')); ?>"
                                   class="<?php echo e(request()->is('admin/customer/loyalty-point/report')?'active-menu':''); ?>">
                                    <?php echo e(translate('Loyalty Points Transactions')); ?>

                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('point_view')): ?>
                    <li>
                        <a href="<?php echo e(route('admin.customer.newsletter.index')); ?>"
                           class="<?php echo e(request()->is('admin/customer/newsletter/*')?'active-menu':''); ?>">
                            <span class="material-icons" title="<?php echo e(translate('subscribed_newsletter')); ?>">email</span>
                            <span class="link-title"><?php echo e(translate('Subscribed Newsletter')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['role_view', 'role_add', 'employee_add', 'employee_view'])): ?>
                <li class="nav-category"
                    title="<?php echo e(translate('employee_management')); ?>"><?php echo e(translate('employee_management')); ?></li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['role_view', 'role_add'])): ?>
                <li>
                    <a href="<?php echo e(route('admin.role.index')); ?>" class="<?php echo e(request()->is('admin/role/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="Employee">settings</span>
                        <span class="link-title"><?php echo e(translate('Employee Role Setup')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_view')): ?>
                <li>
                    <a href="<?php echo e(route('admin.employee.index')); ?>"
                       class="<?php echo e(request()->is('admin/employee/list') ||  request()->is('admin/employee/edit/*') ? 'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('employee_list')); ?>">list</span>
                        <span class="link-title"><?php echo e(translate('employee_list')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('employee_add')): ?>
                <li>
                    <a href="<?php echo e(route('admin.employee.create')); ?>"
                       class="<?php echo e(request()->is('admin/employee/create')?'active-menu':''); ?>">
                        <span class="material-icons" title="<?php echo e(translate('add_new_employee')); ?>">add</span>
                        <span class="link-title"><?php echo e(translate('add_new_employee')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('transaction_view')): ?>
                <li class="nav-category" title="<?php echo e(translate('transaction_management')); ?>">
                    <?php echo e(translate('transaction_management')); ?>

                </li>
                <li>
                    <a href="<?php echo e(route('admin.transaction.list', ['trx_type'=>'all'])); ?>"
                       class="<?php echo e(request()->is('admin/transaction/list')?'active-menu':''); ?>">
                        <span class="material-icons" title="Customers">article</span>
                        <span class="link-title"><?php echo e(translate('All Transactions')); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['report_view','analytics_view'])): ?>
                <li class="nav-category" title="<?php echo e(translate('report_management')); ?>">
                    <?php echo e(translate('Reports & Analytics')); ?>

                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report_view')): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/report/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/report/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="Customers">event_note</span>
                        <span class="link-title"><?php echo e(translate('Reports')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <li>
                            <a href="<?php echo e(route('admin.report.transaction', ['transaction_type'=>'all'])); ?>"
                               class="<?php echo e(request()->is('admin/report/transaction')?'active-menu':''); ?>">
                                <?php echo e(translate('Transaction Reports')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.report.business.overview')); ?>"
                               class="<?php echo e(request()->is('admin/report/business*')?'active-menu':''); ?>">
                                <?php echo e(translate('Business Reports')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.report.booking')); ?>"
                               class="<?php echo e(request()->is('admin/report/booking')?'active-menu':''); ?>">
                                <?php echo e(translate('Booking Reports')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.report.provider')); ?>"
                               class="<?php echo e(request()->is('admin/report/provider')?'active-menu':''); ?>">
                                <?php echo e(translate('Provider Reports')); ?>

                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analytics_view')): ?>
                <li class="has-sub-item <?php echo e(request()->is('admin/analytics/*')?'sub-menu-opened':''); ?>">
                    <a href="#" class="<?php echo e(request()->is('admin/analytics/*')?'active-menu':''); ?>">
                        <span class="material-icons" title="Customers">analytics</span>
                        <span class="link-title"><?php echo e(translate('Analytics')); ?></span>
                    </a>
                    <ul class="nav sub-menu">
                        <li>
                            <a href="<?php echo e(route('admin.analytics.search.keyword')); ?>"
                               class="<?php echo e(request()->is('admin/analytics/search/keyword')?'active-menu':''); ?>">
                                <?php echo e(translate('Keyword_Search')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.analytics.search.customer')); ?>"
                               class="<?php echo e(request()->is('admin/analytics/search/customer')?'active-menu':''); ?>">
                                <?php echo e(translate('Customer_Search')); ?>

                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['addon_view', 'addon_add'])): ?>
                <li class="nav-category" title="<?php echo e(translate('system_addon')); ?>">
                    <?php echo e(translate('system_addon')); ?>

                </li>
                <li>
                    <a class="<?php echo e(Request::is('admin/addon')?'active-menu':''); ?>"
                       href="<?php echo e(route('admin.addon.index')); ?>" title="<?php echo e(translate('system_addons')); ?>">
                        <span class="material-icons" title="add_circle_outline">add_circle_outline</span>
                        <span class="link-title"><?php echo e(translate('system_addons')); ?></span>
                        </span>
                    </a>
                </li>

                <?php if(count(config('addon_admin_routes'))>0): ?>
                    <li class="has-sub-item <?php echo e(request()->is('admin/payment/configuration/*') || request()->is('admin/sms/configuration/*')?'sub-menu-opened':''); ?>">
                        <a href="#"
                           class="<?php echo e(request()->is('admin/payment/configuration/*') || request()->is('admin/sms/configuration/*')?'active-menu':''); ?>">
                            <span class="material-symbols-outlined">list</span>
                            <span class="link-title"><?php echo e(translate('addon_menus')); ?></span>
                        </a>
                        <ul class="nav flex-column sub-menu">
                            <?php $__currentLoopData = config('addon_admin_routes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a class="<?php echo e(Request::is($route['path']) ?'active-menu':''); ?>"
                                           href="<?php echo e($route['url']); ?>" title="<?php echo e(translate($route['name'])); ?>">
                                            <?php echo e(translate($route['name'])); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['business_view', 'landing_view','configuration_view','page_view', 'gallery_view', 'backup_view', 'subscription_settings_view', 'subscriber_view', 'subscription_package_view'])): ?>
                <li class="nav-category"
                    title="<?php echo e(translate('system_management')); ?>"><?php echo e(translate('System Control Panel')); ?></li>
            <?php endif; ?>
            <li class="has-sub-item <?php echo e(request()->is('admin/business-settings/*') || request()->is('admin/language/translate/*')?'sub-menu-opened':''); ?>">
                <a href="#"
                   class="<?php echo e(request()->is('admin/business-settings/*') || request()->is('admin/language/translate/*')?'active-menu':''); ?>">
                    <span class="material-icons" title="Business Settings">business_center</span>
                    <span class="link-title"><?php echo e(translate('Preferences Hub')); ?></span>
                </a>
                <ul class="nav sub-menu">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('business_view')): ?>
                        <li>
                            <a href="<?php echo e(route('admin.business-settings.get-business-information')); ?>"
                               class="<?php echo e(request()->is('admin/business-settings/get-business-information')?'active-menu':''); ?>">
                                <?php echo e(translate('business')); ?>

                            </a>
                        </li>
                        <!--<li>-->
                        <!--    <a href="<?php echo e(route('admin.business-settings.login.setup')); ?>"-->
                        <!--       class="<?php echo e(request()->is('admin/business-settings/login/setup') ?'active-menu':''); ?>">-->
                        <!--        <?php echo e(translate('Login Setup')); ?>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <!--<li>-->
                        <!--    <a href="<?php echo e(route('admin.business-settings.notification-channel', ['notification_type' => 'user'])); ?>"-->
                        <!--       class="<?php echo e(request()->is('admin/business-settings/notification-channel') ?'active-menu':''); ?>">-->
                        <!--        <?php echo e(translate('Notification Channel')); ?>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <!--<li>-->
                        <!--    <a href="<?php echo e(route('admin.business-settings.seo.setting', ['page_type' => 'error_logs'])); ?>"-->
                        <!--       class="<?php echo e(request()->is('admin/business-settings/seo-setting') ?'active-menu':''); ?>">-->
                        <!--        <?php echo e(translate('404 Logs')); ?>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <!--<li>-->
                        <!--    <a href="<?php echo e(route('admin.business-settings.cron-job.list')); ?>"-->
                        <!--       class="<?php echo e(request()->is('admin/business-settings/cron-job') ?'active-menu':''); ?>">-->
                        <!--        <?php echo e(translate('Cron Job')); ?>-->
                        <!--    </a>-->
                        <!--</li>-->
                    <?php endif; ?>
                </ul>
            </li>
            <!--<li class="has-sub-item <?php echo e(request()->is('admin/subscription/*') || request()->is('admin/language/translate/*')?'sub-menu-opened':''); ?>">-->
            <!--    <a href="#"-->
            <!--       class="<?php echo e(request()->is('admin/subscription/*') || request()->is('admin/language/translate/*')?'active-menu':''); ?>">-->
            <!--        <span class="material-icons" title="<?php echo e(translate('Subscription Management')); ?>">campaign</span>-->
            <!--        <span class="link-title"><?php echo e(translate('Subscription Management')); ?></span>-->
            <!--    </a>-->
            <!--    <ul class="nav sub-menu">-->
            <!--        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subscription_package_view')): ?>-->
            <!--            <li>-->
            <!--                <a href="<?php echo e(route('admin.subscription.package.list')); ?>"-->
            <!--                   class="<?php echo e(request()->is('admin/subscription/package/*')?'active-menu':''); ?>">-->
            <!--                    <?php echo e(translate('Subscription Package')); ?>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--        <?php endif; ?>-->
            <!--        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subscriber_view')): ?>-->
            <!--        <li>-->
            <!--            <a href="<?php echo e(route('admin.subscription.subscriber.list')); ?>"-->
            <!--               class="<?php echo e(request()->is('admin/subscription/subscriber/*') ?'active-menu':''); ?>">-->
            <!--                <?php echo e(translate('Subscriber List')); ?>-->
            <!--            </a>-->
            <!--        </li>-->
            <!--        <?php endif; ?>-->
            <!--        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subscription_settings_view')): ?>-->
            <!--        <li>-->
            <!--            <a href="<?php echo e(route('admin.subscription.settings')); ?>"-->
            <!--               class="<?php echo e(request()->is('admin/subscription/settings') ?'active-menu':''); ?>">-->
            <!--                <?php echo e(translate('Settings')); ?>-->
            <!--            </a>-->
            <!--        </li>-->
            <!--        <?php endif; ?>-->
            <!--    </ul>-->
            <!--</li>-->
            <!--<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('landing_view')): ?>-->
            <!--    <li>-->
            <!--        <a href="<?php echo e(route('admin.business-settings.get-landing-information', ['web_page' => 'text_setup'])); ?>"-->
            <!--           class="<?php echo e(request()->is('admin/business-settings/get-landing-information')?'active-menu':''); ?>">-->
            <!--            <span class="material-icons" title="Business Settings">rocket_launch</span>-->
            <!--            <span class="link-title"><?php echo e(translate('landing_page_settings')); ?></span>-->
            <!--        </a>-->
            <!--    </li>-->
            <!--<?php endif; ?>-->
            <!--<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('configuration_view')): ?>-->
            <!--    <li class="has-sub-item <?php echo e(request()->is('admin/configuration/*') || request()->is('admin/language/translate/*')?'sub-menu-opened':''); ?>">-->
            <!--        <a href="#"-->
            <!--           class="<?php echo e(request()->is('admin/configuration/*') || request()->is('admin/language/translate/*')?'active-menu':''); ?>">-->
            <!--            <span class="material-icons" title="Configurations">settings</span>-->
            <!--            <span class="link-title"><?php echo e(translate('configurations')); ?></span>-->
            <!--        </a>-->
            <!--        <ul class="nav sub-menu">-->
            <!--            <li>-->
            <!--                <a href="<?php echo e(route('admin.configuration.get-notification-setting', ['type' => 'customers'])); ?>"-->
            <!--                   class="<?php echo e(request()->is('admin/configuration/get-notification-setting')?'active-menu':''); ?>">-->
            <!--                    <?php echo e(translate('Push Notifications')); ?>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
            <!--                <a href="<?php echo e(route('admin.configuration.get-third-party-config', ['web_page' => 'google_map'])); ?>"-->
            <!--                   class="<?php echo e(request()->is('admin/configuration/get-third-party-config') || request()->is('admin/configuration/offline-payment/*') ?'active-menu':''); ?>">-->
            <!--                    <?php echo e(translate('3rd_party')); ?>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
            <!--                <a href="<?php echo e(route('admin.configuration.language_setup')); ?>"-->
            <!--                   class="<?php echo e(request()->is('admin/configuration/language-setup') || request()->is('admin/language/translate/*') ?'active-menu':''); ?>">-->
            <!--                    <?php echo e(translate('Language Setup')); ?>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--        </ul>-->
            <!--    </li>-->
            <!--<?php endif; ?>-->
            <!--<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('page_view')): ?>-->
            <!--    <li>-->
            <!--        <a href="<?php echo e(route('admin.business-settings.get-pages-setup')); ?>"-->
            <!--           class="<?php echo e(request()->is('admin/business-settings/get-pages-setup')?'active-menu':''); ?>">-->
            <!--            <span class="material-icons" title="Page Settings">article</span>-->
            <!--            <span class="link-title"><?php echo e(translate('page_settings')); ?></span>-->
            <!--        </a>-->
            <!--    </li>-->
            <!--<?php endif; ?>-->
            <!--<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gallery_view')): ?>-->
            <!--    <li>-->
            <!--        <a href="<?php echo e(route('admin.business-settings.get-gallery-setup')); ?>"-->
            <!--           class="<?php echo e(request()->is('admin/business-settings/get-gallery-setup*')?'active-menu':''); ?>">-->
            <!--            <span class="material-icons" title="Page Settings">collections_bookmark</span>-->
            <!--            <span class="link-title"><?php echo e(translate('Gallery')); ?></span>-->
            <!--        </a>-->
            <!--    </li>-->
            <!--<?php endif; ?>-->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('backup_view')): ?>
                <li>
                    <a href="<?php echo e(route('admin.business-settings.get-database-backup')); ?>"
                       class="<?php echo e(request()->is('admin/business-settings/get-database-backup')?'active-menu':''); ?>">
                        <span class="material-icons" title="Page Settings">backup</span>
                        <span class="link-title"><?php echo e(translate('Backup_Database')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
<?php /**PATH /home/housecraft/public_html/Modules/AdminModule/Resources/views/layouts/partials/_aside.blade.php ENDPATH**/ ?>