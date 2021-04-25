# Bootstrap styled Text with Media Element for TYPO3

Text & Media Element adaption for FluidStyledContent.

## Description

This extensions will give you Fluid Styled Content Elements for
Text with Media elements. Both a `standalone` element that adds a new element
"Text & Media - Bootstrap" and a `replace` option are available.

By default, the standalone variant will be placed in the new content 
element wizard as well. Disable this behaviour in the extension manager.

## Version 4.0.0

One and only version for TYPO3 9LTS. Works together with fluid_styled_responsive_images 9.5.x.

## Version 3.0.0

One and only version for TYPO3 8LTS. Works together with fluid_styled_responsive_images 8.7.x.

## Version 2.1.0

* the extension depends on EXT:fluid_styled_responsive_images now to provide
  automatic responsive images. The default configuration should match a standard
  bootstrap 3 12 columns grid. For more information please have a look at
  fluid-styled-responsive-images (Link: https://github.com/alexanderschnitzler/fluid-styled-responsive-images)

* adjust templates

## Version 2.0.2

* switch back to render images through the media ViewHelper to be able to use
  custom renderers from the RendererRegistry

## Version 2.0.0

Major update, please regard these changes:
- new class names in fluid_styled_content style
- EXT:vhs not needed anymore
- responsive videos now possible in gallery grid
- setting the size of the bodytext column not necessary anymore, gets computed automatically

## License

GPL3
