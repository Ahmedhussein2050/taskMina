

<div class="form-group row apply"  id="div_items">
    <label class="col-sm-2">{{ _i('Apply offer to') }}</label>
    <div class="col-sm-10">
        <div class="form-radio">
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="products" class="Products" id="selectall" checked value="0" data-bv-field="member">
                    <i class="helper"></i>{{ _i('All Products') }}
                </label>
            </div>
            <div class="radio radiofill radio-primary radio-inline">
                <label>
                    <input type="radio" name="Productss" class="Products" id="selectpro" value="1" data-bv-field="member">
                    <i class="helper"></i>{{ _i('Selected Products') }}
                </label>
            </div>
        </div>
        <div class="form-group row success_Products" style="display: none">
            <label class="col-sm-2 col-form-label">{{ _i('Products') }}</label>
            <div class="col-sm-9">
                <select class="form-control myselectttt" name="products[]" data-live-search="true" multiple>
                </select>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('.myselectttt').select2({
                minimumInputLength: 2,
                placeholder: "{{ _i('Select products') }}",
                ajax: {
                    url: "{{ url('admin/settings/sections/autocomplete') }}",

                    data: function(params) {
                        var query = {
                            q: params.term,
                        }
                        return query;
                    },

                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                console.log(item);

                                return {
                                    text: item.title,
                                    id: item.product_id,
                                }
                            })
                        };
                    },
                    cache: true,
                }


            });



            $(".Products").click(function() {
            var vpp = $(this).val();
            if (vpp == 1) {
                $(".success_Products").css("display", "block");
                $("#selectall").prop("checked", false);
            } else {
                $(".success_Products").css("display", "none");
                $("#selectpro").prop("checked", false);
            }
        });
        });
    </script>
@endpush
