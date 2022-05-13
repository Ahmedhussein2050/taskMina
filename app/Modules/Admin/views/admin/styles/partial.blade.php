<div class="row">
    <h3 class='mb-4'>{{ _i('Header') }}</h3>
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Background color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="header_background_color"
                        value="{{ $setting_template->header_background_color }}" id="header_background_color">
                    <input type="checkbox" value='' name="header_background_color" class="js-switch"
                        {{ $setting_template->header_background_color == null ? 'checked' : '' }}
                        id="header_background_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Font color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="header_font_color" value="{{ $setting_template->header_font_color }}"
                        id="header_font_color">
                    <input type="checkbox" value='' name="header_font_color" class="js-switch"
                        {{ $setting_template->header_font_color == null ? 'checked' : '' }}
                        id="header_font_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Icon color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="header_icon_color" value="{{ $setting_template->header_icon_color }}"
                        id="header_icon_color">
                    <input type="checkbox" value='' name="header_icon_color" class="js-switch"
                        {{ $setting_template->header_icon_color == null ? 'checked' : '' }}
                        id="header_icon_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <h3 class='mb-4'>{{ _i('Category card') }}</h3>
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Background color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="category_background_color"
                        value="{{ $setting_template->category_background_color }}" id="category_background_color">
                    <input type="checkbox" value='' name="category_background_color" class="js-switch"
                        {{ $setting_template->category_background_color == null ? 'checked' : '' }}
                        id="category_background_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Font color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="category_font_color"
                        value="{{ $setting_template->category_font_color }}" id="category_font_color">
                    <input type="checkbox" value='' name="category_font_color" class="js-switch"
                        {{ $setting_template->category_font_color == null ? 'checked' : '' }}
                        id="category_font_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Background color hover') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="category_background_color_hover"
                        value="{{ $setting_template->category_background_color_hover }}"
                        id="category_background_color_hover">
                    <input type="checkbox" value='' name="category_background_color_hover" class="js-switch"
                        {{ $setting_template->category_background_color_hover == null ? 'checked' : '' }}
                        id="category_background_color_hover_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Font color hover') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="category_font_color_hover"
                        value="{{ $setting_template->category_font_color_hover }}" id="category_font_color_hover">
                    <input type="checkbox" value='' name="category_font_color_hover" class="js-switch"
                        {{ $setting_template->category_font_color_hover == null ? 'checked' : '' }}
                        id="category_font_color_hover_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <h3 class='mb-4'>{{ _i('Product card') }}</h3>
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Background color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="product_background_color"
                        value="{{ $setting_template->product_background_color }}" id="product_background_color">
                    <input type="checkbox" value='' name="product_background_color" class="js-switch"
                        {{ $setting_template->product_background_color == null ? 'checked' : '' }}
                        id="product_background_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Font color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="product_font_color" value="{{ $setting_template->product_font_color }}"
                        id="product_font_color">
                    <input type="checkbox" value='' name="product_font_color" class="js-switch"
                        {{ $setting_template->product_font_color == null ? 'checked' : '' }}
                        id="product_font_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Icon color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="product_icon_color" value="{{ $setting_template->product_icon_color }}"
                        id="product_icon_color">
                    <input type="checkbox" value='' name="product_icon_color" class="js-switch"
                        {{ $setting_template->product_icon_color == null ? 'checked' : '' }}
                        id="product_icon_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Add to cart background color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="product_add_background_color"
                        value="{{ $setting_template->product_add_background_color }}"
                        id="product_add_background_color">
                    <input type="checkbox" value='' name="product_add_background_color" class="js-switch"
                        {{ $setting_template->product_add_background_color == null ? 'checked' : '' }}
                        id="product_add_background_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Add to cart font color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="product_add_font_color"
                        value="{{ $setting_template->product_add_font_color }}" id="product_add_font_color">
                    <input type="checkbox" value='' name="product_add_font_color" class="js-switch"
                        {{ $setting_template->product_add_font_color == null ? 'checked' : '' }}
                        id="product_add_font_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Out of stock background color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="product_out_background_color"
                        value="{{ $setting_template->product_out_background_color }}"
                        id="product_out_background_color">
                    <input type="checkbox" value='' name="product_out_background_color" class="js-switch"
                        {{ $setting_template->product_out_background_color == null ? 'checked' : '' }}
                        id="product_out_background_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Out of stock font color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="product_out_font_color"
                        value="{{ $setting_template->product_out_font_color }}" id="product_out_font_color">
                    <input type="checkbox" value='' name="product_out_font_color" class="js-switch"
                        {{ $setting_template->product_out_font_color == null ? 'checked' : '' }}
                        id="product_out_font_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <h3 class='mb-4'>{{ _i('Footer') }}</h3>
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Background color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="footer_background_color"
                        value="{{ $setting_template->footer_background_color }}" id="footer_background_color">
                    <input type="checkbox" value='' name="footer_background_color" class="js-switch"
                        {{ $setting_template->footer_background_color == null ? 'checked' : '' }}
                        id="footer_background_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Font color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="footer_font_color" value="{{ $setting_template->footer_font_color }}"
                        id="footer_font_color">
                    <input type="checkbox" value='' name="footer_font_color" class="js-switch"
                        {{ $setting_template->footer_font_color == null ? 'checked' : '' }}
                        id="footer_font_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Icon color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="footer_icon_color" value="{{ $setting_template->footer_icon_color }}"
                        id="footer_icon_color">
                    <input type="checkbox" value='' name="footer_icon_color" class="js-switch"
                        {{ $setting_template->footer_icon_color == null ? 'checked' : '' }}
                        id="footer_icon_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <h3 class='mb-4'>{{ _i('Basic') }}</h3>
    <div class="col-md-12">
        <div class="form-group row">
            <label class="col-sm-4 control-label">
                {{ _i('Font color') }}
            </label>
            <div class="col-sm-3 ">
                <div class="form-group">
                    <input type="color" name="store_color" value="{{ $setting_template->store_color }}"
                        id="store_color">
                    <input type="checkbox" value='' name="store_color" class="js-switch"
                        {{ $setting_template->store_color == null ? 'checked' : '' }} id="store_color_check">
                    {{ _i('Default') }}
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label">{{ _i('Store Font') }}</label>
            <div class="col-sm-3">
                <select class="form-control" name="font" id="font">
                    <option>{{ _i('Default Font') }}</option>
                    <option value="elmessiri-regular.otf"
                        {{ $setting_template['store_font'] == 'elmessiri-regular.otf' ? 'selected' : '' }}>
                        {{ _i('elmessiri') }}</option>
                    <option value="fontawesome-webfont.ttf"
                        {{ $setting_template['store_font'] == 'fontawesome-webfont.ttf' ? 'selected' : '' }}>
                        {{ _i('fontawesome') }}</option>
                </select>
            </div>
        </div>

    </div>
</div>
