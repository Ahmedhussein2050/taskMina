{{-- <div class="form-group row"> --}}
<div class="col-sm-3">
    <div class="input-group">
        <input class="form-control load" type="number" name="minumim[]" required id="test"
            value="{{ isset($index) ? old('minumim')[$index] : '' }}">
        <span class="input-group-addon" id="basic-addon3">%</span>
    </div>

</div>
<div class="col-sm-3">
    <div class="input-group">
        <input class="form-control load2" type="number" name="maximum[]" id="test2" required value="{{(isset($index)) ? old('maximum')[$index] : "" }}">
        <span class="input-group-addon" id="basic-addon3">%</span>
    </div>
</div>
<div class="col-sm-3">
    <div class="input-group">
        <input class="form-control" type="number" name="bonus[]" required value="{{(isset($index)) ? old('bonus')[$index] : "" }}">
        <span class="input-group-addon" id="basic-addon3">%</span>
    </div>


</div>

