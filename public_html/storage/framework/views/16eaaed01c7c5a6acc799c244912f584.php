<footer class="footer mt-auto">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center justify-content-md-start mb-2 mb-md-0">
                <?php echo e((business_config('footer_text','business_information'))->live_values??""); ?> <span class="currentYear ml-3"></span>
            </div>
            <div class="col-md-6 d-flex justify-content-center justify-content-md-end">
                <ul class="list-inline list-separator">
                    <li>
                        <a href="<?php echo e(route('provider.profile_update')); ?>"><?php echo e(translate('Profile')); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('provider.dashboard')); ?>">
                            <span class="material-icons">home</span>
                        </a>
                    </li>
                    <li>
                        <span class="badge badge-success opacity-75"><?php echo e(translate('Software_version')); ?> : <?php echo e(env('SOFTWARE_VERSION')); ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH /home/housecraft/public_html/Modules/ProviderManagement/Resources/views/layouts/partials/_footer.blade.php ENDPATH**/ ?>