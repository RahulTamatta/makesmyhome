import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';

class LocationSearchDialog extends StatelessWidget {
  final GoogleMapController? mapController;
  final bool hasTitleWidget;
  const LocationSearchDialog(
      {super.key, required this.mapController, this.hasTitleWidget = false});

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(
          top: ResponsiveHelper.isDesktop(context) && hasTitleWidget
              ? 180
              : ResponsiveHelper.isDesktop(context)
                  ? 120
                  : 0),
      padding:
          const EdgeInsets.symmetric(horizontal: Dimensions.paddingSizeSmall),
      alignment: Alignment.topCenter,
      child: Material(
        shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(Dimensions.radiusSmall)),
        child: GetBuilder<LocationController>(builder: (locationController) {
          return SizedBox(
            width: Dimensions.webMaxWidth - 30,
            child: TypeAheadField(
              debounceDuration: const Duration(milliseconds: 350),
              suggestionsCallback: (pattern) async {
                final q = pattern.trim();
                if (q.length < 3) {
                  return <PredictionModel>[];
                }
                return await locationController.searchLocation(context, q);
              },
              hideOnEmpty: true,
              builder: (context, controller, focusNode) {
                return TextField(
                  controller: controller,
                  focusNode: focusNode,
                  autofocus: true,
                  decoration: InputDecoration(
                    hintText: 'search_location'.tr,
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10),
                      borderSide:
                          const BorderSide(style: BorderStyle.none, width: 0),
                    ),
                    hintStyle:
                        Theme.of(context).textTheme.displayMedium!.copyWith(
                              fontSize: Dimensions.fontSizeDefault,
                              color: Theme.of(context).disabledColor,
                            ),
                    filled: true,
                    fillColor: Theme.of(context).cardColor,
                  ),
                  style: Theme.of(context).textTheme.displayMedium!.copyWith(
                        color: Theme.of(context).textTheme.bodyLarge!.color,
                        fontSize: Dimensions.fontSizeLarge,
                      ),
                );
              },
              itemBuilder: (context, suggestion) {
                return Container(
                  color: Theme.of(context).cardColor,
                  child: Padding(
                    padding: const EdgeInsets.all(Dimensions.paddingSizeSmall),
                    child: Row(children: [
                      const Icon(Icons.location_on),
                      Expanded(
                        child: Text(
                            suggestion.placePrediction?.text?.text ?? "",
                            maxLines: 1,
                            overflow: TextOverflow.ellipsis,
                            style: Theme.of(context)
                                .textTheme
                                .displayMedium!
                                .copyWith(
                                  color: Theme.of(context)
                                      .textTheme
                                      .bodyLarge!
                                      .color,
                                  fontSize: Dimensions.fontSizeLarge,
                                )),
                      ),
                    ]),
                  ),
                );
              },
              onSelected: (suggestion) {
                final placeId = suggestion.placePrediction?.placeId;
                if (placeId == null ||
                    placeId.isEmpty ||
                    mapController == null) {
                  return;
                }
                Get.find<LocationController>().setLocation(
                    placeId,
                    suggestion.placePrediction?.text?.text ?? "",
                    mapController!);
                Get.back();
              },
              errorBuilder: (_, value) {
                return const SizedBox();
              },
            ),
          );
        }),
      ),
    );
  }
}
