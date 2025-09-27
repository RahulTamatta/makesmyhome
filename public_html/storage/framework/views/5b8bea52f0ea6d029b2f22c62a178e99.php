<?php $__env->startSection('title',translate('zone_setup')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/select.dataTables.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin-module/css/zone-module.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-wrap mb-3">
                        <h2 class="page-title"><?php echo e(translate('zone_setup')); ?></h2>
                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone_add')): ?>
                        <div class="card zone-setup-instructions mb-30">
                            <div class="card-body p-30">
                                <form id="zone-form" action="<?php echo e(route('admin.zone.store')); ?>"
                                      enctype="multipart/form-data"
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="row justify-content-between">
                                        <div class="col-lg-5 col-xl-4 mb-5 mb-lg-0">
                                            <h4 class="mb-3 c1"><?php echo e(translate('instructions')); ?></h4>
                                            <div class="d-flex flex-column">
                                                <p><?php echo e(translate('create_zone_by_click_on_map_and_connect_the_dots_together')); ?></p>

                                                <div class="media mb-2 gap-3 align-items-center">
                                                    <img
                                                        src="<?php echo e(asset('public/assets/admin-module/img/icons/map-drag.png')); ?>"
                                                        alt="<?php echo e(translate('image')); ?>">
                                                    <div class="media-body ">
                                                        <p><?php echo e(translate('use_this_to_drag_map_to_find_proper_area')); ?></p>
                                                    </div>
                                                </div>

                                                <div class="media gap-3 align-items-center">
                                                    <img
                                                        src="<?php echo e(asset('public/assets/admin-module/img/icons/map-draw.png')); ?>"
                                                        alt="<?php echo e(translate('image')); ?>">
                                                    <div class="media-body ">
                                                        <p><?php echo e(translate('click_this_icon_to_start_pin_points_in_the_map_and_connect_them_to_draw_a_
                                                        zone_._Minimum_3_points_required')); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="map-img mt-4">
                                                    <img class="dark-support"
                                                         src="<?php echo e(asset('public/assets/admin-module/img/instructions.gif')); ?>"
                                                         alt="<?php echo e(translate('image')); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <?php ($language= Modules\BusinessSettingsModule\Entities\BusinessSettings::where('key_name','system_language')->first()); ?>
                                            <?php ($default_lang = str_replace('_', '-', app()->getLocale())); ?>
                                            <?php if($language): ?>
                                                <ul class="nav nav--tabs border-color-primary mb-4">
                                                    <li class="nav-item">
                                                        <a class="nav-link lang_link active"
                                                           href="#"
                                                           id="default-link"><?php echo e(translate('default')); ?></a>
                                                    </li>
                                                    <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link lang_link"
                                                               href="#"
                                                               id="<?php echo e($lang['code']); ?>-link"><?php echo e(get_language_name($lang['code'])); ?></a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                            <?php if($language): ?>
                                                <div class="form-floating form-floating__icon mb-30 lang-form"
                                                     id="default-form">
                                                    <input type="text" name="name[]" class="form-control"
                                                           placeholder="<?php echo e(translate('zone_name')); ?>" required>
                                                    <label><?php echo e(translate('zone_name')); ?> (<?php echo e(translate('default')); ?>

                                                        )</label>
                                                    <span class="material-icons">note_alt</span>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                                <?php $__currentLoopData = $language?->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div
                                                        class="form-floating form-floating__icon mb-30 d-none lang-form"
                                                        id="<?php echo e($lang['code']); ?>-form">
                                                        <input type="text" name="name[]" class="form-control"
                                                               placeholder="<?php echo e(translate('zone_name')); ?>">
                                                        <label><?php echo e(translate('zone_name')); ?>

                                                            (<?php echo e(strtoupper($lang['code'])); ?>)</label>
                                                        <span class="material-icons">note_alt</span>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="<?php echo e($lang['code']); ?>">
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="lang-form">
                                                    <div class="mb-30">
                                                        <div class="form-floating form-floating__icon">
                                                            <input type="text" class="form-control" name="name[]"
                                                                   placeholder="<?php echo e(translate('zone_name')); ?> *"
                                                                   required value="<?php echo e(old('name')); ?>">
                                                            <label><?php echo e(translate('zone_name')); ?> *</label>
                                                            <span class="material-icons">note_alt</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            <?php endif; ?>

                                            <div class="form-group mb-3 coordinates">
                                                <label class="input-label"
                                                       for="exampleFormControlInput1"><?php echo e(translate('coordinates')); ?>

                                                    <span
                                                        class="input-label-secondary"><?php echo e(translate('draw_your_zone_on_the_map')); ?></span>
                                                </label>
                                                <textarea type="text" rows="8" name="coordinates" id="coordinates"
                                                          class="form-control" readonly></textarea>
                                            </div>

                                            <div class="map-warper dark-support rounded overflow-hidden">
                                                <input id="pac-input" class="controls rounded search_area"
                                                       title="<?php echo e(translate('search_your_location_here')); ?>" type="text"
                                                       placeholder="<?php echo e(translate('search_here')); ?>"/>
                                                <div class="map_canvas" id="map-canvas"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-20 mt-30">
                                                <button class="btn btn--secondary" type="reset"
                                                        id="reset_btn"><?php echo e(translate('reset')); ?></button>
                                                <button class="btn btn--primary"
                                                        type="submit"><?php echo e(translate('submit')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-end border-bottom mx-lg-4 mb-10">
                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75"><?php echo e(translate('Total_Zones')); ?>:</span>
                            <span class="title-color"><?php echo e($zones->total()); ?></span>
                        </div>
                    </div>

                    <div class="card mb-30">
                        <div class="card-body">
                            <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                <form action="<?php echo e(url()->current()); ?>" class="search-form search-form_style-two"  method="GET">
                                    <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                        <input type="search" class="theme-input-style search-form__input zone-search-input"
                                               value="<?php echo e($search); ?>" name="search"
                                               placeholder="<?php echo e(translate('search_here')); ?>">
                                    </div>
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('search')); ?></button>
                                </form>

                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone_export')): ?>
                                        <div class="dropdown">
                                            <button type="button"
                                                    class="btn btn--secondary text-capitalize dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                <span
                                                    class="material-icons">file_download</span> <?php echo e(translate('download')); ?>

                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                <li><a class="dropdown-item"
                                                       href="<?php echo e(route('admin.zone.download')); ?>?search=<?php echo e($search); ?>"><?php echo e(translate('excel')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div id="ListTableContainer">
                                <?php echo $__env->make('zonemanagement::admin.partials._table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="offset" value="<?php echo e(request()->page); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin-module/plugins/dataTables/dataTables.select.min.js')); ?>"></script>

    <?php ($api_key=(business_config('google_map', 'third_party'))->live_values); ?>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($api_key['map_api_key_client']); ?>&libraries=drawing,places&v=3.45.8"></script>

    <script>
        "use strict";

        var map;
        var drawingManager;
        var lastpolygon = null;
        var polygons = [];

        auto_grow();

        function auto_grow() {
            let element = document.getElementById("coordinates");
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }

        function resetMap(controlDiv) {
            const controlUI = document.createElement("div");
            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border = "2px solid #fff";
            controlUI.style.borderRadius = "3px";
            controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor = "pointer";
            controlUI.style.marginTop = "8px";
            controlUI.style.marginBottom = "22px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Reset map";
            controlDiv.appendChild(controlUI);
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "10px";
            controlText.style.lineHeight = "16px";
            controlText.style.paddingLeft = "2px";
            controlText.style.paddingRight = "2px";
            controlText.innerHTML = "X";
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => {
                lastpolygon.setMap(null);
                $('#coordinates').val('');
            });
        }

        <?php ($location = session('location')); ?>

        function initialize() {
            var myLatlng = {
                lat: '<?php echo e($location['lat']); ?>',
                lng: '<?php echo e($location['lng']); ?>'
            };

            var myOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            }
            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });
            drawingManager.setMap(map);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        map.setCenter(pos);
                    });
            }

            google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
                if (lastpolygon) {
                    lastpolygon.setMap(null);
                }
                $('#coordinates').val(event.overlay.getPath().getArray());
                lastpolygon = event.overlay;
                auto_grow();
            });

            const resetDiv = document.createElement("div");
            resetMap(resetDiv, lastpolygon);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);

            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    const icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };
                    // Create a marker for each place.
                    markers.push(
                        new google.maps.Marker({
                            map,
                            icon,
                            title: place.name,
                            position: place.geometry.location,
                        })
                    );

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        $('#reset_btn').click(function () {
            $('#name').val(null);

            lastpolygon.setMap(null);
            $('#coordinates').val(null);
        })

        function performValidation(event) {
            if (!lastpolygon) {
                event.preventDefault();
                toastr.warning('<?php echo e(translate('Please draw your zone on the map')); ?>', {
                    CloseButton: true,
                    ProgressBar: true,
                });
            }
        }

        $('#zone-form').submit(function (event) {
            performValidation(event);
        });

        $('#pac-input').keydown(function (event) {
            if (event.keyCode === 13) {
                performValidation(event);
            }
        });

        $(".lang_link").on('click', function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang-form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            $("#" + lang + "-form").removeClass('d-none');
        });

        let selectedItem;
        let selectedRoute;
        let initialState;

        $('.nav-link').on('click', function () {
            const urlParams = new URLSearchParams($(this).attr('href').split('?')[1]);
        });

        $(document).on('change', '.status-update', function (e) {
            // Prevent default toggle behavior to avoid checkbox jumping
            e.preventDefault();
            e.stopImmediatePropagation();

            selectedItem = $(this);
            initialState = selectedItem.prop('checked'); // Get current state (true if ON)

            // Immediately revert the checkbox visually until confirmation
            selectedItem.prop('checked', !initialState);

            let itemId = selectedItem.data('id');
            selectedRoute = '<?php echo e(route('admin.zone.status-update', ['id' => ':itemId'])); ?>'.replace(':itemId', itemId);

            let confirmationTitleText = initialState
                ? '<?php echo e(translate('Are you sure to Turn On the Zone Status')); ?>?'
                : '<?php echo e(translate('Are you sure to Turn Off the Zone Status')); ?>?';

            $('.confirmation-title-text').text(confirmationTitleText);

            let confirmationDescriptionText = initialState
                ? '<?php echo e(translate('Once you turn on the Zone Status, the user can find the category, services, and location in that zone')); ?>.'
                : '<?php echo e(translate('Once you turn off the Zone Status it will impact the category, services, and location finding for customers')); ?>.';

            $('.confirmation-description-text').text(confirmationDescriptionText);

            let imgSrc = initialState
                ? "<?php echo e(asset('public/assets/admin-module/img/icons/status-on.png')); ?>"
                : "<?php echo e(asset('public/assets/admin-module/img/icons/status-off.png')); ?>";

            $('#confirmChangeModal img').attr('src', imgSrc);

            showModal();
        });

        $('#confirmChange').on('click', function () {
            updateStatus(selectedRoute);
        });

        $('.cancel-change').on('click', function () {
            resetCheckboxState();
            hideModal();
        });

        $('#confirmChangeModal').on('hidden.bs.modal', function () {
            resetCheckboxState();
        });

        function showModal() {
            $('#confirmChangeModal').modal('show');
        }

        function hideModal() {
            $('#confirmChangeModal').modal('hide');
        }

        //  Reverts checkbox if user cancels
        function resetCheckboxState() {
            if (selectedItem) {
                selectedItem.prop('checked', !initialState);
            }
        }

        //  AJAX update - triggers only if user confirms
        function updateStatus(route) {
            let page = $('#offset').val();
            $.ajax({
                url: route,
                type: 'POST',
                data: {_token: '<?php echo e(csrf_token()); ?>'},
                dataType: 'json',
                success: function (data) {
                    toastr.success(data.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });

                    // Update UI manually or reload table as needed
                    reloadTable(page); // Optional - if backend changes are needed
                    hideModal();
                },
                error: function () {
                    resetCheckboxState();
                    toastr.error('Something went wrong! Please try again.');
                }
            });
        }

        function reloadTable(page) {
            let search = $('.zone-search-input').val();
            $.ajax({
                url: "<?php echo e(route('admin.zone.table')); ?>",
                type: "GET",
                data: {
                    search: search,
                    page: page
                },
                success: function (response) {
                    if (response.page != page) {
                        updateBrowserUrl(search, response.page);
                        $('#offset').val((response.page - 1) * <?php echo e(pagination_limit()); ?>);
                    } else {
                        $('#offset').val(response.offset);
                        updateBrowserUrl(search, page);
                    }

                    $('#totalListCount').html(response.totalCount)
                    $('#ListTableContainer').empty().html(response.view);
                },
                error: function () {
                    toastr.error('Failed to update table. Please reload the page.', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        }

        function updateBrowserUrl(search, page) {
            const params = new URLSearchParams();
            if (search) params.set('search', search);
            if (page > 1) params.set('page', page);

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, '', newUrl);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminmodule::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/housecraft/public_html/Modules/ZoneManagement/Resources/views/admin/create.blade.php ENDPATH**/ ?>