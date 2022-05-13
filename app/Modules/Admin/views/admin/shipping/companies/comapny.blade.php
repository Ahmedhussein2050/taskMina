@php
$img = null;
if (isset($company) && $company['logo']!=null ) {
    if (file_exists(public_path($company['logo']) )) {
        $img = asset($company['logo']) ;
    }
}
@endphp
<div class="card">

    <div class="card-body  text-center">

        <div class=" form-group row ">
            <div class="col-md-12">
                <img class="img-fluid " id="output" src="@if (isset($company) && $img != null) {{ $img }} @else {{ asset('images/placeholder.png') }} @endif">
            </div>
            <div class="col-sm-12">

                <div class="input-group ">
                    <input accept="image/*" type="file" name="logo" id="logo" onchange="showMyImage(this)">
                </div>
                <div class="input-group ">
                    <input class="form-control" name="company_name" placeholder="{{ _i('Company Name') }}"
                        required="" @if (isset($company)) value="{{ $company['title'] }}" @endif>
                    <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                        <i class="fa fa-industry"></i>
                    </span>

                </div>
                <div class="form-group">
                    <textarea class="form-control" name="description"
                        placeholder="{{ _i('Company description') }}">@if (isset($company)){{ $company['description'] }}@endif</textarea>
                </div>
                <div class="input-group ">
                    <input class="form-control " type="number" name="order" placeholder="{{ _i('Arrangement') }}"
                        required="" @if (isset($company)) value="{{ $company['order'] }}" @endif>
                    <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                        <i class="fa fa-industry"></i>
                    </span>
                </div>
                <div class="form-group row ">
                    <div class="col-md-6">
                        {{ _i('Free Shipping') }}
                    </div>
                    <div class="col-md-6">

                        <input type="checkbox" class="js-switch" title="{{ _i('Free Shipping') }}"
                            @if (isset($company))  @if ($company->shipping_type == 'free') checked @endif @endif name="free_shipping" id="free_shipping" value="1" />
                    </div>

                    <div class="col-md-6">
                        <label>{{ _i('Active') }}</label>
                    </div>
                    <div class="col-md-6">
                        <input type="checkbox" class="js-switch " value="1" name="is_active"
                            @if (isset($company) && $company->is_active == 1) checked @endif />
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
@include('admin.shipping.companies.new_option')

@push('js')
    <script>
        function showMyImage(fileInput) {
            var files = fileInput.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var imageType = /image.*/;
                if (!file.type.match(imageType)) {
                    continue;
                }
                var img = document.getElementById("output");
                img.file = file;
                var reader = new FileReader();
                reader.onload = (function(aImg) {
                    return function(e) {
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        }
    </script>

@endpush
