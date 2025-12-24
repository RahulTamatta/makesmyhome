import 'package:makesmyhome/common/widgets/time_picker_snipper.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class CustomTimePicker extends StatelessWidget {
  const CustomTimePicker({super.key}) ;

  @override
  Widget build(BuildContext context) {
    return Padding(padding: const EdgeInsets.all(Dimensions.paddingSizeDefault ),
      child: Row(
        children: [
          Text('time'.tr, style: robotoBold.copyWith(fontSize: Dimensions.fontSizeLarge,color: Theme.of(Get.context!).colorScheme.primary)),
          const SizedBox(width: Dimensions.paddingSizeLarge,),
          GetBuilder<ScheduleController>(builder: (sc){
            if (sc.loadingAvailability) {
              return const SizedBox(width: 140, height: 40, child: Center(child: CircularProgressIndicator(strokeWidth: 2)));
            }
            if (sc.availableSlots.isNotEmpty) {
              return SizedBox(
                width: Get.width * 0.6,
                child: Wrap(
                  spacing: 8,
                  runSpacing: 8,
                  children: sc.availableSlots.map((slot) {
                    final selected = sc.selectedTime.startsWith(slot);
                    return ChoiceChip(
                      label: Text(slot, style: robotoMedium.copyWith(fontSize: Dimensions.fontSizeSmall)),
                      selected: selected,
                      onSelected: (_) {
                        sc.selectedTime = "$slot:00";
                        sc.update();
                      },
                    );
                  }).toList(),
                ),
              );
            }
            return TimePickerSpinner(
              is24HourMode: Get.find<SplashController>().configModel.content?.timeFormat == '24',
              normalTextStyle: robotoRegular.copyWith(color: Theme.of(context).hintColor,fontSize: Dimensions.fontSizeSmall),
              highlightedTextStyle: robotoMedium.copyWith(
                fontSize: Dimensions.fontSizeLarge*1, color: Theme.of(context).colorScheme.primary,
              ),
              spacing: Dimensions.paddingSizeDefault,
              itemHeight: Dimensions.fontSizeLarge + 2,
              itemWidth: 50,
              alignment: Alignment.topCenter,
              isForce2Digits: true,
              onTimeChange: (time) {
                sc.selectedTime = "${time.hour}:${time.minute}:${time.second}";
              },
            );
          }),
        ],
      ),
    );
  }
}
