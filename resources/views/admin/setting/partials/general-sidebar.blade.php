<div class="email__sidebar bg-style">
    <div class="sidebar__item">
        <ul class="d-flex flex-column rg-15 sidebar__mail__nav">
            <li>
                <a href="{{ route('admin.setting.application-settings') }}"
                   class="align-items-center flex list-item list-item">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$subApplicationSettingActiveClass }}">{{__('Application Setting')}}</span>
                </a>
            </li>
            @if(!isAddonInstalled('ALUSAAS'))
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.storage.index') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$subStorageSettingActiveClass }}">{{ __('Storage Setting') }}</span>
                </a>
            </li>
            @endif
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.color-settings') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$subColorSettingActiveClass }}">{{ __('Logo Setting') }}</span>
                </a>
            </li>
            @if(!isAddonInstalled('ALUSAAS'))
            <li>
                <a class="align-items-center flex list-item list-item"
                   href="{{ route('admin.setting.maintenance') }}">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$subMaintenanceModeActiveClass }}">{{ __('Maintenance Mode') }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.setting.cache-settings') }}" class="align-items-center flex list-item list-item">
                    <span class="fa fa-gear fs-14 text-707070"></span>
                    <span class="font-bold fs-14 hover-color-one text-1b1c17 {{ @$subCacheActiveClass }}">{{ __('Cache Settings') }}</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>
