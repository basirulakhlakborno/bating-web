@php
    /** @var \App\Models\NavigationItem $item */
    $meta = $item->drawer_meta ?? [];
    $variant = $meta['variant'] ?? null;
@endphp
<a href="{{ $item->href }}" class="v-list-item v-list-item--link theme--light" tabindex="0" role="option" aria-selected="false" @if ($item->is_external) target="_blank" rel="noopener noreferrer" @endif>
    <div class="v-list-item__icon">
        @if (($meta['icon_wrap'] ?? null) === 'button' && $item->icon_path)
            <button type="button" class="v-btn v-btn--icon v-btn--round theme--light v-size--small" style="margin-left: -3px;">
                <span class="v-btn__content">
                    <div class="v-avatar" style="height: 25px; min-width: 25px; width: 25px;">
                        <img src="{{ $item->icon_path }}" alt="" width="25" height="25">
                    </div>
                </span>
            </button>
        @elseif ($item->icon_path)
            <img src="{{ $item->icon_path }}" alt="" width="25" height="25">
        @endif
    </div>
    <div class="v-list-item__content">
        <div class="v-list-item__title">
            @if ($variant === 'referral')
                <div class="row no-gutters align-center justify-start">
                    <div class="mt-1 col col-auto">
                        {{ $item->label_bn }}
                    </div>
                    <div class="text-center col col-2" style="margin-left: 2px; border-radius: 8px; color: white; font-size: 10px;">
                        <div class="v-image v-responsive img-hot-home theme--light" style="width: 40px;">
                            <div class="v-image__image v-image__image--preload v-image__image--cover" style="background-position: center center;"></div>
                            <div class="v-responsive__content"></div>
                        </div>
                    </div>
                </div>
            @elseif ($variant === 'row_badge_hot')
                <div class="row no-gutters align-center justify-start">
                    <div class="mt-1 col col-auto">
                        {{ $item->label_bn }}
                    </div>
                    <div class="text-center col col-2" style="margin-left: 2px; border-radius: 8px; color: white; font-size: 10px;">
                        <div class="v-image v-responsive img-hot-home theme--light" style="width: 40px;">
                            <div class="v-image__image v-image__image--preload v-image__image--cover" style="background-position: center center;"></div>
                            <div class="v-responsive__content"></div>
                        </div>
                    </div>
                </div>
            @elseif ($variant === 'row_badge_empty')
                <div class="row no-gutters align-center justify-start">
                    <div class="mt-1 col col-auto">
                        {{ $item->label_bn }}
                    </div>
                    <div class="text-center col col-2" style="margin-left: 2px; border-radius: 8px; color: white; font-size: 10px;">
                        <div class="v-image v-responsive theme--light" style="width: 40px;">
                            <div class="v-image__image v-image__image--preload v-image__image--cover" style="background-position: center center;"></div>
                            <div class="v-responsive__content"></div>
                        </div>
                    </div>
                </div>
            @elseif (! empty($meta['badge']))
                <div class="row no-gutters align-center justify-start">
                    <div class="mt-1 col col-auto">
                        {{ $item->label_bn }}
                    </div>
                    <div class="text-center col col-2" style="margin-left: 5px; background-color: {{ $meta['badge_bg'] ?? 'rgb(4, 178, 43)' }}; border-radius: 8px; color: white; font-size: 10px;">
                        <span class="font-weight-bold">{{ $meta['badge'] }}</span>
                    </div>
                </div>
            @else
                <div class="row no-gutters align-center justify-start">
                    <div class="mt-1 col col-auto">
                        {{ $item->label_bn }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</a>
