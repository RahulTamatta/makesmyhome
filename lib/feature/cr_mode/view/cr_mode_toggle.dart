import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/feature/cr_mode/controller/cr_mode_controller.dart';

class CrModeToggle extends StatelessWidget {
  final EdgeInsetsGeometry padding;
  const CrModeToggle(
      {super.key,
      this.padding = const EdgeInsets.symmetric(horizontal: 16, vertical: 8)});

  @override
  Widget build(BuildContext context) {
    return GetBuilder<CrModeController>(builder: (ctrl) {
      if (!ctrl.isEnabled) {
        return const SizedBox.shrink();
      }
      final bool isCr = ctrl.isCrMode;
      return Padding(
        padding: padding,
        child: Container(
          decoration: BoxDecoration(
            color: Theme.of(context).cardColor,
            borderRadius: BorderRadius.circular(24),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.05),
                blurRadius: 8,
                offset: const Offset(0, 2),
              )
            ],
          ),
          child: Row(
            children: [
              _segment(
                context,
                title: 'Quick Work',
                selected: !isCr,
                onTap: () {
                  if (isCr) {
                    ctrl.toggleCrMode();
                  }
                },
              ),
              _segment(
                context,
                title: 'Construction',
                selected: isCr,
                onTap: () {
                  if (!isCr) {
                    ctrl.toggleCrMode();
                  }
                },
              ),
            ],
          ),
        ),
      );
    });
  }

  Widget _segment(BuildContext context,
      {required String title,
      required bool selected,
      required VoidCallback onTap}) {
    return Expanded(
      child: InkWell(
        borderRadius: BorderRadius.circular(24),
        onTap: onTap,
        child: AnimatedContainer(
          duration: const Duration(milliseconds: 180),
          padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
          decoration: BoxDecoration(
            color:
                selected ? Theme.of(context).primaryColor : Colors.transparent,
            borderRadius: BorderRadius.circular(24),
          ),
          alignment: Alignment.center,
          child: Text(
            title,
            style: TextStyle(
              fontSize: 12,
              fontWeight: FontWeight.w600,
              color: selected
                  ? Colors.white
                  : Theme.of(context).textTheme.bodyMedium?.color,
            ),
          ),
        ),
      ),
    );
  }
}
