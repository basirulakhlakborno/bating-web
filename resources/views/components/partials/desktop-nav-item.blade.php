@php
    /** @var \App\Models\NavigationItem $item */
    $aClass = 'pt-4 pb-2 px-0 page-navigator-button text-capitalize v-btn v-btn--router v-btn--text theme--dark v-size--default';
    if ($item->href === '/promotion' || str_starts_with($item->href ?? '', 'http')) {
        $aClass = str_replace(' text-capitalize', '', $aClass);
    }
    if ($item->is_external) {
        $aClass = str_replace(' v-btn--router', '', $aClass);
    }
@endphp
<div class="page-navigator-item">
    @if ($item->has_badge_ui)
        <span right="" class="v-badge v-badge--overlap theme--light">
            <a href="{{ $item->href }}" class="{{ $aClass }}" style="height: auto;" @if ($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
                <span class="v-btn__content">
                    <div class="row no-gutters">
                        <div class="pa-0 text-center col col-12">
                            <label class="{{ $item->label_class }}">
                                {{ $item->label_bn }}
                            </label>
                        </div>
                        @if ($item->show_underline)
                            <div class="px-0 py-1 underline_bar col col-12">
                                <hr role="separator" aria-orientation="horizontal" class="mx-2 add_border_bold v-divider theme--dark">
                            </div>
                        @endif
                    </div>
                </span>
            </a>
            <span class="v-badge__wrapper">
                <span aria-atomic="true" aria-label="Badge" aria-live="polite" role="status" class="v-badge__badge light" style="inset: auto auto calc(100% - 4px) calc(100% - 25px);">
                    @if ($item->badge_variant === 'hot')
                        <div class="v-image v-responsive img-hot-home theme--light" style="height: 25px; width: 35px;">
                            <div class="v-responsive__sizer" style="padding-bottom: 79.5918%;"></div>
                            <div class="v-image__image v-image__image--cover" style="background-image: url(&quot;/static/image/other/hot-icon.png&quot;); background-position: center center;"></div>
                            <div class="v-responsive__content" style="width: 49px;"></div>
                        </div>
                    @else
                        <div class="v-image v-responsive theme--light" style="height: 25px; width: 25px;">
                            <div class="v-image__image v-image__image--preload v-image__image--cover" style="background-position: center center;"></div>
                            <div class="v-responsive__content"></div>
                        </div>
                    @endif
                </span>
            </span>
        </span>
    @else
        <a href="{{ $item->href }}" class="{{ $aClass }}" style="height: auto;" @if ($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
            <span class="v-btn__content">
                <div class="row no-gutters">
                    <div class="pa-0 text-center col col-12">
                        <label class="{{ $item->label_class }}">
                            {{ $item->label_bn }}
                        </label>
                    </div>
                    @if ($item->show_underline)
                        <div class="px-0 py-1 underline_bar col col-12">
                            <hr role="separator" aria-orientation="horizontal" class="mx-2 add_border_bold v-divider theme--dark">
                        </div>
                    @endif
                </div>
            </span>
        </a>
    @endif
    <div class="v-menu mt-2" style="z-index: 15;"></div>
</div>
