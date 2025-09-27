<?php $__env->startSection('title', bs_data($settings, 'business_name', 1)); ?>

<?php $__env->startSection('content'); ?>
    <section class="banner-section">
        <div class="container">
            <div class="banner-wrapper justify-content-between">
                <div class="banner-content wow animate__fadeInUp">
                    <h6 class="subtitle text--btn"><?php echo e(bs_data_text($settingss, 'top_title', 1)); ?></h6>
                    <h1 class="title"><?php echo e(bs_data_text($settingss, 'top_description', 1)); ?></h1>
                    <p class="txt text--title">
                        <?php echo e(bs_data_text($settingss, 'top_sub_title', 1)); ?>

                    </p>
                    <div class="app-btns d-flex flex-wrap">
                        <?php if($settings->where('key_name', 'app_url_appstore')->first()->is_active ?? 0): ?>
                            <a href="<?php echo e(bs_data($settings, 'app_url_appstore', 1)); ?>">
                                <img src="<?php echo e(asset('public/assets/landing/img/app-btn/app-store.png')); ?>"
                                    alt="<?php echo e(translate('app store')); ?>">
                            </a>
                        <?php endif; ?>

                        <?php if($settings->where('key_name', 'app_url_playstore')->first()->is_active ?? 0): ?>
                            <a href="<?php echo e(bs_data($settings, 'app_url_playstore', 1)); ?>">
                                <img src="<?php echo e(asset('public/assets/landing')); ?>/img/app-btn/google-play.png"
                                    alt="<?php echo e(translate('play store')); ?>">
                            </a>
                        <?php endif; ?>

                        <?php if($settings->where('key_name', 'web_url')->first()->is_active ?? 0): ?>
                            <a href="<?php echo e(bs_data($settings, 'web_url', 1)); ?>">
                                <img src="<?php echo e(asset('public/assets/landing')); ?>/img/app-btn/brows_button.png"
                                    alt="<?php echo e(translate('app')); ?>">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="banner-thumb">
                    <div class="banner-thumb-wrapper">
                        <img class="wow animate__dropIn" src="<?php echo e($topImageData['top_image_1']); ?>"
                            alt="<?php echo e(translate('banner')); ?>">
                    </div>
                    <div class="banner-thumb-wrapper">
                        <img class="wow animate__dropIn" src="<?php echo e($topImageData['top_image_2']); ?>"
                            alt="<?php echo e(translate('banner')); ?>">
                    </div>
                    <div class="banner-thumb-wrapper">
                        <img class="wow animate__dropIn" src="<?php echo e($topImageData['top_image_3']); ?>"
                            alt="<?php echo e(translate('banner')); ?>">
                    </div>
                    <div class="banner-thumb-wrapper">
                        <img class="wow animate__dropIn" src="<?php echo e($topImageData['top_image_4']); ?>"
                            alt="<?php echo e(translate('banner')); ?>">
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="service-section py-25">
        <div class="scroll-elem" id="service"></div>
        <div class="container position-relative">
            <h3 class="section-title"><?php echo e(bs_data_text($settingss, 'mid_title', 1)); ?></h3>
            <div class="service-slide-nav">
                <span class="service-slide-prev slide-icon">
                    <i class="las la-arrow-left"></i>
                </span>
                <span class="service-slide-next slide-icon">
                    <i class="las la-arrow-right"></i>
                </span>
            </div>
            <div class="slider-wrapper">
                <div class="service-slider owl-theme owl-carousel">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="javascript:void(0)" class="service__item" data-target="slide-<?php echo e($category->id); ?>">
                            <div class="service__item-icon">
                                <img src="<?php echo e($category->image_full_path); ?>" alt="<?php echo e(translate('category')); ?>">
                            </div>
                            <div class="service__item-content">
                                <h6 class="title"><?php echo e($category['name']); ?></h6>
                                <p class="txt">
                                    <?php echo e(translate('this_category_is_available_in')); ?> ( <?php echo e($category->zones_count); ?>

                                    ) <?php echo e(translate('zones')); ?>. <?php echo e(translate('and_available_subcategories')); ?>

                                    (<?php echo e($category->children->count()); ?>)
                                </p>
                                <span class="service__item-btn"><?php echo e(translate('Read More')); ?></span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="service__item-popup" data-slide="slide-<?php echo e($category->id); ?>">
                        <div class="service__item-popup-inner">
                            <button type="button" class="close__popup">
                                <i class="las la-times"></i>
                            </button>
                            <div class="left-content">
                                <div class="service__item-icon">
                                    <img src="<?php echo e($category->image_full_path); ?>" alt="<?php echo e(translate('category')); ?>">
                                </div>
                                <div class="service__item-content">
                                    <h6 class="title"><?php echo e($category['name']); ?></h6>
                                    <p class="txt">
                                        <?php echo e(translate('this_category_is_available_in')); ?> ( <?php echo e($category->zones_count); ?>

                                        ) <?php echo e(translate('zones')); ?>. <?php echo e(translate('and_available_subcategories')); ?>

                                        ( <?php echo e($category->children->count()); ?> )
                                    </p>
                                </div>
                            </div>
                            <div class="right-content ms-sm-5">
                                <div class="mb-4">
                                    <span class="top-text"><?php echo e(translate('Thousands of companies use on demand service platform  as their go-to place for all kinds of cleaning and maintenance services. Our verified service providers are always ready for your next call whenever you have a business need. A dedicated Key Account Manager and a 24 X 7 customer support team make us your first choice for many companies.')); ?></span>
                                </div>
                                <div class="service-inner-slider owl-theme owl-carousel">
                                    <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="service-inner-slider-item">
                                            <img src="<?php echo e($child->image_full_path); ?>" alt="<?php echo e(translate('child image')); ?>">
                                            <span><?php echo e($child['name']); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>


        </div>
    </section>
    <section class="about-section py-25">
        <div class="scroll-elem" id="about"></div>
        <div class="container">
            <div class="about__wrapper">
                <div class="about__wrapper-content  wow animate__fadeInUp">
                    <h3 class="section-title text-start ms-0"><?php echo e(bs_data_text($settingss, 'about_us_title', 1)); ?></h3>
                    <p>
                        <?php echo e(bs_data_text($settingss, 'about_us_description', 1)); ?>

                    </p>
                    <a href="<?php echo e(route('page.about-us')); ?>" class="cmn--btn2">
                        <?php echo e(translate('Read More')); ?> <i class="las la-long-arrow-alt-right"></i>
                    </a>
                </div>
                <div class="about__wrapper-thumb">
                    <?php ($aboutUsImage = getBusinessSettingsImageFullPath(key: 'about_us_image', settingType: 'landing_images', path: 'landing-page/', defaultPath: 'public/assets/placeholder.png')); ?>
                    <img class="main-img" src="<?php echo e($aboutUsImage); ?>" alt="<?php echo e(translate('image')); ?>">
                    <div class="bg-img">
                        <img src="<?php echo e(asset('public/assets/landing')); ?>/img/about-us.png" alt="<?php echo e(translate('image')); ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-info-section py-25 wow animate__fadeInUp">
        <div class="container">
            <div class="row g-2 g-sm-3 g-md-4 justify-content-center">
                <?php $__currentLoopData = $specialities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="counter__item h-100">
                            <div class="counter__item-left">
                                <img src="<?php echo e($item['image_full_path']); ?>" alt="<?php echo e(translate('counter')); ?>">
                            </div>
                            <div class="counter__item-right">
                                <h3 class="subtitle mb-2">
                                    <span class="ms-1"><?php echo e($item['title']); ?></span>
                                </h3>
                                <div><?php echo e($item['description']); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <section class="app-slider-section pt-25 pb-50">
        <div class="container">
            <div class="app-slider-wrapper">
                <div class="app-content">
                    <div class="app-slider owl-theme owl-carousel">
                        <?php $__currentLoopData = $features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <h3 class="subtitle"><?php echo e($item['title']); ?></h3>
                                <p><?php echo e($item['sub_title']); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="slider-bottom mt-4 mt-lg-5 d-flex justify-content-center">
                        <div class="owl-btn app-owl-prev">
                            <i class="las la-long-arrow-alt-left"></i>
                        </div>
                        <div class="app-counter mx-3"></div>
                        <div class="owl-btn app-owl-next">
                            <i class="las la-long-arrow-alt-right"></i>
                        </div>
                    </div>
                </div>
                <div class="app-thumb">
                    <div class="main-thumb">
                        <img class="main-img" src="<?php echo e(asset('public/assets/landing/img/app/iphone-frame.png')); ?>"
                            alt="<?php echo e(translate('app')); ?>">
                        <div class="app-slider owl-theme owl-carousel">
                            <?php $__currentLoopData = $features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e($item['image_1_full_path']); ?>" alt="<?php echo e(translate('app')); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="smaller-thumb">
                        <img class="main-img" src="<?php echo e(asset('public/assets/landing')); ?>/img/app/iphone-frame.png"
                            alt="<?php echo e(translate('app')); ?>">
                        <div class="app-slider owl-theme owl-carousel">
                            <?php $__currentLoopData = $features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e($item['image_2_full_path']); ?>" alt="<?php echo e(translate('app')); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cta-section py-25">
        <div class="container">
            <div class="cta-main">
                <?php ($providerSectionImage = getBusinessSettingsImageFullPath(key: 'provider_section_image', settingType: 'landing_images', path: 'landing-page/', defaultPath: 'public/assets/placeholder.png')); ?>

                <div class="cta-wrapper bg__img" data-img="<?php echo e(asset('public/assets/landing')); ?>/img/cta-bg.png">
                    <img width="238" src="<?php echo e($providerSectionImage); ?>" alt="<?php echo e(translate('image')); ?>"
                        class="left-icon">
                    <div class="content text-center">
                        <h2 class="title text-uppercase"><?php echo e(bs_data_text($settingss, 'registration_title', 1)); ?></h2>
                        <p class="text-btn-title">
                            <?php echo e(bs_data_text($settingss, 'registration_description', 1)); ?>

                        </p>
                    </div>
                    <?php if(bs_data_text($settingss, 'registration_description', 1) ?? 0): ?>
                        <div class="text-center">
                            <a href="<?php echo e(route('provider.auth.sign-up')); ?>"
                                class="cmn--btn"><?php echo e(translate('register_here')); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonial-section pt-25 pb-50">
        <div class="container-fluid">
            <h3 class="section-title mb-5"> <?php echo e(bs_data_text($settingss, 'bottom_title', 1)); ?></h3>
            
            <div class="testimonial-slider swiper">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $testimonials ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="testimonial__item swiper-slide">
                            <div class="testimonial__item-wrapper">
                                <div class="testimonial__item-img">
                                    <img src="<?php echo e($item['image_full_path']); ?>" alt="<?php echo e(translate('image')); ?>">
                                </div>
                                <div class="testimonial__item-cont">
                                    <span class="fw-bold fs-5"><?php echo e($item['name']); ?></span><br>
                                    <span class="text--secondary"><?php echo e($item['designation']); ?> </span>
                                    <blockquote>
                                        <?php echo e($item['review']); ?>

                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="slider-bottom d-flex justify-content-center">
                    <div class="owl-btn testimonial-owl-prev">
                        <i class="las la-long-arrow-alt-left"></i>
                    </div>
                    <div class="slider-counter mx-3"></div>
                    <div class="owl-btn testimonial-owl-next">
                        <i class="las la-long-arrow-alt-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/resources/views/welcome.blade.php ENDPATH**/ ?>