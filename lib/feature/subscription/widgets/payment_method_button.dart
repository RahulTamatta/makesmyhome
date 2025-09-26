import 'package:makesmyhome/utils/dimensions.dart';
import 'package:makesmyhome/utils/styles.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:flutter/material.dart';

class PaymentMethodButton extends StatelessWidget {
  final String icon;
  final String title;
  final bool isSelected;
  final VoidCallback onTap;
  final String? paymentMethodName;
  final String? assetName;

  const PaymentMethodButton({
    Key? key,
    required this.icon,
    required this.title,
    required this.isSelected,
    required this.onTap,
    this.paymentMethodName,
    this.assetName,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: Dimensions.paddingSizeSmall),
      child: InkWell(
        onTap: onTap,
        child: Container(
          decoration: BoxDecoration(
            color: isSelected
                ? Theme.of(context).primaryColor.withOpacity(0.05)
                : Theme.of(context).cardColor,
            borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
            border: Border.all(
              color: isSelected
                  ? Theme.of(context).primaryColor
                  : Theme.of(context).hintColor.withOpacity(0.2),
              width: 1,
            ),
          ),
          padding: const EdgeInsets.symmetric(
            horizontal: Dimensions.paddingSizeDefault,
            vertical: Dimensions.paddingSizeSmall,
          ),
          child: Row(
            children: [
              Container(
                height: 20,
                width: 20,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  border: Border.all(
                    color: isSelected
                        ? Theme.of(context).primaryColor
                        : Theme.of(context).hintColor.withOpacity(0.5),
                    width: 1,
                  ),
                ),
                child: isSelected
                    ? Center(
                        child: Container(
                          height: 12,
                          width: 12,
                          decoration: BoxDecoration(
                            shape: BoxShape.circle,
                            color: Theme.of(context).primaryColor,
                          ),
                        ),
                      )
                    : const SizedBox(),
              ),
              const SizedBox(width: Dimensions.paddingSizeDefault),
              if (icon.isNotEmpty)
                Padding(
                  padding: const EdgeInsets.only(right: Dimensions.paddingSizeSmall),
                  child: Image.asset(
                    icon,
                    width: 24,
                    height: 24,
                    errorBuilder: (context, error, stackTrace) => const SizedBox(
                      width: 24,
                      height: 24,
                    ),
                  ),
                ),
              Expanded(
                child: Text(
                  title,
                  style: robotoMedium.copyWith(
                    fontSize: Dimensions.fontSizeDefault,
                    color: isSelected
                        ? Theme.of(context).primaryColor
                        : Theme.of(context).textTheme.bodyLarge?.color,
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
