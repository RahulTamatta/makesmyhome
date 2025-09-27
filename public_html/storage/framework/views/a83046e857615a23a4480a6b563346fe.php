<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo e(translate('New joining')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">

        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }

        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        .list-inline {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .list-inline li {
            display: inline-block;
        }

        .bg-white {
            background-color: #fff !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        p, h3, h5 {
            margin-top: 0;
            margin-bottom: 16px;
        }

        .btn {
            font-size: 14px;
            font-weight: 600;
            text-transform: capitalize;
            line-height: 1;
            padding: 0.75rem 1.625rem;
            outline: none;
            white-space: nowrap;
            border: none;
            background-color: #1455AC;
            color: #fff;
        }

        .btn--primary {
            background-color: #4153b3;
            color: #fff !important;
        }

        .btn--secondary {
            background-color: transparent;
            color: #000 !important;
            border: 1px solid #0c63e4;
        }

        hr {
            margin-block-start: 2rem;
            margin-block-end: 2rem;
        }

        .top-wrap-box > *:not(:last-child) {
            margin-top: 10px;
        }

        .list-gap {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .list-gap-2 > *,
        .list-gap > * {
            display: inline-block;
        }

        .list-gap > *:not(:last-child) {
            margin-right: 10px;
        }

        .list-gap-2 > *:not(:last-child) {
            margin-right: 20px;
        }

        .text-center {
            text-align: center !important;
        }
        .box{
            background-color: #fff;
            width: 500px;
            margin-left: auto;
            margin-right: auto;
            padding: 45px 40px 44.579px 40px;

        }
        .table-wrap{
            border: 1px solid #E6E6E6;
            padding: 16px;
            border-radius: 5px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
<div class="box">
    <div class="top-wrap-box">
        <?php ($logo = getBusinessSettingsImageFullPath(key: 'business_logo', settingType: 'business_information', path: 'business/', defaultPath: 'public/assets/placeholder.png')); ?>
        <img src="<?php echo e($logo); ?>" alt="<?php echo e(translate('Logo')); ?>" width="140"/>

        <h3 style="margin-top: 20px"><?php echo e(translate('New Joining Request')); ?> !</h3>
        <h5><?php echo e(translate('Hi')); ?> <?php echo e(translate('admin')); ?>,</h5>
        <p><?php echo e(translate('A new joining request has been submitted by')); ?> <?php echo e($provider->company_name); ?> <?php echo e(translate('to')); ?>

            <?php echo e(business_config( 'business_name', 'business_information')->live_values); ?>. <?php echo e(translate('Here are the key details:')); ?></p><br>
        <div class="table-wrap">
            <table>
                <tbody>
                <tr>
                    <td><?php echo e(translate('Provider Name: ')); ?></td>
                    <td><?php echo e($provider->company_name); ?><</td>
                </tr>
                <tr>
                    <td><?php echo e(translate('Email & Phone: ')); ?></td>
                    <td><?php echo e($provider->company_email); ?>, <?php echo e($provider->company_phone); ?></td>
                </tr>
                <tr>
                    <td><?php echo e(translate('Business Name: ')); ?></td>
                    <td><?php echo e($provider->company_name); ?></td>
                </tr>
                <tr>
                    <td><?php echo e(translate('Address: ')); ?></td>
                    <td><?php echo e($provider->company_address); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex gap-20 mt-30">
            <a href="<?php echo e(route('admin.provider.onboarding_details',[$provider->id])); ?>" class="btn btn--primary"><?php echo e(translate('View Details')); ?></a>
            <a href="<?php echo e(route('admin.provider.onboarding_request', ['status'=>'onboarding'])); ?>" class="btn btn--secondary" type="submit"><?php echo e(translate('View All Request')); ?></a>
        </div>
        <hr style="margin-top: 16px; margin-bottom: 16px">
        <p><?php echo e(translate('Please contact us for any queries, we’re always happy to help')); ?>. </p>
        <div><?php echo e(translate('Thanks & Regards')); ?>,</div>
        <div style="margin-top: 4px;"><?php echo e((business_config('business_name', 'business_information'))->live_values); ?></div>
    </div>

    <div class="text-center">
        <ul class="list-inline list-gap-2">
            <li><a href="<?php echo e(route('page.privacy-policy')); ?>"><?php echo e(translate('Privacy Policy')); ?></a></li>
            <li><a href="<?php echo e(route('page.contact-us')); ?>"><?php echo e(translate('Contact Us')); ?></a></li>
        </ul>

        <div class="list-gap">
            <?php ($dataValues = business_config('social_media', 'landing_social_media')); ?>
            <?php $__currentLoopData = $dataValues->live_values??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($item['link']); ?>">
                    <img width="20"
                         src="<?php echo e(asset('public/assets/admin-module/img/icons/' . $item['media'] . '.png')); ?>"
                         alt="<?php echo e(translate('image')); ?>">
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <p class="text-center"><?php echo e(translate('Copyright')); ?>

            <?php echo e(date('Y')); ?> <?php echo e((business_config('business_name', 'business_information'))->live_values); ?>

            . <?php echo e(translate('All right reserved')); ?></p>
    </div>
</div>
</body>
</html>
<?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/mail-templates/new-joining.blade.php ENDPATH**/ ?>