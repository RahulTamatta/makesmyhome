<div class="modal fade" id="customerAddressModal--<?php echo e($booking['id']); ?>" tabindex="-1" aria-labelledby="customerAddressModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form class="flex-grow-1" id="customerAddressModalSubmit">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="font-weight-bold"><?php echo e(translate('Change Service Location')); ?></h4>

                    <div class="row mt-4">
                        <div class="col-md-6 col-12">
                            <div class="col-md-12 col-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="contact_person_name"
                                               placeholder="<?php echo e(translate('contact_person_name')); ?> *"
                                               value="<?php echo e($booking->service_address?->contact_person_name); ?>" required>
                                        <label><?php echo e(translate('contact_person_name')); ?> *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control company_phone phone-input-with-country-picker7 iti__tel-input"
                                               name="contact_person_number"
                                               id="contact_person_number"
                                               placeholder="<?php echo e(translate('contact_person_number')); ?> *"
                                               value="<?php echo e($booking->service_address?->contact_person_number); ?>" required>
                                        <div class="">
                                            <input type="text" class="country-picker-phone-number7 w-50" value="<?php echo e(old('contact_person_number')); ?>" id="number_with_country_code" name="contact_person_number_with_code" hidden="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div id="location_map_div" class="location_map_class">
                                    <input id="address_pac-input" class="form-control w-auto"
                                           data-toggle="tooltip"
                                           data-placement="right"
                                           data-original-title="<?php echo e(translate('search_your_location_here')); ?>"
                                           type="text" placeholder="<?php echo e(translate('search_here')); ?>"/>
                                    <div id="address_location_map_canvas"
                                         class="overflow-hidden rounded canvas_class">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 row">
                            <div class="col-md-12 col-12">
                                <div class="mb-30">
                                    <select class="js-select theme-input-style w-100" name="address_label">
                                        <option selected disabled><?php echo e(translate('Select_address_label')); ?>*</option>
                                        <option value="home" <?php echo e($booking->service_address?->address_label == 'home' ? 'selected' : ''); ?>><?php echo e(translate('Home')); ?></option>
                                        <option value="office" <?php echo e($booking->service_address?->address_label == 'office' ? 'selected' : ''); ?>><?php echo e(translate('Office')); ?></option>
                                        <option value="others" <?php echo e($booking->service_address?->address_label == 'others' ? 'selected' : ''); ?>><?php echo e(translate('others')); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="address" id="address_address"
                                               placeholder="<?php echo e(translate('address')); ?> *"
                                               value="<?php echo e($booking->service_address?->address); ?>" required>
                                        <label><?php echo e(translate('address')); ?> *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="latitude" id="address_latitude"
                                               placeholder="<?php echo e(translate('lat')); ?> *"
                                               value="<?php echo e($booking->service_address?->lat); ?>" required readonly
                                               data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="<?php echo e(translate('Select from map')); ?>">
                                        <label><?php echo e(translate('lat')); ?> *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="longitude" id="address_longitude"
                                               placeholder="<?php echo e(translate('long')); ?> *"
                                               value="<?php echo e($booking->service_address?->lon); ?>" required readonly
                                               data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="<?php echo e(translate('Select from map')); ?>">
                                        <label><?php echo e(translate('long')); ?> *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="city"
                                               placeholder="<?php echo e(translate('city')); ?>"
                                               value="<?php echo e($booking->service_address?->city); ?>">
                                        <label><?php echo e(translate('city')); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="street"
                                               placeholder="<?php echo e(translate('street')); ?>"
                                               value="<?php echo e($booking->service_address?->street); ?>">
                                        <label><?php echo e(translate('street')); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="zip_code"
                                               placeholder="<?php echo e(translate('zip_code')); ?>"
                                               value="<?php echo e($booking->service_address?->zip_code); ?>">
                                        <label><?php echo e(translate('zip_code')); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-30">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="country"
                                               placeholder="<?php echo e(translate('country')); ?>"
                                               value="<?php echo e($booking->service_address?->country); ?>">
                                        <label><?php echo e(translate('country')); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-3 border-0 pt-0 pb-4 m-4">
                    <button type="button" class="btn btn--secondary" data-bs-dismiss="modal" aria-label="Close">
                        <?php echo e(translate('Cancel')); ?></button>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('Update')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php /**PATH /home/housecraft/public_html/Modules/BookingModule/Resources/views/admin/booking/partials/details/_update-customer-address-modal.blade.php ENDPATH**/ ?>